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
                                        <manage-role inline-template :role="{{ $role }}">
                                            <a href="#" @click.prevent="deleteRole"><i class="fa fa-trash"></i></a>
                                        </manage-role>
                                    </li>
                                    <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ Route('users.update',  $user->id) }}" method="post">
                                @method("put") @csrf
                                <div class="form-group row @if ($errors->has('name')) has-error @endif">
                                    <label for="name" class="col-md-3"> Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}" placeholder="Role Name"
                                           class="form-control col-md-4">
                                    @if ($errors->has('name')) <p
                                        class="help-block">{{ $errors->first('name') }}</p> @endif
                                </div>
                                <div class="form-group row @if ($errors->has('email')) has-error @endif">
                                    <label for="email" class="col-md-3"> Name</label>
                                    <input type="email" name="email" value="{{ $user->email }}" placeholder="Role Name"
                                           class="form-control col-md-4">
                                    @if ($errors->has('email')) <p
                                        class="help-block">{{ $errors->first('email') }}</p> @endif
                                </div>
{{--                                TODO: make this a vue component so you can use v-select with multiple roles --}}
                                <div class="form-group row @if ($errors->has('permissions')) has-error @endif">
                                    <label for="permissions" class="col-md-3"> Name</label>
                                    <select name="roles"  placeholder="Role Name"
                                           class="form-control col-md-4">
                                    @if ($errors->has('permissions')) <p
                                        class="help-block">{{ $errors->first('permissions') }}</p> @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check-square-o"></i> Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

