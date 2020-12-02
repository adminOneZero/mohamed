$(document).ready(function() {
    /******************************[load user information]*************************************/
    // ini model
    $("#modal").iziModal();

    // when  click view
    $(document).on('click', '.showUserInfo', function(event) {
        event.preventDefault();

        // get user id
        var id = $(this).attr('data-id');
        console.log(id);
        // set id to user change password
        $('#chPassID').attr('value', id);
        // get user information by id
        $.getJSON("/dashboard/users/info/" + id, function(result) {

            $('#modal .info').html(`
                <fieldset>
                    <legend>Informations:</legend>
                        <p><span>name : </span><span>` + result['name'] + `</span></p>
                        <p><span>email : </span><span di="email">` + result['email'] + `</span></p>
                        <p><span>phone : </span><span di="phone">` + result['phone'] + `</span></p>
                        <p><span>province : </span><span di="province">` + result['province'] + `</span></p>
                        <p><span>addresses : </span><span di="addresses">` + result['addresses'] + `</span></p>
                        <p><span>image : </span><span di="image">` + result['image'] + `</span></p>
                        <p><span>account_type : </span><span di="account_type">` + result['account_type'] + `</span></p>
                        <p><span>account status : </span><span di="account_status">` + result['account_status'] + `</span></p>
                        <p><span>account plan : </span><span di="account_status">` + result['subscription_type'] + `</span></p>
                        <p><span>subscription start : </span><span di="account_status">` + result['subscription_in'] + `</span></p>
                        <p><span>subscription end : </span><span di="account_status">` + result['subscription_out'] + `</span></p>
                        <input value="` + result['id'] + `" type="hidden" name="id">
                </fieldset>
            `);
        }).fail(function(jqxhr, textStatus, error) {
            flash('حاول مجددا', 'warning');
        });

        $('#modal').iziModal('open', { zindex: 50 });
        // $('#modal').iziModal('open', { zindex: 99999 });
    });

    /******************************[active user]*************************************/
    // asking user before accept
    $(document).on('click', '#active_btn', function() {
            askUser("هل انت متاكد انك تريد تشيط هذا الحساب؟", "yes4active");
        })
        // active user 
    $(document).on('click', '#yes4active', function() {
        var id = $('#modal .info input[name="id"]').attr('value');
        $.ajax({
            type: "post",
            url: "/dashboard/users/active",
            data: {
                'id': id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                flash(response['message'], response['status']);

                if (response['status'] == 'sccess') {
                    setTimeout(function() {
                        document.location.reload()
                    }, 9000);
                }
            },
            error: function(jqXHR, exception) {
                flash('حاول مجددا', 'warning');
            }
        });

        //     if () {
        // } else {
        //     flash("nooooooo")
        // }
    });
    /******************************[delete user]*************************************/
    // ask before
    $(document).on('click', '#delete_btn', function() {
            askUser("هل انت متاكد انك تريد حذف هذا الحساب؟", "yes4delete");
        })
        // do action
    $(document).on('click', '#yes4delete', function() {
        var id = $('#modal .info input[name="id"]').attr('value');
        $.ajax({
            type: "post",
            url: "/dashboard/users/delete/",
            data: {
                'id': id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                // console.log(response['log']);
                flash(response['message'], response['status']);
            },
            error: function(jqXHR, exception) {
                if (jqXHR.status === 500) {
                    flash('حاول مجددا', 'warning');
                    console.log(jqXHR);
                }
            }
        });
    });

    /******************************[deactive user]*************************************/
    // ask before do action
    $(document).on('click', '#deactive_btn', function() {
        askUser("هل انت متاكد انك تريد الغاء تنشيط هذا الحساب؟", "yes4deactive");
    })

    // do action 
    $(document).on('click', '#yes4deactive', function() {
        var id = $('#modal .info input[name="id"]').attr('value');
        $.ajax({
            type: "post",
            url: "/dashboard/users/deactive",
            data: {
                'id': id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                flash(response['message'], response['status']);
            },
            error: function(jqXHR, exception) {
                if (jqXHR.status === 500) {
                    flash('حاول مجددا', 'warning');

                }
            }
        });
    });

    /******************************[user subscription]*************************************/
    // ask before do action
    $(document).on('click', '#sub_btn ', function() {
        askUser("هل انت متاكد انك تريد تنشيط هذه الخطه؟", "yes4subscription");
    })

    // do action
    $(document).on('click', '#yes4subscription', function() {
        var id = $('#modal .info input[name="id"]').attr('value');
        var menu_element = document.getElementById("sub_type");

        var sub_type = menu_element.value;

        $.ajax({
            type: "post",
            url: "/dashboard/users/subscribe",
            data: {
                'id': id,
                'sub_type': sub_type,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                flash(response['message'], response['status']);
            },
            error: function(jqXHR, exception) {
                if (jqXHR.status === 500) {
                    flash('حاول مجددا', 'warning');

                }
            }
        });
    });


    /******************************[search]*************************************/
    $("#searchModal").iziModal();
    $("#Modalx").iziModal();

    // do action
    $(document).on('click', '#search_btn', function() {
        var search_text = $('#search_text').val();


        $.ajax({
            type: "post",
            url: "/dashboard/users/search",
            data: {
                'search_text': search_text,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                // flash(response['message'], response['status']);
                $('#table_body').html('');
                console.log(response.length);
                if (response.length > 0) {
                    response.forEach(element => {
                        $('#table_body').append(`
                        
                            <tr >
                                <td>` + element['name'] + `</td>
                                <td style="flex : 1;"><img class="m-2" style="vertical-align: middle" src="/img/8.webp" alt="" height="30px" width="30px"><span style="vertical-align: middle;margin-right:5px;">` + element['name'] + `</span></td>
                                <td>` + element['email'] + `</td>
                                <td>
                                <span class="dot">
                                <i class="bg-success"></i>
                                مكتمل
                                </span>
                                </td>
                                <td>17/07/2020</td>
                                <td><a href="#" data-id="` + element['id'] + `" class="btn -btn-danger link-icon fas fa-eye size-1 showUserInfo" ></a></td>
                            </tr>
                    
                        `);

                    });

                    $('#modalx').iziModal('setGroup', 'alerts');
                    $('#searchModal').iziModal('open', {
                        zindex: 48,
                        // closeOnEscape: true,
                        width: 1000,
                        closeButton: true,
                    });
                } else {
                    flash("لا توجد نتيجه !!", "warning")
                }

            },
            error: function(jqXHR, exception) {
                if (jqXHR.status === 500) {
                    flash('حاول مجددا', 'warning');

                }
            }
        });
    });

    /******************************[add new user]*************************************/
    // ask before do action
    // $('#newUserModal').iziModal('setGroup', 'alerts');
    $("#newUserModal").iziModal();

    $(document).on('click', '#add_user_btn', function() {
        $('#newUserModal').iziModal('open', {
            zindex: 48,
            // closeOnEscape: true,
            width: 1000,
            closeButton: true,
        });
        // askUser("هل انت متاكد انك تريد الغاء تنشيط هذا الحساب؟", "yes4deactive");
    })
});