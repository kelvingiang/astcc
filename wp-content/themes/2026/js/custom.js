/**
 * custom.js
 *
 * Ngày tạo  : 2026-07-29
 * Mục đích  : Các hàm tiện ích và xử lý sự kiện chung cho theme.
 *
 * Cấu trúc:
 *  1. Utility Functions  – Validation helpers (email, phone, number)
 *  2. Document Ready     – DOM event bindings
 */

'use strict';

/* =============================================================
 * 1. UTILITY FUNCTIONS
 * ============================================================= */

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Kiểm tra định dạng email hợp lệ.
 *             Hỗ trợ TLD dài (vd: .travel, .museum).
 *
 * @param  {string} email - Chuỗi email cần kiểm tra.
 * @return {boolean}
 */
function isValidEmail(email) {
    var pattern = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
    return pattern.test(String(email).trim());
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Chặn ký tự không hợp lệ trên input điện thoại.
 *             Cho phép: số 0-9, dấu '-', dấu '.', phím Backspace/Delete.
 *
 * @param  {KeyboardEvent} evt - Sự kiện bàn phím.
 * @param  {HTMLElement}   el  - Element đang nhập liệu.
 * @return {boolean}
 */
function isPhone(evt, el) {
    var key = evt.key;

    // Cho phép phím điều hướng / xoá
    if (['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight'].indexOf(key) !== -1) {
        return true;
    }

    // Chỉ cho phép một dấu '-'
    if (key === '-' && el.value.indexOf('-') !== -1) return false;

    // Chỉ cho phép một dấu '.'
    if (key === '.' && el.value.indexOf('.') !== -1) return false;

    // Cho phép '-', '.', và số 0-9
    if (/^[\d\-.]$/.test(key)) return true;

    evt.preventDefault();
    return false;
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Chặn ký tự không phải số trên input chỉ nhận số nguyên.
 *
 * @param  {KeyboardEvent} evt - Sự kiện bàn phím.
 * @return {boolean}
 */
function isOnlyNumber(evt) {
    var key = evt.key;

    if (['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight'].indexOf(key) !== -1) {
        return true;
    }

    if (/^\d$/.test(key)) return true;

    evt.preventDefault();
    return false;
}

/* =============================================================
 * 2. DOCUMENT READY
 * ============================================================= */

jQuery(function ($) {

    /**
     * Ngày tạo : 2026-07-29
     * Chức năng : Validate email khi blur khỏi field .email.
     */
    jQuery('.email').on('blur', function () {
        var $field = jQuery(this);
        var $error = jQuery('#error-email');
        if ($field.val() && !isValidEmail($field.val())) {
            $error.text('請輸入正確 E-mail 地址！');
            $field.trigger('focus');
        } else {
            $error.text('');
        }
    });

    /**
     * Ngày tạo : 2026-07-29
     * Chức năng : Chỉ cho phép nhập số điện thoại hợp lệ.
     */
    jQuery('.type-phone, .type-phone-more').on('keydown', function (e) {
        return isPhone(e, this);
    });

    /**
     * Ngày tạo : 2026-07-29
     * Chức năng : Chỉ cho phép nhập số nguyên.
     */
    jQuery('.type-number').on('keydown', function (e) {
        return isOnlyNumber(e);
    });

    /**
     * Ngày tạo : 2026-07-29
     * Chức năng : Hiện/ẩn nút "Back to top" khi cuộn trang > 100px.
     */
    jQuery(window).on('scroll.backtop', function () {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('#back-top').fadeIn('fast');
        } else {
            jQuery('#back-top').fadeOut(1500);
        }
    });

    /**
     * Ngày tạo : 2026-07-29
     * Chức năng : Cuộn mượt lên đầu trang khi click nút #back-top.
     */
    jQuery('#back-top').on('click', function (e) {
        e.preventDefault();
        jQuery('html, body').stop(true).animate({ scrollTop: 0 }, 300, 'swing');
    });

});