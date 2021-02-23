<?php
//Template Name: Check In Waiting
?>
<div class="container-fluid" style="background-color: white; height: 90vh; padding: 0px 20px" >
    <div id="loggo" >
        <a style=" float: left"  href="<?php echo home_url() ?>" >
            <img style="width: 100px" src="<?php echo get_image('astcc-logo.png') ?>"  class="logo-img"  alt="ctcvn_logo" title="ctcvn_logo"/>
        </a> 
        <div style=" margin-top: 5px"><h1 style="font-size: 20px; color: #2E3094">亞 洲 台 灣 商 會 聯 合 總 會</h1></div> 
        <div><h1 style="font-size: 20px; color: #2E3094">ASIA TAIWANESE CHAMBERS OF COMMERCE</h1></div>
    </div>
    <div style=" clear: both"></div>
    <div class="row" style="padding-top:5px">
        <div class="col-lg-12" style="height: 70px; background-color:  #FC9105; border-radius: 5px;  margin-bottom: 10px ">
            <h1 style="font-weight:  bold; color: white; letter-spacing: 3px; text-align: center; line-height: 70px"><?php echo get_option('Title_text'); ?></h1>
        </div>    
        <div class=" col-lg-12" style="text-align: center; height:250px; line-height: 300px;" >
            <label ID="waiting_txt"><?php echo get_option('Waiting_text'); ?></label>              
        </div>

    </div>
</div>


<style>

    #waiting_txt{
        font-size:50px;
        font-weight: bold;
        letter-spacing: 10px;
        -webkit-animation-name: example; /* Safari 4.0 - 8.0 */
        -webkit-animation-duration: 10s; /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: infinite; /* Safari 4.0 - 8.0 */
        animation-name: example;
        animation-duration: 10s;
        animation-iteration-count: infinite;

    }


    /* Safari 4.0 - 8.0 */
    @-webkit-keyframes example {
        0%   {color:#333; font-size: 60px}
        20%   {color:#333; font-size: 60px}
        40%  {color:#FC9105; font-size: 72px}
        41%  {color:#FC9105; font-size: 70px}
        42%  {color:#FC9105; font-size: 71px}
        50%  {color:#FC9105; font-size: 70px}
        70%  {color:#FC9105; font-size: 70px}
        100% {color:#333; font-size: 60px;}
    }

    /* Standard syntax */
    @keyframes example {
        0%   {color:#333; font-size: 60px}
        20%   {color:#333; font-size: 60px}
        40%  {color:#FC9105; font-size: 72px}
        41%  {color:#FC9105; font-size: 70px}
        42%  {color:#FC9105; font-size: 71px}
        50%  {color:#FC9105; font-size: 70px}
        70%  {color:#FC9105; font-size: 70px}
        100% {color:#333; font-size: 60px;}
    }
</style>




