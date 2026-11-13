function AddDeduction()
{
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
        url: "add_deduction",
        method: "post",
        data: $('#addDeductionForm').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#btnAddDeductionIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddDeduction").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Saving failed!');
                if(response['error']['deduction'] === undefined){
                    $("#iddeduction").removeClass('is-invalid');
                    $("#iddeduction").attr('title', '');
                }
                else{
                    $("#iddeduction").addClass('is-invalid');
                    $("#iddeduction").attr('title', response['error']['deduction']);
                }
                if(response['error']['year'] === undefined){
                    $("#idyear").removeClass('is-invalid');
                    $("#idyear").attr('title', '');
                }
                else{
                    $("#idyear").addClass('is-invalid');
                    $("#idyear").attr('title', response['error']['year']);
                }
            }
            else if(response['result'] == 1){
                $("#modalAddDeduction").modal('hide');
                $("#addDeductionForm")[0].reset();
                toastr.success('Deduction added!');
                dataTableDeductions.draw(); // reload the tables after insertion
            }
            else if(response['result'] == 0)
            {
                toastr.warning('Deduction for the year already exists!');
            }

            $("#btnAddDeductionIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddDeduction").removeAttr('disabled');
            $("#btnAddDeductionIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnAddDeductionIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddDeduction").removeAttr('disabled');
            $("#btnAddDeductionIcon").addClass('fa fa-check');
        }
    });
}

function GetDeductionId(deductionId)
{
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
        url: "get_id_deduction",
        method: "get",
        data: {
            deduction_id: deductionId
        },
        dataType: "json",
        beforeSend: function(){
            
        },
        success: function(response){
            let deductionEdited = response['d_value'];

            if(deductionEdited.length > 0){
                $("#idEditdeduction").val(deductionEdited[0].deduction);
            }
            else{
                toastr.warning('No Record Found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function EditDeduction()
{
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
        url: "edit_deduction",
        method: "post",
        data: $('#editDeductionForm').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#btnEditDeductionIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditDeduction").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError')
            {
                toastr.error('Updating Deduction Failed!');

                if(response['error']['deduction'] === undefined)
                {
                    $("#idEditdeduction").removeClass('is-invalid');
                    $("#idEditdeduction").attr('title', '');
                }
                else
                {
                    $("#idEditdeduction").addClass('is-invalid');
                    $("#idEditdeduction").attr('title', response['error']['deduction']);
                }
            }
            else
            {
                if(response['result'] == 1)
                {
                    $("#modalEditDeduction").modal('hide');
                    $("#editDeductionForm")[0].reset();
                    dataTableDeductions.draw();
                    toastr.success('Deduction succesfully updated!');
                }
                else 
                {
                    toastr.warning('Deduction already exists!');
                }
            }
            $("#btnEditDeductionIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditDeduction").removeAttr('disabled');
            $("#btnEditDeductionIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnEditDeductionIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditDeduction").removeAttr('disabled');
            $("#btnEditDeductionIcon").addClass('fa fa-check');
        }
    });
}