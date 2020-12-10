@extends('layouts.dashboard')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Edit User') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Edit User') }}
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
                        <div class="card-header">
                            <h4 class="card-title">
                                Edit User
                            </h4>
                            <a class="heading-elements-toggle"><i
                                    class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <delete-user inline-template :user="{{ $edit_user }}">
                                            <button class="btn btn-sm btn-danger" @click.prevent="deleteUser"><i class="feather icon-trash"></i> Delete</button>
                                        </delete-user>
                                    </li>
                                    <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <edit-user :user="{{$edit_user}}" :roles="{{ $roles }}"></edit-user>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
