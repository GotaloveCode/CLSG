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

    <manage-review inline-template submit-url="{{ route('eois.review',$eoi->id) }}">
        <div class="row">
            <div class="content-detached content-left">
                <div class="content-body">
                    <section class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">EOI Form</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        @include('preview.eoi')
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">EOI Attachments</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Document Name</th>
                                                <th>Document Type</th>
                                                <th>Created at</th>
                                            </tr>
                                            </thead>
                                            @foreach($eoi->attachments as $attachment)
                                                <tr>
                                                    <td><a target="_blank"
                                                           href="{{ route('eois.attachments.show',$attachment->name) }}">{{ $attachment->display_name }}
                                                            <i class="feather icon-file"></i></a></td>
                                                    <td>{{ $attachment->document_type }}</td>
                                                    <td>{{ $attachment->created_at->format('d-M-Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="sidebar-detached sidebar-right">
                <div class="sidebar">
                    <div class="mb-2">
                        <a class="btn btn-info" href="{{ route('eois.create') }}"><i class="feather icon-edit"></i> Edit</a>
                        <a class="btn btn-primary" href="{{ route('eois.attachments' ,$eoi->id) }}"><i
                                class="feather icon-file"></i> Edit Attachments</a>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">EOI Status</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="insights">
                                    <p>{{$eoi->status}}<span class="float-right text-warning h3">{{$progress}}%</span>
                                    </p>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                             style="width: {{$progress}}%"
                                             aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div>
                                    @can('review-eoi')
                                        @if(auth()->user()->hasRole('wasreb'))
                                            @if($eoi->status=='Pending' || $eoi->status =='Needs Review')
                                                <button class="btn btn-success ml-2 mb-1"
                                                        @click.prevent="review('WASREB Approved')"><i
                                                        class="feather icon-check"></i>
                                                    Approve
                                                </button>
                                            @endif
                                            @if($eoi->status =='Pending' || $eoi->status =='draft')
                                                <button class="btn btn-danger mb-1"
                                                        @click.prevent="review('Needs Review')"><i
                                                        class="fa fa-pencil"></i>
                                                    Review
                                                </button>
                                            @endif
                                        @elseif(auth()->user()->hasRole('wstf'))
                                            @if($eoi->status =='WASREB Approved')
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
                                            @if($eoi->status =='WSTF Approved')
                                                <a class="btn btn-info mt-2"
                                                   href="{{ route('eois.commitment_letter',$eoi->id) }}"><i
                                                        class="feather icon-eye"></i>
                                                    View Commitment Letter
                                                </a>
                                            @endif
                                        @endif

                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Comment Box</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
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
                                <comment-form submit-url="{{ route('eois.comment',$eoi->id) }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </manage-review>

@endsection
@push('css')
    <style>
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
    </style>
@endpush
