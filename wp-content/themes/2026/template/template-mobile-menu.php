<div id="mobile-header">
    <div class="mobile-menu-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mobile-icon"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        <span>MENU</span>
    </div>
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
            jQuery('.menu-item-has-children').not(this).removeClass('open');

            // 切换当前子菜单的显示状态，使用 toggle 简化逻辑
            subMenu.slideToggle('slow');
            jQuery(this).toggleClass('open');
        });
    });
</script>