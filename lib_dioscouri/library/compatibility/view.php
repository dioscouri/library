<?php

defined('_JEXEC') or die ;

jimport('joomla.application.component.view');

if (version_compare(JVERSION, '3.0', 'ge'))
{
    class DSCViewBase extends JViewLegacy
    {
    }

}
else
{
    class DSCViewBase extends JView
    {
    }

}
