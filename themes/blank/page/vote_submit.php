<?php
/*
  Template Name:  Vote Submit
 */
?>

<?php
foreach ($_POST as $key => $val) {
    updateVoteCount($key);
}
if (!isset($_SESSION['voteLogin'])) {
    wp_redirect(home_url('vote-login'));
} else {
    userVoteSuccess();
}
?>
<style>
    .main{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 98vh; 
        width: 98vw; 
    }

    .content{
        border-radius: 5px;
        height: 30vh; 
        width: 30vw; 
        background-color: #ccc; 
        display: flex;
        justify-content: center;
        align-items: center;
    }

</style>
<div class="main">
    <div class="content" >
        <div>
            <h2 style="color: #002a80; font-size: 2.5vw; letter-spacing: 1px ">謝謝您的投票 ！</h2>
        </div>
    </div>
</div>

<script type="text/javascript">

    function Redirect() {
        var url = '<?php echo Chang_Url(); ?>';
        window.location = url + "vote-result";

    }

    document.write("You will be redirected to main page in 10 sec.");
    setTimeout('Redirect()', 500);


</script>