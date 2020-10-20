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
                        <p><strong>The wsp should proceed as guided below:</strong></p>
                        <ol>
                            <li>Download Commitment Letter</li>
                            <li>Sign commitment letter</li>
                            <li>Upload signed commitment letter</li>
                        </ol>
                        @if($bcp->status =='WSTF Approved')
                            @if($bcp->attachments->where('document_type','Commitment Letter')->count() == 0)
                                <a class="btn btn-primary mb-1" target="_blank"
                                   href="{{ route('eois.commitment_letter',['eoi'=> $bcp->id,'download' => 'pdf']) }}"><i
                                        class="fa fa-download"></i>
                                    Download
                                </a>
                            @endif
                            <form action="{{ route('eois.commitment_letter.store', $bcp->id) }}" method="post"
                                  enctype="multipart/form-data" class="form">
                                @csrf
                                <div class="form-group">
                                    <label for="attachment" class="control-label">Signed Commitment letter</label>
                                    <input type="file" required name="attachment" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-info" type="submit"><i class="fa fa-upload"></i>Upload
                                    </button>
                                </div>
                            </form>
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
                            @if($bcp->status=='WSTF Approved')
                                <button class="btn btn-success ml-2 mb-1"
                                        @click.prevent="review('WASREB Approved')"><i
                                        class="feather icon-download"></i>
                                    Download
                                </button>
                            @endif
                        @elseif(auth()->user()->hasRole('wstf'))

                        @endif
                        <ol>
                            @foreach($bcp->attachments->where('document_type','Commitment Letter') as $attachment)
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
