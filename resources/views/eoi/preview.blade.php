@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Expression Of Interest Form Review') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Expression Of Interest Form Review') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <manage-review inline-template submit-url="{{ route('eoi.review',$eoi->id) }}">
        <div class="row">
            <div class="content-detached content-left">
                <div class="content-body">
                    <section class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('preview.eoi')
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="sidebar-detached sidebar-right">
                <div class="sidebar">
                    <div class="mb-2">
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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">EOI Status</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="insights">
                                    <p>{{$eoi->status}}<span class="float-right text-warning h3">{{$progress}}%</span></p>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$progress}}%"
                                             aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        </div>
    </manage-review>

@endsection
@push('css')
    <style>
        .detailBox {
            border: 1px solid #bbb;
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
