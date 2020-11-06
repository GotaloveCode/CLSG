<?php

namespace App\Http\Controllers;

use App\Http\Requests\BcpAttachmentRequest;
use App\Models\Attachment;
use App\Models\User;
use App\Models\WspReporting;
use App\Notifications\AttachmentNotification;
use App\Traits\FilesTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WspReportingAttachmentController extends Controller
{
    use FilesTrait;

    public function store(BcpAttachmentRequest $request, WspReporting $report): JsonResponse
    {
        if ($report->status == 'WSTF Approved') {
            abort(403, 'You may only attach documents while the Monthly Report has not been approved by WSTF!');
        }

        $fileName = $this->storeDocument($request->attachment, $request->display_name, 'app/WspReporting');

        $attachment = $report->attachments()->create([
            'name' => $fileName,
            'display_name' => $request->display_name,
            'document_type' => $request->document_type,
        ]);

        $users = User::role(["wasreb", "wstf"])->get();

        $bcp = $report->bcp;
        $wsp = $bcp->wsp;

        $users->each(function ($user) use ($attachment, $wsp, $report) {
            $user->notify(new AttachmentNotification($attachment, $wsp, route('wsp-reporting.show', $report->id)));
        });

        return response()->json(['message' => 'Upload successful']);
    }

    public function destroy(Attachment $attachment)
    {
        if(! $attachment->attachable->bcp->wsp->users()->pluck('user_id')->contains(auth()->id()) && $attachment->attachable->status == 'WSTF Approved'){
            abort(403,"You do not have the permissions to delete this attachment or related document already approved by WSTF");
        }
        return $this->deleteAttachment($attachment, 'app/WspReporting/');
    }

    public function show($filename)
    {
        return $this->showFile(storage_path('app/WspReporting/' . $filename));
    }

}
