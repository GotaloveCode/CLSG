<div class="row">
    <div class="col-md-12">
        @if ($errors && count($errors) > 0)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        @endif

        @if(Session::has('alerts'))
            @foreach(Session::get('alerts') as $alert)
                <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show" role="alert">
                    {!! $alert['message'] !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        @endif
    </div>
</div>


