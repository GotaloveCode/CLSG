<?php

namespace App\Http\Controllers;

use App\Http\Requests\BcpAttachmentRequest;
use App\Models\Attachment;
use App\Models\Bcp;
use App\Models\User;
use App\Notifications\AttachmentNotification;
use App\Traits\FilesTrait;

class BcpAttachmentController extends Controller
{
    use FilesTrait;

    public function index(Bcp $bcp)
    {
        $bcp = $bcp->load('attachments');
        $progress = ceil($bcp->attachments->pluck('document_type')->unique()->count() / 2 * 100);
        $progress = $progress > 100 ? 100 : $progress;
        return view('bcps.attachments')->with(compact('bcp', 'progress'));
    }

    public function store(Bcp $bcp, BcpAttachmentRequest $request)
    {
        $wsp = $bcp->wsp;
        if (!$wsp->users()->pluck('user_id')->contains(auth()->id())) {
            abort('403', 'You do not have the permissions to perform this action');
        }

        if ($bcp->status == 'WSTF Approved') {
            abort('403', 'You may only attach documents while the BCP has not been approved by WSTF');
        }


        $fileName = $this->storeDocument($request->attachment, $request->display_name,"app/Bcp");

        $attachment = $bcp->attachments()->create([
            'name' => $fileName,
            'display_name' => $request->display_name,
            'document_type' => $request->document_type,
        ]);

        $users = User::role(["wasreb", "wstf"])->get();

        $users->each(function ($user) use ($attachment, $wsp, $bcp) {
            $user->notify(new AttachmentNotification($attachment, $wsp, route('bcps.attachments', $bcp->id)));
        });

        return back();
    }

    public function show($filename)
    {

        return $this->showFile(storage_path('app/Bcp/' . $filename));
    }

    public function destroy(Attachment $attachment)
    {
        if(! $attachment->attachable->wsp->users()->pluck('user_id')->contains(auth()->id()) && $attachment->attachable->status == 'WSTF Approved'){
            abort(403,"You do not have the permissions to delete this attachment or related document already approved by WSTF");
        }
        return $this->deleteAttachment($attachment, 'app/Bcp/');
    }
}

