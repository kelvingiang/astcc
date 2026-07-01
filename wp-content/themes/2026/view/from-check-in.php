<?php
// [18/06/2026] Fix Security: Thêm chặn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

$params = getParams();
require_once(DIR_MODEL . 'model-check-in-function.php');
$model = new Model_Check_In_Function();

$errors = [];
if (!empty($_GET['e'])) {
    $errors = json_decode(urldecode(stripslashes($_GET['e'])), true); // Thêm stripslashes bảo vệ
}

$id = $barcode = $full_name = $country = $position = $email = $phone = $img = $note = null;

if (isset($params['id'])) {
    $data = $model->get_item(getParams());

    // [18/06/2026] Ngăn lỗi Undefined Index
    $id        = isset($data['ID']) ? $data['ID'] : '';
    $barcode   = isset($data['barcode']) ? $data['barcode'] : '';
    $full_name = isset($data['full_name']) ? $data['full_name'] : '';
    $country   = isset($data['country']) ? $data['country'] : '';
    $position  = isset($data['position']) ? $data['position'] : '';
    $email     = isset($data['email']) ? $data['email'] : '';
    $phone     = isset($data['phone']) ? $data['phone'] : '';
    $img       = isset($data['img']) ? $data['img'] : '';
    $note      = isset($data['note']) ? $data['note'] : '';
}
?>

<?php if (!empty($errors)) : ?>
    <div class="errorSpace">
        <?php foreach ($errors as $val) {
            // [18/06/2026] Fix Security: Escape lỗi để chống XSS
            echo esc_html($val) . '<br>';
        } ?>
    </div>
<?php endif ?>

<form action="" method="post" enctype="multipart/form-data" id="f-guests" name="f-guests">
    <!-- [18/06/2026] Fix Security: Bắt buộc dùng esc_attr để escape dữ liệu đầu ra vào input -->
    <input type='hidden' id='hidden_barcode' name='hidden_barcode' value='<?php echo esc_attr($barcode); ?>' />
    <input type='hidden' id='hidden_ID' name='hidden_ID' value='<?php echo esc_attr($id); ?>' />
    <input type='hidden' id='hidden_img' name='hidden_img' value='<?php echo esc_attr($img); ?>' />
    <input type='hidden' id='hidden_country' name='hidden_country' value='<?php echo esc_attr($country); ?>' />

    <div class="row-two-column">
        <div class="col">
            <div class="cell-title"><?php _e('Picture') ?></div>
            <div class="cell-text">
                <?php
                if (empty($img)) {
                    $guest_img = 'no-image.jpg';
                } else {
                    $guest_img = $img;
                }
                ?>
                <!-- [18/06/2026] Fix Security: Dùng esc_url cho các đường dẫn ảnh -->
                <div id="show-img" style=" background-image: url('<?php echo esc_url(get_guests_img($guest_img)); ?>');"></div>
                <input type="file" id="guests_img" name="guests_img" accept=".png, .jpg, .jpeg, .bmp" />
            </div>
        </div>

        <?php if (getParams('action') != 'add' && !empty($barcode)) { ?>
            <div class="col">
                <div class="cell-title"><label class="label-admin"> <?php _e('Barcode') ?> </label></div>
                <div class="cell-text">
                    <!-- [18/06/2026] Fix Security: Dùng esc_url và thêm alt -->
                    <div><img id="img_barcode" name="img_barcode" src='<?php echo esc_url(get_qrcode_img($barcode)); ?>' alt="QR Code"></div>
                    <div>
                        <a href="<?php echo esc_url(get_qrcode_img($barcode)); ?>"
                            download="<?php echo esc_attr($full_name . '-' . $barcode . '.png'); ?>"
                            style="font-weight: bold; text-decoration: none; color: blue">
                            <?php echo esc_html($barcode); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="row-three-column">
        <div class="col">
            <div class="cell-title"><?php _e('Full Name') ?></div>
            <div class="cell-text">
                <input type="text" id="txt_fullname" name="txt_fullname" class="my-input" required value="<?php echo esc_attr($full_name); ?>" />
            </div>
        </div>

        <div class="col">
            <div class="cell-title"><?php _e('Country'); ?></div>
            <div class="cell-text">
                <select id="sel_country" name="sel_country" class="my-input">
                    <?php foreach (get_guests_country() as $key => $val) { ?>
                        <!-- [18/06/2026] Tối ưu Logic: Sử dụng hàm selected() của WordPress cho option select -->
                        <option value='<?php echo esc_attr($key); ?>' <?php selected($country, $key); ?>> 
                            <?php echo esc_html($val); ?> 
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col">
            <div class="cell-title"><?php _e('Asia Position') ?></div>
            <div class="cell-text"><input type="text" id="txt_position" name="txt_position" class="my-input" value='<?php echo esc_attr($position); ?>' /></div>
        </div>
    </div>

    <div class="row-two-column">
        <div class="col">
            <div class="cell-title"> <?php _e('Email') ?>
                <i id='error-email' style="color: red; font-size:0.8rem"></i>
            </div>
            <div class="cell-text">
                <!-- [18/06/2026] UX: Đổi type="text" thành type="email" -->
                <input type="email" id="txt_email" name="txt_email" class='email my-input' value='<?php echo esc_attr($email); ?>' />
            </div>
        </div>

        <div class="col">
            <div class="cell-title"><?php _e('Phone') ?></div>
            <div class="cell-text">
                <input type="text" id="txt_phone" name="txt_phone" class='type-phone-more my-input' value='<?php echo esc_attr($phone); ?>' />
            </div>
        </div>
    </div>

    <div class="row-one-column">
        <div class="col">
            <div class="cell-title"><?php _e('Note') ?></div>
            <div class="cell-text">
                <!-- [18/06/2026] Fix Security: Dùng esc_textarea -->
                <textarea id="txt_note" name="txt_note" cols="100%" rows="6" style="width: 100%"><?php echo esc_textarea($note); ?></textarea>
            </div>
        </div>
    </div>

    <div class="btn-add-space">
        <input name="submit" id="submit" class="button button-primary" value="發 表" type="submit" style="margin-right: 50px">
    </div>
</form>

<script type="text/javascript">
    // show hinh anh truoc khi up len
    jQuery(function() {
        jQuery("#guests_img").on("change", function() {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() { // set image data as background of div
                    jQuery("#show-img").css("background-image", "url(" + this.result + ")");
                };
                
                // [18/06/2026] Bug Fix: Bỏ dòng console.log(result); vì biến result chưa từng được khai báo (gây lỗi Uncaught ReferenceError)
            }
        });
    });
</script>