<?php 
defined('_JEXEC') or die('Restricted access');
?>

<ul id="dsc_submenu" class="submenu">

<?php
if(version_compare(JVERSION,'1.6.0','ge')) {
$items = $menu->_menu->getItems();
} else {
	  //joomla 1.5 code
$items = $menu->_menu->_bar;
}
  
foreach ($items as $item) 
{
    ?>
    <li>
    <?php
    if ($hide) 
    {
        if ($item[2] == 1) {
        ?>  <span class="nolink active"><?php echo $item[0]; ?></span> <?php
        } else {
        ?>  <span class="nolink"><?php echo $item[0]; ?></span> <?php    
        }
        
    } 
        else 
    {
        if ($item[2] == 1) {
        ?> <a class="active" href="<?php echo $item[1]; ?>"><?php echo $item[0]; ?></a> <?php
        } else {
        ?> <a href="<?php echo $item[1]; ?>"><?php echo $item[0]; ?></a> <?php   
        }        
    }
    
    $names = explode( ' ', $item[0] );
    $name = strtolower( $names[0] );
    $submenu = DSCMenu::getInstance( 'submenu_' . $name, '1' );
    if(version_compare(JVERSION,'1.6.0','ge')) {
	//$menu->display();
$subitems = $submenu->_menu->getItems();
} else {
	  //joomla 1.5 code
$subitems = $submenu->_menu->_bar;
}
	
    if (!empty($submenu))
    {
        ?>
        <ul class="submenu_dropdown">
        <?php
        
        foreach ($subitems as $submenu_item)
        {
            ?>
            <li>
                <?php
                if ($submenu_item[2] == 1) {
                ?> <a class="active" href="<?php echo $submenu_item[1]; ?>"><?php echo $submenu_item[0]; ?></a> <?php
                } else {
                ?> <a href="<?php echo $submenu_item[1]; ?>"><?php echo $submenu_item[0]; ?></a> <?php   
                }                    
                ?>
            </li>
            <?php
        }
        ?>
        </ul>
        <?php
    }
    ?>
    </li>
    <?php
}
?>

</ul>


