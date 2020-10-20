<?php


namespace App\Traits;

use App\Mail\CommentMailable;
use App\Mail\ReviewMailable;
use App\Models\Wsp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

trait SendMailNotification
{

    static public function postComment($comment, $status, $wsp_id, $subject)
    {
        Mail::to(self::getRecipient($status, $wsp_id))->send(new CommentMailable($comment, $subject));
    }

    static public function postReview($status, $wsp_id, $subject)
    {
        Mail::to(self::getRecipient($status, $wsp_id))->send(new ReviewMailable($status, $subject));
    }

    static public function getRecipient($status, $wsp_id)
    {
        $wsp = Wsp::find($wsp_id);
        switch ($status) {
            case 'WSTF Approved':
                $sender = User::role(["wasreb"])->get();
                $wsp->users->each(function ($user) use ($sender) {
                    $sender->push($user);
                });
                break;
            case 'WASREB Approved':
                $sender = User::role(["wstf"])->get();
                $wsp->users->each(function ($user) use ($sender) {
                    $sender->push($user);
                });
                break;
            case 'Needs Approval':
                $sender = User::role(["wasreb", "wstf"])->get();
                break;
            default:
                $sender = User::role(["wstf", "wasreb"])->get();
                $wsp->users->each(function ($user) use ($sender) {
                    $sender->push($user);
                });
        }
        return $sender;
    }
}
