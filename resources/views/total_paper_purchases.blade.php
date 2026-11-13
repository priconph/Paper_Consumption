@php $layout = 'layouts.user_layout'; @endphp
@auth
    @php

    if (Auth::user()->user_level_id == 2 || Auth::user()->user_level_id == 1) {
        $layout = 'layouts.admin_layout';
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
                            <h1>Paper Consumption - Paper Purchases</h1>
                        </div>
                        <div class="col-sm-6">
                            {{-- <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Overview</li>
                                <li class="breadcrumb-item "><a href="{{ route('paper_consumption_report_monthly') }}">Monthly
                                        Used Paper</a></li> --}}
                            {{-- <li class="breadcrumb-item " id="managementRoute"><a
                                    href="{{ route('management') }}">Management</a></li>
                            <li class="breadcrumb-item " id="summaryRoute"><a href="{{ route('summary') }}">Summary</a> --}}
                            {{-- </li>
                            </ol> --}}
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
                                        {{-- <li class="nav-item">
                                            <a class="nav-link active" id="monthly-target-tab" data-toggle="tab"
                                                href="#monthly-target" role="tab" aria-controls="monthly-target"
                                                aria-selected="true">Monthly Target</a>
                                        </li> --}}
                                        <li class="nav-item">
                                            <a class="nav-link active" id="total-purchases-tab" data-toggle="tab"
                                                href="#total-purchases" role="tab" aria-controls="total-purchases"
                                                aria-selected="false">Total Paper Purchases</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" id="beginning-balance-tab" data-toggle="tab"
                                                href="#beginning-balance" role="tab" aria-controls="beginning-balance"
                                                aria-selected="false">Beginning Balance / BOH</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="month-end-balance-tab" data-toggle="tab"
                                                href="#month-end-balance" role="tab" aria-controls="month-end-balance"
                                                aria-selected="false">Monthly Ending Balance / EOH</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="total-used-tab" data-toggle="tab" href="#total-used"
                                                role="tab" aria-controls="total-used" aria-selected="false">Total Used Paper</a>
                                        </li> --}}
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" id="total-consumption-tab" data-toggle="tab"
                                                href="#total-consumption" role="tab" aria-controls="total-consumption"
                                                aria-selected="false">Total Consumption</a>
                                        </li> --}}
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" id="reason-tab" data-toggle="tab" href="#reason"
                                                role="tab" aria-controls="reason" aria-selected="false">Reasons of (+/-) of
                                                Actual Consumption</a>
                                        </li> --}}
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        {{-- MONTHLY TARGET TAB --}}
                                        <div class="tab-pane fade show active" id="monthly-target" role="tabpanel"
                                            aria-labelledby="monthly-target-tab">
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
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Paper :</strong></label>
                                                    <select class="form-control select2bs4 selectPapers" name=""
                                                        id="selPapersMonthlyTargetId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div style="margin-left: 35%">
                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modalMonthlyTarget" id="addMonthlyTargetModalbtn"><i
                                                            class="fa fa-plus fa-md"></i> Insert Monthly Target</button>
                                                </div>
                                            </div><br>
                                            <div class="table-responsive">
                                                <table id="monthlyTargetTable"
                                                    class="table table-sm table-bordered table-striped table-hover text-center"
                                                    width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10%">Month</th>
                                                            <th style="width: 10%">Fiscal Year</th>
                                                            <th>Paper</th>
                                                            <th>Monthly Target</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- MONTHLY TARGET TAB END --}}

                                        {{-- BEGINNING BALANCE TAB --}}
                                        <div class="tab-pane fade" id="beginning-balance" role="tabpanel"
                                            aria-labelledby="beginning-balance-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearBeginningId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthBeginningBalance" name="month_value"
                                                        id="selMonthBeginningId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Paper :</strong></label>
                                                    <select class="form-control select2bs4 selectPapers" name="month_value"
                                                        id="selPapersBeginningBalId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div style="margin-left: 33%">
                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modalBeginningBalance" id="addBeginningBalanceModalbtn"><i
                                                            class="fa fa-plus fa-md"></i> Insert Beginning Balance</button>
                                                </div>
                                            </div><br>
                                            <div class="table-responsive">
                                                <table id="beginningBalanceTable"
                                                    class="table table-sm table-bordered table-striped table-hover text-center"
                                                    width="100%">
                                                    <thead class="month_name">
                                                        <tr>
                                                            <th style="width: 10%">Month</th>
                                                            <th style="width: 10%">Fiscal Year</th>
                                                            <th>Paper</th>
                                                            <th>Quantity</th>
                                                            {{-- <th style="display: none;">monthname</th> --}}
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- BEGINNING BALANCE TAB END --}}

                                        {{-- TOTAL PURCHASES TAB --}}
                                        <div class="tab-pane fade" id="total-purchases" role="tabpanel"
                                            aria-labelledby="total-purchases-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearTotalPurchasesId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthTotalPurchases" name="month_value"
                                                        id="selMonthTotalPurchasesId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Paper :</strong></label>
                                                    <select class="form-control select2bs4 selectPapers" name=""
                                                        id="selPapersTotalPurchasesId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div style="margin-left: 34%">
                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modalPaperPurchases" id="addPaperPurchasesModalbtn"><i
                                                            class="fa fa-plus fa-md"></i> Insert Paper Purchases</button>
                                                </div>
                                            </div>
                                            {{-- Get month --}}
                                            <form method="post" id="getMonthForm">
                                                @csrf
                                                <input class="form-control" type="hidden" name="month1" id="idmonth1"
                                                    readonly>
                                                <input class="form-control" type="hidden" name="year1" id="idyear1" readonly>
                                            </form>
                                            {{-- Get month end --}}
                                            <div class="table-responsive">
                                                <table id="paperPurchasesTable"
                                                    class="table table-sm table-bordered table-striped table-hover text-center"
                                                    width="100%">
                                                    <thead class="month_name">
                                                        <tr>
                                                            <th style="width: 10%">Month</th>
                                                            <th style="width: 10%">Fiscal Year</th>
                                                            <th>Paper</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- TOTAL PURCHASES TAB END --}}

                                        {{-- TOTAL USED PAPER TAB --}}
                                        <div class="tab-pane fade" id="total-used" role="tabpanel"
                                            aria-labelledby="total-used-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearTotalUsedId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthTotalUsed" name="month_value"
                                                        id="selMonthTotalUsedId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div class="form-group nowrap" style="margin-left: 45%;">
                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modalViewTotalUsedPaper"
                                                        id="viewTotalUsedPaperModalbtn"><i
                                                            class="far fa-file"></i>&nbsp;&nbsp;Total used per
                                                        paper</button>
                                                </div>

                                            </div><br>
                                            <div class="table-responsive">
                                                <table id="totalUsedPaperTable"
                                                    class="table table-sm table-bordered table-striped table-hover text-center"
                                                    width="100%">
                                                    <thead class="month_name">
                                                        <tr>
                                                            <th style="width: 10%">Month</th>
                                                            <th style="width: 10%">Fiscal Year</th>
                                                            <th>Total Used Paper (Pieces)</th>
                                                            <th>Total Used Paper (Reams)</th>
                                                            <th>Target (Pieces)</th>
                                                            <th>Consumption Status</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- TOTAL USED PAPER TAB END --}}

                                        {{-- MONTH ENDING BALANCE TAB --}}
                                        <div class="tab-pane fade" id="month-end-balance" role="tabpanel"
                                            aria-labelledby="month-end-balance-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearMonthEndBalId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthMonthEndBal" name="month_value"
                                                        id="selMonthMonthEndBalId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Paper :</strong></label>
                                                    <select class="form-control select2bs4 selectPapers" name=""
                                                        id="selPapersMonthEndId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                            </div><br>
                                            <div class="table-responsive">
                                                <table id="monthEndBalanceTable"
                                                    class="table table-sm table-bordered table-striped table-hover text-center"
                                                    width="100%">
                                                    <thead class="">
                                                        <tr>
                                                            <th style="width: 10%">Month</th>
                                                            <th style="width: 10%">Fiscal Year</th>
                                                            <th>Paper</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- MONTH ENDING BALANCE TAB END --}}

                                        {{-- TOTAL CONSUMPTION TAB --}}
                                        <div class="tab-pane fade" id="total-consumption" role="tabpanel"
                                            aria-labelledby="total-consumption-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value" id="selYearId"
                                                        style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonth" name="month_value" id="selMonthId"
                                                        style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Paper :</strong></label>
                                                    <select class="form-control select2bs4 selectPapers" name=""
                                                        id="selPapersId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="table-responsive">
                                                <table id="totalConsumptionTable"
                                                    class="table table-sm table-bordered table-striped table-hover text-center"
                                                    width="100%">
                                                    <thead class="">
                                                        <tr>
                                                            <th>Paper</th>
                                                            <th>Fiscal Year</th>
                                                            <th>Target</th>
                                                            <th>Over/Under</th>
                                                            <th>Total Pieces</th>
                                                            <th>Total Ream</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- TOTAL CONSUMPTION TAB END --}}

                                        {{-- REASONS OF ACTUAL CONSUMPTION TAB --}}
                                        <div class="tab-pane fade" id="reason" role="tabpanel" aria-labelledby="reason-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control selectYear" name="year_value"
                                                        id="selYearPaperConsumptionReasonsId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthPaperConsumptionReasons"
                                                        name="month_value" id="selMonthPaperConsumptionReasonsId"
                                                        style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="table-responsive">
                                                <table id="paperConsumptionReasonsTable"
                                                    class="table table-sm table-bordered table-striped table-hover text-center"
                                                    width="100%">
                                                    <thead class="">
                                                        <tr>
                                                            <th style="width: 10%">Month</th>
                                                            <th style="width: 10%">Fiscal Year</th>
                                                            <th>Reason</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- REASONS OF ACTUAL CONSUMPTION TAB END --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- ADD MONTHLY TARGET MODAL START -->
        <div class="modal fade" id="modalMonthlyTarget">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title"><i class="fa fa-calendar-check" aria-hidden="true"></i>&nbsp;&nbsp;Monthly
                            Target</h4>
                        <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="addMonthlyTargetForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{-- <label>Year</label> --}}
                                        <input type="hidden" class="form-control" name="year" id="idyear"
                                            style="width: 100%;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Month</label>
                                        <input class="form-control selectMonth" type="text" name="month" id="idmonth"
                                            style="width: 100%;" readonly>

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Paper</label>
                                        <select class="form-control select2bs4 selectPaper" name="paper_id" id="selPaperId"
                                            style="width: 100%;">
                                            <!-- Code generated -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Monthly Target</label>
                                        <input type="number" class="form-control" name="monthly_target" min="0" id="idtarget"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" style="margin-right: 45%;"
                                data-dismiss="modal">Close</button>
                            <button type="submit" id="btnAddMonthlyTarget" class="btn btn-primary"><i
                                    id="btnAddMonthlyTargetIcon" class="fa fa-upload"></i> Submit</button>
                            <button type="submit" id="btnAddMonthlyTarget" class="btn btn-warning"><i
                                    id="btnAddMonthlyTargetIcon" class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- ADD MONTHLY TARGET MODAL END -->

        <!-- ADD PAPER PURCHASES MODAL START -->
        <div class="modal fade" id="modalPaperPurchases">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title"><i class="fas fa-shopping-cart" aria-hidden="true"></i>&nbsp;&nbsp;Paper
                            Purchases</h4>
                        <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="addPaperPurchasesForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="fiscal_year" id="fiscalYearId"
                                            style="width: 100%;" readonly>
                                        <input type="hidden" class="form-control" name="year" id="idyear2"
                                            style="width: 100%;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Month</label>
                                        <input class="form-control" type="text" name="month" id="idmonth2"
                                            style="width: 100%;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Paper Purchased</label>
                                        <select class="form-control select2bs4 selectPaper" name="paper_id" id="selPaperId"
                                            style="width: 100%;">
                                            <!-- Code generated -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" name="paper_purchase_quantity" min="0"
                                            id="idquantity"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnAddPaperPurchases" class="btn btn-primary"><i
                                    id="btnAddPaperPurchasesIcon" class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- ADD PAPER PURCHASES MODAL END -->

        <!-- ADD BEGINNING BALANCE MODAL START -->
        <div class="modal fade" id="modalBeginningBalance">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title"><i class="fa fa-calendar-check"
                                aria-hidden="true"></i>&nbsp;&nbsp;Beginning Balance
                        </h4>
                        <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="addBeginningBalanceForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{-- <label>Year</label> --}}
                                        <input type="hidden" class="form-control" name="year" id="idyear"
                                            style="width: 100%;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Month</label>
                                        <input class="form-control selectMonth" type="text" name="month" id="idmonth3"
                                            style="width: 100%;" readonly>

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Paper</label>
                                        <select class="form-control select2bs4 selectPaper" name="paper_id" id="selPaperId"
                                            style="width: 100%;">
                                            <!-- Code generated -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Beginning Balance</label>
                                        <input type="number" class="form-control" name="beginning_balance" min="0"
                                            id="beginningBalanceQuantityId"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnAddBeginningBalance" class="btn btn-primary"><i
                                    id="btnAddBeginningBalanceIcon" class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- ADD BEGINNING BALANCE MODAL END -->

        {{-- VIEW TOTAL USED PER PAPER MODAL --}}
        <div class="modal fade" id="modalViewTotalUsedPaper" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:100%; max-width:1750px;">
                <div class="modal-content">
                    <div class=" table-responsive mt-5 col-10 offset-1">
                        <h4 style="margin-bottom: 2%;">Total used per paper</h4>
                        <div class="text-left mt-1 d-flex flex-row">
                            <div class="form-group ml-1 col-2">
                                <label><strong>Fiscal Year :</strong></label>
                                <select class="form-control selectYear" name="year_value" id="selYearTotalUsedPerPaperId"
                                    style="width: 100%;">
                                    <!-- Code generated -->
                                </select>
                            </div>
                            <div class="form-group ml-3 col-2">
                                <label><strong>Month :</strong></label>
                                <select class="form-control selectMonthTotalUsedPerPaper" name="month_value"
                                    id="selMonthTotalUsedPerPaperId" style="width: 100%;">
                                    <!-- Code generated -->
                                </select>
                            </div>
                            <div class="form-group ml-3 col-2">
                                <label><strong>Paper :</strong></label>
                                <select class="form-control select2bs4 selectPapers" name="" id="selPapersTotalUsedPerPaperId"
                                    style="width: 100%;">
                                    <!-- Code generated -->
                                </select>
                            </div>
                        </div>
                        <table id="paperUsedTable" class="table table-sm table-bordered table-striped table-hover text-center"
                            width="100%">
                            <thead class="month_name">
                                <tr>
                                    <th style="width: 10%">Month</th>
                                    <th style="width: 10%">Fiscal Year</th>
                                    <th>Paper</th>
                                    <th>Total Used (Pieces)</th>
                                    {{-- <th>Total Used (Reams)</th> --}}
                                    <th>Target (Pieces)</th>
                                    <th>Consumption Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- VIEW TOTAL USED PER PAPER MODAL END --}}
    @endsection

    @section('js_content')
        <script type="text/javascript">
            //===== PASS CURRENT FY =====//
            GetFiscal();
            //===== PASS CURRENT FY ID =====//


            //===== PASS PAPERS TO PAPER PURCHASES AND MONTHLY TARGET DROPDOWN =====//
            GetPaper($(".selectPaper"));
            //===== PASS PAPERS TO PAPER PURCHASES AND MONTHLY TARGET DROPDOWN END =====//

            //===== PASS PAPERS TO PAPER PURCHASES AND MONTHLY TARGET DROPDOWN =====//
            GetPapersForFilter($(".selectPapers"));
            //===== PASS PAPERS TO PAPER PURCHASES AND MONTHLY TARGET DROPDOWN END =====//


            //===== PASS FISCAL YEAR TO FILTER DROPDOWN =====//
            GetFiscalYears($(".selectYear"));
            //===== PASS FISCAL YEAR TO FILTER DROPDOWN =====//


            //===== PASS MONTH FROM BEGINNING BALANCE TO FILTER DROPDOWN =====//
            GetMonthsFromBeginningBalance($(".selectMonthBeginningBalance"));
            //===== PASS MONTH FROM BEGINNING BALANCE TO FILTER DROPDOWN END =====//


            //===== PASS MONTH FROM MONTHLY TARGET TO FILTER DROPDOWN =====//
            GetMonthsFromMonthlyTarget($(".selectMonthMonthlyTarget"));
            //===== PASS MONTH FROM MONTHLY TARGET TO FILTER DROPDOWN END =====//


            //===== PASS MONTH FROM TOTAL PURCHASES TO FILTER DROPDOWN =====//
            GetMonthsFromTotalPurchases($(".selectMonthTotalPurchases"));
            //===== PASS MONTH FROM TOTAL PURCHASES TO FILTER DROPDOWN END =====//


            //===== PASS MONTH FROM TOTAL USED PAPER TO FILTER DROPDOWN =====//
            GetMonthsFromTotalUsedPaper($(".selectMonthTotalUsed"));
            //===== PASS MONTH FROM TOTAL USED PAPER TO FILTER DROPDOWN END =====//


            //===== PASS MONTH FROM TOTAL USED PER PAPER TO FILTER DROPDOWN =====//
            GetMonthsFromTotalUsedPaperPerPaper($(".selectMonthTotalUsedPerPaper"));
            //===== PASS MONTH FROM TOTAL USED PER PAPER TO FILTER DROPDOWN END =====//


            //===== PASS MONTH FROM MONTH END BALANCE TO FILTER DROPDOWN =====//
            GetMonthsFromMonthEndBalance($(".selectMonthMonthEndBal"));
            //===== PASS MONTH FROM MONTH END BALANCE TO FILTER DROPDOWN END =====//


            //===== PASS MONTH FROM PAPER CONSUMPTION REASONS TO FILTER DROPDOWN =====//
            GetMonthsFromMonthlyUsedPapers($(".selectMonthPaperConsumptionReasons"));
            //===== PASS MONTH FROM PAPER CONSUMPTION REASONS TO FILTER DROPDOWN END =====//


            //===== FILTER FISCAL YEAR AND MONTH ON BEGINNING BALANCE DATATABLE =====//
            $("#selMonthBeginningId").on('change', function() {
                dataTableBeginningBalance.column(0).search($(this).val()).draw();
            });

            $("#selYearBeginningId").on('change', function() {
                dataTableBeginningBalance.column(1).search($(this).val()).draw();
            });

            $("#selPapersBeginningBalId").on('change', function() {
                dataTableBeginningBalance.column(2).search($(this).val()).draw();
            });
            //===== FILTER FISCAL YEAR AND MONTH ON BEGINNING BALANCE DATATABLE END =====//


            //===== FILTER FISCAL YEAR AND MONTH ON MONTHLY TARGET DATATABLE =====//
            $("#selMonthMonthlyTargetId").on('change', function() {
                dataTableMonthlyTarget.column(0).search($(this).val()).draw();
            });

            $("#selYearMonthlytargetId").on('change', function() {
                dataTableMonthlyTarget.column(1).search($(this).val()).draw();
            });

            $("#selPapersMonthlyTargetId").on('change', function() {
                dataTableMonthlyTarget.column(2).search($(this).val()).draw();
                // console.log($(this).val());
            });
            //===== FILTER FISCAL YEAR AND MONTH ON MONTHLY TARGET DATATABLE END =====//


            //===== FILTER FISCAL YEAR AND MONTH ON TOTAL PAPER PURCHASES DATATABLE =====//
            $("#selMonthTotalPurchasesId").on('change', function() {
                dataTablePurchasedPaper.column(0).search($(this).val()).draw();
            });

            $("#selYearTotalPurchasesId").on('change', function() {
                dataTablePurchasedPaper.column(1).search($(this).val()).draw();
            });

            $("#selPapersTotalPurchasesId").on('change', function() {
                dataTablePurchasedPaper.column(2).search($(this).val()).draw();
            });
            //===== FILTER FISCAL YEAR AND MONTH ON TOTAL PAPER PURCHASES DATATABLE END =====//



            //===== FILTER FISCAL YEAR AND MONTH ON TOTAL USED PAPER PURCHASES DATATABLE =====//
            $("#selMonthTotalUsedId").on('change', function() {
                dataTableTotalUsedPaper.column(0).search($(this).val()).draw();
            });

            $("#selYearTotalUsedId").on('change', function() {
                dataTableTotalUsedPaper.column(1).search($(this).val()).draw();
            });
            //===== FILTER FISCAL YEAR AND MONTH ON TOTAL USED PAPER PURCHASES DATATABLE END =====//


            //===== FILTER FISCAL YEAR AND MONTH ON TOTAL USED PAPER PER PURCHASES DATATABLE =====//
            $("#selMonthTotalUsedPerPaperId").on('change', function() {
                dataTablePaperUsed.column(0).search($(this).val()).draw();
            });

            $("#selYearTotalUsedPerPaperId").on('change', function() {
                dataTablePaperUsed.column(1).search($(this).val()).draw();
            });

            $("#selPapersTotalUsedPerPaperId").on('change', function() {
                dataTablePaperUsed.column(2).search($(this).val()).draw();
            });
            //===== FILTER FISCAL YEAR AND MONTH ON TOTAL USED PAPER PER PURCHASES DATATABLE END =====//


            //===== FILTER FISCAL YEAR AND MONTH ON MONTH END BAL DATATABLE =====//
            $("#selMonthMonthEndBalId").on('change', function() {
                dataTableMonthEndBalance.column(0).search($(this).val()).draw();
            });

            $("#selYearMonthEndBalId").on('change', function() {
                dataTableMonthEndBalance.column(1).search($(this).val()).draw();
            });

            $("#selPapersMonthEndId").on('change', function() {
                dataTableMonthEndBalance.column(2).search($(this).val()).draw();
            });
            //===== FILTER FISCAL YEAR AND MONTH ON MONTH END BAL DATATABLE END =====//

            //===== FILTER FISCAL YEAR AND MONTH ON MONTH END BAL DATATABLE =====//
            $("#selMonthPaperConsumptionReasonsId").on('change', function() {
                dataTablePaperConsumptionReasons.column(0).search($(this).val()).draw();
            });

            $("#selYearPaperConsumptionReasonsId").on('change', function() {
                dataTablePaperConsumptionReasons.column(1).search($(this).val()).draw();
            });
            //===== FILTER FISCAL YEAR AND MONTH ON MONTH END BAL DATATABLE END =====//

            //===== MONTHLY TARGET DATATABLE =====//
            var dataTableMonthlyTarget = $("#monthlyTargetTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // // "scrollX": true,
                "ajax": {
                    url: "display_monthly_target",
                },
                "columns": [{
                        "data": "month",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "fiscal_year.year",
                        // width: "10%"
                    },
                    {
                        "data": "paper.name",
                        orderable: false,
                    },
                    {
                        "data": "data_monthly_target",
                        orderable: false,
                    }
                ],
                "order": [
                    [1, 'desc'],
                    [0, 'asc']
                ],
                "pageLength": 12
            });
            //===== MONTHLY TARGET DATATABLE END =====//

            //===== TOTAL USED PAPER DATATABLE =====//
            var dataTableTotalUsedPaper = $("#totalUsedPaperTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // // "scrollX": true,
                "ajax": {
                    url: "display_total_used_paper",
                },

                "columns": [{
                        "data": "month",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "fiscal_year.year",
                        // width: "10%"
                    },
                    {
                        "data": "quantity",
                        orderable: false
                    },
                    {
                        "data": "total_reams",
                        orderable: false
                    },
                    {
                        "data": "monthly_target_id",
                        orderable: false
                    },
                    {
                        "data": "status",
                        orderable: false
                    },
                ],
                "order": [
                    [1, 'desc'],
                    [0, 'asc']
                ],
                "pageLength": 12

            });
            //===== TOTAL USED PAPER DATATABLE END =====//

            //===== PAPER USED DATATABLE =====//
            var dataTablePaperUsed = $("#paperUsedTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "scrollX": true,
                "ajax": {
                    url: "display_total_used_per_paper",
                },

                "columns": [{
                        "data": "month",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "fiscal_year.year",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "paper.name",
                        orderable: false
                    },
                    {
                        "data": "quantity",
                        orderable: false
                    },
                    // {
                    //     "data": "paper_reams",
                    //     orderable: false
                    // },
                    {
                        "data": "monthly_target_quantity",
                        orderable: false
                    },
                    {
                        "data": "status",
                        orderable: false
                    },

                ],
                "order": [
                    [1, 'desc'],
                    [0, 'asc']
                ],
                "pageLength": 12

            });
            //===== PAPER USED DATATABLE END =====//

            //===== PAPER PURCHASES DATATABLE =====//
            var dataTablePurchasedPaper = $("#paperPurchasesTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // // "scrollX": true,
                "ajax": {
                    url: "display_paper_purchases",

                },
                "columns": [{
                        "data": "month",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "fiscal_year.year",
                        // width: "10%"
                    },
                    {
                        "data": "paper.name",
                        orderable: false
                    },
                    {
                        "data": "quantity",
                        orderable: false
                    }
                ],
                "order": [
                    [1, 'desc'],
                    [0, 'asc']
                ],
                "pageLength": 12
            });
            //===== PAPER PURCHASES DATATABLE END =====//

            //===== BEGINNING BALANCE DATATABLE =====//
            var dataTableBeginningBalance = $("#beginningBalanceTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // // "scrollX": true,
                "ajax": {
                    url: "display_beginning_bal",
                },

                "columns": [{
                        "data": "month",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "fiscal_year.year",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "paper.name",
                        orderable: false
                    },
                    {
                        "data": "quantity",
                        orderable: false
                    },
                ],

                "order": [
                    [1, 'desc'],
                    [0, 'asc']
                ],
                "pageLength": 12

                // "bSort": false,
            });
            //===== BEGINNING BALANCE DATATABLE END =====//

            //===== MONTH END BALANCE DATATABLE =====//
            var dataTableMonthEndBalance = $("#monthEndBalanceTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // // "scrollX": true,
                "ajax": {
                    url: "display_month_end_balance",
                },

                "columns": [{
                        "data": "month",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "fiscal_year.year",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "paper.name",
                        orderable: false
                    },
                    {
                        "data": "quantity",
                        orderable: false
                    },
                ],
                "order": [
                    [1, 'desc'],
                    [0, 'asc']
                ],
                "pageLength": 12
                // "bSort": false,
            });
            //===== MONTH END BALANCE DATATABLE END =====//

            //===== TOTAL CONSUMPTION DATATABLE =====//
            // var dataTableTotalConsumption = $("#totalConsumptionTable").DataTable({
            //     "processing": false,
            //     "serverSide": true,
            //     "responsive": true,
            //     "ajax": {
            //         url: "display_total_consumption",
            //     },

            //     "columns": [{
            //             "data": "",
            //             orderable: false
            //         },
            //         {
            //             "data": "",
            //             orderable: false
            //         },
            //         {
            //             "data": "",
            //             orderable: true
            //         },
            //         {
            //             "data": "",
            //             orderable: false
            //         },
            //         {
            //             "data": "",
            //             orderable: false
            //         },
            //         {
            //             "data": "",
            //             orderable: false
            //         }
            //     ],

            // });
            //===== TOTAL CONSUMPTION DATATABLE END =====//

            //===== PAPER CONSUMPTION REASONS DATATABLE =====//
            var dataTablePaperConsumptionReasons = $("#paperConsumptionReasonsTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                "autoWidth": false,
                "ajax": {
                    url: "display_paper_consumption_reasons",
                },
                "columns": [{
                        "data": "month",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "fiscal_year.year",
                        orderable: true,
                        // width: "10%"
                    },
                    {
                        "data": "reason",
                        orderable: false
                    },
                ],
                "order": [
                    [1, 'desc'],
                    [0, 'asc']
                ],
            });
            //===== PAPER CONSUMPTION REASONS DATATABLE END =====//

            $(document).ready(function() {

                var month = new Date(
                    new Date().getFullYear(),
                    new Date().getMonth(),
                    new Date().getDate()
                );
                let current_month = month.toISOString().slice(0, 10);
                // console.log(current_month);   

                $('#idyear').val(current_month);
                $('#idyear1').val(current_month);
                $('#idyear2').val(current_month);

                var months = ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September",
                    "October", "November", "December"
                ];
                var new_month = new Date();
                var get_month = months[new_month.getMonth()];
                // console.log(get_last_month);
                $("#idmonth").val(get_month);
                $("#idmonth1").val(get_month);
                $("#idmonth2").val(get_month);
                $("#idmonth3").val(get_month);
            });

            // ADD MONTHLY TARGET
            $("#addMonthlyTargetForm").submit(function(event) {
                event.preventDefault(); // to stop the form submission
                AddMonthlyTarget();
            });

            $("#addMonthlyTargetModalbtn").click(function() {
                $("#selPaperId").removeClass('is-invalid');
                $("#selPaperId").attr('title', '');
                $("#idtarget").removeClass('is-invalid');
                $("#idtarget").attr('title', '');
                $("#selPaperId").focus();
            });
            // ADD MONTHLY TARGET END

            // ADD PAPER PURCHASES
            $("#addPaperPurchasesForm").submit(function(event) {
                event.preventDefault(); // to stop the form submission
                AddPaperPurchases();
            });

            $("#addPaperPurchasesModalbtn").click(function() {
                $("#selPaperId").removeClass('is-invalid');
                $("#selPaperId").attr('title', '');
                $("#idquantity").removeClass('is-invalid');
                $("#idquantity").attr('title', '');
                $("#selPaperId").focus();
            });
            // ADD PAPER PURCHASES END

            // ADD BEGINNING BALANCE
            $("#addBeginningBalanceForm").submit(function(event) {
                event.preventDefault(); // to stop the form submission
                AddBeginningBalance();
            });

            $("#addBeginningBalancebtn").click(function() {
                $("#selPaperId").removeClass('is-invalid');
                $("#selPaperId").attr('title', '');
                $("#beginningBalanceQuantityId").removeClass('is-invalid');
                $("#beginningBalanceQuantityId").attr('title', '');
                $("#selPaperId").focus();
            });
            // ADD BEGINNING BALANCE END

            // PASS MONTH YEAR
            $("#getMonthForm").submit(function(event) {
                event.preventDefault();
                GetMonthForPaperPurchases();
            });
            // PASS MONTH YEAR END

            $(document).ready(function() {
                $("#formSignOut").submit(function(event) {
                    event.preventDefault();
                    SignOut();
                });
            });
        </script>
    @endsection
@endauth
