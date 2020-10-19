<?php


namespace App\Traits;
use App\Mail\EoiComment;
use App\Mail\EoiReview;
use Illuminate\Support\Facades\Mail;

trait SendMailNotification
{

    static public function postComment($comment){
        Mail::to(auth()->user())->send(new EoiComment($comment));
    }
    static public function postReview($status){
        Mail::to(auth()->user())->send(new EoiReview($status));
    }
}
