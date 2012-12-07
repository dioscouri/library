<?php
defined('_JEXEC') or die ;

jimport('joomla.application.component.controller');

if (version_compare(JVERSION, '3.0', 'ge'))
{
    class DSCControllerBase extends JControllerLegacy
    {
        public function display($cachable = false, $urlparams = array())
        {
            parent::display($cachable, $urlparams);
        }

    }

}
else if (version_compare(JVERSION, '2.5', 'ge'))
{
    class DSCControllerBase extends JController
    {
        public function display($cachable = false, $urlparams = false)
        {
            parent::display($cachable, $urlparams);
        }

    }

}
else
{
    class DSCControllerBase extends JController
    {
        public function display($cachable = false)
        {
            parent::display($cachable);
        }

    }

}
