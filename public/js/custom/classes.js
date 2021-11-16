$(function () {

    $('#classesForm').on('submit', function(e){
        e.preventDefault();
        var form = this;
        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:new FormData(form),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend: function(){
                 $(form).find('span.error-text').text('');
            },
            success: function(data){
                  if(data.code == 0){
                      $.each(data.error, function(prefix, val){
                          $(form).find('span.'+prefix+'_error').text(val[0]);
                      });
                  }else{
                      $('#class-table').DataTable().ajax.reload(null, false);
                      $('.addClassModal').modal('hide');
                      $('.addClassModal').find('form')[0].reset();
                      toastr.success(data.msg);
                  }
            }
        });
    });

    // edit class

    $(document).on('click','#editClassBtn', function(){
        var class_id = $(this).data('id');
        // alert(class_id)
        $('.editClassModal').find('form')[0].reset();
        $('.editClassModal').find('span.error-text').text('');
        $.post(classDetails,{class_id:class_id}, function(data){
            $('.editClassModal').find('input[name="class_id"]').val(data.details.id);
            $('.editClassModal').find('input[name="name"]').val(data.details.name);
            $('.editClassModal').find('input[name="name_numeric"]').val(data.details.name_numeric);
            $('.editClassModal').modal('show');
        },'json');
    });

    // update class
    $('#classesUpdateForm').on('submit', function(e){
        e.preventDefault();
        var form = this;
        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:new FormData(form),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend: function(){
                 $(form).find('span.error-text').text('');
            },
            success: function(data){
                  if(data.code == 0){
                      $.each(data.error, function(prefix, val){
                          $(form).find('span.'+prefix+'_error').text(val[0]);
                      });
                  }else{
                      $('#class-table').DataTable().ajax.reload(null, false);
                      $('.editClassModal').modal('hide');
                      $('.editClassModal').find('form')[0].reset();
                      toastr.success(data.msg);
                  }
            }
        });
    });
    // delete form
    $(document).on('click', '#deleteClassBtn', function () {
        var class_id = $(this).data('id');
        var url = deleteClasses;
        swal.fire({
            title: 'Are you sure?',
            html: 'You want to <b>delete</b> this class',
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
                $.post(url, {
                    class_id: class_id
                }, function (data) {
                    if (data.code == 1) {
                        $('#class-table').DataTable().ajax.reload(null, false);
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }, 'json');
            }
        });
    });

    //GET ALL CLASSES
    var table = $('#class-table').DataTable({
        processing: true,
        info: true,
        ajax: classList,
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
                data: 'name_numeric',
                name: 'name_numeric'
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