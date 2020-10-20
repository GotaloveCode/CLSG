<?php

namespace App\Http\Controllers;

use App\Http\Requests\BcpFormRequest;
use App\Http\Requests\EoiCommentRequest;
use App\Models\Bcp;
use App\Models\Operationcost;
use App\Traits\BcpAuthTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Attachment;
use App\Traits\SendMailNotification;

class BcpController extends Controller
{
    use SendMailNotification, BcpAuthTrait;

    public function index()
    {
        if (!request()->ajax()) {
            return view('bcps.index');
        }
        $bcp = Bcp::query()->with('wsp:id,name');
        if(auth()->user()->hasRole('wsp')){
            $bcp = $bcp->where('wsp_id', auth()->user()->wsps()->first()->id);
        }
        return Datatables::of($bcp)
            ->addColumn('action', function ($bcp) {
                return '<a href="' . route("bcps.show", $bcp->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }

    public function create()
    {
        $wsp = auth()->user()->wsps()->first();
        if (!isset($wsp->eoi)) {
            return redirect(route("eois.create"));
        }
        $operation_costs = $wsp->eoi->operationcosts()->get();
        $operation_cost_fields = Cache::rememberForever('operationCosts', function () {
            return Operationcost::select('id', 'name')->get();
        });
        return view('bcps.create')->with(compact('operation_cost_fields', 'operation_costs'));
    }

    public function store(BcpFormRequest $request)
    {
        $wsp_id = auth()->user()->wsps()->first()->id;
        $bcp = Bcp::where('wsp_id', $wsp_id)->first();
        if ($bcp) {
            return response()->json([
                'message' => 'The given field was invalid',
                'errors' => ['wsp_id' => ['A BCP already exists!']]
            ], 422);
        }

        $bcp = Bcp::create(Arr::except($request->validated(), ['objectives', 'strategic_plans']) + [
                'wsp_id' => $wsp_id
            ]);

        foreach ($request->input('objectives') as $objective) {
            $bcp->objectives()->create([
                'description' => $objective['description']
            ]);
        }

        foreach ($request->input('operation_costs') as $operation_cost) {
            $bcp->operationcosts()->attach($operation_cost['operationcost_id'], [
                'unit_rate' => $operation_cost['unit_rate'],
                'quantity' => $operation_cost['quantity'],
                'total' => $operation_cost['total'],
            ]);
        }

        foreach ($request->input('projected_revenues') as $revenue) {
            $bcp->revenue_projections()->create([
                'amount' => $revenue['amount'],
                'month' => $revenue['month'],
                'year' => now()->year,
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Business Continuity Plan submitted successfully']);
        }
        return back()->with('success', 'Business Continuity Plan submitted successfully');
    }

    public function show(Bcp $bcp)
    {
        $progress = $bcp->progress();
        $eoi = $bcp->wsp->first()->eoi;
        $bcp = $bcp->load(['wsp', 'objectives', 'operationcosts', 'revenue_projections']);
        return view('bcps.show')->with(compact('bcp', 'progress', 'eoi'));
    }

    public function review(Bcp $bcp, Request $request)
    {
        $this->canAccessBcp($bcp);
        $bcp->status = $request->status;
        $bcp->save();

        SendMailNotification::postReview($request->status, $bcp->wsp_id, 'BCP Review');
        $route = route('bcps.preview', $bcp->id);

        if ($request->status == 'WSTF Approved') {
            $route = route('bcps.commitment_letter', $bcp->id);
        }

        return response()->json([
            'message' => 'Bcp status changed to ' . $request->status,
            'route' => $route
        ]);
    }

    public function comment(Bcp $bcp, EoiCommentRequest $request)
    {
        $this->canAccessBcp($bcp);

        $bcp->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        SendMailNotification::postComment($request->description, $bcp->status, $bcp->wsp_id, 'BCP Comment');

        return response()->json(['message' => 'Comment posted successfully']);
    }


    public function commitment_letter(Bcp $bcp)
    {

        $this->validate_bcp_approved($bcp);
        if (request()->input('download')) {
            $pdf = PDF::loadView('preview.bcp', compact('bcp'));
            return $pdf->download('commitment-letter.pdf');
        }
        $eoi = $bcp->wsp()->first()->eois()->first();
        $bcp = $bcp->load(['wsp', 'wsp.postalcode', 'attachments']);
        return view('wsps.commitment-letter-bcp')->with(['bcp' => $bcp, 'eoi' => $eoi]);
    }

    public function upload_commitment_letter(Bcp $bcp, Request $request)
    {
        $this->validate_bcp_approved($bcp);
        $request->validate(['attachment' => 'required|file|mimes:pdf,jpg,jpeg,png,docx,doc']);

        $attachment = $bcp->attachments()->where('document_type', 'Commitment Letter')->first();

        if ($attachment) {
            Attachment::remove($attachment);
        }

        $fileName = $this->storeDocument($request->attachment, 'Commitment Letter');

        $bcp->attachments()->create([
            'name' => $fileName,
            'display_name' => 'Commitment Letter',
            'document_type' => 'Commitment Letter',
        ]);

        //todo: send notification to wft if wsp uploaded signed copy and vice-versa

        return back()->with('success', 'Commitment letter uploaded successfully');
    }


    private function validate_bcp_approved(Bcp $bcp)
    {
        if ($bcp->status !== 'WSTF Approved') {
            return back()->withErrors("Expression of Interest must have been approved by Water Trust Fund");
        }
    }
}
