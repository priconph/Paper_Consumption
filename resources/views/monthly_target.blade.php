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
                            <h1>Paper Consumption - Monthly Target</h1>
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
                                        <li class="nav-item">
                                            <a class="nav-link active" id="monthly-target-tab" data-toggle="tab"
                                                href="#monthly-target" role="tab" aria-controls="monthly-target"
                                                aria-selected="true">Monthly Target</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="monthly-target-draft-tab" data-toggle="tab"
                                                href="#monthly-target-draft" role="tab" aria-controls="monthly-target-draft"
                                                aria-selected="true">Monthly Target - Draft</a>
                                        </li>
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

                                        {{-- MONTHLY TARGET TAB --}}
                                        <div class="tab-pane fade show" id="monthly-target-draft" role="tabpanel"
                                            aria-labelledby="monthly-target-draft-tab">
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
                                        <input type="hidden" class="form-control" name="year" id="idyear" style="width: 100%;"
                                            readonly>
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


            //===== PASS MONTH FROM MONTHLY TARGET TO FILTER DROPDOWN =====//
            GetMonthsFromMonthlyTarget($(".selectMonthMonthlyTarget"));
            //===== PASS MONTH FROM MONTHLY TARGET TO FILTER DROPDOWN END =====//


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
