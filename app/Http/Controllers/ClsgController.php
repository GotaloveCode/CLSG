<?php

namespace App\Http\Controllers;

use App\Models\Bcp;
use App\Models\Wsp;
use App\Traits\FilesTrait;
use App\Traits\SendMailNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClsgController extends Controller
{
    use FilesTrait;

    public function index()
    {
        if (!request()->ajax()) {
            return view('clsg.index');
        }
        $bcp = Bcp::query()->with('wsp:id,name')
            ->select('bcps.*')
            ->where('status', 'WSTF Approved');

        return Datatables::of($bcp)
            ->addColumn('action', function ($bcp) {
                return '<a href="' . route("clsg.show", $bcp->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }

    public function show(Wsp $wsp)
    {
        if (\request()->has('print')) {
            $pdf = \PDF::loadView('clsg.print', compact('wsp'));
            return $pdf->inline();
        }
        $wsp = $wsp->load('attachments');
        return view('clsg.show', compact('wsp'));
    }

    public function upload(Wsp $wsp, Request $request)
    {
        $request->validate(['attachment' => 'required|file|mimes:pdf,jpg,jpeg,png,docx,doc']);

//        $attachment = $wsp->attachments()->where('document_type', 'CLSGA')->first();
//
//        if ($attachment) {
//            Attachment::remove($attachment, 'app/Clsg/');
//        }

        $fileName = $this->storeDocument($request->attachment, 'CLSGA', 'app/Clsg');

        $wsp->attachments()->create([
            'name' => $fileName,
            'display_name' => 'CLSGA',
            'document_type' => 'CLSGA',
        ]);

        $uploader = auth()->user()->hasRole('wsp') ? $wsp->name : auth()->user()->getRoleNames()->first();

        SendMailNotification::created($wsp,
            route('clg.show', $wsp->id),
            $wsp->name . ' CLSGA Uploaded',
            $uploader . ' uploaded CLSGA for ' . $wsp->name
        );

        if ($request->ajax()) {
            return response()->json(['success' => 'CLSGA uploaded successfully']);
        }

        return back()->with('success', 'CLSGA uploaded successfully');
    }

    public function attachment($filename)
    {
        return $this->showFile(storage_path('app/Clsg/' . $filename));
    }

    public function formula()
    {
        return view('clsg');
    }
}
