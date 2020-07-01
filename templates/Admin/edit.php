<?php

defined('ABSPATH') || die();

?>
<div class="wrap">
    <h3><?php _e('Edit Snippet', 'ucsi'); ?></h3>
    <div class="ud-form">
        <?php
        if ($errors) {
            foreach ($errors as $err) {
        ?>
                <div class="ud-alert a-err">
                    <?php echo $err; ?>
                </div>
        <?php
            }
        }
        ?>
        <form action="" method="post">
            <?php wp_nonce_field('_ucsi'); ?>
            <div class="ud-form-group">
                <label for="stitle"><?php _e('Snippet Title', 'ucsi'); ?> </label>
                <input type="text" name="stitle" id="stitle" value="<?php echo isset($sTitle) ? $sTitle : ''; ?>">
            </div>
            <div class="ud-form-group">
                <label for="code"><?php _e('Code', 'ucsi'); ?></label>
                <textarea name="code" id="ucsi_code" rows="10"><?php echo isset($sCon) ? $sCon : ''; ?></textarea>
            </div>
            <?php submit_button(__('Update', 'ucsi'), 'primary', 'update-s'); ?>
        </form>
    </div>
</div>