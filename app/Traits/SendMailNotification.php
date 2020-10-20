<?php


namespace App\Traits;
use App\Mail\EoiComment;
use App\Mail\EoiReview;
use App\Models\Wsp;
use Illuminate\Support\Facades\Mail;

trait SendMailNotification
{

    static public function postComment($comment,$status){
        $sender='';
        switch ($status){
            case 'WSTF Approved':
                $sender = 100;
                break;
            case 'WASREB Approved':
                $sender = 75;
                break;
            case 'Needs Approval':
                $sender = Wsp::first();
                break;
            default:
                $sender = Wsp::first();
        }
        if ($status=='draft') $sender = Wsp::first();
        Mail::to(Wsp::first())->send(new EoiComment($comment,Wsp::first()));
    }
    static public function postReview($status){
        Mail::to(Wsp::first())->send(new EoiReview($status,Wsp::first()));
    }
}
