<?php
defined('_JEXEC') or die ;

jimport('joomla.application.component.model');

if (version_compare(JVERSION, '3.0', 'ge'))
{
    class DSCModelBase extends JModelLegacy
    {
        public static function addIncludePath($path = '', $prefix = '')
        {
            return parent::addIncludePath($path, $prefix);
        }

    }

}
else if (version_compare(JVERSION, '2.5', 'ge'))
{
    class DSCModelBase extends JModel
    {
        public static function addIncludePath($path = '', $prefix = '')
        {
            return parent::addIncludePath($path, $prefix);
        }

    }

}
else
{
    class DSCModelBase extends JModel
    {
        public function addIncludePath($path = '', $prefix = '')
        {
            return parent::addIncludePath($path);
        }

    }

}
