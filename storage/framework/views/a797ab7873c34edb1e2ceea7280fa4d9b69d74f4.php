<style>
    ::-webkit-scrollbar {
        display: none !important;
    }

    /* html,
    body {
        margin: 0;
        height: 100%;
        overflow: hidden
    } */

    /* input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none !important;
    margin: 0 !important; */
    /* } */

</style>

<?php $__env->startSection('content_page'); ?>
    

    <div class="content-wrapper" style="margin-right: 1%;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            
                            <button data-toggle="modal" data-target="#modalFiscalYear" id="setFiscalYearbtn"
                                class="btn btn-secondary"><i id="btnAddPaperIcon" class="fa fa-calendar"></i> Set Fiscal
                                Year</button>
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
                                        <a class="nav-link active" id="item-management-tab" data-toggle="tab"
                                            href="#item-management" role="tab" aria-controls="item-management"
                                            aria-selected="true">Paper Management Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="department-tab" data-toggle="tab" href="#department-management" role="tab" aria-controls="department-management" aria-selected="false">Department Management Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="user-tab" data-toggle="tab" href="#user-management"
                                            role="tab" aria-controls="user-management" aria-selected="false">Assigned Staff
                                            Management Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="deduction-tab" data-toggle="tab"
                                            href="#deduction-management" role="tab" aria-controls="deduction-management"
                                            aria-selected="false">Policy Deductions Management Tab</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">

                                    <div class="tab-pane fade show active" id="item-management" role="tabpanel"
                                        aria-labelledby="item-management-tab">
                                        <div class="text-right mt-4">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddItem"
                                                id="addItemModalbtn"><i class="fa fa-plus fa-md"></i> Add Paper</button>
                                        </div><br>
                                        <div class="table responsive">
                                            <table id="paperTable"
                                                class="table table-sm table-bordered table-striped table-hover text-center"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>

                                                        <th>Paper</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="department-management" role="tabpanel"
                                        aria-labelledby="department-tab">
                                        <div class="text-right mt-4">
                                            <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#modalAddDepartment" id="addDepartmentModalbtn"><i
                                                    class="fa fa-plus fa-md"></i> Add Department</button>
                                        </div><br>
                                        <div class="table responsive">
                                            <table id="departmentTable"
                                                class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>

                                                        <th>Department</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="user-management" role="tabpanel"
                                        aria-labelledby="user-tab">
                                        <div class="text-right mt-4">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddUser"
                                                id="addUserModalbtn"><i class="fa fa-plus fa-md"></i> Add Staff</button>
                                        </div><br>
                                        <div class="table responsive">
                                            <table id="userTable"
                                                class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>

                                                        <th>Name</th>
                                                        <th>Department</th>
                                                        <th>User Level</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="deduction-management" role="tabpanel"
                                        aria-labelledby="deduction-management">
                                        <div class="text-right mt-4">
                                            <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#modalAddDeduction" id="addDeductionModalbtn"><i
                                                    class="fa fa-plus fa-md"></i> Add Deduction</button>
                                        </div><br>
                                        <div class="table responsive">
                                            <table id="deductionTable"
                                                class="table table-sm table-bordered table-striped table-hover display nowrap text-center"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>

                                                        <th>Fiscal Year</th>
                                                        <th>Deduction</th>
                                                        <th>Department</th>
                                                        <th>Action</th>
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

    <!-- ADD PAPER MODAL START -->
    <div class="modal fade" id="modalAddItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Add Paper</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="addPaperForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Paper name</label>
                                    <input style="text-transform: capitalize;" type="text" class="form-control"
                                        name="paper_name" id="idpapername">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddPaper" class="btn btn-primary"><i id="btnAddPaperIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- ADD PAPER MODAL END -->

    <!-- DEACTIVATE PAPER MODAL START -->
    <div class="modal fade" id="modalDeactivatePaper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Deactivate Paper</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="deactivatePaperForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Are you sure you want to deactivate this paper?</label>
                            <input type="hidden" class="form-control" name="paper_id" id="deactivatePaperID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnDeactivatePaper" class="btn btn-primary"><i id="deactivateIcon"
                                class="fa fa-check"></i> Deactivate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- DEACTIVATE PAPER MODAL END -->

    <!-- ACTIVATE PAPER MODAL START -->
    <div class="modal fade" id="modalActivatePaper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Activate Paper</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="activatePaperForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Activate this paper?</label>
                            <input type="hidden" class="form-control" name="paper_id" id="activatePaperID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnActivatePaper" class="btn btn-primary"><i id="activateIcon"
                                class="fa fa-check"></i> Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- ACTIVATE PAPER MODAL END -->

    <!-- EDIT PAPER MODAL START -->
    <div class="modal fade" id="modalEditItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-file"></i>&nbsp;&nbsp;Edit Paper</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="editPaperForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Paper name</label>
                                    <input type="hidden" class="form-control" name="paper_id" id="editPaperID">
                                    <input style="text-transform: capitalize;" type="text" class="form-control"
                                        name="paper_name" id="idEditpapername">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnEditPaper" class="btn btn-primary"><i id="btnEditPaperIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- EDIT PAPER MODAL END -->

    
    <div class="modal fade" id="modalAddDepartment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-building"></i>&nbsp;&nbsp;Add Department</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="addDepartmentForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Department name</label>
                                    <input style="text-transform: capitalize;" type="text" class="form-control"
                                        name="department_name" id="iddepartmentname">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddDepartment" class="btn btn-primary"><i id="btnAddDepartmentIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <!-- DEACTIVATE DEPARTMENT MODAL START -->
    <div class="modal fade" id="modalDeactivateDepartment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-building"></i>&nbsp;&nbsp;Deactivate Department</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="deactivateDepartmentForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Are you sure you want to deactivate this department?</label>
                            <input type="hidden" class="form-control" name="department_id" id="deactivateDepartmentID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnDeactivateDepartment" class="btn btn-primary"><i id="deactivateIcon"
                                class="fa fa-check"></i> Deactivate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- DEACTIVATE DEPARTMENT MODAL END -->

    <!-- ACTIVATE DEPARTMENT MODAL START -->
    <div class="modal fade" id="modalActivateDepartment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-building"></i>&nbsp;&nbsp;Activate Department</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="activateDepartmentForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Activate this department?</label>
                            <input type="hidden" class="form-control" name="department_id" id="activateDepartmentID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnActivateDepartment" class="btn btn-primary"><i id="activateIcon"
                                class="fa fa-check"></i> Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- ACTIVATE DEPARTMENT MODAL END -->

    <!-- EDIT DEPARTMENT MODAL START -->
    <div class="modal fade" id="modalEditDepartment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-building"></i>&nbsp;&nbsp;Edit Department</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="editDepartmentForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Department name</label>
                                    <input type="hidden" class="form-control" name="department_id" id="editDepartmentID">
                                    <input style="text-transform: capitalize;" type="text" class="form-control"
                                        name="department_name" id="idEditdepartmentname">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnEditDepartment" class="btn btn-primary"><i id="btnEditDepartmentIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- EDIT DEPARTMENT MODAL END -->

    <!-- ADD USER MODAL START -->
    <div class="modal fade" id="modalAddUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp;Add Staff</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="addUserForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input style="text-transform: capitalize;" type="text" class="form-control"
                                        name="name" id="idname">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" id="idemail">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" id="idusername">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control select2bs4 selectDepartment" name="department"
                                        id="selDepartmentId" style="width: 100%;">
                                        <!-- Code generated -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>User Level</label>
                                    <select class="form-control select2bs4 selectUserLevel" name="userLevel"
                                        id="selUserLevelId" style="width: 100%;">
                                        <!-- Code generated -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddUser" class="btn btn-primary"><i id="btnAddUserIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ADD USER MODAL END -->

    <!-- DEACTIVATE USER MODAL START -->
    <div class="modal fade" id="modalDeactivateUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp;Deactivate Staff</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="deactivateUserForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Are you sure you want to deactivate this user?</label>
                            <input type="hidden" class="form-control" name="user_id" id="deactivateUserID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnDeactivateUser" class="btn btn-primary"><i id="deactivateIcon"
                                class="fa fa-check"></i> Deactivate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- DEACTIVATE USER MODAL END -->

    <!-- ACTIVATE USER MODAL START -->
    <div class="modal fade" id="modalActivateUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp;Activate Staff</h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="activateUserForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Activate this user?</label>
                            <input type="hidden" class="form-control" name="user_id" id="activateUserID">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnActivateUser" class="btn btn-primary"><i id="activateIcon"
                                class="fa fa-check"></i> Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- ACTIVATE USER MODAL END -->

    <!-- EDIT USER MODAL START -->
    <div class="modal fade" id="modalEditUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp;Edit Staff</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="editUserForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="hidden" class="form-control" name="user_id" id="editUserId">
                                    <input style="text-transform: capitalize;" type="text" class="form-control"
                                        name="name" id="idEditname">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" id="idEditusername">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" id="idEditemail">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control select2bs4 selectDepartment" name="department"
                                        id="selDepartmentId" style="width: 100%;">
                                        <!-- Code generated -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>User Level</label>
                                    <select class="form-control select2bs4 selectUserLevel" name="userLevel"
                                        id="selUserLevelId" style="width: 100%;">
                                        <!-- Code generated -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnEditUser" class="btn btn-primary"><i id="btnEditUserIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- EDIT USER MODAL END -->

    <!-- ADD DEDUCTION MODAL START -->
    <div class="modal fade" id="modalAddDeduction">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-minus"></i>&nbsp;&nbsp;Add Deduction</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="addDeductionForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Deduction</label>
                                    <input style="text-transform: capitalize;" type="number" class="form-control"
                                        name="deduction" id="iddeduction" min="0" max="100" placeholder="%">
                                </div>
                                <div class="form-group">
                                    <label>Fiscal Year</label>
                                    <select class="form-control selectYear" name="fiscal_year" id="selYearFYTargetId"
                                        style="width: 100%;">
                                        <!-- Code generated -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control selectDepartment" name="department" id="selDepartmentId"
                                        style="width: 100%;">
                                        <!-- Code generated -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddDeduction" class="btn btn-primary"><i id="btnAddDeductionIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- ADD DEDUCTION MODAL END -->

    <!-- EDIT DEDUCTION MODAL START -->
    <div class="modal fade" id="modalEditDeduction">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-minus"></i>&nbsp;&nbsp;Edit Deduction</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="editDeductionForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Deduction</label>
                                    <input type="hidden" class="form-control" name="deduction_id" id="editDeductionId">
                                    <input type="number" class="form-control" name="deduction" id="idEditdeduction"
                                        min="0" max="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnEditDeduction" class="btn btn-primary"><i id="btnEditDeductionIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- EDIT DEDUCTION MODAL END -->

    <!-- SET FISCAL MODAL START -->
    <div class="modal fade" id="modalFiscalYear">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-calendar-check" aria-hidden="true"></i>&nbsp;&nbsp;Set
                        Fiscal Year</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="setFiscalYearForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <label>Current Fiscal Year</label><br>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#modalUpdateFiscal" id="updateFiscalbtn"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                                <input type="number" class="form-control" name="fiscal_year" min="2021" id="fiscalYearId"
                                    readonly>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnSetFiscalYear" class="btn btn-primary"><i id="btnSetFiscalYearIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- SET FISCAL MODAL END -->

    <!-- UPDATE FISCAL MODAL START -->
    <div class="modal fade" id="modalUpdateFiscal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fa fa-calendar-check" aria-hidden="true"></i>&nbsp;&nbsp;Set
                        Fiscal Year</h4>
                    <button type="button" style="color: #fff;" id="updateFiscalclosebtn" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="updateFiscalYearForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row text-center">
                            <p class="text-center">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Are
                                you sure you want to set fiscal year to <span class="nextYear"
                                    style="font-weight: bold;"></span> ?
                            </p>
                            <input type="hidden" id="nextYearId" name="next_fiscal_year">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" id="updateFiscalclosebtn1"
                            data-dismiss="modal">Close</button>
                        <button type="submit" id="btnUpdateFiscalYear" class="btn btn-primary"><i
                                id="btnUpdateFiscalYearIcon" class="fa fa-check"></i> Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- UPDATE FISCAL MODAL END -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js_content'); ?>
    <script type="text/javascript">
        GetDepartment($(".selectDepartment"));
        GetUserLevel($(".selectUserLevel"));
        GetFiscalYearTarget($(".selectYear"));
        // GetFiscalYears($(".selectYear"));



        GetFiscalYear();

        $("#updateFiscalbtn").click(function() {
            $("#modalFiscalYear").hide();
        });

        $("#updateFiscalclosebtn").click(function() {
            $('.modal-backdrop').remove();
        });

        $("#updateFiscalclosebtn1").click(function() {
            $('.modal-backdrop').remove();
        });

        $("#updateFiscalYearForm").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            UpdateFiscalYear();
        });


        dataTablePapers = $("#paperTable").DataTable({
            "processing": false,
            "serverSide": true,
            "responsive": true,
            // "scrollX": true,
            "ajax": {
                url: "view_papers",
            },
            "columns": [

                {
                    "data": "name",
                    orderable: false
                },
                {
                    "data": "status",
                    orderable: false
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                }
            ],
        }); // PAPER DATATABLES END

        // ADD PAPER
        $("#addPaperForm").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            AddPapers();
        });

        $("#addItemModalbtn").click(function() {
            $("#idpapername").removeClass('is-invalid');
            $("#idpapername").attr('title', '');
            $("#idpapername").focus();
        });
        // ADD PAPER END

        // DEACTIVATE PAPER
        $(document).on('click', '.actionDeactivatePaper', function() {

            let paperId = $(this).attr('paper-id');

            $("#deactivatePaperID").val(paperId);
        });
        $("#deactivatePaperForm").submit(function(event) {
            event.preventDefault();
            DeactivatePapers();
        });
        // DEACTIVATE PAPER END

        // ACTIVATE PAPER
        $(document).on('click', '.actionActivatePaper', function() {

            let paperId = $(this).attr('paper-id');

            $("#activatePaperID").val(paperId);
        });
        $("#activatePaperForm").submit(function(event) {
            event.preventDefault();
            ActivatePapers();
        });
        // ACTIVATE PAPER END

        // EDIT PAPER
        $(document).on('click', '.actionEditPaper', function() {

            let paperId = $(this).attr('paper-id');
            $("#editPaperID").val(paperId);

            GetPaperByIdToEdit(paperId);

            $("#idEditpapername").removeClass('is-invalid');
            $("#idEditpapername").attr('title', '');
            $("#idEditpapername").focus();
        });

        $("#editPaperForm").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            EditPaper();
        });
        // EDIT PAPER END

        // DEPARTMENT DATATABLES
        dataTableDepartments = $("#departmentTable").DataTable({
            "processing": false,
            "serverSide": true,
            "responsive": true,
            // "scrollX": true,
            "ajax": {
                url: "view_departments",
            },
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "status"
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                }
            ],
        }); // DEPARTMENT DATATABLES END

        // USER DATATABLES
        dataTableUsers = $("#userTable").DataTable({
            "processing": false,
            "serverSide": true,
            "responsive": true,
            // "scrollX": true,
            "ajax": {
                url: "view_users",
            },
            "columns": [

                {
                    "data": "name"
                },
                {
                    "data": "department.name"
                },
                // {  data: 'user_levels_id.user_level', render: function(data) {return "Key 4" + data}, orderable:false},
                {
                    "data": "user_levels_id.user_level"
                },
                {
                    "data": "status",
                    orderable: false
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                }
            ],
            "order": [2, 'asc']
        }); // USER DATATABLES END

        // ADD DEPARTMENT
        $("#addDepartmentForm").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            AddDepartment();
        });

        $("#addDepartmentModalbtn").click(function() {
            $("#iddepartmentname").removeClass('is-invalid');
            $("#iddepartmentname").attr('title', '');
            $("#iddepartmentname").focus();
        });
        // ADD DEPARTMENT END

        // DEACTIVATE DEPARTMENT
        $(document).on('click', '.actionDeactivateDepartment', function() {

            let departmentId = $(this).attr('department-id');

            $("#deactivateDepartmentID").val(departmentId);
        });
        $("#deactivateDepartmentForm").submit(function(event) {
            event.preventDefault();
            DeactivateDepartment();
        });
        // DEACTIVATE DEPARTMENT END

        // ACTIVATE DEPARTMENT
        $(document).on('click', '.actionActivateDepartment', function() {

            let departmentId = $(this).attr('department-id');

            $("#activateDepartmentID").val(departmentId);
        });
        $("#activateDepartmentForm").submit(function(event) {
            event.preventDefault();
            ActivateDepartment();
        });
        // ACTIVATE DEPARTMENT END

        // EDIT DEPARTMENT
        $(document).on('click', '.actionEditDepartment', function() {

            let departmentId = $(this).attr('department-id');
            $("#editDepartmentID").val(departmentId);

            GetDepartmentByIdToEdit(departmentId);

            $("#idEditdepartmentname").removeClass('is-invalid');
            $("#idEditdepartmentname").attr('title', '');
            $("#idEditdepartmentname").focus();
        });

        $("#editDepartmentForm").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            EditDepartment();
        });
        // EDIT DEPARTMENT END

        // ADD USER
        $("#addUserForm").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            AddUser();
        });

        $("#addUserModalbtn").click(function() {
            $("#idname").removeClass('is-invalid');
            $("#idname").attr('title', '');
            $("#idemail").removeClass('is-invalid');
            $("#idemail").attr('title', '');
            $("#idusername").removeClass('is-invalid');
            $("#idusername").attr('title', '');
            $("#selDepartmentId").removeClass('is-invalid');
            $("#selDepartmentId").attr('title', '');
            $("#selUserLevelId").removeClass('is-invalid');
            $("#selUserLevelId").attr('title', '');
            $("#idname").focus();
        });
        // ADD USER END

        // DEACTIVATE USER
        $(document).on('click', '.actionDeactivateUser', function() {

            let userId = $(this).attr('user-id');

            $("#deactivateUserID").val(userId);
        });
        $("#deactivateUserForm").submit(function(event) {
            event.preventDefault();
            DeactivateUser();
        });
        // DEACTIVATE USER END

        // ACTIVATE USER
        $(document).on('click', '.actionActivateUser', function() {

            let userId = $(this).attr('user-id');

            $("#activateUserID").val(userId);
        });
        $("#activateUserForm").submit(function(event) {
            event.preventDefault();
            ActivateUser();
        });
        // ACTIVATE USER END

        // EDIT USER
        $(document).on('click', '.actionEditUser', function() {

            let userId = $(this).attr('user-id');
            $("#editUserId").val(userId);

            GetUserId(userId);

            $("#idEditname").removeClass('is-invalid');
            $("#idEditname").attr('title', '');
            $("#idEditusername").removeClass('is-invalid');
            $("#idEditusername").attr('title', '');
            $("#idEditemail").removeClass('is-invalid');
            $("#idEditemail").attr('title', '');
            $("#selDepartmentId").removeClass('is-invalid');
            $("#selDepartmentId").attr('title', '');
            $("#idEditname").focus();
        });

        $("#editUserForm").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            EditUser();
        });
        // EDIT USER END

        // DEDUCTION DATATABLES
        dataTableDeductions = $("#deductionTable").DataTable({
            "processing": false,
            "serverSide": true,
            "responsive": true,
            // "scrollX": true,
            "ajax": {
                url: "view_deductions",
            },
            "columns": [

                {
                    "data": "year"
                },
                {
                    data: 'deduction',
                    render: function(data) {
                        return data + "%"
                    },
                    orderable: false
                },
                // { "data" : "deduction"},
                {
                    "data": "department.name",
                    orderable: false,
                    searchable: false
                },

                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                }
            ],
            "order": [0, "desc"],
        }); // DEDUCTION DATATABLES END

        // ADD DEDUCTION
        $("#addDeductionForm").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            AddDeduction();
        });

        $("#addDeductionModalbtn").click(function() {
            $("#iddeduction").removeClass('is-invalid');
            $("#iddeduction").attr('title', '');
            $("#idyear").removeClass('is-invalid');
            $("#idyear").attr('title', '');
            $("#iddeduction").focus();
        });
        // ADD DEDUCTION END

        // EDIT DEDUCTION
        $(document).on('click', '.actionEditDeduction', function() {

            let deductionId = $(this).attr('deduction-id');
            $("#editDeductionId").val(deductionId);

            GetDeductionId(deductionId);

            $("#iddeduction").removeClass('is-invalid');
            $("#iddeduction").attr('title', '');
            $("#iddeduction").focus();
        });

        $("#editDeductionForm").submit(function(event) {
            event.preventDefault(); // to stop the form submission
            EditDeduction();
        });
        // EDIT DEDUCTION END

        $(document).ready(function() {
            $("#formSignOut").submit(function(event) {
                event.preventDefault();
                SignOut();
            });
        });

        // SET FISCAL YEAR
        $(document).ready(function() {
            $("#setFiscalYearForm").submit(function(event) {
                event.preventDefault();
                SetFiscalYear();
            });
        });

        $("#setFiscalYearbtn").click(function() {
            $("#fiscalYearId").removeClass('is-invalid');
            $("#fiscalYearId").attr('title', '');
            $("#fiscalYearId").focus();
        });
        // SET FISCAL YEAR END
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/paper_consumption/resources/views/management.blade.php ENDPATH**/ ?>