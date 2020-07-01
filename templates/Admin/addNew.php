<?php

defined('ABSPATH') || die();

?>
<div class="wrap">
    <h3><?php _e('Add New Code Snippet', 'ucsi'); ?></h3>
    <div class="ud-form">
        <?php
        if ($errors) {
            foreach ($errors as $err) {
        ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo $err; ?></p>
                </div>
        <?php
            }
        }
        ?>
        <form action="" method="post">
            <?php wp_nonce_field('_ucsi'); ?>
            <div class="ud-form-group">
                <label for="stitle"><?php _e('Snippet Title', 'ucsi'); ?> </label>
                <input type="text" name="stitle" id="stitle" placeholder="Enter snippet title">
            </div>
            <div class="ud-form-group">
                <label for="code"><?php _e('Code', 'ucsi'); ?></label>
                <textarea name="code" id="ucsi_code" rows="10"></textarea>
            </div>
            <?php submit_button(__('Add New', 'ucsi'), 'primary', 'add_s'); ?>
        </form>
    </div>
</div>