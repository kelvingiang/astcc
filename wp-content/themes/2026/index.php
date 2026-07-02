<?php

get_header();
?>
<div class="home-statistics" style="margin: 0.5rem 2rem;">
    <?php get_template_part('template/template', 'home-statistics'); ?>
</div>
<div class="home-supervisor" >
    <?php get_template_part('template/template', 'home-supervisor'); ?>
</div>
<div class="home-event">
    <?php get_template_part('template/template', 'home-event'); ?>
</div>
<div id="home-slider-section">
    <?php get_template_part('template/template', 'home-slider'); ?>
</div>
<div class="home-maps">
    <?php get_template_part('template/template', 'home-maps'); ?>
</div>
<?php
get_footer();
