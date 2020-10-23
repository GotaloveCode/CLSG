<?php


namespace App\Traits;

use App\Models\Wsp;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Notifications\ReviewNotification;

trait SendMailNotification
{

    static public function postComment($comment, $status, $wsp_id, $route, $subject)
    {
        $wsp = Wsp::find($wsp_id);
        $users = self::getRecipient($status, $wsp);
        $users->each(function ($user) use ($wsp, $route, $subject, $comment) {
            $user->notify(new CommentNotification($wsp, $route, $subject, $comment));
        });
    }

    static public function postReview($status, $wsp_id, $route, $subject)
    {
        $body = "The status has been changed by " . auth()->user()->getRoleNames()->first() . " to: " . $status;
        $wsp = Wsp::find($wsp_id);
        $users = self::getRecipient($status, $wsp);
        $users->each(function ($user) use ($wsp, $route, $subject, $body) {
            $user->notify(new ReviewNotification($wsp, $route, $subject, $body));
        });
    }

    static public function getRecipient($status, $wsp)
    {
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
