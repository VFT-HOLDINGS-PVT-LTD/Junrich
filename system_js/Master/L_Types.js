
//Clear Text Boxes
$("#Cancel").click(function () {

    $("#txt_L_Name").val("");
    $("#txt_L_Entitle").val("");


});


//Insert Data
$("#frm_leave_type").submit(function (e) {

//Prevent Default Submit form Data
    e.preventDefault();
    $("#divmessage").hide();

    var jqXHR = $.ajax({
        type: "POST",
        url: baseurl + "Master/Leave_Types/insert_Data",
        data: $("#frm_leave_type").serialize(),
        success: function (data) {

            var data1 = JSON.parse(data);


            if (data1[0].a > 0)
            {
                $("#spnmessage").html(' <b>  New Leave Types added successfully.</b>');
                $("#divmessage").attr("class", "alert alert-dismissable alert-success");
                $("#divmessage").show();
                $("#divmessage").effect("shake", {times: 3}, 1000);
                $("#txt_L_Name").val("");
                $("#txt_L_Entitle").val("");

            } else {
                $("#spnmessage").html('<p><h5> <b>Error.</b></h5></p>');
                $("#divmessage").attr("class", "alert alert-danger");
                $("#divmessage").show();
                $("#divmessage").effect("shake", {times: 3}, 1000);
                $("#txtDesig_Code").val(data1[0].b);
            }
        }
    });

});



//Get Designation Data
$(".get_data").click(function () {

    var id = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + "index.php/Master/Leave_Types/get_details",
        data: {'id': id},
        dataType: "JSON",
        success: function (response) {
                    alert(response[0].IsActive);
            
                $('#id').val(response[0].id);
                $('#L_Name').val(response[0].leave_name);
                $('#L_Ent').val(response[0].leave_entitle);
                $('#L_BF').val(response[0].leave_BF);
                $('#is_active').val(response[0].IsActive);
                $('#is_active').prop("checked",true);
            
        }
    });
});



function delete_id(id)
{
    swal({title: "Are you sure?", text: "You will not be able to recover this data!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, Delete This!", cancelButtonText: "No, Cancel This!", closeOnConfirm: false, closeOnCancel: false},
            function (isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url: baseurl + "index.php/Master/Holiday_Types/ajax_delete/" + id,
                        type: "POST",
                        dataType: "JSON",
                        success: function (data)
                        {

                            //if success reload ajax table
                            $('#modal_form').modal('hide');
                            reload_table();
                        }

                    });


                    swal("Deleted!", "Selected data has been deleted.", "success");


                    $(document).ready(function () {
                        setTimeout(function () {
                            window.location.replace(baseurl + "Master/Holiday_Types/");
                        }, 1000);
                    });


                } else {
                    swal("Cancelled", "Selected data Cancelled", "error");

                }

            });

}


