@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/comment.css') }}">
@endpush
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
                                <div class="card-header">
                                    <h4 class="card-title">Business Continuity Plan</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a href="{{ route('bcps.show',['bcp' => $bcp->id,'print' => 'pdf']) }}"><i
                                                        class="feather icon-printer"></i></a>
                                            </li>
                                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @role('wasreb')
                                        @if($bcp->status !== "WSTF Approved")
                                            <div class="alert alert-success alert-dismissible mb-2" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <strong>Note: </strong> <a href="#mgm">Set the Monthly Grant
                                                    Multiplier</a> to be applied to the BCP before approving this BCP!
                                            </div>
                                        @endif
                                        @endrole
                                        @include('preview.bcp')
                                    </div>
                                </div>
                            </div>
                            <div class="card" id="mgm">
                                <div class="card-header">
                                    <h4 class="card-title">Business Continuity Plan Monthly Grant Multiplier</h4>
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
                                        @role('wasreb')
                                        @if($bcp->status !== "WSTF Approved")
                                            <mgm-form class="mb-2"
                                                      submit-url="{{ route('bcps.mgm', $bcp->id) }}"></mgm-form>
                                        @endif
                                        @endrole
                                        @if($bcp->mgms->count() > 0)
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Year</th>
                                                    <th>Monthly Grant Multiplier</th>
                                                </tr>
                                                </thead>
                                                @foreach($bcp->mgms as $mgm)
                                                    <tr>
                                                        <td>{{ getMonthName($mgm->month) }}</td>
                                                        <td>{{ $mgm->year }}</td>
                                                        <td>{{ $mgm->amount }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">BCP Attachments</h4>
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
                                            @foreach($bcp->attachments as $attachment)
                                                <tr>
                                                    <td><a target="_blank"
                                                           href="{{ route('bcps.attachments.show',$attachment->name) }}">{{ $attachment->display_name }}
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
                        @if($bcp->status=='Pending' || $bcp->status =='Needs Review')
                            <div class="mb-2">
                                <a class="btn btn-info" href="{{ route('bcps.create') }}"><i
                                        class="feather icon-edit"></i>
                                    Edit</a>
                                <a class="btn btn-primary" href="{{ route('bcps.attachments' ,$bcp->id) }}"><i
                                        class="feather icon-file"></i> Edit Attachments</a>
                            </div>
                        @endif
                    @endcan
                    <div>
                        @can('review-bcp')
                            @if(auth()->user()->hasRole('wasreb'))
                                @if($bcp->status=='Pending')
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
                            @endif
                        @endcan
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">BCP Status</h4>
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
                                    <p>{{$bcp->status}}<span class="float-right text-warning h3">{{$progress}}%</span>
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
                                    @foreach($bcp->comments as $comment)
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
                                <comment-form submit-url="{{ route('bcps.comment',$bcp->id) }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </manage-review>

@endsection

