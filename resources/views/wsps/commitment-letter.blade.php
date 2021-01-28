@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Commitment Letter') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Commitment Letter') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-detached content-left">
        <div class="content-body">
            <section class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('preview.commitment-letter')
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
                    <h4 class="card-title">INSTRUCTIONS</h4>
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
                        @role("wsp")
                        <p><strong>The wsp should proceed as guided below:</strong></p>
                        <ol>
                            <li>Download Commitment Letter Signed by WSTF</li>
                            <li>Sign commitment letter</li>
                            <li>Upload signed commitment letter</li>
                        </ol>
                        @else
                        <p><strong>WSTF should proceed as guided below:</strong></p>
                        <ol>
                            <li>Download Commitment Letter</li>
                            <li>Sign commitment letter</li>
                            <li>Upload signed commitment letter</li>
                            <li>Wait for WSP to download sign and reupload</li>
                        </ol>
                        @endrole
                        @if($eoi->status =='WSTF Approved')
                            @role("wstf")
                            @if($eoi->attachments->where('document_type','Commitment Letter')->count() == 0)
                                <a class="btn btn-primary mb-1" target="_blank"
                                   href="{{ route('eois.commitment_letter',['eoi'=> $eoi->id,'download' => 'pdf']) }}"><i
                                        class="fa fa-download"></i>
                                    Download
                                </a>
                            @endif
                            @endrole
                            <file-upload document-name="Signed Commitment Letter" submit-url="{{ route('eois.commitment_letter.store', $eoi->id) }}"></file-upload>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">SIGNED COPY</h4>
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
                        @if(auth()->user()->hasRole('wsp'))
                            @if($eoi->status=='WSTF Approved')
                                <a class="btn btn-primary mb-1" target="_blank"
                                   href="{{ route('eois.commitment_letter',['eoi'=> $eoi->id,'download' => 'pdf']) }}"><i
                                        class="fa fa-download"></i>
                                    Download
                                </a>
                            @endif
                        @endif
                        <ol>
                            @foreach($eoi->attachments->where('document_type','Commitment Letter') as $attachment)
                                <li>
                                    <a href="{{ route('eois.attachments.show',['filename' =>$attachment->name, 'download' =>'true']) }}"
                                       target="_blank">{{$attachment->name}} <i class="feather icon-download"></i></a></li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
