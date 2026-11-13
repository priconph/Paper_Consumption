<?php $layout = 'layouts.admin_layout'; ?>
<?php if(auth()->guard()->check()): ?>
    <?php

    if (Auth::user()->user_level_id == 3) {
        $layout = 'layouts.user_layout';
    }
    ?>
<?php endif; ?>

<?php if(auth()->guard()->check()): ?>
    
    <style>
        ::-webkit-scrollbar {
            display: none !important;
        }

    </style>

    <?php $__env->startSection('content_page'); ?>
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
                                        

                                        <li class="nav-item">
                                            <a class="nav-link active" id="fyTarget-management-tab" data-toggle="tab"
                                                href="#fyTarget-management" role="tab" aria-controls="fyTarget-management"
                                                aria-selected="true">FY Target</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="monthlyTarget-management-tab" data-toggle="tab"
                                                href="#monthlyTarget-management" role="tab"
                                                aria-controls="monthlyTarget-management" aria-selected="true">Monthly Target</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="actualConsumption-management-tab" data-toggle="tab"
                                                href="#actualConsumption-management" role="tab"
                                                aria-controls="actualConsumption-management" aria-selected="true">Actual
                                                Consumption</a>
                                        </li>
                                        
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

                                                        <th colspan="13">
                                                            <h4>
                                                                FY Target
                                                            </h4>
                                                        </th>

                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>BOD</th>
                                                            <th>IAS</th>
                                                            <th>FIN</th>
                                                            <th>HRD</th>
                                                            <th>ESS</th>
                                                            <th>LOG</th>
                                                            <th>FAC</th>
                                                            <th>ISS</th>
                                                            <th>QAD</th>
                                                            <th>EMS</th>
                                                            <th>TOTAL</th>
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
                                                        <th colspan="15">
                                                            <h4>
                                                                Monthly Target
                                                            </h4>
                                                        </th>
                                                        <tr>
                                                            <th>Section</th>
                                                            <th></th>
                                                            <th>April</th>
                                                            <th>May</th>
                                                            <th>June</th>
                                                            <th>July</th>
                                                            <th>August</th>
                                                            <th>September</th>
                                                            <th>October</th>
                                                            <th>November</th>
                                                            <th>December</th>
                                                            <th>January</th>
                                                            <th>February</th>
                                                            <th>March</th>
                                                            <th>TOTAL</th>
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
                                                        <th colspan="15">
                                                            <h4>
                                                                Actual Consumption
                                                            </h4>
                                                        </th>
                                                        <tr>
                                                            <th>Section</th>
                                                            <th></th>
                                                            <th>April</th>
                                                            <th>May</th>
                                                            <th>June</th>
                                                            <th>July</th>
                                                            <th>August</th>
                                                            <th>September</th>
                                                            <th>October</th>
                                                            <th>November</th>
                                                            <th>December</th>
                                                            <th>January</th>
                                                            <th>February</th>
                                                            <th>March</th>
                                                            <th>TOTAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="actualConsumptionData"></tbody>
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
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('js_content'); ?>
        <script type="text/javascript">
            GetFiscalYearTarget($(".selectYear"));

            //===== FOR WHOLE FY TARGET =====//
            $(window).on("load", function() {
                let year = $('#selYearFYTargetId').val();
                let paperId = $(".selectedFiscalYear").val(year);
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
                let paperId = $(".selectedFiscalYear").val();

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
                let paperId = $(".selectedFiscalYearforMonthlyTarget").val(year);
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
                let paperId = $(".selectedFiscalYearforMonthlyTarget").val();

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
                let paperId = $(".selectedFiscalYearforActualConsumption").val(year);
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
                let paperId = $(".selectedFiscalYearforActualConsumption").val();

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



            // DATATABLES OF MONTHLY USED PAPER
            // var dataTableFYTarget = $("#fyTarget").DataTable({
            //     "processing": false,
            //     "serverSide": true,
            //     "responsive": true,
            //     // // "scrollX": true,
            //     "ajax": {
            //         url: "get_all_target_papers",
            //     },
            //     "columns": [{
            //             "data": "papers"
            //         },
            //         {
            //             "data": "monthly_target"
            //         }
            //     ],
            //     // "order": []
            // });
            // DATATABLES OF MONTHLY USED PAPER END



            $(document).ready(function() {
                $("#formSignOut").submit(function(event) {
                    event.preventDefault();
                    SignOut();
                });
            });
        </script>
    <?php $__env->stopSection(); ?>
<?php endif; ?>

<?php echo $__env->make($layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/paper_consumption/resources/views/summary_fy_target.blade.php ENDPATH**/ ?>