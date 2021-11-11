$(function () {

    // update profile details
    $('#updateProfileInfo').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0]);
                    });
                } else {
                    $('.user_name').each(function () {
                        $(this).html($('#updateProfileInfo').find($('input[name="name"]')).val());
                    });
                    toastr.success(data.msg);
                    // alert(data.msg);
                }
            }
        });
    });

    // change password

    $('#changeNewPassword').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0]);
                    });
                } else {
                    $('#changeNewPassword')[0].reset();
                    toastr.success(data.msg);
                }
            }
        });
    });

    // change profile image
    $(document).on('click', '#change_picture_btn', function () {
        $('#admin_image').click();
    });

    $('#admin_image').ijaboCropTool({
        preview : '.admin_picture',
        setRatio:1,
        allowedExtensions: ['jpg', 'jpeg','png'],
        buttonsText:['CROP','QUIT'],
        buttonsColor:['#30bf7d','#ee5155', -15],
        processUrl: pictureUpdateUrl,
        // withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){
           toastr.success(message);
        },
        onError:function(message, element, status){
          toastr.danger(message);
        }
     });

});
