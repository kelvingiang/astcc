<?php
// lay phan header
get_header();
?>
 <div id="silder"><?php get_template_part('template/template', 'silder'); ?></div>
<!-- phan noi dung of trang index --------------------------------------- -->
<!--LAY THONG TIN SU KIEN QUAN TRONG-->

<div style="background-color: #b7d9e9;  margin: 1rem 0" >
    <?php get_template_part('template/template', 'home-supervisor'); ?>
</div>
<div style="margin: 2rem 0;">
    <?php get_template_part('template/template', 'event'); ?>
</div>
<div>
    <?php get_template_part('template/template', 'maps'); ?>
</div>


<?php
get_footer();
