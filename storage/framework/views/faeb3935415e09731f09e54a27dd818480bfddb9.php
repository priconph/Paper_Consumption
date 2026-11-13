<?php $__env->startSection('content_page'); ?>
    <div class="content-wrapper" style="margin-right: 1%;">
        <section class="content-header"></section>
        <section class="content">
            <div class="container-fluid">
                <div class="col-12 text-center">
                    <h1 style="font-weight: bold;"> ACTIVE MONTH </h1><br>
                    <h2 id="ActiveMonth"></h2>
                    <button data-toggle="modal" data-target="#modalSetActiveMonth" id="setActiveMonthBtn" active_month="" class="btn btn-success">
                        <i id="" class="fa fa-calendar"></i> Change Active Month
                    </button>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalSetActiveMonth" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTitle"><strong>Set Active Month</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="ChangeActiveMonthForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <h5 id="ActiveMonthModalLabel"></h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js_content'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            GetActiveMonth();

            $('#setActiveMonthBtn').click(function(e){
                e.preventDefault();
                if($('#setActiveMonthBtn').attr('active_month') == 1){//if active month is real-time month
                    $('#ActiveMonthModalLabel').html('Change to Previous Month?');
                }else{
                    $('#ActiveMonthModalLabel').html('Change to Real-Time Month?');
                }
            });

            $('#ChangeActiveMonthForm').submit(function (e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "change_active_month",
                    data: $('#ChangeActiveMonthForm').serialize(),
                    dataType: "json",
                    success: function (response) {
                        toastr.success(response['message']);
                        $('#modalSetActiveMonth').modal('hide');
                        GetActiveMonth();
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/paper_consumption/resources/views/month_config.blade.php ENDPATH**/ ?>