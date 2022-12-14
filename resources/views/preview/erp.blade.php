<div>
    <h4 class="text-center">EMERGENCY RESPONSE PLAN</h4>
    <p>{{ $eoi->date ? $eoi->date->format('d/m/Y') : now()->format('d/m/Y') }}</p>

    <p><b>A. Coordinator</b></p>
    <p>{{$erp->coordinator}}</p>

    <p><b>B. Period</b></p>
    <p>{{$erp->period}}</p>


    <p><b>C. Resource Requirement:</b></p>

    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th>COVID-19 Emergency Intervention</th>
            <th>Potential risks</th>
            <th>Potential Mitigation Measures</th>
            <th>Cost(KSHS)</th>
            <th>Others</th>
        </tr>
        </thead>
        @foreach($erp->erp_items as $item)
            <tr>
                <td>{{ $item->emergency_intervention }}</td>
                <td>{{ $item->risks }}</td>
                <td>
                    @foreach($item->mitigation as $mitigation)
                    <div>{{ $mitigation }}</div>
                    @endforeach
                </td>
                <td>{{ number_format($item->cost) }}</td>
                <td>{{ $item->other }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="1"><b>Total Costs</b></td>
            <td></td>
            <td></td>
            <td><b>{{ number_format($erp->erp_items->sum('cost')) }}</b></td>
        </tr>
    </table>
    <p><b>D. O&M Costs:</b></p>
    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th>Type of Service/Item</th>
            <th>Cost(KSHS)</th>
        </tr>
        </thead>
        @foreach($erp->operationcosts as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->pivot->cost) }}</td>
            </tr>
        @endforeach
        <tr>
            <td><b>Total Costs</b></td>
            <td><b>{{ number_format($erp->operationcosts->sum('pivot.cost')) }}</b></td>
        </tr>
    </table>
</div>
