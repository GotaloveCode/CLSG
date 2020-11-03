@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css/pages/vertical-timeline.min.css")}}"/>
@endpush
@section('content')
    <div class="row">
        <a href="{{ route('wsps.index') }}" class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="primary">{{ $wsp_count }}</h3>
                                <span>WSPs</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-briefcase primary font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('eois.index') }}" class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="primary">{{ $eoi_count }}</h3>
                                <span>EOIs</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-edit primary font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('bcps.index') }}" class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="primary">{{ $bcp_count }}</h3>
                                <span>BCPs</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-book-open primary font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('erps.index') }}" class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="primary">{{ $erp_count }}</h3>
                                <span>ERPs</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-life-buoy primary font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="row">
        <div class="col-xxl-4 col-xl-8 col-lg-8 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-bold-500">Latest Tasks</h4>
                </div>
                <div class="card-content pt-0 pb-1 px-2 position-relative ps">
                    <ul class="list-group">
                        <li class="list-group-item px-0 border-0 d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                              <span class="list-group-item-icon d-inline mr-1">
                                <i class="feather icon-edit bg-light-info text-info rounded-circle p-50"></i>
                              </span>
                                <div>
                                    <p class="mb-25 text-bold-600">Pending EOIs</p>
                                    <small class="font-small-3">Waiting for review</small>
                                </div>
                            </div>
                            <span class="text-bold-600">{{ $eoi_pending }}</span>
                        </li>
                        <li class="list-group-item pt-0 px-0 border-0 d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                              <span class="list-group-item-icon d-inline mr-1">
                                <i class="feather icon-book-open text-primary bg-light-primary rounded-circle p-50"></i>
                              </span>
                                <div>
                                    <p class="mb-25 text-bold-600">Pending BCPs</p>
                                    <small class="font-small-3">Waiting for review</small>
                                </div>
                            </div>
                            <span class="text-bold-600">{{ $bcp_pending }}</span>
                        </li>
                        <li class="list-group-item px-0 border-0 d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                          <span class="list-group-item-icon d-inline mr-1">
                            <i class="feather icon-life-buoy bg-light-danger text-danger rounded-circle p-50"></i>
                          </span>
                                <div>
                                    <p class="mb-25 text-bold-600">Pending ERPs</p>
                                    <small class="font-small-3">Waiting for review</small>
                                </div>
                            </div>
                            <span class="text-bold-600">{{ $erp_pending }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-bold-500">Recent Activity</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pt-0">
                        <div class="widget-timeline">
                            <ul>
                                @foreach($notifications as $notification)
                                    <li class="timeline-items timeline-icon-danger">
                                        <p class="timeline-time">{{ $notification->created_at->diffForHumans() }}</p>
                                        <div class="timeline-title"><a href="{{ $notification->data['url'] }}">{{ $notification->data['title'] }}</a></div>
                                        <div class="timeline-subtitle">{{ $notification->data['details'] }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
