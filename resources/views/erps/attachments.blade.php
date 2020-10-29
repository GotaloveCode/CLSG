@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Emergency Response Plan Attachments') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Emergency Response Plan Attachments') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="justify-content-center">
        <div class="card">
            <div class="card-body">
                @if($progress < 100 && $erp->status !== "WSTF Approved")
                    <div class="alert alert-success alert-dismissible mb-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Almost there!</strong> ERP will be considered binding upon attachment and review of the documents indicated below by WASREB!
                    </div>
                @endif
                <p>The following documents are attached to support this request:</p>
                <ul>
                    <li>Signed Copy of ERP document </li>
                    <li>Copy of board resolution or minutes of board meeting approving the plan</li>
                </ul>
                <manage-attachments inline-template delete_url="{{ route('erps.attachments.destroy',0) }}">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Document Name</th>
                            <th>Document Type</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                        </thead>
                        @foreach($erp->attachments as $attachment)
                            <tr>
                                <td><a target="_blank"
                                       href="{{ route('erps.attachments.show',$attachment->name) }}">{{ $attachment->display_name }}
                                        <i class="feather icon-file"></i></a></td>
                                <td>{{ $attachment->document_type }}</td>
                                <td>{{ $attachment->created_at->format('d-M-Y') }}</td>
                                <th>
                                    @if($erp->status != "WSTF Approved")
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
                @if($erp->status != "WSTF Approved")
                    <div class="row">
                        <div class="col-md-12">
                            <attachment-form :documents="['Signed ERP Document','Board Resolution on ERP','Board Meeting Minutes on ERP']" submit-url="{{ route('erps.attachments.store',$erp->id) }}"/>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
