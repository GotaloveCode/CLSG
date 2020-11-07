@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('WSP Monthly Reporting') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('WSP Monthly Reporting') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            @if($wsp_report)
                <wsp-reporting
                    :operation-costs="{{ $operationCosts }}"
                    :services="{{$services}}"
                    :wsp_report="{{$wsp_report}}"
                ></wsp-reporting>
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header pb-0">
                                <h6 class="card-title">WSP Reporting Attachments</h6>
                                <a class="heading-elements-toggle"><i
                                        class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info alert-dismissible mb-2" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Note: </strong> Please attach evidence for each operational cost!
                                </div>
                                <attachment-form
                                    :documents="['Expected activities','Revenues collected','O&M costs','COVID-19 interventions status']"
                                    submit-url="{{ route('wsp-reporting.attachments.store',json_decode($wsp_report)->id) }}"/>
                            </div>
                        </div>
                    </div>
                </div>
{{--            TODO: add mitigation costs to potential risks ?--}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p>The following documents are attached to support this request:</p>
                            <manage-attachments inline-template delete_url="{{ route('wsp-reporting.attachments.destroy',0) }}">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Document Type</th>
                                        <th>Created</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    @foreach($attachments as $attachment)
                                        <tr>
                                            <td><a target="_blank"
                                                   href="{{ route('wsp-reporting.attachments.show',$attachment->name) }}">{{ $attachment->display_name }}
                                                    <i class="feather icon-file"></i></a></td>
                                            <td>{{ $attachment->document_type }}</td>
                                            <td>{{ $attachment->created_at }}</td>
                                            <th>
                                                @if(json_decode($wsp_report)->status != "WSTF Approved")
                                                    <button class="btn btn-sm btn-danger"
                                                            @click="deleteAttachment({{ json_encode($attachment) }})"><i
                                                            class="feather icon-trash"></i></button>
                                                @endif
                                            </th>
                                        </tr>
                                    @endforeach
                                </table>
                            </manage-attachments>
                        </div>
                    </div>
                </div>
            @else
                <wsp-reporting
                    :operation-costs="{{ $operationCosts }}"
                    :services="{{$services}}"
                ></wsp-reporting>
            @endif
        </div>
    </div>
@endsection
