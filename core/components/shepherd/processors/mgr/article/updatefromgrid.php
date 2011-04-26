<?php

if(empty($scriptProperties['data']))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_id'));

$_DATA = $modx->fromJSON($scriptProperties['data']);

if(!is_array($_DATA))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_id'));
if(empty($_DATA['id']))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_ns'));

$article = $modx->getObject('Article',$_DATA['id']);

if(empty($article))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_nf'));
 
$article->fromArray($_DATA);
 
if($article->save() == false)
  return $modx->error->failure($modx->lexicon('shepherd.article_err_save'));
 
return $modx->error->success('',$article);