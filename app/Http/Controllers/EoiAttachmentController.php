<?php

namespace App\Http\Controllers;

use App\Http\Requests\EoiAttachmentRequest;
use App\Models\Attachment;
use App\Models\Eoi;
use App\Notifications\EoiSubmittedNotification;
use App\Traits\FilesTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Role;

class EoiAttachmentController extends Controller
{
    use FilesTrait;

    public function index(Eoi $eoi)
    {
        $eoi = $eoi->load('attachments');
        $progress = ceil($eoi->attachments->pluck('document_type')->unique()->count() / 5 * 100);
        $progress = $progress > 100 ? 100 : $progress;
        return view('eoi.attachments')->with(compact('eoi', 'progress'));
    }

    public function store(Eoi $eoi, EoiAttachmentRequest $request)
    {
        if (!$eoi->wsp->users()->pluck('user_id')->contains(auth()->id())) {
            abort('403', 'You do not have the permissions to perform this action');
        }

        $statuses = collect('Pending', 'Needs Review');
        if ($statuses->has($eoi->status)) {
            abort('403', 'You may only attach documents while the Expression of Interest needs review or is Pending');
        }

        $fileName = $this->storeDocument($request->attachment, $request->display_name);

        $eoi->attachments()->create([
            'name' => $fileName,
            'display_name' => $request->display_name,
            'document_type' => $request->document_type,
        ]);

        if ($eoi->attachments->pluck('document_type')->unique()->count() == 5) {
            $eoi->status = "Pending";
            $eoi->save();

            $users = $eoi->wsp->users;
            $wasreb = Role::findByName('wasreb')->users;
            $wasreb->each(function ($u) use (&$users) {
                $users->push($u);
            });

            $users->each(function ($user) use ($eoi) {
                $user->notify(new EoiSubmittedNotification($eoi));
            });
        }

        if ($request->ajax()) {
            return response()->json('Attachment uploaded successfully');
        }

        return back();
    }

    public function show($filename)
    {
        return $this->showFile(storage_path('app/Eoi/' . $filename));
    }

    public function destroy(Attachment $attachment)
    {
        if (!$attachment->attachable->wsp->users()->pluck('user_id')->contains(auth()->id()) && $attachment->attachable->status == 'WSTF Approved') {
            abort(403, "You do not have the permissions to delete this attachment or related document already approved by WSTF");
        }
        return $this->deleteAttachment($attachment, 'app/Eoi/');
    }
}
