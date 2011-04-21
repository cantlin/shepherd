<?php

$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/shepherd.js');

$modx->regClientStartupHTMLBlock(
'<script type="text/javascript">
Ext.onReady(function() {
    Shepherd.config = '.$modx->toJSON($shepherd->config).';
});
</script>'
);

return;