<?php


namespace App\Traits;
use App\Mail\EoiComment;
use App\Mail\EoiReview;
use App\Models\Wsp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

trait SendMailNotification
{

    static public function postComment($comment,$status){
       Mail::to(self::getSender($status))->send(new EoiComment($comment,self::getSender($status)));
    }
    static public function postReview($status){
        Mail::to(self::getSender($status))->send(new EoiReview($status,self::getSender($status)));
    }

    static public function getSender($status)
    {
        switch ($status){
            case 'WSTF Approved':
                $sender = User::role("wasreb")->first();
                break;
            case 'WASREB Approved':
                $sender = User::role("wstf")->first();
                break;
            case 'Needs Approval':
                $sender = User::role("wasreb")->first();
                break;
            default:
                $sender = User::role("wsp")->first();
        }
        return $sender;
    }
}
