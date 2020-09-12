<?php
$aptf_settings = $this->aptf_settings;
//$this->print_array($aptf_settings);
?>
<div class="wrap">
    <div class="aptf-panel">
        <?php include('header.php'); ?>
        <div class="aptf-nav">
            <ul>
                <li><a href="javascript:void(0)" id="aptf-settings-trigger" class="aptf-tabs-trigger aptf-active-trigger"><?php _e('Settings', APTF_VERSION); ?></a></li>
                <li><a href="javascript:void(0)" id="aptf-how_to_use-trigger" class="aptf-tabs-trigger"><?php _e('How To Use', APTF_VERSION); ?></a></li>
                <li><a href="javascript:void(0)" id="aptf-about-trigger" class="aptf-tabs-trigger"><?php _e('About', APTF_VERSION); ?></a></li>
                <li><a href="https://wordpress.org/support/view/plugin-reviews/accesspress-twitter-feed" target="_blank"><?php _e('Give us a rating', APTF_VERSION); ?></a></li>
                <li><a href="javascript:void(0)" id="aptf-morewp-trigger" class="aptf-tabs-trigger"><?php _e('More WordPress Resources', APTF_VERSION); ?></a></li>
                <li><a href="https://accesspressthemes.com/documentation/accesspress-twitter-feed/" target="_blank" class="aptf-tabs-trigger"><?php _e('Documentation', APTF_VERSION); ?></a></li>
                <li><a href="https://demo.accesspressthemes.com/wordpress-plugins/accesspress-twitter-feed-pro/" target="_blank" class="aptf-tabs-trigger"><?php _e('Check Premium Versions', APTF_VERSION); ?></a></li>
            </ul>
        </div>
        <div class="aptf-board-wrapper">
            <?php 
            if(!empty($_GET['message'])){
                switch($_GET['message']){
                    case 1:
                    $message = __('Settings saved successfully','accesspress-twitter-feed');
                    break;
                    case 2:
                    $message = __('Cache deleted successfully','accesspress-twitter-feed');
                    break;
                    case 3:
                    $message = __('Settings restored successfully','accesspress-twitter-feed');
                    break;
                }
                ?>
                <div class="updated notice is-dismissible"> 
                    <p><?php echo $message;?></p>
                </div>
                <?php
            }
            
            ?>
            <form method="post" action="<?php echo admin_url() . 'admin-post.php'; ?>">
                <input type="hidden" name="action" value="aptf_form_action"/>
                <?php
                /**
                 * Settings Panel
                 */
                include('boards/main-settings.php');

                /**
                 * How To use Panel
                 */
                include('boards/how-to-use.php');

                /**
                 * About Panel
                 */
                include('boards/about.php');
                
                 /**
                 * More WordPress Resources Panel
                 */
                include('boards/more-wp.php');
                ?>
                <?php
                wp_nonce_field('aptf_action_nonce', 'aptf_nonce_field');
                $restore_nonce = wp_create_nonce('aptf-restore-nonce');
                ?>
                <input type="submit" name="aptf_settings_submit" value="<?php _e('Save Settings', 'accesspress-twitter-feed'); ?>" class="button button-primary"/>
                <a href="<?php echo admin_url() . 'admin-post.php?action=aptf_restore_settings&_wpnonce=' . $restore_nonce; ?>" onclick="return confirm('<?php _e('Are you sure you want to restore default settings?', 'accesspress-twitter-feed') ?>');"><input type="button" value="<?php _e('Restore Default Settings', 'accesspress-twitter-feed'); ?>" class="button button-primary"/></a>
                <a href="<?php echo admin_url() . 'admin-post.php?action=aptf_delete_cache'; ?>" onclick="return confirm('<?php _e('Are you sure you want to delete cache?', 'accesspress-twitter-feed') ?>');"><input type="button" value="<?php _e('Delete Cache', 'accesspress-twitter-feed'); ?>" class="button button-primary"/></a>
            </form>
        </div>
    </div>
    <div class="aptf-promo">
        <a href="https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Faccesspress-twitter-feed-pro%2F11029697" target="_blank"><img src="<?php echo APTF_IMAGE_DIR . '/upgrade.png' ?>"/></a>
        <div class="aptf-promo-actions">
            <a href="http://demo.accesspressthemes.com/wordpress-plugins/accesspress-twitter-feed-pro/" title="Demo" target="_blank"><input type="button" class="aptf-demo-btn" value="Demo"/></a>
            <a href="https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Faccesspress-twitter-feed-pro%2F11029697" title="Upgrade" target="_blank"><input type="button" class="aptf-upgrade-btn" value="Upgrade"/></a>
            <a href='https://accesspressthemes.com/wordpress-plugins/accesspress-twitter-feed-pro/' title="Plugin Information" target="_blank"><input type="button" class="aptf-demo-btn" value="Plugin Information"/></a>
        </div>

        <a href="https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Faccesspress-twitter-feed-pro%2F11029697" target="_blank"><img src="<?php echo APTF_IMAGE_DIR . '/upgrade-features.png' ?>"/></a>
        <div class="aptf-promo-actions">
            <a href="http://demo.accesspressthemes.com/wordpress-plugins/accesspress-twitter-feed-pro/" title="Demo" target="_blank"><input type="button" class="aptf-demo-btn" value="Demo"/></a>
            <a href="https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Faccesspress-twitter-feed-pro%2F11029697" title="Upgrade" target="_blank"><input type="button" class="aptf-upgrade-btn" value="Upgrade"/></a>
            <a href='https://accesspressthemes.com/wordpress-plugins/accesspress-twitter-feed-pro/' title="Plugin Information" target="_blank"><input type="button" class="aptf-demo-btn" value="Plugin Information"/></a>
        </div>
    </div>
</div>

