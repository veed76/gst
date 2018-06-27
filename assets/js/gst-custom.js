var mainurl = "";
switch (location.hostname) {
    case "mshinetechnologies.com":
        mainurl = 'http://mshinetechnologies.com/gstbill/';
        break;
    case "localhost":
        mainurl = 'http://localhost/gst/';
        break;
}

var Webetech = {

    init: function () {
        this.user();
    },
    user: function () {
        var main_unique_class = ".user_listing";
        var controller = "gst-admin/user";
        $data_table_id="user_table_data";
        if ($('#'+$data_table_id).length > 0) {
            var ajax_url = mainurl + controller + "/json/";
            $user_table = $('#'+$data_table_id).DataTable({
                "ajax": ajax_url,
                "columns": [
                    {"data": "user_uuid"},
                    {"data": "user_profileurl"},
                    {"data": "user_firstname"},
                    {"data": "user_email"},
                    {"data": "user_status"},
                    {"data": "user_createdt"}
                ],
                "columnDefs": [
                    {
                        "render": function (data, type, row) {

                           var checkbox = '<div class="checkbox"><input id="checkbox-' + row['user_uuid'] + '" type="checkbox" class="std_select" name="std[]" value="' + row['user_uuid'] + '"/><label for="checkbox-' + row['user_uuid'] + '"></label></div>';
                            return checkbox;
                        },
                        "orderable": false,
                        "targets": 0
                    },   
                    {
                        "render": function (data, type, row) {
                            var img = '';
                            if (row["user_profileurl"])
                            {
                                img = '<img src="' + mainurl + 'assets/user_data/' + row["user_profileurl"] + '" style="width:32px;height: 32px;"/>';
                            } else
                            {
                                img = '<img src="' + mainurl + 'assets/user_data/no-image.png" style="width:32px;height: 32px;"/>';
                            }
                            return img;
                        },
                        "orderable": false,
                        "targets": 1
                    }, 
                    {
                        "render": function (data, type, row) {
                            var status = row['user_status'];
                                if(status == 1)
                                    status = '<span class="label label-table label-success">Active</span>';
                                else if(status == 2)
                                    status = '<span class="label label-table label-danger">Expired</span>';
                                else if(status == 3)
                                    status = '<span class="label label-table label-inverse">Disabled</span>';
                                else 
                                    status = '<span class="label label-table label-success">Admin</span>'
                            return status;
                        },
                        "orderable": false,
                        "targets": 4
                    },     
                    {
                        "render": function (data, type, row) {

                            var html = '<a href="" class="table-action-btn edit" title="Edit" data-source="' + row['user_uuid'] + '"><i class="md md-edit"></i></a>'  +
                                    '<a href="" class="table-action-btn view" title="View" data-source="' + row['user_uuid'] + '"><i class="md md-remove-red-eye"></i></a>' +
                                    '<a href="" class="table-action-btn remove" title="Delete" data-source="' + row['user_uuid'] + '"><i class="md md-close"></i></a>';
                            return html;
                        },
                        "orderable": false,
                        "targets": 5
                    }

                ],
                "pageLength": 30,
                "orderable": false,
                "bSort": false,
            });
            //For view
            $(main_unique_class + ' #'+$data_table_id+' tbody').on('click', '.view', function (event) {
                event.preventDefault();
                var source = $(this).data("source");
                var redirect_url = mainurl + controller + '/view/' + source;
                window.location = redirect_url;
            });
            //For Edit
            $(main_unique_class + ' #'+$data_table_id+' tbody').on('click', '.edit', function (event) {
                event.preventDefault();
                var source = $(this).data("source");
                var redirect_url = mainurl + controller+'/edit/' + source;
                window.location = redirect_url;
            });
            // for remove
            $(main_unique_class).on('click', '.remove', function (event) {
                event.preventDefault();
                var group = 0;
                if ($(this).val() == 1)
                {
                    var rmv_data = [];
                    $('input[name="std[]"]:checked').each(function () {
                        //console.log((this.value));
                        rmv_data.push(this.value);
                    });
                    group = 1;
                } else
                {
                    var rmv_data = $(this).data("source");
                    group = 0;
                }


                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function () {


                    var redirect_url = mainurl + controller + '/remove/';
                    var data = {
                        "code": rmv_data,
                        "group": group
                    };
                    $.ajax({
                        type: "POST",
                        url: redirect_url,
                        data: data,
                        success: function () {
                            //$(".std_select_action").attr("disabled", "disabled");
                            $("button.remove").attr("disabled", "disabled");
                            $company_table.ajax.reload();
                            swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                        }
                    });
                })
            });
            // global select checkbox
            $(main_unique_class).on("click", "#select_all_chk_box", function () {
                if ($(this).prop('checked') == true) {
                    $("input[name='std[]']").prop('checked', true);
                    $(".std_select_action").removeAttr("disabled");
                    $("button.remove").removeAttr("disabled");
                } else {
                    $("input[name='std[]']").prop('checked', false);
                    $(".std_select_action").attr("disabled", "disabled");
                    $("button.remove").attr("disabled", "disabled");
                }
            });
            // individual select checkbox
            $(main_unique_class).on("click", ".std_select", function () {
                if ($(this).prop('checked') == true) {
                    $(this).prop('checked', true);
                    $(".std_select_action").removeAttr("disabled");
                    $("button.remove").removeAttr("disabled");
                } else {
                    $("#select_all_chk_box").prop('checked', false);
                }
                var a = $("input[name='std[]'].std_select");
                if (a.length == a.filter(":checked").length) {
                    $("#select_all_chk_box").prop('checked', true);
                }
                if (a.filter(":checked").length <= 0)
                {
                    $(".std_select_action").attr("disabled", "disabled");
                    $("button.remove").attr("disabled", "disabled");
                }

            });
        }
    },
    setting: function(){
        var main_unique_class=".dealer_tag_listing";
        var controller = "gst-admin/setting";
        $(main_unique_class).on('click', '.remove', function (event) {
            event.preventDefault();
            var group = 0;
            if ($(this).val() == 1)
            {
                var rmv_data = [];
                var firstElement = [];
                $('input[name="std[]"]:checked').each(function () {

                    rmv_data.push(this.value);
                    firstElement.push($(this).parent().parent());
                    //console.log((this.value));
                });
                group = 1;
            } else
            {
                var rmv_data = $(this).data("source");
                group = 0;
                var firstElement = $(this).parent().parent();
            }

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {

                var redirect_url = mainurl + controller + '/remove/';
                var data = {
                    "code": rmv_data,
                    "group": group
                };
                $.ajax({
                    type: "POST",
                    url: redirect_url,
                    data: data,
                    success: function () {
                        $(firstElement).remove();
                        swal(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                        //$('#datatable-exam-result').dataTable().fnDestroy();
                    }
                });
            })
        });
    } 
};
$(document).ready(function () {
    
    Webetech.init();
    $(".wholesale_common").on("blur", ".weight-calculate", function () {
        var rate_id = $(this).data("source");
        var value = parseFloat($(this).val());
        value=Math.abs(value);
        if($.isNumeric(value) )
        {
            var base = $("#company-idd").data("source");
            base = parseFloat(base);
            var gram = 10;
            var ek_tola  = base / 10;
            
            value = value * ek_tola;
            $("#"+rate_id).val(value);
        }else
        {
            $(this).val("");
            $("#"+rate_id).val("");
        }
        console.log($(this).val());
        /*if(!$(this).val()) {
            $(this).val("");
            $("#"+rate_id).val("");
        }*/
    });

     $(".view_wholesale_bill").on("click", ".pdf_print", function () {
            var pdf_input = $(this).data("source");
            $("#pdf_input").val(pdf_input);
            $("#pdf_wholesale_form").submit();
     });
});

function validateForm() {
    var conf_val = $("input[name=confirm]").val();
    var new_val = $("input[name=new]").val();
    var old = $("input[name=old]").val();
    if (new_val != conf_val) {
        $("#msg_err").html('<div class="alert alert-danger alert-dismissible" role="alert"> New and Confirm Password Are Not Same...! </div>');
        return false;
    }

}
