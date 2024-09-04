<div id="mobile-header">
    <div class="mobile-menu-title"><img src="<?php echo get_image('mobile_menu_icon.png') ?>" style="width: 20px; margin: 5px" />
        <label style="margin-left: 20px; color: #FFF; font-weight:  bold;  font-size: 15px"> 項 目 </label>
    </div>
    <?php //suite_menu('mobile-menu') ?>
    <?php mobile_menu('mobile-menu') ?>
</div>
<script>
    jQuery(document).ready(function() {

        jQuery('.mobile-menu-title').click(function() {
           jQuery('.mobile-menu').toggle("slow");

        });

        // jQuery('.menu-item-has-children').on('click', function(event) {
        //     event.stopPropagation(); // 防止事件冒泡

        //     let subMenu = jQuery(this).children('.sub-menu');

        //     // 关闭所有其他子菜单
        //    jQuery('.sub-menu').not(subMenu).slideUp('fast');

        //     // 使用 .is(":visible") 来判断当前子菜单是否可见
        //     if (!subMenu.is(":visible")) {
        //         subMenu.slideDown('slow');
        //     } else {
        //         subMenu.slideUp('fast');
        //     }
        // });
        jQuery('.menu-item-has-children').on('click', function(event) {
            event.stopPropagation(); // 防止事件冒泡

            let subMenu = jQuery(this).children('.sub-menu');

            // 停止当前所有动画，防止动画冲突
            subMenu.stop(true, true);

            // 关闭所有其他子菜单并停止它们的动画
            jQuery('.sub-menu').not(subMenu).stop(true, true).slideUp('fast');

            // 切换当前子菜单的显示状态，使用 toggle 简化逻辑
            subMenu.slideToggle('slow');
        });
    });
</script>