@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('MONTHLY PERFORMANCE VERIFICATION REPORT ') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('MONTHLY PERFORMANCE VERIFICATION REPORT ') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <show-verification
                                :verification="{{$verify}}"
                                :checklist_items="{{$checklist_items}}"
                            ></show-verification>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection