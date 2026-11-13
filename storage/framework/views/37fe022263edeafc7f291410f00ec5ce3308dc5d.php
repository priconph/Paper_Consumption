<?php if(!Auth::user()): ?>
    <script type="text/javascript">
        window.location = "/paper_consumption";
    </script>

<?php else: ?>
    <?php
        session_start();
        $_SESSION['user_level'] = Auth::user()->user_level_id;
        $_SESSION['user_department'] = Auth::user()->department_id;
    ?>
    <!DOCTYPE html>
    <html>

    
    <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">
    
    

    
    
    

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Paper Consumption Monitoring</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <style>
            #paperConsumptionRoutesId:hover {
                background-color: #778899;
                list-style-type: none !important;
            }

            #aRoutesId {
                color: silver !important;
            }

            hr {
                color: white !important;
                background-color: white !important;
            }

        </style>

        
        <?php echo $__env->make('shared.css_links.css_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </head>

    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php echo $__env->make('shared.pages.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('shared.pages.user_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldContent('content_page'); ?>
            <?php echo $__env->make('shared.pages.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                $("#summaryRoute").show();
            } else if ($("#userLevel").val() == 2) {
                $("#managementRoute").show();
            } else if ($("#userLevel").val() == 3) {
                $("#managementRoute").hide();
                $("#summaryRoute").hide();
            }
        });

        $(document).ready(function() {
            if ($("#userLevel").val() == 2) {
                $("#toSummary").hide();
                $("#toPaperConsumptionReport").hide();
                $("#toManagement").show();
            } else if ($("#userLevel").val() == 1) {
                $("#toSummary").show();
                $("#toManagement").hide();
                $("#toPaperConsumptionReport").hide();
            } else if ($("#userLevel").val() == 3) {
                $("#toSummary").hide();
                $("#toManagement").hide();
                $("#toPaperConsumptionReport").show();
            }
        });
    </script>
    </html>
<?php endif; ?>
<?php /**PATH /var/www/paper_consumption/resources/views/layouts/user_layout.blade.php ENDPATH**/ ?>