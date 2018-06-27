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
        this.company();
        this.wholesale();
        this.setting();
        this.customer();
    },
   /* student: function () {
        var main_unique_class = ".students_listing";
        var btn_counter = 0;
        function student_init(value, field, value2, field2, value3, field3) {
            btn_counter = 0;
            var stdinfo_url = '';
            // use fo where condition in json method in controller ssp->complex()
            if (field != "std_rollno")
                $("input[name='search_rollno']").val("");
            if (value == null)
            {
                stdinfo_url = mainurl + "student/json/";
                //console.log("non parameter " + stdinfo_url);
            } else if (value !== null && value2 !== null && value3 !== null)
            {
                stdinfo_url = mainurl + "student/json/" + value + "/" + field + "/" + value2 + "/" + field2 + "/" + value3 + "/" + field3;
                //console.log("with parameter" + stdinfo_url);
            } else if (value !== null && value2 !== null)
            {
                stdinfo_url = mainurl + "student/json/" + value + "/" + field + "/" + value2 + "/" + field2;
                //console.log("with parameter" + stdinfo_url);
            } else
            {
                stdinfo_url = mainurl + "student/json/" + value + "/" + field;
                //console.log("with parameter single " + stdinfo_url);
            }

            // console.log("with parameter" + stdinfo_url);
            $std_table = $(main_unique_class + ' #student_data').DataTable({
                'fnDrawCallback': function (oSettings) {
                    // console.log($('.dataTables_filter').length);
                    if (btn_counter == 0)
                    {
                        $('.dataTables_filter').each(function () {
                            $(this).append('&nbsp;<input type="text" title="Search By Rollno" class="form-control input-sm"  name="search_rollno" placeholder="Search By Rollno" />');
                        });
                        btn_counter = 1;
                    }
                },
                "ajax": stdinfo_url,
                "columns": [
                    {"data": "std_id"},
                    {"data": "std_profileurl"},
                    {"data": "std_rollno"},
                    {"data": "firstname"},
                    {"data": "middlename"},
                    {"data": "lastname"},
                    {"data": "faculty"},
                    {"data": "standard"}
                ],
                "columnDefs": [
                    {
                        "render": function (data, type, row) {
                            return '<input type="checkbox" class="std_select" name="std[]" value="' + row['std_id'] + '"/>';
                        },
                        "orderable": false,
                        "targets": 0
                    },
                    {
                        "render": function (data, type, row) {
                            var img = '';
                            if (row["std_profileurl"])
                            {
                                img = '<img src="' + mainurl + 'assets/std_data/' + row["std_profileurl"] + '" style="width:32px;height: 32px;"/>';
                            } else
                            {
                                img = '<img src="' + mainurl + 'assets/std_data/no-image.png" style="width:32px;height: 32px;"/>';
                            }
                            return img;
                        },
                        "orderable": false,
                        "targets": 1
                    },
                    {
                        "render": function (data, type, row) {

                            return '<a href="" class="table-action-btn edit" title="Edit" data-source="' + row['std_id'] + '"><i class="md md-edit"></i></a>' +
                                    '<a href="" class="table-action-btn send-msg" title="Message" data-source="' + row['std_id'] + '"><i class="md md-messenger"></i></a>' +
                                    '<a href="" class="table-action-btn view" title="Information" data-source="' + row['std_id'] + '"><i class="md md-remove-red-eye"></i></a>' +
                                    '<a href="" class="table-action-btn remove" title="Delete" data-source="' + row['std_id'] + '"><i class="md md-close"></i></a>';
                        },
                        "orderable": false,
                        "targets": 8,
                    }
                ],
                "oLanguage": {
                    "sSearch": "Search :"
                },
                "pageLength": 30,
                "order": [[2, 'asc']]


            });
        }



        $(document).on('change', '#from_month', function () {
            event.preventDefault();
            var value = $(this).val();
            var stud_id = $("#stud_id").val();
            var redirect_url = mainurl + 'student/progress_report/' + stud_id + "/" + value;
            window.location = redirect_url;
        });
        if ($(main_unique_class + ' #student_data').length > 0) {


            student_init(null, null, null, null, null, null);
            //For select
            $(main_unique_class + ' #student_data tbody').on('click', '.std_select', function () {
                $(this).parents("tr").toggleClass('selected');
            });
            //Action
            $(main_unique_class).on('click', '.std_select_action', function () {
                var sele_val = $(this).val();
                var redirect_url = mainurl + 'student/sendmsg/';
                var std_data = [];
                $('input[name="std[]"]:checked').each(function () {
                    std_data.push(this.value);
                });
                swal({
                    title: 'Send Message',
                    html: '<div class="">' + $html_guj_tag + '</div> <br> <div class="">' + $html_dropdown + '</div> <br> <div class="add_gujarati_text language_scroll" style="font-size:13px;text-align:left">' + $html_data + '</div>',
                    showCancelButton: true,
                    confirmButtonText: 'Send',
                    showLoaderOnConfirm: true,
                    preConfirm: function (message) {
                        return new Promise(function (resolve) {

                            var detect_lang = $("#general_description").val();
                            if (detect_lang == "english")
                            {
                                message = $('#chilg_lang_message').val();
                            } else
                                message = $('#lang_message').val();
                            var data = {
                                "source": std_data,
                                "group": 1,
                                "message": message
                            };
                            $.ajax({
                                type: "POST",
                                url: redirect_url,
                                data: data,
                                success: function () {
                                    $(".std_select_action").val($(".std_select_action option:first").val());
                                    $('input[name="std[]"]:checked').removeAttr('checked');
                                    swal({
                                        type: 'success',
                                        title: 'Message sent.'
                                    });
                                    $(main_unique_class + " #clear_reset").trigger("click");
                                }
                            });
                        })
                    },
                    allowOutsideClick: false
                }).catch(swal.noop);
            });
            $(main_unique_class).on('change', '#filter_standard', function () {
                $('#student_data').dataTable().fnDestroy();
                var value = $(this).val();
                var val_faculty = $('#filter_faculty').val();
                var val_year = $('#filter_year').val();
                if (val_faculty !== 'null' && value !== 'null' && val_year !== 'null')
                {
                    student_init(value, "std_standard", val_faculty, "std_faculty", val_year, "std_create_dt");
                } else if (val_faculty !== 'null' && value !== 'null') {
                    student_init(value, "std_standard", val_faculty, "std_faculty", null, null);
                } else if (value !== 'null' && val_year !== 'null') {
                    student_init(val_year, "std_create_dt", value, "std_standard", null, null);
                } else if (value !== 'null')
                {
                    student_init(value, "std_standard", null, null, null, null);
                } else
                {
                    student_init(null, null, null, null, null, null);
                    $("#filter_faculty").val($("option:first").val());
                }

            });
            $(main_unique_class).on('change', '#filter_faculty', function () {
                $('#student_data').dataTable().fnDestroy();
                var value = $(this).val();
                var val_standard = $('#filter_standard').val();
                var val_year = $('#filter_year').val();
                if (val_standard !== 'null' && value !== 'null' && val_year !== 'null')
                {
                    student_init(value, "std_faculty", val_standard, "std_standard", val_year, "std_create_dt");
                } else if (val_standard !== 'null' && value !== 'null')
                {
                    student_init(value, "std_faculty", val_standard, "std_standard", null, null);
                } else if (value !== 'null' && val_year !== 'null') {
                    student_init(val_year, "std_create_dt", value, "std_faculty", null, null);
                } else if (value !== 'null')
                {
                    student_init(value, "std_faculty", null, null, null, null);
                } else
                {
                    student_init(null, null, null, null, null, null);
                    $("#filter_standard").val($("option:first").val());
                }
            });

            $(document).on('change', '#filter_year', function () {
                $('#student_data').dataTable().fnDestroy();
                var value = $(this).val();
                var val_standard = $('#filter_standard').val();
                var val_faculty = $('#filter_faculty').val();
                if (val_standard !== 'null' && value !== 'null' && val_faculty !== 'null')
                {
                    student_init(val_faculty, "std_faculty", val_standard, "std_standard", value, "std_create_dt");
                } else if (val_standard !== 'null' && value !== 'null')
                {
                    student_init(value, "std_create_dt", val_standard, "std_standard", null, null);
                } else if (value !== 'null' && val_faculty !== 'null') {
                    student_init(value, "std_create_dt", val_faculty, "std_faculty", null, null);
                } else if (value !== 'null')
                {
                    student_init(value, "std_create_dt", null, null, null, null);
                } else
                {
                    student_init(null, null, null, null, null, null);
                    $("#filter_year").val($("option:first").val());
                }
            });
            //

            $(main_unique_class).on('blur', 'input[name=search_rollno]', function () {
                $('#student_data').dataTable().fnDestroy();
                var value = $(this).val();
                // console.log(value);
                if (!$(this).val())
                {
                    student_init(null, null, null, null, null, null);
                } else
                {
                    student_init(value, "std_rollno", null, null, null, null);
                    // $("#filter_standard").val($("option:first").val());
                }
            });

            //For Edit
            $(main_unique_class + ' #student_data tbody').on('click', '.edit', function (event) {
                event.preventDefault();
                var source = $(this).data("source");
                var redirect_url = mainurl + 'student/edit/' + source;
                window.location = redirect_url;
            });
            //For msg
            $(main_unique_class + ' #student_data tbody').on('click', '.send-msg', function (event) {
                event.preventDefault();
                var source = $(this).data("source");
                var redirect_url = mainurl + 'student/sendmsg/';
                swal({
                    title: 'Send Message',
                    html: '<div class="">' + $html_guj_tag + '</div> <br> <div class="">' + $html_dropdown + '</div> <br> <div class="add_gujarati_text language_scroll" style="font-size:13px;text-align:left">' + $html_data + '</div>',
                    showCancelButton: true,
                    confirmButtonText: 'Send',
                    showLoaderOnConfirm: true,
                    preConfirm: function (message) {
                        return new Promise(function (resolve) {
                            var detect_lang = $("#general_description").val();
                            if (detect_lang == "english")
                            {
                                message = $('#chilg_lang_message').val();
                            } else
                                message = $('#lang_message').val();
                            var data = {
                                "source": source,
                                "message": message
                            };
                            $.ajax({
                                type: "POST",
                                url: redirect_url,
                                data: data,
                                success: function () {
                                    swal({
                                        type: 'success',
                                        title: 'Message sent.'
                                    });
                                    $(main_unique_class + " #clear_reset").trigger("click");
                                }
                            });
                        })
                    },
                    allowOutsideClick: false,
                }).catch(swal.noop);
            });
            //For view
            $(main_unique_class + ' #student_data tbody').on('click', '.view', function (event) {
                event.preventDefault();
                var source = $(this).data("source");
                var redirect_url = mainurl + 'student/view/' + source;
                window.location = redirect_url;
            });
            //For remove
            $(main_unique_class).on('click', '.remove', function (event) {
                event.preventDefault();
                var group = 0;
                if ($(this).val() == 1)
                {
                    var std_data = [];
                    $('input[name="std[]"]:checked').each(function () {
                        console.log((this.value));
                        std_data.push(this.value);
                    });
                    group = 1;
                } else
                {
                    var std_data = $(this).data("source");
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


                    var redirect_url = mainurl + 'student/remove/';
                    var data = {
                        "code": std_data,
                        "group": group
                    };
                    $.ajax({
                        type: "POST",
                        url: redirect_url,
                        data: data,
                        success: function () {
                            $(".std_select_action").attr("disabled", "disabled");
                            $("button.remove").attr("disabled", "disabled");
                            $std_table.ajax.reload();
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
            // reset filters
            $(main_unique_class).on('click', '#clear_reset', function () {
                $('#filter_faculty').prop('selectedIndex', 0);
                $('#filter_standard').prop('selectedIndex', 0);
                $('#filter_year').prop('selectedIndex', 0);
                $('#select_all_chk_box').attr('checked', false);
                $("input[name='std[]']").prop('checked', false);
                $("input[name='search_rollno']").val("");
                $(".std_select_action").attr("disabled", "disabled");
                $("button.remove").attr("disabled", "disabled");
                $('#student_data').dataTable().fnDestroy();
                student_init(null, null, null, null, null, null);
            });
        }
    },*/
    company: function () {
        var main_unique_class = ".company_listing";
        var controller = "company";
        if ($('#company_table_data').length > 0) {
            var ajax_url = mainurl + controller + "/json/";
            $company_table = $('#company_table_data').DataTable({
                "ajax": ajax_url,
                "columns": [
                    {"data": "company_uuid"},
                    {"data": "company_name"},
                   /* {"data": "company_branch_name"},
                    {"data": "company_name_entity"},*/
                    {"data": "company_pan"},
                   // {"data": "company_state"},
                    {"data": "company_mobile"},
                    {"data": "company_registrationdt"},
                    {"data": "company_city"}
                ],
                "columnDefs": [
                    {
                        "render": function (data, type, row) {
                            var checkbox = '<div class="checkbox"><input id="checkbox-' + row['company_uuid'] + '" type="checkbox" class="std_select" name="std[]" value="' + row['company_uuid'] + '"/><label for="checkbox-' + row['company_uuid'] + '"></label></div>';
                            return checkbox;
                        },
                        "orderable": false,
                        "targets": 0
                    },         
                    {
                        "render": function (data, type, row) {

                            var html = '<a href="" class="table-action-btn edit" title="Edit" data-source="' + row['company_uuid'] + '"><i class="md md-edit"></i></a>'  +
                                    '<a href="" class="table-action-btn view" title="View" data-source="' + row['company_uuid'] + '"><i class="md md-remove-red-eye"></i></a>' +
                                    '<a href="" class="table-action-btn remove" title="Delete" data-source="' + row['company_uuid'] + '"><i class="md md-close"></i></a>';
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
            $(main_unique_class + ' #company_table_data tbody').on('click', '.view', function (event) {
                event.preventDefault();
                var source = $(this).data("source");
                var redirect_url = mainurl + controller + '/view/' + source;
                window.location = redirect_url;
            });
            //For Edit
            $(main_unique_class + ' #company_table_data tbody').on('click', '.edit', function (event) {
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
    wholesale: function () {
        var main_unique_class = ".wholesale_listing";
        var controller = "wholesale";
        $data_table_id="wholesale_table_data";
        if ($('#'+$data_table_id).length > 0) {
            var ajax_url = mainurl + controller + "/json/";
            $wholesale_table = $('#'+$data_table_id).DataTable({
                "ajax": ajax_url,
                "columns": [
                   /* {"data": "wholesale_uuid"},
                    {"data": "wholesale_invoice_number"},
                    {"data": "wholesale_generatedt"},
                    {"data": "company_name"},
                    {"data": "wholesale_name"},*/
                ],
                "columnDefs": [
                    {
                        "render": function (data, type, row) {
                            var checkbox = '<div class="checkbox"><input id="checkbox-' + row[0] + '" type="checkbox" class="std_select" name="std[]" value="' + row[0] + '"/><label for="checkbox-' + row[0] + '"></label></div>';
                            return checkbox;
                        },
                        "orderable": false,
                        "targets": 0
                    },       
                    {
                        "render": function (data, type, row) {

                            var html = '<a href="" class="table-action-btn edit" title="Edit" data-source="' + row[0] + '"><i class="md md-edit"></i></a>'  +
                                    '<a href="" class="table-action-btn view" title="View" data-source="' + row[0] + '"><i class="md md-remove-red-eye"></i></a>' +
                                    '<a href="" class="table-action-btn remove" title="Delete" data-source="' + row[0] + '"><i class="md md-close"></i></a>';
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
                            $wholesale_table.ajax.reload();
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
        var controller = "setting";
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
    },
    customer: function () {
        var main_unique_class = ".customer_listing";
        var controller = "customer";
        $data_table_id="customer_table_data";
        if ($('#'+$data_table_id).length > 0) {
            var ajax_url = mainurl + controller + "/json/";
            $customer_table = $('#'+$data_table_id).DataTable({
                "ajax": ajax_url,
                "columns": [
                    {"data": "customer_uuid"},
                    {"data": "customer_profileurl"},
                    {"data": "customer_firstname"},
                    {"data": "customer_email"},
                    {"data": "customer_gstin_number"}
                ],
                "columnDefs": [
                    {
                        "render": function (data, type, row) {

                           var checkbox = '<div class="checkbox"><input id="checkbox-' + row['customer_uuid'] + '" type="checkbox" class="std_select" name="std[]" value="' + row['customer_uuid'] + '"/><label for="checkbox-' + row['customer_uuid'] + '"></label></div>';
                            return checkbox;
                        },
                        "orderable": false,
                        "targets": 0
                    },   
                    {
                        "render": function (data, type, row) {
                            var img = '';
                            if (row["customer_profileurl"])
                            {
                                img = '<img src="' + mainurl + 'assets/customer_data/' + row["customer_profileurl"] + '" style="width:32px;height: 32px;"/>';
                            } else
                            {
                                img = '<img src="' + mainurl + 'assets/images/no-image.png" style="width:32px;height: 32px;"/>';
                            }
                            return img;
                        },
                        "orderable": false,
                        "targets": 1
                    }, 
                    
                    {
                        "render": function (data, type, row) {

                            var html = '<a href="" class="table-action-btn edit" title="Edit" data-source="' + row['customer_uuid'] + '"><i class="md md-edit"></i></a>'  +
                                    '<a href="" class="table-action-btn view" title="View" data-source="' + row['customer_uuid'] + '"><i class="md md-remove-red-eye"></i></a>' +
                                    '<a href="" class="table-action-btn remove" title="Delete" data-source="' + row['customer_uuid'] + '"><i class="md md-close"></i></a>';
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
                            $customer_table.ajax.reload();
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