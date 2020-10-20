<?php


namespace App\Traits;
use App\Mail\EoiComment;
use App\Mail\EoiReview;
use App\Models\Wsp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

trait SendMailNotification
{

    static public function postComment($comment,$status,$subject){
       Mail::to(self::getSender($status))->send(new EoiComment($comment,$subject));
    }
    static public function postReview($status,$subject){
        Mail::to(self::getSender($status))->send(new EoiReview($status,$subject));
    }

    static public function getSender($status)
    {
        switch ($status){
            case 'WSTF Approved':
                $sender = User::role(["wasreb","wsp"])->get();
                break;
            case 'WASREB Approved':
                $sender = User::role(["wstf","wsp"])->get();
                break;
            case 'Needs Approval':
                $sender = User::role(["wasreb","wstf"])->get();
                break;
            default:
                $sender = User::role(["wsp","wstf","wasreb"])->get();
        }
        return $sender;
    }
}
