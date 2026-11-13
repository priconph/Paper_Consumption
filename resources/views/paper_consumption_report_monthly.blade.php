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
        <div class="content-wrapper" style="">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Paper Consumption - Used Papers</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <button class="btn btn-warning" data-toggle="modal" data-target="#modalViewDrafts"
                                    id="viewDraftsbtn"><i class="fas fa-edit"></i> Drafts</button>
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
                                        <li class="nav-item">
                                            <a class="nav-link active" id="monthly-target-tab" data-toggle="tab"
                                                href="#monthly-target" role="tab" aria-controls="monthly-target"
                                                aria-selected="true">Used Papers</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="monthly-target" role="tabpanel"
                                            aria-labelledby="monthly-target-tab">
                                            <div class="text-left mt-4 d-flex flex-row">
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Fiscal Year :</strong></label>
                                                    <select class="form-control select2bs4 selectYear" name="year_value"
                                                        id="selYearMonthlyUsedPaperId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>
                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Month :</strong></label>
                                                    <select class="form-control selectMonthMonthlyUsedPapers" name="month_value"
                                                        id="selMonthMonthlyUsedPaperId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div class="form-group ml-3 col-2">
                                                    <label><strong>Paper :</strong></label>
                                                    <select class="form-control select2bs4 selectPapers" name=""
                                                        id="selPapersMonthlyUsedId" style="width: 100%;">
                                                        <!-- Code generated -->
                                                    </select>
                                                </div>

                                                <div style="margin-left: 35%">

                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modalMonthlyUsedPaper" id="addMonthlyUsedModalbtn"><i
                                                            class="fa fa-plus fa-md"></i> Insert Used Paper</button>
                                                </div>
                                            </div><br>
                                            <div class="table-responsive">
                                                <table id="monthlyUsedTable"
                                                    class="table table-sm table-bordered table-striped table-hover text-center w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Month</th>
                                                            <th>Fiscal Year</th>
                                                            <th>Paper</th>
                                                            <th>Quantity</th>
                                                            <th>Reason</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- ADD MONTHLY USED PAPER MODAL START -->
        <div class="modal fade" data-backdrop="static" id="modalMonthlyUsedPaper">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title"><i class="fa fa-calendar-check" aria-hidden="true"></i>&nbsp;&nbsp;
                            Used Paper</h4>
                        <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                            aria-label="Close" id="closeModalAddId">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="addMonthlyUsedPaperForm">
                        @csrf
                        {{-- <input type="hidden" class="form-control" name="draft_id" id="editDraftId"> --}}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{-- <label>Year</label> --}}
                                        <input type="hidden" class="form-control" name="fiscal_year" id="fiscalYearId"
                                            style="width: 100%;" readonly>
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
                                        <label>Paper Used</label>
                                        <select class="form-control select2bs4 selectPaper" name="paper_id" id="selPaperId"
                                            style="width: 100%;">
                                            <!-- Code generated -->
                                        </select>

                                        <label class="mt-2">Remaining Quantity</label>
                                        <div class="d-flex flex-row">
                                            <input type="number" class="form-control w-50 getRemainingQuantity"
                                                name="paper_purchased_quantity" id="paperPurchasedQuantityId" readonly>

                                            <input type="hidden" class="form-control w-50 getPaperId" name="paper_purchased_id"
                                                id="paperPurchasedId" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input checkedNoConsumption" type="checkbox"
                                                id="noConsumptionCheckedId">
                                            <h6 class="form-check-label" for="noConsumptionCheckedId">
                                                No Consumption
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control getQuantity" name="quantity" min="0"
                                            id="idquantity"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Reason</label>
                                        <input class="form-control" type="text" name="reason" id="idreason"
                                            style="width: 100%;">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" style="margin-right: 45%;" data-dismiss="modal"
                                id="closeModalAddId1">Close</button>

                            <button type="submit" id="btnAddMonthlyUsedDraft" class="btn btn-warning"><i
                                    id="btnAddMonthlyUsedDraftIcon" class="fa fa-check"></i> Save</button>

                            <button type="submit" id="btnAddMonthlyUsed" class="btn btn-primary"><i id="btnAddMonthlyUsedIcon"
                                    class="fa fa-upload"></i> Submit</button>
                            {{-- <button type="submit" id="btnEditMonthlyUsedDraft" class="btn btn-success"><i
                                    id="btnEditMonthlyUsedDraftIcon" class="fa fa-check"></i> Save</button> --}}
                        </div>
                    </form>

                </div>
            </div>
        </div><!-- ADD MONTHLY USED PAPER MODAL END -->


        {{-- EDIT MONTHLY USED PAPER MODAL DRAFT --}}
        <div class="modal fade" data-backdrop="static" id="modalMonthlyUsedPaperDraft">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="title"><i class="fa fa-calendar-check"
                                aria-hidden="true"></i>&nbsp;&nbsp;
                            Used Paper - DRAFT</h4>
                        <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                            data-toggle="modal" data-target="#modalViewDrafts" aria-label="Close" id="closeModalEditId">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <h3 id="modalContent" class="mt-5 mb-5" style="text-align: center;"></h3> --}}
                    <form method="post" id="editMonthlyUsedPaperForm">
                        @csrf
                        <input type="hidden" class="form-control" name="draft_id" id="editDraftId">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{-- <label>Year</label> --}}
                                        <input type="hidden" class="form-control" name="fiscal_year" id="fiscalYearId"
                                            style="width: 100%;" readonly>
                                        <input type="hidden" class="form-control" name="year" id="idyear" style="width: 100%;"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label id="labelMonthId">Month</label>
                                        <input class="form-control selectMonth" type="text" name="month" id="monthId"
                                            style="width: 100%;" readonly>
                                        {{-- <input class="form-control getMonth" type="text" id="getMonthId" style="width: 100%;"
                                            readonly> --}}
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label id="labelPaperUsedId">Paper Used</label>
                                        <select class="form-control select2bs4 selectPaper" name="paper_id_edit"
                                            id="selPaperIdEdit" style="width: 100%;">
                                            <!-- Code generated -->
                                        </select>

                                        <label class="mt-2" id="labelRemainingQuantityId">Remaining Quantity</label>
                                        <div class="d-flex flex-row">
                                            <input type="number" class="form-control w-50 getRemainingQuantityEdit"
                                                name="paper_purchased_quantity" id="paperPurchasedQuantityId" readonly>

                                            <input type="hidden" class="form-control w-50 getPaperId" name="paper_purchased_id"
                                                id="paperPurchasedId" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input checkedNoConsumptionEdit" type="checkbox"
                                                id="editNoConsumptionCheckedId">
                                            <h6 class="form-check-label" id="labelNoConsumptionId"
                                                for="editNoConsumptionCheckedId">
                                                No Consumption
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label id="labelQuantityId">Quantity</label>
                                        <input type="number" class="form-control getQuantityEdit" name="quantity_edit" min="0"
                                            id="quantityId"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label id="labelReasonId">Reason</label>
                                        <input class="form-control" type="text" name="reason_edit" id="reasonId"
                                            style="width: 100%;">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" style="margin-right: auto;" data-dismiss="modal"
                                data-toggle="modal" data-target="#modalViewDrafts" id="closeModalEditId1">Close</button>

                            <button type="submit" id="btnSaveDraft" class="btn btn-warning"><i id=""
                                    class="fa fa-check"></i>
                                Save</button>

                            <button type="submit" id="btnSubmitDraft" class="btn btn-primary"><i id="btnSubmitDraftIcon"
                                    class="fa fa-upload"></i>
                                Submit</button>
                            {{-- <button type="submit" id="btnEditMonthlyUsedDraft" class="btn btn-success"><i
                                    id="btnEditMonthlyUsedDraftIcon" class="fa fa-check"></i> Save</button> --}}
                        </div>
                    </form>

                </div>
            </div>
        </div>
        {{-- EDIT MONTHLY USED PAPER MODAL DRAFT END --}}

        {{-- DELETE MONTHLY USED PAPER MODAL DRAFT --}}
        <div class="modal fade" data-backdrop="static" id="modalDeleteDraft">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="title"><i class="fa fa-trash"
                                aria-hidden="true"></i>&nbsp;&nbsp;Delete Draft</h4>
                        <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                            data-toggle="modal" data-target="#modalViewDrafts" aria-label="Close" id="closeModalEditId">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" id="deleteDraftForm">
                        @csrf
                        <input type="hidden" class="form-control" name="draft_id" id="deleteDraftId">
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <h4>Are you sure you want to delete this draft?</h4>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" style="margin-right: auto;" data-dismiss="modal"
                                data-toggle="modal" data-target="#modalViewDrafts" id="closeModalEditId1">Close</button>

                            <button type="submit" id="btnDeleteDraft" class="btn btn-success"><i id="btnDeleteDraftIcon"
                                    class="fa fa-check"></i>
                                Confirm</button>
                            {{-- <button type="submit" id="btnEditMonthlyUsedDraft" class="btn btn-success"><i
                                    id="btnEditMonthlyUsedDraftIcon" class="fa fa-check"></i> Save</button> --}}
                        </div>
                    </form>

                </div>
            </div>
        </div>
        {{-- DELETE MONTHLY USED PAPER MODAL DRAFT END --}}

        {{-- VIEW DRAFTS MODAL --}}
        <div class="modal fade" id="modalViewDrafts" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" style="width:100%; max-width:1750px;">
                <div class="modal-content">
                    <div class=" table-responsive mt-5 col-10 offset-1">
                        <h3 style="margin-bottom: 2%;"> Used Paper Drafts</h3>
                        <div class="text-left mt-1 d-flex flex-row">
                            <div class="form-group ml-1 col-2">
                                <label><strong>Fiscal Year :</strong></label>
                                <select class="form-control select2bs4 selectYear" name="year_value"
                                    id="selYearTotalUsedPerPaperId" style="width: 100%;">
                                    <!-- Code generated -->
                                </select>
                            </div>
                            <div class="form-group ml-3 col-2">
                                <label><strong>Month :</strong></label>
                                <select class="form-control selectMonthMonthlyUsedPapers" name="month_value"
                                    id="selMonthMonthlyUsedPaperId" style="width: 100%;">
                                    <!-- Code generated -->
                                </select>
                            </div>
                            {{-- <div class="form-group ml-3 col-2">
                                <label><strong>For :</strong></label>
                                <select class="form-control select2bs4 selectPapers" name="" id="selPapersTotalUsedPerPaperId"
                                    style="width: 100%;">
                                    <!-- Code generated -->
                                </select>
                            </div> --}}
                        </div>
                        <table id="draftTable" class="table table-sm table-bordered table-striped table-hover text-center"
                            width="100%">
                            <thead class="month_name">
                                <tr>
                                    <th style="width: 10%">Month</th>
                                    <th style="width: 10%">Fiscal Year</th>
                                    <th>Paper</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- VIEW DRAFTS MODAL END --}}
    @endsection

    @section('js_content')
        <script type="text/javascript">
            GetPapers($(".selectPaper"));

            GetPapersForFilter($(".selectPapers"));

            //===== PASS CURRENT FY =====//
            GetFiscal();
            //===== PASS CURRENT FY ID =====//

            //===== PASS FISCAL YEAR TO FILTER DROPDOWN =====//
            GetFiscalYears($(".selectYear"));
            //===== PASS FISCAL YEAR TO FILTER DROPDOWN =====//

            //===== PASS MONTH FROM BEGINNING BALANCE TO FILTER DROPDOWN =====//
            GetMonthsFromMonthlyUsedPapers($(".selectMonthMonthlyUsedPapers"));
            //===== PASS MONTH FROM BEGINNING BALANCE TO FILTER DROPDOWN END =====//

            //===== FILTER FISCAL YEAR AND MONTH ON BEGINNING BALANCE DATATABLE =====//
            $("#selMonthMonthlyUsedPaperId").on('change', function() {
                dataTableMonthlyUsedPaper.column(0).search($(this).val()).draw();
            });

            $("#selYearMonthlyUsedPaperId").on('change', function() {
                dataTableMonthlyUsedPaper.column(1).search($(this).val()).draw();
            });

            $("#selPapersMonthlyUsedId").on('change', function() {
                dataTableMonthlyUsedPaper.column(2).search($(this).val()).draw();
            });
            //===== FILTER FISCAL YEAR AND MONTH ON BEGINNING BALANCE DATATABLE END =====//

            $('#closeModalAddId').on('click', function() {
                $("#idquantity").val("");
                $("#idreason").val("");
                $("#paperPurchasedQuantityId").val("");
                $(".selectPaper").val(0).trigger("change");
                $('.checkedNoConsumption').prop('checked', false);
                $('#idquantity').attr('readonly', false);
                $('#idreason').attr('readonly', false);
            });

            $('#closeModalAddId1').on('click', function() {
                $("#idquantity").val("");
                $("#idreason").val("");
                $("#paperPurchasedQuantityId").val("");
                $(".selectPaper").val(0).trigger("change");
                $('.checkedNoConsumption').prop('checked', false);
                $('#idquantity').attr('readonly', false);
                $('#idreason').attr('readonly', false);
            });

            $(document).ready(function() {

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "3000",
                    "timeOut": "3000",
                    "extendedTimeOut": "3000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                };
                // GET REMAINING QUANTITY BASED ON SELECTED PAPER
                $('#selPaperId').on('change', function() {
                    $('.getPaperId').val($(this).find(":selected").val());
                    let paperId = $(".getPaperId").val();

                    $.ajax({
                        url: 'get_beginning_balance_quantity',
                        method: 'get',
                        dataType: 'json',
                        data: {
                            paper_purchased_id: $('#paperPurchasedId').val()
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {
                            $(".getRemainingQuantity").val(Number(response['result']));
                        }
                    });

                    $('.checkedNoConsumption').on('click', function() {
                        if ($(this).is(":checked")) {
                            $('#idquantity').attr('readonly', true);
                            $('#idquantity').val(0);

                            $('#idreason').prop('required', true);
                            // $('#idreason').attr('readonly', true);
                            // $('#idreason').val('No Consumption');
                        } else if ($(this).is(":not(:checked)")) {
                            $('#idquantity').attr('readonly', false);
                            $('#idquantity').val('');
                            $('#idreason').attr('readonly', false);
                            $('#idreason').val('');
                            $('#idreason').prop('required', true);

                        }
                    });
                });

                setTimeout(() => {
                    $(".getQuantity").keyup(function(e) {
                        let remaining_quantity = $('.getRemainingQuantity').val();
                        let quantity_input = $('.getQuantity').val();

                        if (Number(remaining_quantity) < Number(quantity_input)) {
                            $('.getQuantity').val('');
                            toastr.warning('Insufficient remaining paper quantity');
                        }
                    });
                }, 2000);
                // GET VALUE OF USED QUANTITY OF THE SELECTED PAPER END

                $('#selPaperIdEdit').on('change', function() {
                    $('.getPaperId').val($(this).find(":selected").val());
                    let paperId = $(".getPaperId").val();

                    $.ajax({
                        url: 'get_beginning_balance_quantity',
                        method: 'get',
                        dataType: 'json',
                        data: {
                            paper_purchased_id: $('#paperPurchasedId').val()
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {
                            $(".getRemainingQuantityEdit").val(Number(response['result']));
                        }
                    });

                    $('.checkedNoConsumptionEdit').on('click', function() {
                        if ($(this).is(":checked")) {
                            $('#quantityId').attr('readonly', true);
                            $('#quantityId').val(0);

                            $('#reasonId').prop('required', true);
                            // $('#idreason').attr('readonly', true);
                            // $('#idreason').val('No Consumption');
                        } else if ($(this).is(":not(:checked)")) {
                            $('#quantityId').attr('readonly', false);
                            $('#quantityId').val('');
                            $('#reasonId').attr('readonly', false);
                            $('#reasonId').val('');
                            $('#reasonId').prop('required', true);
                        }
                    });
                });

                setTimeout(() => {
                    $(".getQuantityEdit").keyup(function(e) {
                        let remaining_quantity = $('.getRemainingQuantityEdit').val();
                        let quantity_input = $('.getQuantityEdit').val();

                        if (Number(remaining_quantity) < Number(quantity_input)) {
                            $('.getQuantityEdit').val('');
                            toastr.warning('Insufficient remaining paper quantity');
                        }
                    });
                }, 2000);

                var oneMonthAgo = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                var last_month = oneMonthAgo.toISOString().slice(0, 10);

                $('#idyear').val(last_month);

                var day = new Date();
                var get_day_now = day.getDate();
                console.log(get_day_now);

                if (get_day_now == 1 || get_day_now == 2 || get_day_now == 3 || get_day_now == 4 || get_day_now == 5) {
                    let current = new Date();
                    console.log('Current Month: ' + current.getMonth());

                    GetActiveMonth('with_callback', function(result){
                        // console.log('test');
                        if(result.active_month == 1){ //Real-Time Month
                            console.log('Real-Time Month');
                            current.setMonth(current.getMonth() - 1);
                        }else{ //Previous Month
                            console.log('Previous Month');
                            current.setMonth(current.getMonth() - 2);
                        }

                        let previousMonth = current.toLocaleString('en-US', {
                            timeZone: 'Asia/Manila',
                            month: 'long'
                        });

                        $("#idmonth").val(previousMonth);
                    });

                }else{
                    let current = new Date();

                    GetActiveMonth('with_callback', function(result){
                        if(result.active_month == 1){ //Real-Time Month
                            current.setMonth(current.getMonth());
                        }else{ //Previous Month
                            current.setMonth(current.getMonth() - 1);
                        }

                        let currentMonth = current.toLocaleString('en-US', {
                            timeZone: 'Asia/Manila',
                            month: 'long'
                        });
                        $("#idmonth").val(currentMonth);
                    });

                    //commented by ***** clark *****
                    // current.setMonth(current.getMonth()); //uncomment to activate real month
                    // current.setMonth(current.getMonth() - 1); //uncomment to activate previous month
                    // current.setMonth(4); //uncomment to activate previous month **custom**
                }
            });

            // DATATABLES OF MONTHLY USED PAPER
            var dataTableMonthlyUsedPaperDraft = $("#draftTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                // // "scrollX": true,
                "ajax": {
                    url: "display_monthly_used_paper_draft",
                },
                "columns": [{
                        "data": "month",
                        orderable: true,
                        width: "10%"
                    },
                    {
                        "data": "fiscal_year.year",
                        width: "10%",
                        visible: false
                    },
                    {
                        "data": "paper.name",
                        orderable: false
                    },
                    {
                        "data": "paper_quantity",
                        orderable: false
                    },
                    {
                        "data": "action",
                        orderable: false
                    }
                ],
                "order": [
                    [1, 'desc'],
                    [0, 'asc']
                ]

                // "bSort": false,
            });
            // DATATABLES OF MONTHLY USED PAPER END

            // DATATABLES OF MONTHLY USED PAPER DRAFT
            var dataTableMonthlyUsedPaper = $("#monthlyUsedTable").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                // // "scrollX": true,
                "ajax": {
                    url: "display_monthly_used_paper",
                },
                "columns": [{
                        "data": "month",
                        orderable: true,
                        width: "10%"
                    },
                    {
                        "data": "fiscal_year.year",
                        width: "10%",
                        visible: false
                    },
                    {
                        "data": "paper.name",
                        orderable: false
                    },
                    {
                        "data": "data_monthly_used_paper",
                        orderable: false
                    },
                    {
                        "data": "reason",
                        orderable: false
                    }
                ],
                "order": [
                    [1, 'desc'],
                    [0, 'asc']
                ]
                // "bSort": false,
            });
            // DATATABLES OF MONTHLY USED PAPER DRAFT END

            // ADD DRAFT
            $("#btnAddMonthlyUsedDraft").on('click', function(event) {
                // ADD MONTHLY USED PAPER DRAFT
                // $("#addMonthlyUsedPaperForm").submit(function(event) {
                event.preventDefault(); // to stop the form submission
                AddMonthlyUsedPaperDraft();
                // });

                $("#addMonthlyUsedModalbtn").on('click', function() {
                    $("#selPaperId").removeClass('is-invalid');
                    $("#selPaperId").attr('title', '');
                    $("#idquantity").removeClass('is-invalid');
                    $("#idquantity").attr('title', '');
                    $("#idreason").removeClass('is-invalid');
                    $("#idreason").attr('title', '');
                    $("#selPaperId").focus();
                });
                // ADD MONTHLY USED PAPER DRAFT END
            });
            // ADD DRAFT END

            // ADD MONTHLY USED PAPER
            $("#btnAddMonthlyUsed").on('click', function(event) {
                // ADD MONTHLY USED PAPER DRAFT
                // $("#addMonthlyUsedPaperForm").submit(function(event) {
                event.preventDefault(); // to stop the form submission
                AddMonthlyUsedPaper();
                // });

                $("#addMonthlyUsedModalbtn").on('click', function() {
                    $("#selPaperId").removeClass('is-invalid');
                    $("#selPaperId").attr('title', '');
                    $("#idquantity").removeClass('is-invalid');
                    $("#idquantity").attr('title', '');
                    $("#idreason").removeClass('is-invalid');
                    $("#idreason").attr('title', '');
                    $("#selPaperId").focus();
                });
                // ADD MONTHLY USED PAPER END
            });
            // ADD DRAFT END

            // EDIT DRAFT
            $(document).on('click', '.actionEditDraft', function() {

                let draftId = $(this).attr('draft-id');
                $("#editDraftId").val(draftId);

                GetMonthlyUsedDraftByIdToEdit(draftId);

                $('#btnSaveDraft').show();
                $('#btnSubmitDraft').hide();
                $('#title').html('<i class="fas fa-edit"></i> &nbsp;Edit Used Paper Draft')
                $('#quantityId').attr('readonly', false);
                $('#selPaperIdEdit').prop('disabled', false);
                $('#reasonId').attr('readonly', false);
                $('#editNoConsumptionCheckedId').prop('disabled', false);

                $("#selPaperIdEdit").removeClass('is-invalid');
                $("#selPaperIdEdit").attr('title', '');
                $("#quantityId").removeClass('is-invalid');
                $("#quantityId").attr('title', '');
                $("#reasonId").removeClass('is-invalid');
                $("#reasonId").attr('title', '');
                $("#selPaperIdEdit").focus();
            });

            $("#btnSaveDraft").on('click', function(event) {
                // $("#editMonthlyUsedPaperForm").submit(function(event) {
                event.preventDefault(); // to stop the form submission
                EditMonthlyUsedPaperDraft();
                // });
            });
            // EDIT DRAFT END

            // SUBMIT DRAFT
            $(document).on('click', '.actionSubmitDraft', function() {
                $('#btnSaveDraft').hide();
                $('#btnSubmitDraft').show();
                $('#title').html('<i class="fa fa-check"></i> &nbsp;Submit Used Paper Draft');
                $('#quantityId').attr('readonly', true);
                $('#selPaperIdEdit').prop('disabled', true);
                $('#reasonId').attr('readonly', true);
                $('#editNoConsumptionCheckedId').prop('disabled', true);

                let draftId = $(this).attr('draft-id');
                $("#editDraftId").val(draftId);

                GetMonthlyUsedDraftByIdToEdit(draftId);

                $("#selPaperIdEdit").removeClass('is-invalid');
                $("#selPaperIdEdit").attr('title', '');
                $("#quantityId").removeClass('is-invalid');
                $("#quantityId").attr('title', '');
                $("#reasonId").removeClass('is-invalid');
                $("#reasonId").attr('title', '');
                $("#selPaperIdEdit").focus();
            });

            $("#btnSubmitDraft").on('click', function(event) {
                // $("#editMonthlyUsedPaperForm").submit(function(event) {
                $('#selPaperIdEdit').prop('disabled', false);
                event.preventDefault(); // to stop the form submission
                AddMonthlyUsedPaperFromDraft();
                // });
            });
            // SUBMIT DRAFT END

            // DELETE DRAFT
            $(document).on('click', '.actionDeleteDraft', function(event) {

                let draftId = $(this).attr('draft-id');

                $("#deleteDraftId").val(draftId);

                $('#btnDeleteDraft').on('click', function(event) {
                    event.preventDefault();
                    DeleteDraft();
                });
                // $("#deleteDraftForm").submit(function(event) {
                // });
            });
            // DELETE DRAFT END

            // PASS MONTH YEAR
            $("#getMonthForm").submit(function(event) {
                event.preventDefault();
                GetMonthForTotalUsed();
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
