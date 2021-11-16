$(function () {

    $('#sectionForm').on('submit', function(e){
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
                      $('#section-table').DataTable().ajax.reload(null, false);
                      $('.addSection').modal('hide');
                      $('.addSection').find('form')[0].reset();
                      toastr.success(data.msg);
                  }
            }
        });
    });

    // get all sections
    var table = $('#section-table').DataTable({
        processing: true,
        info: true,
        ajax: sectionList,
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
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            },
        ]
    }).on('draw', function () {
    });

    // edit section

    $(document).on('click','#editSectionBtn', function(){
        var section_id = $(this).data('id');
        // alert(section_id)
        $('.editSection').find('form')[0].reset();
        $('.editSection').find('span.error-text').text('');
        $.post(sectionDetails,{section_id:section_id}, function(data){
            $('.editSection').find('input[name="sid"]').val(data.details.id);
            $('.editSection').find('input[name="name"]').val(data.details.name);
            $('.editSection').modal('show');
        },'json');
    });

    // update section
    $('#sectionEditForm').on('submit', function(e){
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
                      $('#section-table').DataTable().ajax.reload(null, false);
                      $('.editSection').modal('hide');
                      $('.editSection').find('form')[0].reset();
                      toastr.success(data.msg);
                  }
            }
        });
    });

    // delete section
    $(document).on('click','#deleteSectionBtn', function(){
        var section_id = $(this).data('id');
        swal.fire({
             title:'Are you sure?',
             html:'You want to <b>delete</b> this section',
             showCancelButton:true,
             showCloseButton:true,
             cancelButtonText:'Cancel',
             confirmButtonText:'Yes, Delete',
             cancelButtonColor:'#d33',
             confirmButtonColor:'#556ee6',
             width:400,
             allowOutsideClick:false
        }).then(function(result){
              if(result.value){
                  $.post(sectionDelete,{section_id:section_id}, function(data){
                       if(data.code == 1){
                           $('#section-table').DataTable().ajax.reload(null, false);
                           toastr.success(data.msg);
                       }else{
                           toastr.error(data.msg);
                       }
                  },'json');
              }
        });
    });

});
