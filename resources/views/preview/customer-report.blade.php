<h4>VULNERABLE CUSTOMERS</h4>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Description</th>
            <th>Status</th>
            <th>Notes</th>
        </tr>
        </thead>
        <tbody>
        @foreach(json_decode($customer->customer_details) as $cus)
            <tr>
                <td>{{$checklist->firstWhere('id',$cus->id)->name}}</td>
                <td><span class="badge
@if($cus->status == 'Completed') badge-success
@elseif($cus->status == 'In Progress') badge-warning
@else badge-danger
@endif">{{ $cus->status }}</span></td>
                <td>{{$cus->comment}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
