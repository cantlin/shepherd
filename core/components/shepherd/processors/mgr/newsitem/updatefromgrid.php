<?php

if(empty($scriptProperties['data']))
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_id'));

$_DATA = $modx->fromJSON($scriptProperties['data']);

if(!is_array($_DATA))
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_id'));
if(empty($_DATA['id']))
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_ns'));

$newsitem = $modx->getObject('NewsItem', $_DATA['id']);

if(empty($newsitem))
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_nf'));
 
$newsitem->fromArray($_DATA);
 
if($newsitem->save() == false)
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_save'));
 
return $modx->error->success('', $newsitem);