<?php

// Register ExtJs Extensions

$modx->regClientStartupScript($modx->config['assets_url'].'components/tinymce/jscripts/tiny_mce/tiny_mce.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'tiny_mce.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/ext/Ext.ux.TinyMCE.min.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/ext/SuperBoxSelect/SuperBoxSelect.js');

// Register CSS

$modx->regClientCSS($shepherd->config['cssUrl'].'shepherd.css');
$modx->regClientCSS($shepherd->config['jsUrl'].'mgr/ext/SuperBoxSelect/superboxselect-gray-extend.css');

// Register Namespace

$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/shepherd.js');

// Make class config available to scripts

$modx->regClientStartupHTMLBlock(
'<script type="text/javascript">
Ext.onReady(function() {
    Shepherd.config = '.$modx->toJSON($shepherd->config).';
});
</script>'
);

// Done

return;