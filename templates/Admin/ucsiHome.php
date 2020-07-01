<?php

defined('ABSPATH') || die();

?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Ultra Code Snippets', 'ucsi'); ?></h1>
    <?php
    $addNewUrl = add_query_arg(
        array(
            'action' => 'add',
        ),
        admin_url('admin.php?page=uc-snippet')
    );
    ?>
    <a href="<?php echo $addNewUrl; ?>" class="page-title-action">Add New</a>
    <hr class="wp-header-end">
    <ul class="subsubsub">
        <?php
        $snippets_cl = new \Inc\Admin\Snippets();
        $total = $snippets_cl::ucsi_snippets_count();
        ?>
        <li class="all"><a href="" class="current" aria-current="page">All <span class="count">(<?php echo $total; ?>)</span></a> </li>
    </ul>
    <div class="ucsi-list">
        <form method="post">
            <?php
            $snippets = new \Inc\Admin\Snippets();
            $snippets->prepare_items();
            $snippets->search_box('search', 'search_id');
            $snippets->display();
            ?>
        </form>
    </div>
</div>