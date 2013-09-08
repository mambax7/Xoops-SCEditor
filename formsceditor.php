<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 *  SCEditor adapter for XOOPS
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         class
 * @subpackage      editor
 * @since           2.5.6
 * @author          Michael Beck <mambax7@gmail.com>
 * @version         $Id: formtinymce.php 8066 2011-11-06 05:09:33Z beckmi $
 */

xoops_load('XoopsEditor');

class XoopsFormSceditor extends XoopsEditor
{
    var $language = _LANGCODE;
    var $width;
    var $height;
//    var $editor;

    function __construct($configs)
    {
        $current_path = __FILE__;
        if ( DIRECTORY_SEPARATOR != "/" ) {
            $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
        }
        $this->rootPath = "/class/xoopseditor/sceditor";
        parent::__construct($configs);
        $this->width = $configs['width'];
        $this->height = $configs['height'];
        $this->setLanguage(_XOOPS_EDITOR_SCEDITOR_LANGUAGE);
    }
    function getName()
    {
        return $this->name;
    }
    function setName($value)
    {
        $this->name = $value;
    }
    /**
     * get textarea width
     *
     * @return  string
     */
    function getWidth()
    {
        return $this->width;
    }
    /**
     * get textarea height
     *
     * @return  string
     */
    function getHeight()
    {
        return $this->height;
    }
    /**
     * get language
     *
     * @return  string
     */
    function getLanguage()
    {
        return str_replace('_','-',strtolower($this->language));
    }
    /**
     * set language
     *
     * @return  null
     */
    function setLanguage($lang='en')
    {
        $this->language = $lang;
    }

    /**
     * Renders the Javascript function needed for client-side for validation
     *
     * @return    string
     */
    function renderValidationJS()
    {
        if ($this->isRequired() && $eltname = $this->getName()) {
            $eltcaption = $this->getCaption();
            $eltmsg = empty($eltcaption) ? sprintf( _FORM_ENTER, $eltname ) : sprintf( _FORM_ENTER, $eltcaption );
            $eltmsg = str_replace('"', '\"', stripslashes( $eltmsg ) );
            $ret = "\n";
            $ret.= "if ( tinyMCE.get('{$eltname}').getContent() == \"\" || tinyMCE.get('{$eltname}').getContent() == null)";
            $ret.= "{ window.alert(\"{$eltmsg}\"); myform.{$eltname}.focus(); return false; }";
            return $ret;
            }
        return '';
    }
    /**
     * prepare HTML for output
     *
     * @return  sting HTML
     */
    function render()
    {
      static $isJsLoaded = false;
      $this->rootPath = "/class/xoopseditor/sceditor/sceditor";
      $ret = "\n";
      if(!$isJsLoaded)
      {
        $GLOBALS['xoTheme']->addStylesheet( XOOPS_URL . $this->rootPath . '/minified/themes/default.min.css', array('type'=>'text/css', 'media'=>'all') );
        $GLOBALS['xoTheme']->addScript('browse.php?Frameworks/jquery/jquery.js');
        $GLOBALS['xoTheme']->addScript( XOOPS_URL . $this->rootPath . '/minified/jquery.sceditor.bbcode.min.js' );
        if($this->getLanguage() != 'en')
          $GLOBALS['xoTheme']->addScript( XOOPS_URL . $this->rootPath . '/languages/'.$this->getLanguage().'.js' );
        $isJsLoaded = true;
      }
      
      if(!_XOOPS_EDITOR_SCEDITOR_DIRECTION == "ltr"){
        $rtl = "false";
        $toolbar = "bold,italic,underline,strike,subscript,superscript|left,center,right,justify|font,size,color,removeformat|cut,copy,paste,pastetext|bulletlist,orderedlist|table|code,quote|horizontalrule,image,email,link,unlink|emoticon,youtube,date,time|ltr,rtl|print,maximize,source";
      }else{
        $rtl = "true";
        $toolbar = "bold,italic,underline,strike,subscript,superscript|right,center,left,justify|font,size,color,removeformat|cut,copy,paste,pastetext|bulletlist,orderedlist|table|code,quote|horizontalrule,image,email,link,unlink|emoticon,youtube,date,time|rtl,ltr|print,maximize,source";
      }
      
      $smilies_dropdown = '';
      $smilies_more = '';
      foreach(MyTextSanitizer::getInstance()->getSmileys() as $smily){
        if($smily['display'])
          $smilies_dropdown .= '"'.$smily['code'].'": "'.XOOPS_URL.'/uploads/'.$smily['smile_url'].'",';
        else
          $smilies_more .= '"'.$smily['code'].'": "'.XOOPS_URL.'/uploads/'.$smily['smile_url'].'",';
      }
      $ret.= "<script type='text/javascript'>\n";
      $ret.= "jQuery(document).ready(function(){\n";
			$ret.= "  $('#".$this->getName()."').sceditor({\n";
      $ret.= "    rtl : ".$rtl.",\n";
      $ret.= "    fonts : \""._XOOPS_EDITOR_SCEDITOR_FONTS."\",\n";
      $ret.= "    toolbar : \"".$toolbar."\",\n";
      $ret.= "    locale : '".$this->getLanguage()."',\n";
			$ret.= "    plugins: 'bbcode',\n";
			$ret.= "    style: '".XOOPS_URL . $this->rootPath . "/minified/jquery.sceditor.default.min.css',\n";
			$ret.= "    emoticons: {dropdown: {".rtrim($smilies_dropdown, ",")."},more: {".rtrim($smilies_more, ",")."}}\n";
			$ret.= "  });\n";
      $ret.= "});\n";
      $ret.= "</script>\n";

      $ret.= "<textarea class='".$this->getName()."' name='".$this->getName()."' id='".$this->getName()."' ".$this->getExtra()."style='width:".$this->getWidth().";height:".$this->getHeight().";'>" . $this->getValue() . "</textarea>";
         return $ret ;

    }
}
?>