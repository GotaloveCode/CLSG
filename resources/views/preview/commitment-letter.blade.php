<p class="text-right">Nairobi,<br>{{ now()->format('d/m/Y') }}</p>
<p>
    {{ $eoi->wsp->name }}<br>
    {{ $eoi->wsp->postal_address }}-{{ $eoi->wsp->postalcode->code }} {{ $eoi->wsp->postalcode->county }}
</p>
<p>Dear Ms./Mr. {{ $eoi->wsp->managing_director }}</p>
<p>We refer to your application for WSTF-managed Conditional Liquidity Support Grant (CLSG) to provide
    short-term COVID-19 emergency interventions and funding for operation and maintenance costs for service
    delivery.
    I am pleased to advise you that WSTF has approved funding of KES {{ number_format($eoi->fixed_grant + $eoi->variable_grant)}} for your
    project. </p>
<p>The aforementioned amount is provided to be spent in the following categories up to the amounts indicated
    below:</p>
<table class="table table-borderless">
    <tr>
        <th>Activity</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td>1. Short-term COVID-19 related emergency interventions</td>
        <td><b>KES: </b>{{ number_format($eoi->fixed_grant)}}</td>
    </tr>
    <tr>
        <td>2. Operation & Maintenance financing costs</td>
        <td><b>KES: </b>{{ number_format($eoi->variable_grant)}}</td>
    </tr>
    <tr>
        <td><b>Total</b></td>
        <td><b>KES: </b> {{ number_format($eoi->fixed_grant + $eoi->variable_grant)}}</td>
    </tr>
</table>
<p>Please, take into account the following conditions:</p>
<p>As per the application, the Manager responsible for this activity will be
    <b>{{$eoi->wsp->managing_director}}</b>.
    Please note that you must request clearance from the WSTF CLSG Programme Manager for any transfer in
    management of this activity.</p>
<p>As the CLSG managed by the WSTF will be providing financing for this activity, we require that all
    documentation for the project and associated documents will include the following text: </p>
<p>“Conditional Liquidity Support Grant - Water Sector Trust Fund”</p>
We would also like to bring the following to your attention:
<p><b>1. Use of Funds </b></p>
<ol style="list-style-type: lower-alpha;">
    <li>All work to be financed using funding from the CLSG must be expressly for this activity, and in
        accordance with the work programme stated in the original application for CLSG funding; any substantial
        changes to the conditions and/or tasks identified in your approved activity should be reported to and
        agreed with WSTF management.
    </li>
    <li>Available funds are strictly limited to the approved amounts per categories and it is solely the
        Activity Manager’s responsibility to make sure that spending limits are maintained.
    </li>
    <li>The funding under this award and commitment letter should be used for activities executed by
        the {{ $eoi->wsp->acronym }},
    </li>
    <li>All project documents should include the project name and code.</li>
    <li>The funds provided for the implementation of this project under the CLSG corresponds to the expiration
        of the CLSG and limited time thereof to ensure successful closure.
    </li>
</ol>
<p><b>2. Documentation and Reporting to the WSTF Management </b></p>
<ol style="list-style-type:lower-alpha">
    <li>Before contracts and initial disbursements are approved, please ensure compliance with the CLSG
        Operating Manual in consultation with the Programme Manager. WSTF management should be provided with
        copies of relevant documentation relating to the execution of the project under the Conditional
        Liquidity Support Grant.
    </li>
    <li>Before disbursements are approved, WSTF management should be provided with copies (paper and electronic
        versions) of any reports and other work financed fully or partially by the Conditional Liquidity Support
        Grant.
    </li>
    <li>From time to time, the WSTF management may request reports on the status of funded activities,
        including:
        <ol style="list-style-type:lower-roman">
            <li>Brief updates on approved activity</li>
            <li>A monthly and quarterly progress report of each CLSG financed activity</li>
        </ol>
    </li>
</ol>
<p><b>Signatures of Parties:</b></p>
<p><b>Water Sector Trust Fund</b><br>
    Mr. Ismail Fahmy M. Shaiye: - Chief Executive Officer
</p>
<p>
    Signature: -
    ...............................................................................................................</p>
<p>Date: -
    ...............................................................................................................<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Date of Signature)
</p>
<p><b>{{$eoi->wsp->name}}</b><br>
    {{$eoi->wsp->managing_director}}: - Managing Director
</p>
<p>
    Signature: -
    ................................................................................................................
<p>
<p> Date: -
    ...............................................................................................................<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Date of Signature)
</p>

