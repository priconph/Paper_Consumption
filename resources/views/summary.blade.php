@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @php
    if (Auth::user()->user_level_id == 3) {
        $layout = 'layouts.user_layout';
    }
    @endphp
@endauth

@auth
    @extends($layout)
    <style>
        ::-webkit-scrollbar {
            display: none !important;
        }

    </style>

    @section('content_page')
        <div class="content-wrapper" style="margin-right: 1%;">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Summary</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        {{-- <h3>Current FY Target</h3> --}}

                                        <li class="nav-item">
                                            <a class="nav-link active" id="fyTarget-management-tab" data-toggle="tab"
                                                href="#fyTarget-management" role="tab" aria-controls="fyTarget-management"
                                                aria-selected="true">FY Target</a>
                                        <li class="nav-item">
                                            <a class="nav-link" id="monthlyTarget-management-tab" data-toggle="tab"
                                                href="#monthlyTarget-management" role="tab"
                                                aria-controls="monthlyTarget-management" aria-selected="true">Monthly Target</a>
                                        </li>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="actualConsumption-management-tab" data-toggle="tab"
                                                href="#actualConsumption-management" role="tab"
                                                aria-controls="actualConsumption-management" aria-selected="true">Actual
                                                Consumption</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="targetSubActual-management-tab" data-toggle="tab"
                                                href="#targetSubActual-management" role="tab"
                                                aria-controls="targetSubActual-management" aria-selected="true">Target (-)
                                                Actual</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="quarterlyConsumption-management-tab" data-toggle="tab"
                                                href="#quarterlyConsumption-management" role="tab"
                                                aria-controls="quarterlyConsumption-management" aria-selected="true">Quarterly
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="deduction-management-tab" data-toggle="tab"
                                                href="#deduction-management" role="tab" aria-controls="deduction-management"
                                                aria-selected="true">Policy Deduction</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="reasonsPerDept-management-tab" data-toggle="tab"
                                                href="#reasonsPerDept-management" role="tab"
                                                aria-controls="reasonsPerDept-management" aria-selected="true">Reasons for (+ /
                                                -) usage</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" id="iss-management-tab" data-toggle="tab"
                                                href="#iss-management" role="tab" aria-controls="iss-management"
                                                aria-selected="true">ISS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="qad-management-tab" data-toggle="tab"
                                                href="#qad-management" role="tab" aria-controls="qad-management"
                                                aria-selected="true">QAD</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="ems-management-tab" data-toggle="tab"
                                                href="#ems-management" role="tab" aria-controls="ems-management"
                                                aria-selected="true">EMS</a>
                                        </li> --}}
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="fyTarget-management" role="tabpanel"
                                            aria-labelledby="fyTarget-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearFYTargetId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                    <input class="selectedFiscalYear" type="hidden">
                                                </div>

                                            </div><br>
                                            <div class="table responsive">
                                                <table id="fyTarget"
                                                    class="table table-sm table-bordered table-striped display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>

                                                        <th colspan="13"
                                                            style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black;">
                                                            <h4>
                                                                FY Target
                                                            </h4>
                                                        </th>

                                                        <tr>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                Paper
                                                            </th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                            </th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                BOD</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                IAS</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                FIN</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                HRD</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                ESS</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                LOG</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                FAC</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                ISS</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                QAD</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                EMS</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                TOTAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fyTargetData">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="monthlyTarget-management" role="tabpanel"
                                            aria-labelledby="monthlyTarget-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearMonthlyTargetId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                    <input class="selectedFiscalYearforMonthlyTarget" type="hidden">
                                                </div>
                                            </div><br>
                                            <div class="table responsive">
                                                <table id=""
                                                    class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <th colspan="15"
                                                            style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black;">
                                                            <h4>
                                                                Monthly Target
                                                            </h4>
                                                        </th>
                                                        <tr>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                Section</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                            </th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                April</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                May</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                June</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                July</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                August</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                September</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                October</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                November</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                December</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                January</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                February</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                March</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                TOTAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="monthlyTargetData">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="actualConsumption-management" role="tabpanel"
                                            aria-labelledby="actualConsumption-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearActualConsumptionId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                    <input class="selectedFiscalYearforActualConsumption" type="hidden">
                                                </div>
                                            </div><br>
                                            <div class="table responsive">
                                                <table id=""
                                                    class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <th colspan="17"
                                                            style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black;">
                                                            <h4>
                                                                Actual Consumption
                                                            </h4>
                                                        </th>
                                                        <tr>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                Section</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                            </th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                April</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                May</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                June</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                July</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                August</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                September</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                October</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                November</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                December</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                January</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                February</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                March</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                TOTAL</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                FY Target</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black;">
                                                                Over/Under</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="actualConsumptionData"></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="targetSubActual-management" role="tabpanel"
                                            aria-labelledby="targetSubActual-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearTargetSubActualId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                    <input class="selectedFiscalYearforTargetSubActual" type="hidden">
                                                </div>
                                            </div><br>
                                            <div class="table responsive">
                                                <table id=""
                                                    class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <th colspan="15"
                                                            style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black;">
                                                            <h4>
                                                                Target (-) Actual
                                                            </h4>
                                                        </th>
                                                        <tr>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                Section</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                            </th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                April</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                May</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                June</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                July</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                August</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                September</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                October</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                November</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                December</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                January</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                February</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                March</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                TOTAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="targetSubActualData">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="quarterlyConsumption-management" role="tabpanel"
                                            aria-labelledby="quarterlyConsumption-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearQuarterlyConsumptionId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                    <input class="selectedFiscalYearforQuarterlyConsumption" type="hidden">
                                                </div>
                                            </div><br>
                                            <div class="table responsive">
                                                <table id=""
                                                    class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <th colspan="15"
                                                            style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black;">
                                                            <h4>
                                                                Quarterly
                                                            </h4>
                                                        </th>
                                                        <tr>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black;">
                                                                Section
                                                            </th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; ">
                                                            </th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; ">
                                                                1ST QUARTER</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; ">
                                                                2ND QUARTER</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; ">
                                                                3RD QUARTER</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; ">
                                                                4TH QUARTER</th>
                                                            <th
                                                                style="border-bottom: 2px solid black; border-right: 2px solid black; ">
                                                                TOTAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="quarterlyConsumptionData">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="reasonsPerDept-management" role="tabpanel"
                                            aria-labelledby="reasonsPerDept-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYearReasons" name="year_value"
                                                        id="selYearPaperConsumptionReasonsId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthPaperConsumptionReasons" name=""
                                                        id="selMonthPaperConsumptionReasonsId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Department :</strong></label>
                                                    <select class="form-control selectDepartment" name="month_value"
                                                        id="selDepartmentId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="table-responsive">
                                                <table id="paperConsumptionReasonsTable"
                                                    class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Month</th>
                                                            <th>Fiscal Year</th>
                                                            <th>Department</th>
                                                            <th>Reason</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="deduction-management" role="tabpanel"
                                            aria-labelledby="deduction-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" id="selYearDeductionsId"
                                                        style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <input class="selectedFiscalYearforDeductions" type="hidden">

                                            </div><br>
                                            <div class="table-responsive">
                                                <table id=""
                                                    class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <th colspan="15"
                                                            style="border-bottom: 2px solid black; border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black;">
                                                            <h4>
                                                                With Policy Deduction
                                                            </h4>
                                                        </th>
                                                        <tr
                                                            style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                            <th
                                                                style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                            </th>
                                                            <th style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;"
                                                                colspan="2" width="20%">Last FY Total Consumption</th>
                                                            <th style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;"
                                                                colspan="2" width="20%">Deduction</th>
                                                            <th style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;"
                                                                colspan="2" width="20%">Current FY Target</th>
                                                        </tr>
                                                        <tr
                                                            style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                            <th
                                                                style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                                Section</th>
                                                            <td
                                                                style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                                PCS</td>
                                                            <td
                                                                style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                                REAM</td>
                                                            <td
                                                                style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                                PCS</td>
                                                            <td
                                                                style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                                REAM</td>
                                                            <td
                                                                style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                                PCS</td>
                                                            <td
                                                                style="border-right: 2px solid black; border-left: 2px solid black; border-top: 2px solid black; border-bottom: 2px solid black;">
                                                                REAM</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="deductionsData">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- <div class="tab-pane fade" id="iss-management" role="tabpanel"
                                            aria-labelledby="iss-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearMonthlytargetId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthMonthlyTarget" name="month_value"
                                                        id="selMonthMonthlyTargetId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="table responsive">
                                                <table id=""
                                                    class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Paper</th>
                                                            <th>Pieces</th>
                                                            <th>Ream</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="qad-management" role="tabpanel"
                                            aria-labelledby="qad-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearMonthlytargetId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthMonthlyTarget" name="month_value"
                                                        id="selMonthMonthlyTargetId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="table responsive">
                                                <table id=""
                                                    class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Paper</th>
                                                            <th>Pieces</th>
                                                            <th>Ream</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="ems-management" role="tabpanel"
                                            aria-labelledby="ems-management-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearMonthlytargetId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthMonthlyTarget" name="month_value"
                                                        id="selMonthMonthlyTargetId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="table responsive">
                                                <table id=""
                                                    class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Paper</th>
                                                            <th>Pieces</th>
                                                            <th>Ream</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div> --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection

    @section('js_content')
        <script type="text/javascript">
            GetFiscalYearTarget($(".selectYear"));
            GetDepartments($(".selectDepartment"));
            GetFiscalYears($(".selectYearReasons"));
            GetMonthsFromMonthlyUsedPapers($(".selectMonthPaperConsumptionReasons"));

            $(".selectMonthPaperConsumptionReasons").on('change', function() {
                dataTablePaperConsumptionReasons.column(0).search($(this).val()).draw();
            });

            $("#selYearPaperConsumptionReasonsId").on('change', function() {
                dataTablePaperConsumptionReasons.column(1).search($(this).val()).draw();
            });

            $("#selDepartmentId").on('change', function() {
                dataTablePaperConsumptionReasons.column(2).search($(this).val()).draw();
            });

            //===== FOR WHOLE FY TARGET =====//
            $(window).on("load", function() {
                let year = $('#selYearFYTargetId').val();
                $(".selectedFiscalYear").val(year);
                // console.log($('#selYearFYTargetId').val());
                // console.log(year);
                $.ajax({
                    url: 'get_all_target_papers',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearFYTargetId').val()
                    },
                    success: function(response) {
                        $('.fyTargetData').html(response['result']);
                    }
                });
            });

            $('#selYearFYTargetId').on('change', function() {
                $('.selectedFiscalYear').val($(this).find(":selected").val());
                $(".selectedFiscalYear").val();

                $.ajax({
                    url: 'get_all_target_papers',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearFYTargetId').val()
                    },
                    success: function(response) {

                        $('.fyTargetData').html(response['result']);
                    }
                });
            });
            //===== FOR WHOLE FY TARGET END =====//

            //===== FOR ALL DEPARTMENTS MONTHLY TARGET =====/
            $(window).on("load", function() {
                let year = $('#selYearMonthlyTargetId').val();
                $(".selectedFiscalYearforMonthlyTarget").val(year);
                // console.log(year);
                $.ajax({
                    url: 'get_monthly_target_all_dept',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearMonthlyTargetId').val()
                    },
                    success: function(response) {
                        $('.monthlyTargetData').html(response['result']);
                    }
                });
            });

            $('#selYearMonthlyTargetId').on('change', function() {
                $('.selectedFiscalYearforMonthlyTarget').val($(this).find(":selected").val());
                $(".selectedFiscalYearforMonthlyTarget").val();

                $.ajax({
                    url: 'get_monthly_target_all_dept',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearMonthlyTargetId').val()
                    },
                    success: function(response) {

                        $('.monthlyTargetData').html(response['result']);
                    }
                });
            });
            //===== FOR ALL DEPARTMENTS MONTHLY TARGET END =====//

            //===== GET AND PASS ACTUAL CONSUMPTION DATA =====//
            $(window).on("load", function() {
                let year = $('#selYearActualConsumptionId').val();
                $(".selectedFiscalYearforActualConsumption").val(year);
                // console.log(year);
                $.ajax({
                    url: 'get_actual_consumption',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearActualConsumptionId').val()
                    },
                    success: function(response) {
                        $('.actualConsumptionData').html(response['result']);
                    }
                });
            });

            $('#selYearActualConsumptionId').on('change', function() {
                $('.selectedFiscalYearforActualConsumption').val($(this).find(":selected").val());
                $(".selectedFiscalYearforActualConsumption").val();

                $.ajax({
                    url: 'get_actual_consumption',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearActualConsumptionId').val()
                    },
                    success: function(response) {

                        $('.actualConsumptionData').html(response['result']);
                    }
                });
            });
            //===== GET AND PASS ACTUAL CONSUMPTION DATA END =====//

            //===== GET AND PASS TARGET SUBTRACT ACTUAL CONSUMPTION DATA =====//
            $(window).on("load", function() {
                let year = $('#selYearTargetSubActualId').val();
                $(".selectedFiscalYearforTargetSubActual").val(year);
                // console.log(year);
                $.ajax({
                    url: 'subtract_actual_consumption',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearTargetSubActualId').val()
                    },
                    success: function(response) {
                        $('.targetSubActualData').html(response['result']);
                    }
                });
            });

            $('#selYearTargetSubActualId').on('change', function() {
                $('.selectedFiscalYearforTargetSubActual').val($(this).find(":selected").val());
                $(".selectedFiscalYearforTargetSubActual").val();

                $.ajax({
                    url: 'subtract_actual_consumption',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearTargetSubActualId').val()
                    },
                    success: function(response) {

                        $('.targetSubActualData').html(response['result']);
                    }
                });
            });
            //===== GET AND PASS TARGET SUBTRACT ACTUAL CONSUMPTION DATA =====//

            //===== GET AND PASS QUARTERLY CONSUMPTION DATA ======//
            $(window).on("load", function() {
                let year = $('#selYearQuarterlyConsumptionId').val();
                $(".selectedFiscalYearforQuarterlyConsumption").val(year);
                // console.log(year);
                $.ajax({
                    url: 'get_quarterly_consumption',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearQuarterlyConsumptionId').val()
                    },
                    success: function(response) {
                        $('.quarterlyConsumptionData').html(response['result']);
                    }
                });
            });

            $('#selYearQuarterlyConsumptionId').on('change', function() {
                $('.selectedFiscalYearforQuarterlyConsumption').val($(this).find(":selected").val());
                $(".selectedFiscalYearforQuarterlyConsumption").val();

                $.ajax({
                    url: 'get_quarterly_consumption',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearQuarterlyConsumptionId').val()
                    },
                    success: function(response) {

                        $('.quarterlyConsumptionData').html(response['result']);
                    }
                });
            });
            //===== GET AND PASS QUARTERLY CONSUMPTION DATA END ======//


            // DATATABLES OF MONTHLY USED PAPER
            var dataTablePaperConsumptionReasons = $("#paperConsumptionReasonsTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                // // "scrollX": true,
                "ajax": {
                    url: "get_paper_consumption_reasons",
                },
                "columns": [{
                        "data": "month"
                    },
                    {
                        "data": "fiscal_year.year"
                    },
                    {
                        "data": "department.name"
                    },
                    {
                        "data": "reason"
                    }
                ],
                // "order": []
            });
            // DATATABLES OF MONTHLY USED PAPER END

            //===== GET AND PASS DEDUCTIONS DATA ======//
            $(window).on("load", function() {
                let year = $('#selYearDeductionsId').val();
                $(".selectedFiscalYearforDeductions").val(year);
                // console.log(year);
                $.ajax({
                    url: 'deduction_summary',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearDeductionsId').val()
                    },
                    success: function(response) {
                        $('.deductionsData').html(response['result']);
                    }
                });
            });

            $('#selYearDeductionsId').on('change', function() {
                $('.selectedFiscalYearforDeductions').val($(this).find(":selected").val());
                $(".selectedFiscalYearforDeductions").val();

                $.ajax({
                    url: 'deduction_summary',
                    method: 'get',
                    dataType: 'json',
                    data: {
                        fiscal_year: $('#selYearDeductionsId').val()
                    },
                    success: function(response) {

                        $('.deductionsData').html(response['result']);
                    }
                });
            });
            //===== GET AND PASS DEDUCTIONS DATA END ======//

            $(document).ready(function() {
                $("#formSignOut").submit(function(event) {
                    event.preventDefault();
                    SignOut();
                });
            });
        </script>
    @endsection
@endauth
