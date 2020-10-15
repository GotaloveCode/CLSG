@extends('layouts.app')

@section('content')
    <div class="container">
        <manage-review inline-template submit-url="{{ route('eoi.review',$eoi->id) }}">
            <div class="row">
                <div class="col-md-8">
                    @include('preview.eoi')
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$progress}}%;"
                                 aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">{{$progress}}%
                            </div>
                        </div>
                        <h5></h5>
                    </div>
                    <div class="p-2">
                        @can('review-eoi')
                            @if(auth()->user()->hasRole('wasreb'))
                                @if($eoi->status=='Pending' || $eoi->status =='Needs Review')
                                    <button class="btn btn-success ml-2" @click.prevent="review('WASREB Approved')"><i
                                            class="fa fa-check"></i>
                                        Approve
                                    </button>
                                @endif
                            @elseif(auth()->user()->hasRole('wft'))
                                @if($eoi->status =='Wasreb Approved')
                                    <button class="btn btn-success ml-2" @click.prevent="review('WFT Approved')"><i
                                            class="fa fa-check"></i>
                                        Approve
                                    </button>
                                @endif
                            @endif
                            <button class="btn btn-danger" @click.prevent="review('Needs Review')"><i
                                    class="fa fa-pencil"></i>
                                Review
                            </button>
                        @endcan
                    </div>
                    <div class="detailBox">
                        <div class="titleBox">
                            <label>Comment Box</label>
                            <button type="button" class="close" aria-hidden="true">&times;</button>
                        </div>
                        <div class="actionBox">
                            <ul class="commentList">
                                @foreach($eoi->comments as $comment)
                                    @php
                                        $user_role = auth()->user()->roles()->first()->name;
                                        $comment_role = $comment->user->roles()->first()->name
                                    @endphp
                                    <li>
                                        <div
                                            class="profileBox @if($comment_role != $user_role) text-success @else text-info @endif">{{ strtoupper($comment_role) }}</div>
                                        <div class="commentText">
                                            <p class="">{!! $comment->description !!}</p>
                                            <span
                                                class="date sub-text">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @can('comment-eoi')
                            <comment-form submit-url="{{ route('eoi.comment',$eoi->id) }}"/>
                        @endcan
                    </div>
                </div>
            </div>
        </manage-review>
    </div>
@endsection
@push('css')
    <style>
        .detailBox {
            border: 1px solid #bbb;
            margin: 15px;
        }

        .titleBox {
            background-color: #fdfdfd;
            padding: 10px;
        }

        .titleBox label {
            color: #444;
            margin: 0;
            display: inline-block;
        }

        .actionBox .form-group * {
            width: 100%;
        }

        .commentList {
            padding: 0;
            list-style: none;
            max-height: 600px;
            overflow: auto;
        }

        .commentList li {
            margin: 10px 0 0;
            border-bottom: 1px solid #9fa2a5;
        }

        .commentText p {
            margin: 0;
        }

        .sub-text {
            color: #aaa;
            font-size: 11px;
        }

        .actionBox {
            border-top: 1px dotted #bbb;
            padding: 10px;
        }
    </style>
@endpush
