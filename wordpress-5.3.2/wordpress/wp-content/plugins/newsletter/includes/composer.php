<?php

/** For old style coders */
function tnp_register_block($dir) {
    return TNP_Composer::register_block($dir);
}

/**
 * Generates and HTML button for email using the values found on $options and
 * prefixed by $prefix, with the standard syntax of NewsletterFields::button().
 * 
 * @param array $options
 * @param string $prefix
 * @return string
 */
function tnpc_button($options, $prefix = 'button') {
    return TNP_Composer::button($options, $prefix);
}

class TNP_Composer {

    static $block_dirs = array();

    static function register_block($dir) {
        // Checks

        if (!file_exists($dir . '/block.php')) {
            $error = new WP_Error('1', 'block.php missing on folder ' . $dir);
            NewsletterEmails::instance()->logger->error($error);
            return $error;
        }
        self::$block_dirs[] = $dir;
        return true;
    }

    /**
     * @param string $open
     * @param string $inner
     * @param string $close
     * @param string[] $markers
     *
     * @return string
     */
    static function wrap_html_element($open, $inner, $close, $markers = array('<!-- tnp -->', '<!-- /tnp -->')) {

        return $open . $markers[0] . $inner . $markers[1] . $close;
    }

    /**
     * @param string $block
     * @param string[] $markers
     *
     * @return string
     */
    static function unwrap_html_element($block, $markers = array('<!-- tnp -->', '<!-- /tnp -->')) {
        if (self::_has_markers($block, $markers)) {
            self::_escape_markers($markers);
            $pattern = sprintf('/%s(.*?)%s/s', $markers[0], $markers[1]);

            $matches = array();
            preg_match($pattern, $block, $matches);

            return $matches[1];
        }

        return $block;
    }

    /**
     * @param string $block
     * @param string[] $markers
     *
     * @return bool
     */
    private static function _has_markers($block, $markers = array('<!-- tnp -->', '<!-- /tnp -->')) {

        self::_escape_markers($markers);

        $pattern = sprintf('/%s(.*?)%s/s', $markers[0], $markers[1]);

        return preg_match($pattern, $block);
    }

    static function get_html_open($email) {
        $open = "<!DOCTYPE html>\n";
        $open .= "<html>\n<head>\n<title>" . esc_html($email->subject) . "</title>\n";
        $open .= "<meta charset=\"utf-8\">\n<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
        $open .= "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
        $open .= "<style type=\"text/css\">\n";
        $open .= NewsletterEmails::instance()->get_composer_css();
        $open .= "\n</style>\n";
        $open .= "</head>\n<body style=\"margin: 0; padding: 0;\">\n";
        return $open;
    }

    static function get_html_close($email) {
        return "</body>\n</html>";
    }

    /**
     * 
     * @param TNP_Email $email
     * @return string
     */
    static function get_main_wrapper_open($email) {
        if (!isset($email->options['composer_background'])) {
            $bgcolor = '#ffffff';
        } else {
            $bgcolor = $email->options['composer_background'];
        }

        return "\n<table cellpadding='0' cellspacing='0' border='0' width='100%'>\n" .
                "<tr>\n" .
                "<td bgcolor='$bgcolor' valign='top'><!-- tnp -->";
    }

    /**
     * 
     * @param TNP_Email $email
     * @return string
     */
    static function get_main_wrapper_close($email) {
        return "\n<!-- /tnp -->\n" .
                "</td>\n" .
                "</tr>\n" .
                "</table>\n\n";
    }

    /**
     * Remove <doctype>, <body> and unnecessary envelopes for editing with composer
     * 
     * @param string $html_email
     *
     * @return string
     */
    static function unwrap_email($html_email) {

        if (self::_has_markers($html_email)) {
            $html_email = self::unwrap_html_element($html_email);
        } else {
            //KEEP FOR OLD EMAIL COMPATIBILITY
            // Extracts only the body part
            $x = strpos($html_email, '<body');
            if ($x) {
                $x = strpos($html_email, '>', $x);
                $y = strpos($html_email, '</body>');
                $html_email = substr($html_email, $x + 1, $y - $x - 1);
            }

            /* Cleans up uncorrectly stored newsletter bodies */
            $html_email = preg_replace('/<style\s+.*?>.*?<\\/style>/is', '', $html_email);
            $html_email = preg_replace('/<meta.*?>/', '', $html_email);
            $html_email = preg_replace('/<title\s+.*?>.*?<\\/title>/i', '', $html_email);
            $html_email = trim($html_email);
        }

        // Required since esc_html DOES NOT escape the HTML entities (apparently)
        $html_email = str_replace('&', '&amp;', $html_email);
        $html_email = str_replace('"', '&quot;', $html_email);
        $html_email = str_replace('<', '&lt;', $html_email);
        $html_email = str_replace('>', '&gt;', $html_email);

        return $html_email;
    }

    private static function _escape_markers(&$markers) {
        $markers[0] = str_replace('/', '\/', $markers[0]);
        $markers[1] = str_replace('/', '\/', $markers[1]);
    }

    /**
     * Using the data collected inside $controls (and submitted by a form containing the
     * composer fields), updates the email. The message body is completed with doctype,
     * head, style and the main wrapper.
     * 
     * @param TNP_Email $email
     * @param NewsletterControls $controls
     */
    static function update_email($email, $controls) {
        if (isset($controls->data['subject'])) {
            $email->subject = $controls->data['subject'];
        }

        // They should be only composer options
        foreach ($controls->data as $name => $value) {
            if (strpos($name, 'options_') === 0) {
                $email->options[substr($name, 8)] = $value;
            }
        }

        $email->editor = NewsletterEmails::EDITOR_COMPOSER;

        $email->message = self::get_html_open($email) . self::get_main_wrapper_open($email) .
                $controls->data['message'] . self::get_main_wrapper_close($email) . self::get_html_close($email);
    }

    /**
     * Prepares a controls object injecting the relevant fields from an email
     * which cannot be directly used by controls.
     * 
     * @param Newsletter $controls
     * @param TNP_Email $email
     */
    static function prepare_controls($controls, $email) {
        foreach ($email->options as $name => $value) {
            if (strpos($name, 'composer_') === 0) {
                $controls->data['options_' . $name] = $value;
            }
        }

        $controls->data['message'] = TNP_Composer::unwrap_email($email->message);
        $controls->data['subject'] = $email->subject;
    }

    /**
     * Extract inline edited post field from inline_edit_list[]
     *
     * @param array $inline_edit_list
     * @param string $field_type
     * @param int $post_id
     *
     * @return string
     */
    static function get_edited_inline_post_field($inline_edit_list, $field_type, $post_id) {

        foreach ($inline_edit_list as $edit) {
            if ($edit['type'] == $field_type && $edit['post_id'] == $post_id) {
                return $edit['content'];
            }
        }

        return '';
    }

    /**
     * Check if inline_edit_list[] have inline edit field for specific post
     *
     * @param array $inline_edit_list
     * @param string $field_type
     * @param int $post_id
     *
     * @return bool
     */
    static function is_post_field_edited_inline($inline_edit_list, $field_type, $post_id) {
        foreach ($inline_edit_list as $edit) {
            if ($edit['type'] == $field_type && $edit['post_id'] == $post_id) {
                return true;
            }
        }

        return false;
    }

    static function button($options, $prefix = 'button') {
        $b = '<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;">';
        $b .= '<tr>';
        $b .= '<td align="center" bgcolor="' . $options[$prefix . '_background'] . '" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px;background:' . $options[$prefix . '_background'] . '" valign="middle">';
        $b .= '<a href="' . $options[$prefix . '_url'] . '"';
        $b .= ' style="display:inline-block;background:' . $options[$prefix . '_background'] . ';color:' . $options[$prefix . '_font_color'] . ';font-family:' . $options[$prefix . '_font_family'] . ';font-size:' . $options[$prefix . '_font_size'] . 'px;font-weight:' . $options[$prefix . '_font_weight'] . ';line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px;mso-padding-alt:0px;border-radius:3px;"';
        $b .= ' target="_blank">';
        $b .= $options[$prefix . '_label'];
        $b .= '</a>';
        $b .= '</td></tr></table>';
        return $b;
    }

}
