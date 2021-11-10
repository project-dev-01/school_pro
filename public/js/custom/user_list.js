$(function () {

    // save users
    $("#userAddForm").on("submit", function (e) {
        e.preventDefault();
        var form = this;
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                $(form).find('span.error-text').text('');
            },
            success: function (data) {

                console.log("data")
                console.log(data)
                if (data.code == 0) {
                    $.each(data.error, function (prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val[0]);
                    });
                } else {
                    // $(form)[0].reset();
                    toastr.success(data.msg);
                    setTimeout(function () {
                        window.location.href = userShow;
                    }, 2000);

                }
            }
        });
    });

    // delete form
    $(document).on('click', '#deleteUserBtn', function () {
        var id = $(this).data('id');
        var user_url = deleteUser;
        swal.fire({
            title: 'Are you sure?',
            html: 'You want to <b>delete</b> this user',
            showCancelButton: true,
            showCloseButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, Delete',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#556ee6',
            width: 400,
            allowOutsideClick: false
        }).then(function (result) {
            if (result.value) {
                $.post(user_url, {
                    id: id
                }, function (data) {
                    if (data.code == 1) {
                        $('#user-table').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }, 'json');
            }
        });
    });
    //GET ALL Users
    var table = $('#user-table').DataTable({
        processing: true,
        info: true,
        ajax: userList,
        "pageLength": 5,
        "aLengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        columns: [
            //  {data:'id', name:'id'},
            // {
            //     data: 'checkbox',
            //     name: 'checkbox',
            //     orderable: false,
            //     searchable: false
            // },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'role_name',
                name: 'role_name'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            },
        ]
    }).on('draw', function () {
    });
});
