<?php

// Register ExtJs Extensions

$modx->regClientStartupScript($modx->config['assets_url'].'components/tinymce/jscripts/tiny_mce/tiny_mce.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'tiny_mce.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/ext/Ext.ux.TinyMCE.min.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/ext/SuperBoxSelect/SuperBoxSelect.js');

// Register CSS

$modx->regClientCSS($shepherd->config['cssUrl'].'shepherd.css');
$modx->regClientCSS($shepherd->config['cssUrl'].'superboxselect-gray-extend.css');

// Register Namespace

$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/shepherd.js');

// Make class config available to scripts, set up TinyMCE

$modx->regClientStartupHTMLBlock(
'<script type="text/javascript">
Ext.onReady(function() {
    Shepherd.config = '.$modx->toJSON($shepherd->config).';
    Shepherd.config.tinymce = {
	theme : "advanced",
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|"
	  + ",justifyleft,justifycenter,justifyright,justifyfull,|,"
	  + ",formatselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|"
	  + ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|"
	  + ",undo,redo,|,link,unlink,anchor,image,cleanup,code,|"
	  + ",insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3: "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
	extended_valid_elements : "a[name|href|target|title|onclick]"
	  + ",img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]"
	  + ",hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	template_external_list_url : "template_list.js",
	accessibility_focus : false
    }
});
</script>'
);

// Done

return;