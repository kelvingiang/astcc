/**
 * UTILITY FUNCTIONS
 * ==========================================================================
 */

// Hàm kiểm tra định dạng email
function isValidEmail(email) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return filter.test(email);
}

// Hàm kiểm tra ký tự số điện thoại hợp lệ
function isPhone(evt, element) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (
        (charCode != 45 || jQuery(element).val().indexOf('-') != -1) && // “-” CHECK MINUS, AND ONLY ONE.
        (charCode != 46 || jQuery(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
        (charCode != 8) && // DELETE KEY
        (charCode < 48 || charCode > 57) // NUMBERS ONLY
    ) {
        return false;
    }
    return true;
}

// Hàm kiểm tra chỉ cho phép nhập số
function isOnlyNumber(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

// Các hàm liên quan đến UI (Waiting, Popup)
function showwaiting() {
    jQuery('#waiting-img').css('display', 'block');
}

function hidewaiting() {
    jQuery('#waiting-img').css('display', 'none');
}

function fnpopup() {
    jQuery('#div-popup').fadeIn('slow');
    jQuery('#div-alertInfo').css('top', '150px');
    setTimeout(closePopup, 5000);
}

function closePopup() {
    jQuery('#div-popup').fadeOut('slow');
    jQuery('#div-alertInfo').css('top', '0px');
    jQuery('#div-alertInfo').css('opacity', '0');
}

function fnOpenNormalDialog() {
    jQuery("#dialog-confirm").html("Confirm Dialog Box");
    jQuery("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Modal",
        height: 250,
        width: 400,
        buttons: {
            "Yes": function() {
                jQuery(this).dialog('close');
                callback(true);
            },
            "No": function() {
                jQuery(this).dialog('close');
                callback(false);
            }
        }
    });
}

// Các hàm xử lý Cookie
function setCookie(name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
        ((expires == null) ? "" : "; expires=" + expires.toGMTString()) +
        ((path == null) ? "" : "; path=" + path) +
        ((domain == null) ? "" : "; domain=" + domain) +
        ((secure == null) ? "" : "; secure");
}

function getCookie(name) {
    var cname = name + "=";
    var dc = document.cookie;
    if (dc.length > 0) {
        var begin = dc.indexOf(cname);
        if (begin != -1) {
            begin += cname.length;
            var end = dc.indexOf(";", begin);
            if (end == -1) end = dc.length;
            return unescape(dc.substring(begin, end));
        }
    }
    return null;
}

function eraseCookie(name, path, domain) {
    if (getCookie(name)) {
        document.cookie = name + "=" +
            ((path == null) ? "" : "; path=" + path) +
            ((domain == null) ? "" : "; domain=" + domain) +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}


/**
 * DOCUMENT READY
 * ==========================================================================
 */
jQuery(document).ready(function($) {

    // Bắt sự kiện kiểm tra email
    $('.email').focusout(function(e) {
        var emailInput = document.getElementById('txt_email');
        if (emailInput && !isValidEmail(emailInput.value)) {
            $('#error-email').text('請輸入正確 E-mail 地址 ! ');
            emailInput.focus();
        } else {
            $('#error-email').text('');
        }
    });

    // Bắt sự kiện nhập liệu điện thoại
    $('.type-phone-more, .type-phone').keypress(function(event) {
        return isPhone(event, this);
    });

    // Bắt sự kiện nhập liệu chỉ số
    $('.type-number').keypress(function(event) {
        return isOnlyNumber(event);
    });

    // Sự kiện cuộn trang (Back to top)
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#back-top').fadeIn('fast');
        } else {
            $('#back-top').fadeOut(1500);
        }
    });

    // Click mượt mà lên đầu trang
    $('#back-top img').click(function() {
        $('body,html').stop(false, false).animate({
            scrollTop: 0
        }, 10);
        return false;
    });

});