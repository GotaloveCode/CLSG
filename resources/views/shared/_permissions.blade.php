<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            {{ $title }}
            {!! isset($role) ? '<span class="text-danger">(' . $role->permissions()->count() . ')</span>' : '' !!}
        </h4>
        <a class="heading-elements-toggle"><i
                class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                @can('edit_roles')
                    <li><a href="{{ Route('roles.edit',$role->id) }}"><i class="fa fa-edit"></i></a></li>
                @endcan
                <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                <li><a data-action="close"><i class="feather icon-x"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="row">
                @foreach($permissions as $perm)
                    <?php
                    $per_found = null;

                    if (isset($role)) {
                        $per_found = $role->hasPermissionTo($perm->name);
                    }
                    ?>

                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{$perm->name}}"
                                   @if($per_found) checked @endif
                                   @isset($options) disabled="disabled" @endisset
                                   class="form-check-input">
                            <label
                                class="form-check-label {{ Str::contains($perm->name, 'delete') ? 'text-danger' : '' }}"
                                for="permissions[]">{{ $perm->name }}</label>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12 pt-2">
                    @can('edit_roles')
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check-square-o"></i> Save
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>


