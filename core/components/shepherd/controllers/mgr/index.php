<?php

// Stores

$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/stores.js');

// Widgets

$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/widgets/articles.grid.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/widgets/news.grid.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/widgets/home.panel.js');

// Sections

$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/sections/index.js');

return '<div id="shepherd-panel-home-div"></div>';