function AddDepartment() {
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

    $.ajax({
        url: "add_department",
        method: "post",
        data: $('#addDepartmentForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnAddDepartmentIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddDepartment").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving department failed!');
                if (response['error']['department_name'] === undefined) {
                    $("#iddepartmentname").removeClass('is-invalid');
                    $("#iddepartmentname").attr('title', '');
                }
                else {
                    $("#iddepartmentname").addClass('is-invalid');
                    $("#iddepartmentname").attr('title', response['error']['department_name']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalAddDepartment").modal('hide');
                $("#addDepartmentForm")[0].reset();
                toastr.success('Department added!');
                dataTableDepartments.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 0) {
                toastr.error('Department already exists!');
            }

            $("#btnAddDepartmentIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddDepartment").removeAttr('disabled');
            $("#btnAddDepartmentIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddDepartmentIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddDepartment").removeAttr('disabled');
            $("#btnAddDepartmentIcon").addClass('fa fa-check');
        }
    });
}

function DeactivateDepartment() {
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

    $.ajax({
        url: "deactivate_department",
        method: "post",
        data: $('#deactivateDepartmentForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#deactivateIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateDepartment").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableDepartments.draw();
                $("#modalDeactivateDepartment").modal('hide');
                $("#deactivateDepartmentForm")[0].reset();
                toastr.success('Department successfully deactivated!');
            }
            else {
                toastr.warning('Department already deactivated!');
            }

            $("#deactivateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateDepartment").removeAttr('disabled');
            $("#deactivateIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#deactivateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateDepartment").removeAttr('disabled');
            $("#deactivateIcon").addClass('fa fa-check');
        }
    });
}

function ActivateDepartment() {
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

    $.ajax({
        url: "activate_department",
        method: "post",
        data: $('#activateDepartmentForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#activateIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnActivateDepartment").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableDepartments.draw();
                $("#modalActivateDepartment").modal('hide');
                $("#activateDepartmentForm")[0].reset();
                toastr.success('Department successfully activated!');
            }
            else {
                toastr.warning('Department already deactivated!');
            }

            $("#activateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateDepartment").removeAttr('disabled');
            $("#activateIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#activateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateDepartment").removeAttr('disabled');
            $("#activateIcon").addClass('fa fa-check');
        }
    });
}

function GetDepartmentByIdToEdit(departmentId) {
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

    $.ajax({
        url: "get_id_edit_department",
        method: "get",
        data: {
            department_id: departmentId
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let department = response['department_name'];
            if (department.length > 0) {
                $("#idEditdepartmentname").val(department[0].name);
            }
            else {
                toastr.warning('No Record Found!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function EditDepartment() {
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

    $.ajax({
        url: "edit_department",
        method: "post",
        data: $('#editDepartmentForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnEditDepartmentIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditDepartment").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Updating Department Failed!');

                if (response['error']['department_name'] === undefined) {
                    $("#idEditdepartmentname").removeClass('is-invalid');
                    $("#idEditdepartmentname").attr('title', '');
                }
                else {
                    $("#idEditdepartmentname").addClass('is-invalid');
                    $("#idEditdepartmentname").attr('title', response['error']['department_name']);
                }
            }
            else {
                if (response['result'] == 1) {
                    $("#modalEditDepartment").modal('hide');
                    $("#editDepartmentForm")[0].reset();
                    dataTableDepartments.draw();
                    toastr.success('Department succesfully updated!');
                }
                else {
                    toastr.warning('Department already exists!');
                }
            }
            $("#btnEditDepartmentIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditDepartment").removeAttr('disabled');
            $("#btnEditDepartmentIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnEditDepartmentIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditDepartment").removeAttr('disabled');
            $("#btnEditDepartmentIcon").addClass('fa fa-check');
        }
    });
}

function GetDepartment(cboElement) {
    let result = '<option value="0" selected disabled> -- Select Department -- </option>';
    $.ajax({
        url: 'get_department',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function (response) {
            result = '';
            if (response['department'].length > 0) { // true
                result = '<option value="0" selected disabled> Select Department </option>';
                for (let index = 0; index < response['department'].length; index++) {
                    result += '<option value="' + response['department'][index].id + '">' + response['department'][index].name + '</option>';
                }
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function GetDepartments(cboElement) {
    let result = '<option value="0" selected disabled> -- Select Department -- </option>';
    $.ajax({
        url: 'get_department',
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function (response) {
            result = '';
            if (response['department'].length > 0) { // true
                result += '<option value="0" selected disabled> Select Department </option>';
                result += '<option value=""> All </option>';
                for (let index = 0; index < response['department'].length; index++) {
                    result += '<option value="' + response['department'][index].name + '">' + response['department'][index].name + '</option>';
                }
            }
            else {
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}