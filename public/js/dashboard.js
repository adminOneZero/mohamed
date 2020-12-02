$(document).ready(function() {
    $('.seeStatus').on('click', function(event) {
        // event.preventDefault();
        var id = $(this).attr('data-noti_id');
        console.log(id);
        $(this).removeClass('active');
        // if ($('#notiAlert').html() == 1) {

        //     $('#notiAlert').remove();
        // }
        $.ajax({
            type: "post",
            url: "/dashboard/notify/deactive",
            data: {
                'id': id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                var num = $('#notiAlert').html();
                num = num - 1;
                $('#notiAlert').html(num);
                // remove notify alert is = 0
                if (response == 0) {
                    $('#notiAlert').remove();
                }
                // flash(response['message'], response['status']);
            },
            error: function(jqXHR, exception) {
                if (jqXHR.status === 500) {
                    flash('حاول مجددا', 'warning');

                }
            }
        });
    });
});