<input type="hidden" id="userLevel" value="<?php echo e($_SESSION['user_level']); ?>">

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
    <a id="toManagement" href="<?php echo e(route('dashboard')); ?>" class="brand-link">
        <img src="<?php echo e(asset('public/images/pcms.png')); ?>" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        
        <span class="brand-text font-weight-light" style="font-size: 14px;">Paper Consumption Monitoring<br>
        </span>
    </a>

    <a id="toSummary" href="<?php echo e(route('dashboard')); ?>" class="brand-link">
        <img src="<?php echo e(asset('public/images/pcms.png')); ?>" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        
        <span class="brand-text font-weight-light" style="font-size: 14px;">Paper Consumption Monitoring<br>

        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">ADMINISTRATOR - <?php if(auth()->guard()->check()): ?>
                        <?php echo e(Auth::user()->department->name); ?>

                    <?php endif; ?></li>
                <li class="nav-item has-treeview">
                    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li id="managementRoute" class="nav-item has-treeview">
                    <a href="<?php echo e(route('management')); ?>" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Management</p>
                    </a>
                </li>

                
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->department_id == 8): ?> 
                        <li id="activeMonthConfigRoute" class="nav-item has-treeview">
                            <a href="<?php echo e(route('data_settings')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-sliders-h"></i>
                                <p>Data Settings</p>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

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

                <li id="paperConsumptionRoute" class="nav-item has-treeview">
                    <a href="<?php echo e(route('summary')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>Summary</p>
                    </a>
                    
                </li>
            </ul>
            <hr>
        </nav>
    </div>
</aside>
<?php /**PATH /var/www/paper_consumption/resources/views/shared/pages/admin_nav.blade.php ENDPATH**/ ?>