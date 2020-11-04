@extends('layouts.print')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4>VULNERABLE CUSTOMERS</h4>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="bg-yellow bg-lighten-4">
                    <tr>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(json_decode($customer->details) as $cus)
                        <tr>
                            <td>{{\App\Models\BcpChecklist::find($cus->id)->name}}</td>
                            <td>{{ $cus->status }}</td>
                            <td>{{$cus->comment}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
