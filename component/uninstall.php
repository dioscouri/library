<?php defined( '_JEXEC' ) or die( 'Restricted access' );
// The following two lines must be defined in the component install.php file prior to including this file
//$thisextension = strtolower( "com_whatever" );
//$thisextensionname = substr ( $thisextension, 4 );

JLoader::import( 'dioscouri.library.dscinstaller', '/libraries/' );
$dscinstaller = new dscInstaller();
$dscinstaller->thisextension = $thisextension;
$dscinstaller->manifest = $this->manifest;

// load the component language file
$language = JFactory::getLanguage();
$language->load( $thisextension );

$status = new JObject();
$status->modules = array();
$status->plugins = array();
$status->templates = array();

// TODO Should list all the aux extensions from the install.XML file with a notice saying that each one is still installed
// and that if the user wants to completely remove component, must also uninstall all of them too
// and remove database tables
// Questions: do any of these files exist at this point?  when is the uninstall.php being run?

/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * MODULE UNINSTALLATION SECTION
 * ---------------------------------------------------------------------------------------------
 ***********************************************************************************************/

$modules = $dscinstaller->getElementByPath('modules');
if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) {

    foreach ($modules->children() as $module)
    {
        $mname      = $module->attributes('module');
        $mpublish   = $module->attributes('publish');
        $mposition  = $module->attributes('position');
        $mclient    = JApplicationHelper::getClientInfo($module->attributes('client'), true);
        
        $package    = array();
        $package['type'] = 'module';
        $package['group'] = '';
        $package['element'] = $mname;
        $package['client'] = $module->attributes('client');
                
        // Set the installation path
        if (!empty ($mname)) {
            $this->parent->setPath('extension_root', $mclient->path.DS.'modules'.DS.$mname);
        } else {
            $this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('Install Module File Missing'));
            return false;
        }
        
        /*
         * fire the dioscouriInstaller
         */
        $dscInstaller = new dscInstaller();
        $result = $dscInstaller->uninstallExtension($package);
        
        // track the message and status of installation from dscInstaller
        if ($result) 
        {
            $alt = JText::_( "Uninstalled" );
            $mstatus = "<img src='images/tick.png' border='0' alt='{$alt}' />";
        } 
            else 
        {
            $alt = JText::_( "Failed" );
            $error = $dscInstaller->getError();
            $mstatus = "<img src='images/publish_x.png' border='0' alt='{$alt}' />";
            $mstatus .= " - ".$error;
        }
        
        $status->modules[] = array('name'=>$mname,'client'=>$mclient->name, 'status'=>$mstatus );
    }
}

/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * PLUGIN INSTALLATION SECTION
 * ---------------------------------------------------------------------------------------------
 ***********************************************************************************************/

$plugins = $dscinstaller->getElementByPath('plugins');
if (is_a($plugins, 'JSimpleXMLElement') && count($plugins->children())) {

    foreach ($plugins->children() as $plugin)
    {
        $pname      = $plugin->attributes('plugin');
        $ppublish   = $plugin->attributes('publish');
        $pgroup     = $plugin->attributes('group');

        $package    = array();
        $package['type'] = 'plugin';
        $package['group'] = $pgroup;
        $package['element'] = $plugin->attributes('element');
        $package['client'] = '';
        
        // Set the installation path
        if (!empty($pname) && !empty($pgroup)) {
            $this->parent->setPath('extension_root', JPATH_ROOT.DS.'plugins'.DS.$pgroup);
        } else {
            $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Install Plugin File Missing'));
            return false;
        }
        
        /*
         * fire the dioscouriInstaller
         */
        $dscInstaller = new dscInstaller();
        $result = $dscInstaller->uninstallExtension($package);
        
        // track the message and status of installation from dscInstaller
        if ($result) 
        {
            $alt = JText::_( "Uninstalled" );
            $pstatus = "<img src='images/tick.png' border='0' alt='{$alt}' />"; 
        } 
            else 
        {
            $alt = JText::_( "Failed" );
            $error = $dscInstaller->getError();
            $pstatus = "<img src='images/publish_x.png' border='0' alt='{$alt}' /> ";
            $pstatus .= " - ".$error;   
        }

        $status->plugins[] = array('name'=>$pname,'group'=>$pgroup, 'status'=>$pstatus);
    }
}


/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * OUTPUT TO SCREEN
 * ---------------------------------------------------------------------------------------------
 ***********************************************************************************************/
 $rows = 0;
?>

<h2><?php echo JText::_('Uninstallation Results'); ?></h2>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo JText::_('Component'); ?></td>
			<td><center><strong><?php echo JText::_('Removed'); ?></strong></center></td>
		</tr>
<?php if (count($status->modules)) : ?>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Client'); ?></th>
			<th></th>
		</tr>
	<?php foreach ($status->modules as $module) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td class="key"><center><?php echo $module['status']; ?></center></td>
		</tr>
	<?php endforeach;
endif;

if (count($status->plugins)) : ?>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th><?php echo JText::_('Group'); ?></th>
			<th></th>
		</tr>
	<?php foreach ($status->plugins as $plugin) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
			<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
			<td class="key"><center><?php echo $plugin['status']; ?></center></td>
		</tr>
	<?php endforeach;
endif; ?>
	</tbody>
</table>