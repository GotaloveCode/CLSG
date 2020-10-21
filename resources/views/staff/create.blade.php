@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Create Staff') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('staff.index')}}">Staff List</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Create Staff') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body"><!-- Content start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <staff-form wspid="{{$wsp_id}}"></staff-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content end -->
    </div>

@endsection
