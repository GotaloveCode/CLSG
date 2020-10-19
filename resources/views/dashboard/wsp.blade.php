@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
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
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
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
                                <h3 class="primary">{{ $commitment }} %</h3>
                                <span>Commitment Letter Status</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-book-open primary font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress mt-1 mb-0" style="height: 7px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: {{ $commitment }}%"
                                 aria-valuenow="{{ $commitment }}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="primary">{{ $bcp ? 100 : 0 }} %</h3>
                                <span>BCP Status</span>
                            </div>
                            <div class="align-self-center">
                                <i class="feather icon-briefcase primary font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress mt-1 mb-0" style="height: 7px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: {{ $bcp ? 100 : 0 }}%"
                                 aria-valuenow="{{ $bcp ? 100 : 0 }}" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
