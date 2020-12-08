@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/comment.css') }}">
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('CLSG Agreement') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('CLSG Agreement') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

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
                                            <a href="{{ route('clsg.show',['wsp' => $wsp->id,'print' => 'pdf']) }}"
                                               target="_blank"><i class="feather icon-printer"></i></a>
                                        </li>
                                        <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    @include('preview.clsg')
                                </div>
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
                            <p><strong>The wsp should proceed as follows:</strong></p>
                            <ol>
                                <li>Download CLSGA</li>
                                <li>Sign CLSGA</li>
                                <li>Upload CLSGA</li>
                            </ol>
                            <file-upload document-name="Signed CLSGA"
                                         submit-url="{{ route('clsg.upload', $wsp->id) }}"></file-upload>
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
                            <ol>
                                @foreach($wsp->attachments->where('document_type','CLSGA') as $attachment)
                                    <li>
                                        <a href="{{ route('clsg.attachments.show',['filename' =>$attachment->name, 'download' =>'true']) }}"
                                           target="_blank">{{$attachment->name}} <i
                                                class="feather icon-download"></i></a></li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
