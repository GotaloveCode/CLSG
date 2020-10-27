@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Expression Of Interest Form Attachments') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Expression Of Interest Form Attachments') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="justify-content-center">
        <div class="card">
            <div class="card-body">
                @if($progress == 100 && $eoi->status == "Pending")
                    <div class="alert alert-success alert-dismissible mb-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Well done!</strong> You have successfully submit your <a
                            href="{{ route('eois.show',$eoi->id) }}" class="alert-link">EOI</a> for review.
                    </div>
                @endif
                <p>The following documents are attached to support this request:</p>
                <ul>
                    <li>Documents accrediting the {{ $wsp->name }} registration under the Company Act</li>
                    <li>Copy of licence with WASREB.</li>
                    <li>Map of the area to be served identifying the low income areas targeted by the project, as
                        per the LIA mapping by WASREB.
                    </li>
                    <li>Audited Financial Statement for 2018/19</li>
                    <li>Approved Strategic plan</li>
                </ul>
                <manage-attachments inline-template delete_url="{{ route('eois.attachments.destroy',0) }}">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Document Name</th>
                            <th>Document Type</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                        </thead>
                        @foreach($eoi->attachments as $attachment)
                            <tr>
                                <td><a target="_blank"
                                       href="{{ route('eois.attachments.show',$attachment->name) }}">{{ $attachment->display_name }}
                                        <i class="feather icon-file"></i></a></td>
                                <td>{{ $attachment->document_type }}</td>
                                <td>{{ $attachment->created_at->format('d-M-Y') }}</td>
                                <th>
                                    @if($eoi->status == "Pending" || $eoi->status == "Needs Review")
                                        <button class="btn btn-sm btn-danger"
                                                @click="deleteAttachment({{ json_encode($attachment) }})"><i
                                                class="feather icon-trash"></i></button>
                                    @endif
                                </th>
                            </tr>
                        @endforeach
                    </table>
                </manage-attachments>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{$progress}}%;"
                         aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">{{$progress}}%
                    </div>
                </div>

                @if($eoi->status == "Pending" || $eoi->status == "Needs Review")
                    <div class="row">
                        <attachment-form
                            :documents="['Company Registration Document','Copy of licence with WASREB','Audited Financial Statement for 2018/19','Approved Strategic plan','Map of the area to be served']"
                            submit-url="{{ route('eois.attachments.store',$eoi->id) }}"/>
                    </div>
            </div>
            @endif
        </div>
    </div>
    </div>
@endsection
