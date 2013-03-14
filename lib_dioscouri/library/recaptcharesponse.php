<?php
defined('_JEXEC') or die('Restricted access');

/**
 * A DSCRecaptchaResponse is returned from recaptcha_check_answer()
 */
class DSCRecaptchaResponse extends JObject
{
        var $is_valid;
        var $error;
}