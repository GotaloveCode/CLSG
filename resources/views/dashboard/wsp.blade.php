@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css/pages/timeline.min.css")}}"/>
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
            $erp_route = $erp ? route('bcps.show',$erp->id) : '#';
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
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Basic Timeline</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                    <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="card-text">
                    <section class="cd-horizontal-timeline">
                        <div class="timeline">
                            <div class="events-wrapper">
                                <div class="events">
                                    <ol>
                                        @if($eoi)
                                            <li><a href="#0" data-date="{{ $eoi->updated_at->format('d/m/Y') }}"
                                                   class="selected">{{ $eoi->updated_at->format('d M') }}</a></li>
                                        @endif
                                        @if($att)
                                            <li><a href="#0"
                                                   data-date="{{$att->updated_at->format('d/m/Y')}}">{{ $att->updated_at->format('d M') }}</a>
                                            </li>
                                        @endif
                                        @if($wsp->staff()->first())
                                            <li><a href="#0"
                                                   data-date="{{$wsp->staff()->first()->created_at->format('d/m/Y')}}">{{$wsp->staff()->first()->created_at->format('d M')}}</a>
                                            </li>
                                        @endif
                                        @if($bcp)
                                            <li><a href="#0" data-date="{{ $bcp->updated_at->format('d/m/Y') }}">{{ $bcp->updated_at->format('d M') }}</a></li>
                                        @endif
                                        {{--                                        <li><a href="#0" data-date="20/12/2012">Create BCP</a></li>--}}
                                        {{--                                        <li><a href="#0" data-date="20/03/2013">Sign of CLSGA</a></li>--}}
                                        {{--                                        <li><a href="#0" data-date="20/06/2013">Submit Monthly Reports</a></li>--}}
                                        {{--                                        <li><a href="#0" data-date="20/09/2013">Funds Disbursed</a></li>--}}
                                    </ol>

                                    <span class="filling-line" aria-hidden="true"></span>
                                </div>
                                <!-- .events -->
                            </div>
                            <!-- .events-wrapper -->

                            <ul class="cd-timeline-navigation">
                                <li><a href="#0" class="prev inactive">Prev</a></li>
                                <li><a href="#0" class="next">Next</a></li>
                            </ul>
                            <!-- .cd-timeline-navigation -->
                        </div>
                        <!-- .timeline -->

                        <div class="events-content">
                            <ol>
                                @if($eoi)
                                    <li class="selected" data-date="{{ $eoi->updated_at->format('d/m/Y') }}">
                                        <h2>Expression of Interest Form</h2>
                                        <h3 class="text-muted mb-1">
                                            <em>{{ $eoi ? "Submitted on ".$eoi->updated_at->format('M d, Y') : 'Pending Submission' }}</em>
                                        </h3>
                                        <p class="lead">
                                            Submit the Expression of interest form and attach the required attachments.
                                        </p>
                                        <p class="text-muted"> Status - {{ $eoi->status }}</p>
                                    </li>
                                @endif
                                @if($att)
                                    <li data-date="{{ $eoi->updated_at->format('d/m/Y') }}">
                                        <h2>Sign Commitment Letter</h2>
                                        <h3 class="text-muted mb-1">
                                            <em>{{ $att ? "Uploaded on ". $att->updated_at->format('M d, Y') : 'Pending' }}</em>
                                        </h3>
                                        <p class="lead">
                                            Once the EOI has been reviewed and accepted.Download the Commitment letter
                                            sign
                                            and upload
                                        </p>
                                    </li>
                                @endif
                                @if($wsp->staff()->first())
                                    <li data-date="{{$wsp->staff()->first()->created_at->format('d M')}}">
                                        <h2>Add Staff</h2>
                                        <h3 class="text-muted mb-1">
                                            <em>{{$wsp->staff()->first()->created_at->format('M d, Y')}}</em></h3>
                                        <p class="lead">
                                            Add staff members in preparation to create BCP.
                                        </p>
                                    </li>
                                @endif
                                @if($erp)
                                    <li data-date="{{ $erp->updated_at->format('d/m/Y') }}">
                                        <h2>Create ERP</h2>
                                        <h3 class="text-muted mb-1">
                                            <em>{{ $erp ? "Submitted on ".$erp->updated_at->format('M d, Y') : 'Pending Submission' }}</em>
                                        </h3>
                                        <p class="lead">
                                            Create Emergency Response Plan. This should compliment your Business
                                            Continuity
                                            Plan.
                                        </p>
                                    </li>
                                @endif
                                @if($bcp)
                                    <li data-date="{{ $bcp->updated_at->format('d/m/Y') }}">
                                        <h2>Create BCP</h2>
                                        <h3 class="text-muted mb-1">
                                            <em>{{ $bcp ? "Submitted on ".$bcp->updated_at->format('M d, Y') : 'Pending Submission' }}</em>
                                        </h3>
                                        <p class="lead">
                                            Create Business Continuity Plan and submit.
                                        </p>
                                    </li>
                                @endif
                                {{--                                    <li data-date="20/03/2013">--}}
                                {{--                                        <h2>Sign of CLSGA</h2>--}}
                                {{--                                        <p class="lead">--}}
                                {{--                                            Sign of CLSGA upon agreement by all parties (WSP and WSTF).--}}
                                {{--                                        </p>--}}
                                {{--                                    </li>--}}

                                {{--                                <li data-date="20/06/2013">--}}
                                {{--                                    <h2>Submit Monthly Reports</h2>--}}
                                {{--                                    <p class="lead">--}}
                                {{--                                        Submit Monthly Reports--}}
                                {{--                                    </p>--}}
                                {{--                                </li>--}}

                                {{--                                <li data-date="20/09/2013">--}}
                                {{--                                    <h2>Funds Disbursed</h2>--}}
                                {{--                                    <p class="lead">--}}
                                {{--                                        Funds get disbursed to accounts--}}
                                {{--                                    </p>--}}
                                {{--                                </li>--}}
                            </ol>
                        </div>
                        <!-- .events-content -->
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('app-assets/vendors/js/timeline/horizontal-timeline.js')}}"></script>
@endpush
