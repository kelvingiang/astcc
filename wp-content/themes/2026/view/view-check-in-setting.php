<?php $page = getParams('page'); ?>
<div class="setting-space">
    <ul>
        <li>
            <a class="button button-large" href="<?php echo "admin.php?page=$page&action=waiting" ?>">
                報到時間
            </a>
        </li>
    </ul>
    <hr />
    <ul>
        <li>
            <a class="button button-primary button-large" href="<?php echo "admin.php?page=$page&action=export_member" ?>">
                導出會員
            </a>
        </li>
        <li>
            <a class="button button-primary button-large" href="<?php echo "admin.php?page=$page&action=export_register_member" ?>">
                導出已登記會員
            </a>
        </li>
        <li>
            <a class="button button-primary button-large" href="<?php echo "admin.php?page=$page&action=import_member" ?>">
                導入會員
            </a>
        </li>
    </ul>
    <hr />
    <ul>
        <li>
            <a class="button  button-large" href="<?php echo "admin.php?page=$page&action=create_qrcode" ?>">
                批次產生QRCode
            </a>
        </li>
    </ul>
</div>

<script type="text/javascript">
    function myFunction() {
        if (confirm("您確定刪除所有報到記錄")) {
            location.href = "<?php echo "admin.php?page=$page&action=reset_checkin" ?>";
        } else {
            window.stop();
        }
    }
</script>