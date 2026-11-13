<?php if(!Auth::user()): ?>
    <script type="text/javascript">
        window.location = "/paper_consumption";
    </script>

<?php elseif(Auth::user()->user_level_id == 3): ?>
    <script type="text/javascript">
        window.location = "dashboard";
    </script>
<?php else: ?>
    <?php
        session_start();
        $_SESSION['user_level'] = Auth::user()->user_level_id;
        $_SESSION['user_department'] = Auth::user()->department_id;
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Paper Consumption Monitoring</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <style>
            #paperConsumptionRoutesId:hover {
                background-color: #778899 !important;
                list-style-type: none !important;
            }

            hr {
                color: white !important;
                background-color: white !important;
            }

            #aRoutesId {
                color: silver !important;
                background-color: none !important;
            }

        </style>

        
        <?php echo $__env->make('shared.css_links.css_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </head>

    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php echo $__env->make('shared.pages.admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('shared.pages.admin_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldContent('content_page'); ?>
            <?php echo $__env->make('shared.pages.admin_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        
        <?php echo $__env->make('shared.js_links.js_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('js_content'); ?>
    </body>

    <input type="hidden" id="userLevel" value="<?php echo e($_SESSION['user_level']); ?>">
    <input type="hidden" id="userDept" value="<?php echo e($_SESSION['user_department']); ?>">


    <script>
        $(document).ready(function() {
            // if ($('#userDept').val() != 8) {
            //     $('#addMonthlyTargetModalbtn').css('display', 'none');
            // }


            if ($("#userLevel").val() == 1) {
                $("#managementRoute").hide();
                $("#paperConsumptionRoute").hide();

            } else if ($("#userLevel").val() == 3) {
                $("#managementRoute").hide();
                $("#paperConsumptionRoute").show();
            } else if ($("#userLevel").val() == 2) {
                $("#managementRoute").show();
                $("#paperConsumptionRoute").show();
            }
        });

        $(document).ready(function() {
            if ($("#userLevel").val() == 2) {
                $("#toSummary").hide();
                $("#toManagement").show();
            } else {
                $("#toSummary").show();
                $("#toManagement").hide();
            }
        });
    </script>

    </html>
<?php endif; ?>
<?php /**PATH /var/www/paper_consumption/resources/views/layouts/admin_layout.blade.php ENDPATH**/ ?>