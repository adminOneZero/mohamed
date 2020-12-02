$(document).ready(function() {
    /******************************[load user information]*************************************/
    // ini model
    $("#modal").iziModal();


    // $(document).on('click', '.trigger', function(event) {
    //     event.preventDefault();
    //     // get user id
    //     var id = $(this).attr('data-id');
    //     // get user information by id
    //     $.getJSON("/dashboard/users/info/" + id, function(result) {

    //         $('#modal .info').html(`
    //             <fieldset>
    //                 <legend>Informations:</legend>
    //                     <p><span>name : </span><span>` + result['name'] + `</span></p>
    //                     <p><span>email : </span><span di="email">` + result['email'] + `</span></p>
    //                     <p><span>phone : </span><span di="phone">` + result['phone'] + `</span></p>
    //                     <p><span>province : </span><span di="province">` + result['province'] + `</span></p>
    //                     <p><span>addresses : </span><span di="addresses">` + result['addresses'] + `</span></p>
    //                     <p><span>image : </span><span di="image">` + result['image'] + `</span></p>
    //                     <p><span>account_type : </span><span di="account_type">` + result['account_type'] + `</span></p>
    //                     <p><span>account status : </span><span di="account_status">` + result['account_status'] + `</span></p>
    //                     <p><span>account plan : </span><span di="account_status">` + result['subscription_type'] + `</span></p>
    //                     <p><span>subscription start : </span><span di="account_status">` + result['subscription_in'] + `</span></p>
    //                     <p><span>subscription end : </span><span di="account_status">` + result['subscription_out'] + `</span></p>
    //                     <input value="` + result['id'] + `" type="hidden" name="id">
    //             </fieldset>
    //         `);
    //     }).fail(function(jqxhr, textStatus, error) {
    //         flash('حاول مجددا', 'warning');
    //     });

    //     // $('#modal').iziModal('open', { zindex: 99999 });
    //     $('#modal').iziModal('open', { zindex: 50 });
    // });





    $(document).on('click', '.edit_basket', function() {
        $('#modal').iziModal('open', { zindex: 50 });
        var id = $(this).attr('data-item_id');
        var quantity = $(this).attr('data-quantity');

        console.log(quantity);
        $('#updateQU').attr('data-item_id', id);
        $('#quantity').val(quantity);

    });


    $(document).on('click', '#updateQU', function() {
        var id = $(this).attr('data-item_id');
        var quantity = $('#quantity').val();

        if (quantity == '') {
            flash("sorry1");
            return
        }
        // console.log(id);

        $.ajax({
            type: "post",
            url: "/basket/update",
            data: {
                'id': id,
                'quantity': quantity,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                flash(response['message'], response['status']);
                $('#edit__id__' + id).attr('data-quantity', quantity);
                $('#quantity__id__' + id).html('الكميه : ' + quantity);

                $(this).parent().css({ "color": "red", "border": "2px solid red" });
            },
            error: function(jqXHR, exception) {
                if (jqXHR.status === 500) {
                    flash('حاول مجددا', 'warning');

                }
                if (jqXHR.status === 401) {
                    flash('قم بتسجيل الدخول اولا', 'warning');

                }
            }
        });


    });




});