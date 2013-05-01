<?php
/**
 * @package Dioscouri
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class DSCTemplateLESS
{
    function __construct($parent)
    {
        
        if ($parent->API->get('recompile_css', 0) == 1) {
            // remove old Template CSS files
            jimport('joomla.filesystem.file');
            JFile::delete($parent->API->URLtemplatepath() . '/css/global.css');
            JFile::delete($parent->API->URLtemplatepath() . '/css/default.css');
            JFile::delete($parent->API->URLtemplatepath() . '/css/print.css');
            JFile::delete($parent->API->URLtemplatepath() . '/css/mail.css');
            JFile::delete($parent->API->URLtemplatepath() . '/css/error.css');
            JFile::delete($parent->API->URLtemplatepath() . '/css/offline.css');
            JFile::delete($parent->API->URLtemplatepath() . '/css/override.css');
                        
            // generate new Template CSS files
            try {
                // normal Template code
                $less = new DSCTemplateHelperLessc;
                $less->checkedCompile($parent->API->URLtemplatepath() . '/less/global.less', $parent->API->URLtemplatepath() . '/css/global.css');
                $less->checkedCompile($parent->API->URLtemplatepath() . '/less/default.less', $parent->API->URLtemplatepath() . '/css/default.css');
                $less->checkedCompile($parent->API->URLtemplatepath() . '/less/print.less', $parent->API->URLtemplatepath() . '/css/print.css');
                $less->checkedCompile($parent->API->URLtemplatepath() . '/less/mail.less', $parent->API->URLtemplatepath() . '/css/mail.css');
                // additional Template code
                $less->checkedCompile($parent->API->URLtemplatepath() . '/less/error.less', $parent->API->URLtemplatepath() . '/css/error.css');
                $less->checkedCompile($parent->API->URLtemplatepath() . '/less/offline.less', $parent->API->URLtemplatepath() . '/css/offline.css');
                $less->checkedCompile($parent->API->URLtemplatepath() . '/less/override.less', $parent->API->URLtemplatepath() . '/css/override.css');
            }
            catch (exception $ex) {
                exit('LESS Parser fatal error:<br />' . $ex->getMessage());
            }
        }
    }
}
