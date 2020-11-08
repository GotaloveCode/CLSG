@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/comment.css') }}">
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('CLSG Calculation') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">CLSG Calculation</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('CLSG Calculation') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title">8.1 Grant Formula</h4>
                    <a class="heading-elements-toggle"><i
                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p>Monthly CLSG transfers to WSPs will be determined using a standard formula as follows:
                            <br> <b>Monthly CLSG transfer (in KES) - Fixed Grant + (Variable Grant * Performance
                                Adjustment(%))</b>
                        </p>
                        <p>
                            Where: <br>
                            <b>Fixed Grant </b> = Estimated cost of COVID-19 emergency response interventions agreed
                            with WSTF<br>
                            <b>Variable Grant</b> = Verified Revenue * Monthly Grant Multiplier(MGM). Each WSP will be
                            eligible for a budgeted maximum variable grant in any given month regardless of the amounts
                            of revenues collected.<br>
                            <b>Verified Revenue</b> = Actual revenue collected by the WSP in the month. <br>
                            <b>Monthly Grant Multiplier (MGM)</b> = a pre-agreed multiplier which will be determined
                            based on WSP's monthly revenue forecast during the 8-month grant period<br>
                        </p>
                        <p>
                            <em>Performance Adjustment (%) =</em><br>
                            100%, if performance score > 70% on performance score for the period;<br>
                            Performance score (%) if score < 70% in performance score for period<br>
                            Performance scores between 70% and 100% are compliant and will not have impact on the grant
                            amount.<br>
                            Performance scores below 70% will lead to a reduction in the grant amount and a written
                            warning of possible termination of grant facility if performance issues are not
                            rectified.<br>
                            Consistent under-performance (defined as total performance score below 70% for more than 3
                            consecutive months may lead to termination of the grant facility.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title">8.2 Maximum (Budgeted) Variable Grant</h4>
                    <a class="heading-elements-toggle"><i
                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p>The variable grant will be capped at a maximum budgeted value in each month – i.e. each WSP
                            will only be eligible for a maximum variable grant in any given month regardless of the
                            amount of revenues collected</p>
                        <p>The Maximum Monthly Variable Grant shall be calculated as follows:</p>
                        <em>Monthly Variable Grant (in KES)</em> - Total Costs + Revenues - Existing Government Subsidies (if any) - Fised Grant <br>
                        Where,<br>
                        <b>Total Costs </b> - Sum of the projected monthly O&amp;M costs during the 8 month grant period and the estimated cost of the eligible COVID-19 emergency response interventions <br>
                        <b>Verified Revenue</b> = Projected monthly revenue the WSP expects to collect during the 8 month grant period. <br>
                        <b>Existing Government Subsidies </b> = Any exiting monthly government subsidies the WSP is receiving<br>
                        <b>Fixed Grant </b> = Estimated cost of COVID-19 emergency response interventions agreed
                        with WSTF<br><br>
                        <p>The maximum variable grant amount shall be determined before signing the CLSG Agreement, based on data provided by the WSP in the BCP. </p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title">8.3	Monthly Grant Multiplier</h4>
                    <a class="heading-elements-toggle"><i
                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p>As outlined in 8.1 above, the variable part of the CLSG will be calculated by multiplying the amount of revenue collected with a Monthly Grant Multiplier (MGM).
                            The multipliers for each month will be pre-determined at the time of signing the CLSG Agreement using the formula below.
                            The multipliers will remain fixed for the entire grant period.
                            The idea is to incentivize WSPs to achieve their monthly revenue projections.</p>
                        <p>The Monthly Grant Multiplier shall be calculated as follows:</p>
                        <em>Monthly Grant Multiplier (MGM)</em> = Maximum Monthly Variable Grant / Projected Monthly Revenue<br>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Sample CLSG Calculation</h4>
                    <a class="heading-elements-toggle"><i
                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <p class="card-body">
                        The table below shows an example of a CLSG determination for one of the Eligible WSP assuming
                        100% performance adjustment.
                    </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th>Jan</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Apr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Aug</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dec</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Cost recovery from revenues(%)</td>
                                <td>147%</td>
                                <td>105%</td>
                                <td>100%</td>
                                <td>72%</td>
                                <td>63%</td>
                                <td>57%</td>
                                <td>49%</td>
                                <td>49%</td>
                                <td>58%</td>
                                <td>63%</td>
                                <td>69%</td>
                                <td>74%</td>
                            </tr>
                            <tr>
                                <td>Monthly Grant Multiplier</td>
                                <td>0.0</td>
                                <td>0.0</td>
                                <td>0.0</td>
                                <td>0.0</td>
                                <td>0.6</td>
                                <td>0.6</td>
                                <td>0.9</td>
                                <td>0.9</td>
                                <td>0.7</td>
                                <td>0.6</td>
                                <td>0.5</td>
                                <td>0.4</td>
                            </tr>
                            <tr>
                                <th>Total Cost(USD million)</th>
                                <td>0.50</td>
                                <td>0.60</td>
                                <td>0.53</td>
                                <td>0.50</td>
                                <td>0.50</td>
                                <td>0.53</td>
                                <td>0.61</td>
                                <td>0.61</td>
                                <td>0.57</td>
                                <td>0.57</td>
                                <td>0.57</td>
                                <td>0.57</td>
                            </tr>
                            <tr>
                                <td colspan="13">Paid for by ...</td>
                            </tr>
                            <tr>
                                <td>Existing Government Transfers (USD millions)</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>Verified Revenues USD millions</td>
                                <td>0.73</td>
                                <td>0.63</td>
                                <td>0.53</td>
                                <td>0.36</td>
                                <td>0.31</td>
                                <td>0.30</td>
                                <td>0.30</td>
                                <td>0.30</td>
                                <td>0.33</td>
                                <td>0.36</td>
                                <td>0.39</td>
                                <td>0.42</td>
                            </tr>
                            <tr>
                                <td>Liquidity Grant(fixed) USD millions</td>
                                <td class="bg-info" colspan="5"></td>
                                <td>0.04</td>
                                <td>0.04</td>
                                <td>0.04</td>
                                <td class="bg-info" colspan="4"></td>
                            </tr>
                            <tr>
                                <td>Liquidity Grant(variable) USD millions</td>
                                <td class="bg-info" colspan="3"></td>
                                <td></td>
                                <td>0.19</td>
                                <td>0.19</td>
                                <td>0.27</td>
                                <td>0.27</td>
                                <td>0.24</td>
                                <td>0.21</td>
                                <td>0.18</td>
                                <td>0.15</td>
                            </tr>
                            <tr>
                                <th>Total Grant in USD millions</th>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>0.19</td>
                                <td>0.23</td>
                                <td>0.31</td>
                                <td>0.31</td>
                                <td>0.24</td>
                                <td>0.21</td>
                                <td>0.18</td>
                                <td>0.15</td>
                            </tr>
                            <tr>
                                <th>Performance Adjustment (%)</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>Total Grant after Performance Adjustment (USD millions)</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>0.19</td>
                                <td>0.23</td>
                                <td>0.31</td>
                                <td>0.31</td>
                                <td>0.24</td>
                                <td>0.21</td>
                                <td>0.18</td>
                                <td>0.15</td>
                            </tr>
                            <tr>
                                <td>Cummulative Grant Amount (USD millions)</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>0.19</td>
                                <td>0.42</td>
                                <td>0.73</td>
                                <td>1.04</td>
                                <td>1.28</td>
                                <td>1.49</td>
                                <td>1.67</td>
                                <td>1.82</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">CLSG Adjustment Mechanism</h4>
                    <a class="heading-elements-toggle"><i
                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <p class="card-body">
                        The CLSG amount for the initial list of 35 eligible WSPs represents the current maximum budget
                        available for the CLSG facility currently, as per the WSDP Restructuring Paper. The estimates
                        are based on preliminary data obtained from the WSPs. Actual amount will be confirmed at the
                        time of signing the CLSG Agreements. The grant estimates may change once the draft BCPs are
                        prepared but cannot exceed the budgeted amounts. The table below provides an overview of the
                        applicable adjustment mechanisms.
                    </p>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Determinant of CLSG</th>
                            <th>Basis</th>
                            <th>Time of determination</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Maximum Budget Available</td>
                            <td>WSDP Restructuring Paper</td>
                            <td>Before World Bank and GoK approval of the WSDP Restructuring</td>
                        </tr>
                        <tr>
                            <td>CLSG (Fixed grant)</td>
                            <td>Estimated cost of the COVID-19 emergency interventions (capped at 10% of Maximum Budget
                                Available)
                            </td>
                            <td>One-off determination, before signature of the CLSG Agreement. Fixed grant is only
                                available in the first three months after signing the CLSG Agreement
                            </td>
                        </tr>
                        <tr>
                            <td>CLSG (Variable grant)</td>
                            <td>Verified Revenues in month * MGM (but capped at Maximum Variable Grant)</td>
                            <td>Monthly, upon WASREB verification of the WSP revenue collected in the month</td>
                        </tr>
                        <tr>
                            <td>Maximum Variable Grant</td>
                            <td>Monthly Cost and Revenue Projections in the BCP (but capped at 90% of Maximum Budget
                                Available)
                            </td>
                            <td>Before signature of CLSG Agreement, and fixed thereafter</td>
                        </tr>
                        <tr>
                            <td>MGM</td>
                            <td>Cost and revenue projections provided in the BCP</td>
                            <td>Before signature of CLSG Agreement, and fixed thereafter</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="card-body">
                        <p>
                            For the individual WSP, the sum of the monthly CLSG Transfer over the grant period will
                            always be equal to or less than the sum of the monthly Maximum Variable Grant and monthly
                            Fixed Grant over the same period which in turn will always be equal to or less than the
                            Maximum Budget Available for the individual WSP.
                        </p>
                        <p>
                            If in any month a WSP is not able to earn the Maximum Variable Grant for that month, either
                            due to failure to achieve the performance threshold of 70% on the performance scorecard or
                            failure to achieve its revenue forecasts, the balance of the Maximum Variable Grant for that
                            month may be carried over to the subsequent month. Such carry over will only be permitted if
                            the WSP outlines in writing to WSTF what it will do differently the subsequent month to
                            improve its performance. Any savings realized due to this adjustment will be reserved for
                            new WSPs that may become eligible later, depending on how the COVID-19 situation evolves.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('#burger').trigger('click');
            }, 1500)
        });
    </script>
@endpush

