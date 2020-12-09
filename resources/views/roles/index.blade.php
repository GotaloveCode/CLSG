@extends('layouts.dashboard')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Roles') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Roles') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            <form method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- name Form Input -->
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="Role Name" class="form-control">
                            @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check-square-o"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="content-body">
        <section>
            <div class="mb-1">
                @can("add_roles")
                    <a href="#" data-toggle="modal" data-target="#roleModal" class="btn btn-primary"> <i
                            class="fa fa-plus"></i> Add New</a>
                @endcan
            </div>
            @include('layouts.partials.notifier')
            @forelse ($roles as $role)
                <form action="{{ Route('roles.permissions',  $role->id) }}" method="POST" class="m-b">
                     @csrf
                    @if($role->name === 'Super Admin')
                        @include('shared._permissions', [
                                      'title' => $role->name .' Permissions',
                                      'options' => ['disabled'] ])
                    @else
                        @include('shared._permissions', [
                                      'title' => $role->name .' Permissions',
                                      'model' => $role ])
                    @endif
                </form>
            @empty
                <p>No Roles defined, please run <code>php artisan db:seed</code> to seed some dummy data.
                </p>
            @endforelse

        </section>
    </div>
@endsection
