<?php
/**
 *  SCEditor adapter for XOOPS
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         class
 * @subpackage      editor
 * @since           2.3.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: editor_registry.php 8066 2011-11-06 05:09:33Z beckmi $
 */

return $config = array(
        "name"      =>  "sceditor",
        "class"     =>  "XoopsFormSCEditor",
        "file"      =>  XOOPS_ROOT_PATH . "/class/xoopseditor/sceditor/formsceditor.php",
        "title"     =>  _XOOPS_EDITOR_SCEDITOR,
        "order"     =>  2,
        "nohtml"    =>  0
    );
?>
