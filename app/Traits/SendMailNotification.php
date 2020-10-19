<?php


namespace App\Traits;
use App\Mail\EoiComment;
use App\Mail\EoiReview;
use App\Models\Wsp;
use Illuminate\Support\Facades\Mail;

trait SendMailNotification
{

    static public function postComment($comment){
        Mail::to(Wsp::first())->send(new EoiComment($comment,Wsp::first()));
    }
    static public function postReview($status){
        Mail::to(Wsp::first())->send(new EoiReview($status,Wsp::first()));
    }
}
