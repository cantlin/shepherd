<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('shepherd.core_path',null,$modx->getOption('core_path').'components/shepherd/');

require_once $corePath.'model/shepherd/shepherd.class.php';
$modx->shepherd = new Shepherd($modx);

$modx->lexicon->load('shepherd:default');
print_r($modx->shepherd->config); 
/* handle request */
$path = $modx->getOption('processorsPath',$modx->shepherd->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));