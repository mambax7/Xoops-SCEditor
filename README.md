# XOOPS - SCEditor

[![Build Status](https://travis-ci.org/samclarke/SCEditor.png?branch=master)](https://travis-ci.org/samclarke/SCEditor)

## Intro

SCEditor is a WYSIWYG text editor BBCODE which in order to be light and combine all the features required in a professional BBCODE editor

For more information about the editor visit [sceditor.com](http://www.sceditor.com/)

At the moment the Integrated version support XOOPS Smily system and in the future the FileManager.

## Install

simply download the content of the repo in a folder named ```sceditor``` and put it in ```class\xoopseditor\```

Next step is to add some additional BBCodes to XOOPS to have all functions of the editor by replacing the file at ```class\textsanitizer\youtube\youtube.php``` with the one in ```Extra_BBCode```

Now head to the file ```class\module.textsanitizer.php``` and search for these lines

	$patterns[] = "/\[size=(['\"]?)([a-z0-9-]*)\\1](.*)\[\/size\]/sU";
    $replacements[] = '<span style="font-size: \\2;">\\3</span>';

and disable them by adding ```//``` before them, and add these lines after them

	    // sceditor
        $patterns[] = "/\[color=#(['\"]?)([a-zA-Z0-9]*)\\1](.*)\[\/color\]/sU";
        $replacements[] = '<span style="color: #\\2;">\\3</span>';
        $patterns[] = "/\[size=(['\"]?)([a-z-]*)\\1](.*)\[\/size\]/sU";
        $replacements[] = '<span style="font-size: \\2;">\\3</span>';
        $patterns[] = "/\[size=(['\"]?)([0-9]*)\\1](.*)\[\/size\]/sU";
        $replacements[] = '<font size="\\2">\\3</font>';
        $patterns[] = "/\[justify](.*)\[\/justify\]/sU";
        $replacements[] = '<div style="text-align: justify;">\\1</div>';
        $patterns[] = "/\[s](.*)\[\/s\]/sU";
        $replacements[] = '<del>\\1</del>';
        $patterns[] = "/\[sub](.*)\[\/sub\]/sU";
        $replacements[] = '<sub>\\1</sub>';
        $patterns[] = "/\[sup](.*)\[\/sup\]/sU";
        $replacements[] = '<sup>\\1</sup>';
        $patterns[] = "/\[hr]/sU";
        $replacements[] = '<hr/>';
        $patterns[] = "/\[email=(['\"]?)([^'\"<>]*)\\1](.*)\[\/email\]/sU";
        $replacements[] = '<a href="mailto:\\2" title="\\2">\\2</a>';
        $patterns[] = "/\[ol](.*)\[\/ol\]/sU";
        $replacements[] = '<ol>\\1</ol>';
        $patterns[] = "/\[table](.*)\[\/table\]/sU";
        $replacements[] = '<table style="width:auto;margin:0 auto">\\1</table>';
        $patterns[] = "/\[tr](.*)\[\/tr\]/sU";
        $replacements[] = '<tr>\\1</tr>';
        $patterns[] = "/\[td](.*)\[\/td\]/sU";
        $replacements[] = '<td>\\1</td>';

and that's it ;)

## Options

See the documentation of the editor here [options page](http://www.sceditor.com/documentation/options/) for a full list of options.

The lang, rtl and fonts options are changable at the Language files at ```class\xoopseditor\sceditor\language\``` and for a more control over the options at the call head at ```class\xoopseditor\sceditor\formsceditor.php```



## Donate

If you would like to make a donation to the editor project you can via
[PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=AVJSF5NEETYYG)
or via [Flattr](http://flattr.com/thing/400345/SCEditor)


