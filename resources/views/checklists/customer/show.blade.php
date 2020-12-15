@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Vulnerable Customers') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Vulnerable Customers') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <manage-review inline-template submit-url="{{ route('vulnerable-customer.review',$customer->id) }}">
        <div class="row">
            <div class="content-detached content-left">
                <div class="content-body">
                    <section class="row">
                        @php
                            $completed = 0;
    $in_progress= 0;
    $count=0;
    $not_started = 0;
                        foreach(json_decode($customer->customer_details) as $ess){
                            $count++;
                           switch ($ess->status){
                               case 'Completed':
                               $completed++;
                               break;
                               case 'In Progress':
                                $in_progress++;
                                 break;
                               default:
                                    $not_started++;
                           }
                        }
                        @endphp
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="insights">
                                            <p> {{ $completed }} Completed
                                                <span
                                                    class="float-right text-success h3">{{ceil($completed/$count *100)}}%</span>
                                            </p>
                                            <div class="progress progress-sm mt-1 mb-0">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: {{ ceil($completed/$count *100) }}%"
                                                     aria-valuenow="{{ ceil($completed/$count *100) }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="insights">
                                            <p> {{ $in_progress }} In Progress
                                                <span
                                                    class="float-right text-warning h3">{{ceil($in_progress/$count *100)}}%</span>
                                            </p>
                                            <div class="progress progress-sm mt-1 mb-0">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                     style="width: {{ ceil($in_progress/$count *100) }}%"
                                                     aria-valuenow="{{ ceil($in_progress/$count *100) }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="insights">
                                            <p> {{ $not_started }} Not Started
                                                <span
                                                    class="float-right text-danger h3">{{ceil($not_started/$count *100)}}%</span>
                                            </p>
                                            <div class="progress progress-sm mt-1 mb-0">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: {{ ceil($not_started/$count *100) }}%"
                                                     aria-valuenow="{{ ceil($not_started/$count *100) }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <a class="heading-elements-toggle"><i
                                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a href="{{ route('vulnerable-customer.show',['vulnerable_customer' => $customer->id,'print' => 'pdf']) }}"
                                                   target="_blank"><i
                                                        class="feather icon-printer"></i></a>
                                            </li>
                                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @include('preview.customer-report')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="sidebar-detached sidebar-right">
                <div class="sidebar">
                    @can('create_bcp')
                        @if($customer->status != 'WSTF Approved')
                            <div class="mb-2">
                                <a class="btn btn-info" href="{{ route('vulnerable-customer.create') }}"><i
                                        class="feather icon-edit"></i>
                                    Edit</a>
                            </div>
                        @endif
                    @endcan
                    <div>
                        @can('review_bcp')
                            @if(auth()->user()->hasRole('wasreb'))
                                @if($customer->status=='Pending')
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
                                @if($customer->status =='WASREB Approved')
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
                                    <p>{{$customer->status == 'WASREB Approved' ? 'Pending Approval' : $customer->status}}
                                        <span
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
                                    @foreach($customer->comments as $comment)
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
                                <comment-form submit-url="{{ route('vulnerable-customer.comment',$customer->id) }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </manage-review>
@endsection
