@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Essential Operations') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Essential Operations') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="card-headings">
            <div class="row">
                <a href="{{ route('essential-operation.print',json_decode($essential)->id) }}" style="margin-left: 90%"><i
                        class="feather icon-printer" style="font-size: 20px" title="Print"></i></a>
                <view-essential-operation
                    :essentials="{{$items}}"
                    :essential_item="{{$essential}}"
                ></view-essential-operation>
            </div>

        </section>
    </div>
    <manage-review inline-template submit-url="{{ route('essential-operation.review',$wsp_report->id) }}">
        <div class="row">
            <div class="content-detached content-left">
                <div class="content-body">
                    <section class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="heading-elements-toggle"><i
                                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a href="{{ route('essential-operation.show',['wsp_reporting' => $wsp_report->id,'print' => 'pdf']) }}" target="_blank"><i
                                                        class="feather icon-printer"></i></a>
                                            </li>
                                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @include('preview.essential-report')
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Essential Operations Reporting Attachments</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Document Name</th>
                                                <th>Document Type</th>
                                                <th>Created at</th>
                                            </tr>
                                            </thead>
                                            @foreach($wsp_report->attachments as $attachment)
                                                <tr>
                                                    <td><a target="_blank"
                                                           href="{{ route('essential-operation.attachments.show',$attachment->name) }}">{{ $attachment->display_name }}
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
                    @can('create-bcp')
                        @if($wsp_report->status != 'WSTF Approved')
                            <div class="mb-2">
                                <a class="btn btn-info" href="{{ route('essential-operation.create') }}"><i
                                        class="feather icon-edit"></i>
                                    Edit</a>
                            </div>
                        @endif
                    @endcan
                    <div>
                        @can('review-bcp')
                            @if(auth()->user()->hasRole('wasreb'))
                                @if($wsp_report->status=='Pending')
                                    <button class="btn btn-success ml-2 mb-1"
                                            @click.prevent="review('WASREB Approved')"><i
                                            class="feather icon-check"></i>
                                        Approve
                                    </button>
                                    <button class="btn btn-danger mb-1"
                                            @click.prevent="review('Needs Review')"><i
                                            class="fa fa-pencil"></i>
                                        Needs Review
                                    </button>
                                @endif
                            @elseif(auth()->user()->hasRole('wstf'))
                                @if($wsp_report->status =='WASREB Approved')
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
                            @endif
                        @endcan
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title">REPORT STATUS</p>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="insights">
                                    <p>{{$wsp_report->status == 'WASREB Approved' ? 'Pending Approval' : $wsp_report->status}}<span
                                            class="float-right text-warning h3">{{$progress}}%</span>
                                    </p>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                             style="width: {{$progress}}%"
                                             aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
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
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <ul class="commentList">
                                    @foreach($wsp_report->comments as $comment)
                                        @php
                                            $user_role = auth()->user()->roles()->first()->name;
                                            $comment_role = $comment->user->roles()->first()->name;
                                        if($user_role == 'wsp' && $comment_role == "WSTF") return;
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
                                <comment-form submit-url="{{ route('essential-operation.comment',$wsp_report->id) }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </manage-review>
@endsection
