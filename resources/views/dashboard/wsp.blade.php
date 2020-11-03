@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css/pages/timeline.min.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css/pages/vertical-timeline.min.css")}}"/>
@endpush
@section('content')
    <div class="row">
        @php
            $eoi_route = $eoi ? route('eois.show',$eoi->id) : '#';
        @endphp
        <a href="{{ $eoi_route }}" class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="primary">{{ $eoi ? $eoi->progress() : 0 }} %</h3>
                                <span>EOI Status</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-edit primary font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress mt-1 mb-0" style="height: 7px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: {{ $eoi ? $eoi->progress() : 0 }}%"
                                 aria-valuenow="{{ $eoi ? $eoi->progress() : 0 }}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @php
            $commitment_route = $eoi ? route('eois.commitment_letter',$eoi->id) : '#';
        @endphp
        <a href="{{ $commitment_route }}" class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                @php
                                    $commitment = 0;

                                    if($eoi){
                                        $att = $eoi->attachments()->where('display_name','Commitment Letter')->first();
                                        if($att){
                                            $commitment = 100;
                                        }
                                    }
                                @endphp
                                <h3 class="warning">{{ $commitment }} %</h3>
                                <span>Commitment Letter Status</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-book-open warning font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress mt-1 mb-0" style="height: 7px;">
                            <div class="progress-bar bg-warning" role="progressbar"
                                 style="width: {{ $commitment }}%"
                                 aria-valuenow="{{ $commitment }}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @php
            $bcp_route = $bcp ? route('bcps.show',$bcp->id) : '#';
        @endphp
        <a href="{{ $bcp_route }}" class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="success">{{ $bcp ? $bcp->progress() : 0 }} %</h3>
                                <span>BCP Status</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-briefcase success font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress mt-1 mb-0" style="height: 7px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                 style="width: {{ $bcp ? $bcp->progress() : 0 }}%"
                                 aria-valuenow="{{ $bcp ? $bcp->progress() : 0 }}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @php
            $erp_route = $erp ? route('erps.show',$erp->id) : '#';
        @endphp
        <a href="{{ $erp_route }}" class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="danger">{{ $erp ? $erp->progress() : 0 }} %</h3>
                                <span>ERP Status</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-life-buoy danger font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress mt-1 mb-0" style="height: 7px;">
                            <div class="progress-bar bg-danger" role="progressbar"
                                 style="width: {{ $erp ? $erp->progress() : 0 }}%"
                                 aria-valuenow="{{ $erp ? $erp->progress() : 0 }}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="row">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-bold-500">Basic Timeline</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pt-0">
                        <div class="widget-timeline">
                            <ul>
                                <li class="timeline-items @if($eoi) timeline-icon-success @else timeline-icon-warning @endif">
                                    @if($eoi)
                                        <p class="timeline-time">{{ $eoi->updated_at->diffForHumans() }}</p>
                                    @endif
                                    <div class="timeline-title">Expression of Interest Form</div>
                                    <div class="timeline-subtitle">
                                        Submit the Expression of interest form and attach the required attachments.
                                        <small>
                                            -- {{ $eoi ? "Submitted on ".$eoi->updated_at->format('M d, Y') : 'Pending Submission' }}</small>
                                    </div>
                                    <span
                                        class="badge badge-pill badge-sm {{ $eoi->status == 'WASREB Approved' ? 'badge-success' : 'bagde-warning'}}">{{ $eoi->status == 'Pending' ? 'Pending Review By WASREB' : $eoi->status}}</span>
                                </li>
                                <li class="timeline-items @isset($att) timeline-icon-success @else timeline-icon-warning @endisset">
                                    @isset($att)
                                        <p class="timeline-time">{{ $att->updated_at->diffForHumans() }}</p>
                                    @endisset
                                    <div class="timeline-title">Sign Commitment Letter</div>
                                    <div class="timeline-subtitle">
                                        Once the EOI has been reviewed and accepted.Download the signed Commitment
                                        letter from WSTF sign and upload
                                        <small>
                                            -- {{ $att ? "Uploaded on ".$att->updated_at->format('M d, Y') : 'Pending' }}</small>
                                    </div>
                                    @isset($att)
                                        <span class="badge badge-pill badge-sm badge-success">Uploaded</span>
                                    @endisset
                                </li>
                                @php
                                    $staff = $wsp->staff()->first();
                                @endphp
                                <li class="timeline-items @if($staff) timeline-icon-success @else timeline-icon-warning @endif">
                                    @if($staff)
                                        <p class="timeline-time">{{ $staff->updated_at->diffForHumans() }}</p>
                                    @endif
                                    <div class="timeline-title">Add Staff</div>
                                    <div class="timeline-subtitle">
                                        Add staff members in preparation to create BCP.
                                    </div>
                                    @if($staff)
                                        <span class="badge badge-pill badge-sm badge-success">Created</span>
                                    @endif
                                </li>
                                <li class="timeline-items @if($erp) timeline-icon-success @else timeline-icon-warning @endif">
                                    <p class="timeline-time">{{ $erp->updated_at->diffForHumans() }}</p>
                                    <div class="timeline-title">Create ERP</div>
                                    <div class="timeline-subtitle">
                                        Create Emergency Response Plan. This should compliment your Business Continuity
                                        Plan.
                                        @if($erp)
                                            <small>{{ $erp ? "Submitted on ".$erp->updated_at->format('M d, Y') : 'Pending Submission' }}</small>
                                        @endif
                                    </div>
                                </li>
                                <li class="timeline-items @if($bcp) timeline-icon-success @else timeline-icon-warning @endif">
                                    <p class="timeline-time">{{ $bcp->updated_at->diffForHumans() }}</p>
                                    <div class="timeline-title">Create BCP</div>
                                    <div class="timeline-subtitle">
                                        Create Business Continuity Plan and submit.
                                        @if($bcp)
                                            <small>{{ $bcp ? "Submitted on ".$bcp->updated_at->format('M d, Y') : 'Pending Submission' }}</small>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-bold-500">Recent Activity</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pt-0">
                        <div class="widget-timeline">
                            <ul>
                                @foreach($notifications as $notification)
                                    <li class="timeline-items timeline-icon-info">
                                        <p class="timeline-time">{{ $notification->created_at->diffForHumans() }}</p>
                                        <div class="timeline-title"><a
                                                href="{{ $notification->data['url'] }}">{{ $notification->data['title'] }}</a>
                                        </div>
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
@push('scripts')
    <script src="{{asset('app-assets/vendors/js/timeline/horizontal-timeline.js')}}"></script>
@endpush
