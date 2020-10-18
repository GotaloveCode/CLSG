<?php

namespace App\Http\Controllers;

use App\Http\Requests\EoiAttachmentRequest;
use App\Models\Attachment;
use App\Models\Eoi;
use App\Traits\FilesTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class EoiAttachmentController extends Controller
{
    use FilesTrait;

    public function index(Eoi $eoi)
    {
        $eoi = $eoi->load('attachments');
        $progress = ceil($eoi->attachments->pluck('document_type')->unique()->count() / 5 * 100);
        return view('eoi.attachments')->with(compact('eoi', 'progress'));
    }

    public function store(Eoi $eoi, EoiAttachmentRequest $request)
    {
        if (!$eoi->wsp->users()->pluck('user_id')->contains(auth()->id())) {
            abort('403', 'You do not have the permissions to perform this action');
        }

        $fileName = $this->storeDocument($request->attachment, $request->display_name);

        $eoi->attachments()->create([
            'name' => $fileName,
            'display_name' => $request->display_name,
            'document_type' => $request->document_type,
        ]);

        return view('eoi.attachments')->with(compact('eoi'));
    }

    public function show($filename)
    {
        $path = storage_path('app/Eoi/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        if (request()->has('download')) {
            return Response::download($path);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);


        return $response;
    }

    public function destroy(Attachment $attachment)
    {
        Attachment::remove($attachment);

        if (request()->ajax()) {
            return response()->json(['message' => "Attachment deleted successfully!"]);
        }

        return back()->with(['message' => "Attachment deleted successfully!"]);
    }
}
