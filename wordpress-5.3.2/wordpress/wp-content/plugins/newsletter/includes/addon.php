<?php

/**
 * User by add-ons as base-class.
 */
class NewsletterAddon {

    var $logger;
    var $admin_logger;
    var $name;
    var $options;
    var $version;

    public function __construct($name, $version = '0.0.0') {
        $this->name = $name;
        $this->version = $version;
        if (is_admin()) {
            $old_version = get_option('newsletter_' . $name . '_version');
            if ($version != $old_version) {
                $this->upgrade($old_version === false);
                update_option('newsletter_' . $name . '_version', $version, false);
            }
        }
        add_action('newsletter_init', array($this, 'init'));
    }

    function upgrade($first_install = false) {
        
    }

    function init() {
        
    }

    /**
     * 
     * @return NewsletterLogger
     */
    function get_logger() {
        if (!$this->logger) {
            $this->logger = new NewsletterLogger($this->name);
        }
        return $this->logger;
    }

    function get_admin_logger() {
        if (!$this->admin_logger) {
            $this->admin_logger = new NewsletterLogger($this->name . '-admin');
        }
        return $this->admin_logger;
    }

    function setup_options() {
        if ($this->options)
            return;
        $this->options = get_option('newsletter_' . $this->name, array());
    }

    function save_options($options) {
        update_option('newsletter_' . $this->name, $options);
        $this->setup_options();
    }

    function merge_defaults($defaults) {
        $options = get_option('newsletter_' . $this->name, array());
        $options = array_merge($defaults, $options);
        $this->save_options($options);
    }

    /**
     * @global wpdb $wpdb
     * @param string $query
     */
    function query($query) {
        global $wpdb;

        $r = $wpdb->query($query);
        if ($r === false) {
            $logger = $this->get_logger();
            $logger->fatal($query);
            $logger->fatal($wpdb->last_error);
        }
        return $r;
    }

}

/**
 * Used by mailers as base-class.
 */
class NewsletterMailerAddon extends NewsletterAddon {

    var $enabled = false;

    function __construct($name, $version = '0.0.0') {
        parent::__construct($name, $version);
        $this->setup_options();
        $this->enabled = !empty($this->options['enabled']);
    }

    function init() {
        parent::init();
        add_action('newsletter_register_mailer', function () {
            if ($this->enabled) {
                Newsletter::instance()->register_mailer($this->get_mailer());
            }
        });
    }

    /**
     * 
     * @return NewsletterMailer
     */
    function get_mailer() {
        return null;
    }

    function get_last_run() {
        return get_option('newsletter_' . $this->name . '_last_run', 0);
    }

    function save_last_run($time) {
        update_option('newsletter_' . $this->name . '_last_run', $time);
    }

    function save_options($options) {
        parent::save_options($options);
        $this->enabled = !empty($options['enabled']);
    }

    static function get_test_message($to, $subject = '') {
        $message = new TNP_Mailer_Message();
        $message->to = $to;
        $message->to_name = '';
        $message->body = "<!DOCTYPE html>\n";
        $message->body .= "This is the rich text (HTML) version of a test message.</p>\n";
        $message->body .= "This is a <strong>bold text</strong></p>\n";
        $message->body .= "This is a <a href='http://www.thenewsletterplugin.com'>link to www.thenewsletterplugin.com</a></p>\n";
        $message->body_text = 'This is the TEXT version of a test message. You should see this message only if you email client does not support the rich text (HTML) version.';
        $message->headers['X-Newsletter-Email-Id'] = '0';
        if (empty($subject)) {
            $message->subject = '[' . get_option('blogname') . '] Test message from Newsletter (' . date(DATE_ISO8601) . ')';
        } else {
            $message->subject = $subject;
        }
        $message->from = Newsletter::instance()->options['sender_email'];
        $message->from_name = Newsletter::instance()->options['sender_name'];
        return $message;
    }

    function get_test_messages($to, $count) {
        $messages = array();
        for ($i = 0; $i < $count; $i++) {
            $messages[] = self::get_test_message($to, '[' . get_option('blogname') . '] Test message ' . ($i + 1) . ' from Newsletter (' . date(DATE_ISO8601) . ')');
        }
        return $messages;
    }

}


