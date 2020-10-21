@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('BCP Form Review') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('BCP Form Review') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <manage-review inline-template submit-url="{{ route('bcps.review',$bcp->id) }}">
        <div class="row">
            <div class="content-detached content-left">
                <div class="content-body">
                    <section class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('preview.bcp')
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="sidebar-detached sidebar-right">
                <div class="sidebar">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">BCP Status</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="insights">
                                    <p>{{$bcp->status}}<span class="float-right text-warning h3">{{$progress}}%</span>
                                    </p>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                             style="width: {{$progress}}%"
                                             aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div>
                                    @can('review-bcp')
                                        @if(auth()->user()->hasRole('wasreb'))
                                            @if($bcp->status =='Needs Review')
                                                <button class="btn btn-success ml-2 mb-1"
                                                        @click.prevent="review('WASREB Approved')"><i
                                                        class="feather icon-check"></i>
                                                    Approve
                                                </button>
                                            @endif
                                            @if($bcp->status =='Pending' || $bcp->status =='draft')
                                                <button class="btn btn-danger mb-1"
                                                        @click.prevent="review('Needs Review')"><i
                                                        class="fa fa-pencil"></i>
                                                    Review
                                                </button>
                                            @endif
                                        @elseif(auth()->user()->hasRole('wstf'))
                                            @if($bcp->status =='WASREB Approved')
                                                <button class="btn btn-success ml-2 mb-1"
                                                        @click.prevent="review('WSTF Approved')"><i
                                                        class="fa fa-check"></i>
                                                    Approve
                                                </button>
                                                <button class="btn btn-danger mb-1"
                                                        @click.prevent="review('Needs Review')"><i
                                                        class="fa fa-pencil"></i>
                                                    Review
                                                </button>
                                            @endif
                                            @if($bcp->status =='WSTF Approved')
                                                
                                            @endif
                                        @endif

                                    @endcan
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
                                @foreach($bcp->comments as $comment)
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
                        <comment-form submit-url="{{ route('bcps.comment',$bcp->id) }}"/>
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
