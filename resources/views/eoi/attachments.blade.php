@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Expression Of Interest Form Attachments') }}</div>
                <div class="card-body">
                    <p>The following documents are attached to support this request:</p>
                    <ul>
                        <li>Documents accrediting the [Name of WSP] registration under the Company Act</li>
                        <li>Copy of licence with WASREB.</li>
                        <li>Map of the area to be served identifying the low income areas targeted by the project, as
                            per the LIA mapping by WASREB.
                        </li>
                        <li>Audited Financial Statement for 2018/19</li>
                        <li>Approved Strategic plan</li>
                    </ul>
                    <manage-attachments inline-template delete_url="{{ route('eoi.attachments.destroy',0) }}">
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
                                           href="{{ route('eoi.attachments.show',$attachment->name) }}">{{ $attachment->display_name }}
                                            <i class="fa fa-file"></i></a></td>
                                    <td>{{ $attachment->document_type }}</td>
                                    <td>{{ $attachment->created_at->format('d-M-Y') }}</td>
                                    <th><button class="btn btn-sm btn-danger"
                                           @click="deleteAttachment({{ json_encode($attachment) }})"><i
                                                class="fa fa-trash"></i></button></th>
                                </tr>
                            @endforeach
                        </table>
                    </manage-attachments>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{$progress}}%;"
                             aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">{{$progress}}%
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <attachment-form submit-url="{{ route('eoi.attachments.store',$eoi->id) }}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



