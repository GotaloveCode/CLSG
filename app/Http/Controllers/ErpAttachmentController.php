<?php

namespace App\Http\Controllers;

use App\Http\Requests\ErpAttachmentRequest;
use App\Models\Attachment;
use App\Models\Erp;
use App\Models\User;
use App\Notifications\AttachmentNotification;
use App\Traits\FilesTrait;
use Illuminate\Http\Request;

class ErpAttachmentController extends Controller
{
    use FilesTrait;

    public function index(Erp $erp)
    {
        $erp = $erp->load('attachments');
        $progress = ceil($erp->attachments->pluck('document_type')->unique()->count() / 2 * 100);
        $progress = $progress > 100 ? 100 : $progress;
        return view('erps.attachments')->with(compact('erp', 'progress'));
    }

    public function store(Erp $erp, ErpAttachmentRequest $request)
    {
        $wsp = $erp->wsp;
        if (!$wsp->users()->pluck('user_id')->contains(auth()->id())) {
            abort('403', 'You do not have the permissions to perform this action');
        }

        if ($erp->status == 'WSTF Approved') {
            abort('403', 'You may only attach documents while the ERP has not been approved by WSTF');
        }


        $fileName = $this->storeDocument($request->attachment, $request->display_name,"app/Erp");

        $attachment = $erp->attachments()->create([
            'name' => $fileName,
            'display_name' => $request->display_name,
            'document_type' => $request->document_type,
        ]);

        $users = User::role(["wasreb", "wstf"])->get();

        $users->each(function ($user) use ($attachment, $wsp, $erp) {
            $user->notify(new AttachmentNotification($attachment, $wsp, route('erps.attachments', $erp->id)));
        });

        return back();
    }

    public function show($filename)
    {
        return $this->showFile(storage_path('app/Erp/' . $filename));
    }

    public function destroy(Attachment $attachment)
    {
        if(! $attachment->attachable->wsp->users()->pluck('user_id')->contains(auth()->id()) && $attachment->attachable->status == 'WSTF Approved'){
            abort(403,"You do not have the permissions to delete this attachment or related document already approved by WSTF");
        }
        return $this->deleteAttachment($attachment, 'app/Erp/');
    }
}
