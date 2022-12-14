@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Business Continuity Plan Attachments') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Business Continuity Plan Attachments') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="justify-content-center">
        <div class="card">
            <div class="card-body">
                <p>The following documents are attached to support this request:</p>
                <ul>
                    <li>Signed Copy of BCP document </li>
                    <li>Copy of board resolution or minutes of board meeting approving the plan</li>
                </ul>
                <manage-attachments inline-template delete_url="{{ route('bcps.attachments.destroy',0) }}">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Document Name</th>
                            <th>Document Type</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                        </thead>
                        @foreach($bcp->attachments as $attachment)
                            <tr>
                                <td><a target="_blank"
                                       href="{{ route('bcps.attachments.show',$attachment->name) }}">{{ $attachment->display_name }}
                                        <i class="feather icon-file"></i></a></td>
                                <td>{{ $attachment->document_type }}</td>
                                <td>{{ $attachment->created_at->format('d-M-Y') }}</td>
                                <th>
                                    @if($bcp->status != "WSTF Approved")
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
                @if($bcp->status != "WSTF Approved")
                    <div class="row">
                        <div class="col-md-12">
                            <attachment-form :documents="['Signed BCP Document','Board Resolution','Board Meeting Minutes']" submit-url="{{ route('bcps.attachments.store',$bcp->id) }}"/>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
