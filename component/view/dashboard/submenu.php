<?php 
defined('_JEXEC') or die('Restricted access');
JHTML::_('stylesheet', 'menu.css', 'media/com_amigos/css/');
?>

<div id="<?php echo $this->name; ?>" class="submenu">


<?php 
foreach ($this->items as $item) {
    
    if ($this->hide) {
        
        if ($item[2] == 1) {
        ?>  <span class="nolink active"><?php echo $item[0]; ?></span> <?php
        } else {
        ?>  <span class="nolink"><?php echo $item[0]; ?></span> <?php    
        }
        
    } else {
        
        if ($item[2] == 1) {
        ?> <a class="active" href="<?php echo $item[1]; ?>"><?php echo $item[0]; ?></a> <?php
        } else {
        ?> <a href="<?php echo $item[1]; ?>"><?php echo $item[0]; ?></a> <?php   
        }        
    }
    
}
?>

</div>