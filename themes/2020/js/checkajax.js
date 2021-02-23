/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function() {
    /* su ly ajax  phan login*/
    jQuery('#f_login').submit(function(e) {
    var objInfo = objLoginData; // lay gia tri dc chuyen sang tu file yeu cau
   //     console.log(objInfo);
        jQuery.ajax({
            url: objInfo.url, // lay doi tuong chuyen sang dang array
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {  // set ket qua tra ve  data tra ve co thanh phan status va message
                if (data.status === 'done') {
                    window.location.reload();
                    //      window.location.replace("<?php ?>");
                } else if (data.status === 'error') {
                    $('#strMessageLogin').text(data.message);
                }
            },
            error: function(xhr) {
                console.log(xhr.reponseText);
                //console.log(data.status);
            }
        });      
        e.preventDefault();
 
    });

   /* su ly viec lay lai mat khau bi quan*/
   jQuery('#f-getPass').submit(function(e){
       var objforgetpass= obForgetPass;
         jQuery.ajax({
            url: objforgetpass.url, // lay doi tuong chuyen sang dang array
            type: 'post',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {  // set ket qua tra ve  data tra ve co thanh phan status va message
                if (data.status === 'done') {
                    jQuery('#forgetPassMess').text(data.message);
                    jQuery('#waiting-img').hide();
                    setTimeout(closePopup, 3000);    
                } else if (data.status === 'error') {
                     jQuery('#waiting-img').hide();
                     jQuery('#emailMess').text(data.email);
                     jQuery('#passportMess').text(data.passport); 
                     jQuery('#forgetPassMess').text(data.message2);
                }
            },
            error: function(xhr) {
                console.log(xhr.reponseText);
                //console.log(data.status);
            }
        });      
        e.preventDefault();
   });
   function closePopup(){
            $('#ForgetPass').modal('hide');
            $('#g-email').val('');
            $('#g-passport').val('');
            $('#forgetPassMess').text('');
            $('#PasswordMess').text('');
            $('#PassportMess').text('');
   }
/*===========================================================*/

    /* su ly ajax  phan change avatar*/
    jQuery('#f-avata').submit(function(e) {
        var objavatar = objAvatarData; // lay gia tri dc chuyen sang tu file yeu cau
        //   var formdata = new FormData(this);
        //    $.each(files, function(key, value) {
        //       formdata.append(key, value);
        //    });
        jQuery.ajax({
            url: objavatar.url, // lay doi tuong chuyen sang dang array
            type: 'post',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {  // set ket qua tra ve  data tra ve co thanh phan status va message
                if (data.status === 'done') {
                    $('#myModal').modal('hide'); // dong cai dialog
                    setTimeout(location.reload(), 2000); // lam cham lai thao tac
                } else if (data.status === 'error') {
                    $('#mess').text(data.message);
                }
            },
            error: function(xhr) {
                console.log(xhr.reponseText);
            }
        });
        e.preventDefault();
    });



    /*
     $('#f_changepass').submit(function(e) {
     var objInfo = objchangeData; // lay gia tri dc chuyen sang tu file yeu cau
     $.ajax({
     url: objInfo.url,  // lay doi tuong chuyen sang dang array
     type: 'post',
     data: $(this).serialize(),
     dataType: 'json',
     success: function(data) {  // set ket qua tra ve  data tra ve co thanh phan status va message
     if (data.status === 'done') {
     location.reload();
     } else if (data.status === 'error') {
     $('#strMessageLogin').text(data.message);
     }
     },
     error: function(xhr) {
     console.log(xhr.reponseText);  
     }
     });
     e.preventDefault();
     });
     */
});