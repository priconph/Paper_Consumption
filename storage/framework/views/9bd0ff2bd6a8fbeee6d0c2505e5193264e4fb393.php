<input type="hidden" id="userLevel" value="<?php echo e($_SESSION['user_level']); ?>">

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <a id="toPaperConsumptionReport" href="<?php echo e(route('paper_consumption_report')); ?>" class="brand-link">
        <img src="<?php echo e(asset('public/images/pcms.png')); ?>" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light" style="font-size: 14px;">Paper Consumption Monitoring<br>
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">

                    <h6>
                        User - <?php if(auth()->guard()->check()): ?>
                            <?php echo e(Auth::user()->department->name); ?>

                        <?php endif; ?>
                    </h6>
                </li>
                <li class="nav-item has-treeview">
                    <a href="<?php echo e(route('user_dashboard')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>

                </li>
                <li class="nav-header"> PAPER CONSUMPTION - <?php if(auth()->guard()->check()): ?>
                        <?php echo e(Auth::user()->department->name); ?>

                    <?php endif; ?></li>
                <li id="paperConsumptionRoute" class="item has-treeview">

                    


                    <ul class="menu-content list-unstyled">
                        <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                            <a href="<?php echo e(route('paper_consumption_report')); ?>" aria-controls="monthly-target"
                                aria-selected="true" class="nav-link" id="aRoutesId">&nbsp;
                                <i class="nav-icon fa fa-clipboard-list"></i>&nbsp;&nbsp;&nbsp;
                                <p>Overview</p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                            <a href="<?php echo e(route('paper_consumption_report_monthly')); ?>" class="nav-link"
                                id="aRoutesId">&nbsp;
                                <i class="fas fa-file-export"></i>&nbsp;
                                <p>Used Papers</p>
                            </a>
                        </li>
                    </ul>

                    <hr>
                </li>

                
            </ul>
            

            

            
            
            
        </nav>
    </div>
</aside>
<?php /**PATH /var/www/paper_consumption/resources/views/shared/pages/user_nav.blade.php ENDPATH**/ ?>