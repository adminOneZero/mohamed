 /**************************flash system************************/
 iziToast.settings({
     timeout: 9000,
     layout: 2,
     rtl: true,
     titleColor: '#fff',
     iconColor: '#fff',
     progressBarColor: '#fff',
     messageColor: '#fff',
     titleColor: '#fff',
     class: 'notify',
     resetOnHover: true,
     icon: 'material-icons',
     transitionIn: 'flipInX',
     transitionOut: 'flipOutX',
     //  zindex: 100,
     position: 'topLeft', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
 });


 function flash(message, type = 'default') {
     // normal flash
     if (type == 'default' || type == '' || type == 'undefined') {
         iziToast.show({
             iconText: '✿',
             message: message,
             backgroundColor: 'rgb(114,54,139,0.7)',
         });
     }

     // danger flash
     if (type == 'danger') {
         iziToast.show({
             title: ' خطأ ',
             iconText: '✘',
             message: message,
             backgroundColor: 'rgb(192,57,43,0.7)',
         });
     }

     // success flash
     if (type == 'success') {
         iziToast.show({
             title: ' نجاح ',
             iconText: '☺',
             message: message,
             backgroundColor: 'rgb(30 ,100,72,0.7)',
         });
     }

     // warning flash
     if (type == 'warning') {
         iziToast.show({
             title: ' تنبيه ',
             iconText: '🚧',
             message: message,
             backgroundColor: 'rgb(243 ,156  ,18,0.8)',
         });
     }


 }

 function askUser(MSG, html_id) {
     iziToast.question({
         backgroundColor: 'rgb(243 ,156  ,18,0.8)',
         timeout: 20000,
         close: false,
         overlay: true,
         displayMode: 'once',
         id: 'question',
         zindex: 80,
         title: 'تاكيد',
         message: MSG,
         position: 'center',
         buttons: [
             ['<button id="' + html_id + '"><b>نعم</b></button>', function(instance, toast) {

                 instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                 return true;

             }, true],
             ['<button>لا</button>', function(instance, toast) {

                 instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                 return false;

             }],
         ],
         onClosing: function(instance, toast, closedBy) {
             //  console.info('Closing | closedBy: ' + closedBy);
             //  console.log(toast);
             //  console.log(instance);
         },
         onClosed: function(instance, toast, closedBy) {
             //  console.info('Closed | closedBy: ' + closedBy);
             //  console.log(instance);
             //  console.log(toast);
         }
     });

 }



 /**************************global flash************************/
 // $.get("/flash", function(data, status) {

 //     if (status == 'success') {
 //         if (data.length > 0) {
 //             $.each(data, function(key, value) {
 //                 flash(value, 'warning');
 //             });
 //         }


 //     }

 // });