function AddUser() {
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
        url: "add_user",
        method: "post",
        data: $('#addUserForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnAddUserIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddUser").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving user failed!');
                if (response['error']['name'] === undefined) {
                    $("#idname").removeClass('is-invalid');
                    $("#idname").attr('title', '');
                }
                else {
                    $("#idname").addClass('is-invalid');
                    $("#idname").attr('title', response['error']['name']);
                }
                if (response['error']['email'] === undefined) {
                    $("#idemail").removeClass('is-invalid');
                    $("#idemail").attr('title', '');
                }
                else {
                    $("#idemail").addClass('is-invalid');
                    $("#idemail").attr('title', response['error']['email']);
                }
                if (response['error']['username'] === undefined) {
                    $("#idusername").removeClass('is-invalid');
                    $("#idusername").attr('title', '');
                }
                else {
                    $("#idusername").addClass('is-invalid');
                    $("#idusername").attr('title', response['error']['username']);
                }
                if (response['error']['department'] === undefined) {
                    $("#selDepartmentId").removeClass('is-invalid');
                    $("#selDepartmentId").attr('title', '');
                }
                else {
                    $("#selDepartmentId").addClass('is-invalid');
                    $("#selDepartmentId").attr('title', response['error']['department']);
                }
                if (response['error']['userLevel'] === undefined) {
                    $("#selUserLevelId").removeClass('is-invalid');
                    $("#selUserLevelId").attr('title', '');
                }
                else {
                    $("#selUserLevelId").addClass('is-invalid');
                    $("#selUserLevelId").attr('title', response['error']['userLevel']);
                }
            }
            else if (response['result'] == 1) {
                $("#modalAddUser").modal('hide');
                $("#addUserForm")[0].reset();
                toastr.success('User added!');
                dataTableUsers.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 0) {
                toastr.error('User already exists!');
            }

            $("#btnAddUserIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddUser").removeAttr('disabled');
            $("#btnAddUserIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddUserIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddUser").removeAttr('disabled');
            $("#btnAddUserIcon").addClass('fa fa-check');
        }
    });
}

function DeactivateUser() {
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
        url: "deactivate_user",
        method: "post",
        data: $('#deactivateUserForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#deactivateIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateUser").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableUsers.draw();
                $("#modalDeactivateUser").modal('hide');
                $("#deactivateUserForm")[0].reset();
                toastr.success('User successfully deactivated!');
            }
            else {
                toastr.warning('User already deactivated!');
            }

            $("#deactivateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateUser").removeAttr('disabled');
            $("#deactivateIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#deactivateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeactivateUser").removeAttr('disabled');
            $("#deactivateIcon").addClass('fa fa-check');
        }
    });
}

function ActivateUser() {
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
        url: "activate_user",
        method: "post",
        data: $('#activateUserForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#activateIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnActivateUser").prop('disabled', 'disabled');
        },
        success: function (response) {
            let result = response['result'];
            if (result == 1) {
                dataTableUsers.draw();
                $("#modalActivateUser").modal('hide');
                $("#activateUserForm")[0].reset();
                toastr.success('User successfully activated!');
            }
            else {
                toastr.warning('User already deactivated!');
            }

            $("#activateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateUser").removeAttr('disabled');
            $("#activateIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#activateIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnActivateUser").removeAttr('disabled');
            $("#activateIcon").addClass('fa fa-check');
        }
    });
}

function GetUserId(userId) {
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
        url: "get_id_edit_user",
        method: "get",
        data: {
            user_id: userId
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            let userData = response['user_name'];
            if (userData.length > 0) {
                $("#idEditname").val(userData[0].name);
                $("#idEditusername").val(userData[0].username);
                $("#idEditemail").val(userData[0].email);
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

function EditUser() {
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
        url: "edit_user",
        method: "post",
        data: $('#editUserForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnEditUserIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditUser").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Updating User Failed!');

                if (response['error']['name'] === undefined) {
                    $("#idEditname").removeClass('is-invalid');
                    $("#idEditname").attr('title', '');
                }
                else {
                    $("#idEditname").addClass('is-invalid');
                    $("#idEditname").attr('title', response['error']['name']);
                }
                if (response['error']['username'] === undefined) {
                    $("#idEditusername").removeClass('is-invalid');
                    $("#idEditusername").attr('title', '');
                }
                else {
                    $("#idEditusername").addClass('is-invalid');
                    $("#idEditusername").attr('title', response['error']['username']);
                }
                if (response['error']['email'] === undefined) {
                    $("#idEditemail").removeClass('is-invalid');
                    $("#idEditemail").attr('title', '');
                }
                else {
                    $("#idEditemail").addClass('is-invalid');
                    $("#idEditemail").attr('title', response['error']['email']);
                }
                if (response['error']['department'] === undefined) {
                    $("#selDepartmentId").removeClass('is-invalid');
                    $("#selDepartmentId").attr('title', '');
                }
                else {
                    $("#selDepartmentId").addClass('is-invalid');
                    $("#selDepartmentId").attr('title', response['error']['department']);
                }
                if (response['error']['userLevel'] === undefined) {
                    $("#selUserLevelId").removeClass('is-invalid');
                    $("#selUserLevelId").attr('title', '');
                }
                else {
                    $("#selUserLevelId").addClass('is-invalid');
                    $("#selUserLevelId").attr('title', response['error']['userLevel']);
                }

            }
            else {
                if (response['result'] == 1) {
                    $("#modalEditUser").modal('hide');
                    $("#editUserForm")[0].reset();
                    dataTableUsers.draw();
                    toastr.success('User succesfully updated!');
                }
                else {
                    toastr.warning('User already exists!');
                }
            }
            $("#btnEditUserIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditUser").removeAttr('disabled');
            $("#btnEditUserIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnEditUserIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditUser").removeAttr('disabled');
            $("#btnEditUserIcon").addClass('fa fa-check');
        }
    });
}

function SignIn() {
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
        url: "sign_in",
        method: "post",
        data: $('#signInForm').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#btnSignInIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSignIn").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                if (response['error']['username'] === undefined) {
                    $("#idusername").removeClass('is-invalid');
                    $("#idusername").attr('title', '');
                }
                else {
                    $("#idusername").addClass('is-invalid');
                    $("#idusername").attr('title', response['error']['username']);
                    // toastr.error(response['error']['username']);
                }

                if (response['error']['password'] === undefined) {
                    $("#idpassword").removeClass('is-invalid');
                    $("#idpassword").attr('title', '');
                }
                else {
                    $("#idpassword").addClass('is-invalid');
                    $("#idpassword").attr('title', response['error']['password']);
                    // toastr.error(response['error']['password']);
                }
            }
            else {
                if (response['result'] == 0) {
                    toastr.error(response['error_message']);
                    $("#idusername").removeClass('is-invalid');
                    $("#idusername").attr('title', '');
                    $("#idpassword").removeClass('is-invalid');
                    $("#idpassword").attr('title', '');
                }
                // VIEWING ONLY LEADER
                else if (response['result'] == 1) {
                    window.location = "dashboard";
                }
                // SUB LEADER
                else if (response['result'] == 2) {
                    window.location = "dashboard";
                }
                // USER
                else if (response['result'] == 3) {
                    window.location = "user_dashboard";
                }
                else if (response['result'] == 4) {
                    toastr.error('User is not active!');
                }
            }
            $("#btnSignInIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSignIn").removeAttr('disabled');
            $("#btnSignInIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnSignInIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSignIn").removeAttr('disabled');
            $("#btnSignInIcon").addClass('fa fa-check');
        }
    });
}

function SignOut() {
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
        url: "sign_out",
        method: "post",
        data: $('#formSignOut').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#iBtnSignOutIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSignOut").prop('disabled', 'disabled');
        },
        success: function (response) {
            // $("#iBtnSignOutIcon").removeClass('fa fa-spinner fa-pulse');
            // $("#btnSignOut").removeAttr('disabled');
            // $("#iBtnSignOutIcon").addClass('fa fa-check');
            if (response['result'] == 1) {
                // console.log(response['result']);
                // alert('wait logout');
                window.location = "/paper_consumption";
            }
            else {
                toastr.error('Logout Failed!');
            }
        },
        error: function (data, xhr, status) {
            // toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnSignOutIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSignOut").removeAttr('disabled');
            $("#iBtnSignOutIcon").addClass('fa fa-check');
        }
    });
}