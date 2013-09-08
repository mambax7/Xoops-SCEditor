<?php
/**
 * TextSanitizer extension
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         class
 * @subpackage      textsanitizer
 * @since           2.3.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: youtube.php 8066 2011-11-06 05:09:33Z beckmi $
 */

class MytsYoutube extends MyTextSanitizerExtension
{
    function encode($textarea_id)
    {
        $config = parent::loadConfig( dirname(__FILE__) );
        $code = "<img src='{$this->image_path}/youtube.gif' alt='" . _XOOPS_FORM_ALTYOUTUBE . "' onclick='xoopsCodeYoutube(\"{$textarea_id}\",\"" . htmlspecialchars(_XOOPS_FORM_ENTERYOUTUBEURL, ENT_QUOTES) . "\",\"" . htmlspecialchars(_XOOPS_FORM_ALT_ENTERHEIGHT, ENT_QUOTES) . "\",\"" . htmlspecialchars(_XOOPS_FORM_ALT_ENTERWIDTH, ENT_QUOTES) . "\");'  onmouseover='style.cursor=\"hand\"'/>&nbsp;";
        $javascript = <<<EOH
            function xoopsCodeYoutube(id, enterFlashPhrase, enterFlashHeightPhrase, enterFlashWidthPhrase)
            {
                var selection = xoopsGetSelect(id);
                if (selection.length > 0) {
                    var text = selection;
                } else {
                    var text = prompt(enterFlashPhrase, "");
                }
                var domobj = xoopsGetElementById(id);
                if ( text.length > 0 ) {
                    var text2 = prompt(enterFlashWidthPhrase, "425");
                    var text3 = prompt(enterFlashHeightPhrase, "350");
                    var result = "[youtube="+text2+","+text3+"]" + text + "[/youtube]";
                    xoopsInsertText(domobj, result);
                }
                domobj.focus();
            }
EOH;

        return array($code, $javascript);
    }

    function load(&$ts)
    {
        $ts->patterns[] = "/\[youtube([^\"]*)\]([^\"]*)\[\/youtube\]/esU";
        $ts->replacements[] = __CLASS__ . "::decode( '\\2' )";
    }

    function decode($url)
    {        
    
        if (preg_match("/^http:\/\/(www\.)?youtube\.com\/watch\?v=(.*)/i", $url, $matches)) {
            $src = "//www.youtube.com/v/" . $matches[2];
        }else{
            $src = "//www.youtube.com/v/" . $url; 
        }

        $code = "<object width='420' height='315'>";
        $code.= "<param name='movie' value='{$src}?version=3'></param>";
        $code.= "<param name='allowFullScreen' value='true'></param>";
        $code.= "<param name='allowscriptaccess' value='always'></param>";
        $code.= "<embed src='{$src}?version=3'";
        $code.= "type='application/x-shockwave-flash'";
        $code.= "width='420'";
        $code.= "height='315'";
        $code.= "allowscriptaccess='always'";
        $code.= "allowfullscreen='true'>";
        $code.= "</embed>";
        $code.= "</object>";
        
        return $code;
    }
}
?>