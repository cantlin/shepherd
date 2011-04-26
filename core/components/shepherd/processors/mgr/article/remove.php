<?php

if(empty($scriptProperties['id']))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_ns'));

$article = $modx->getObject('Article', $scriptProperties['id']);

if(empty($article))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_nf'));
 
if($article->remove() == false)
  return $modx->error->failure($modx->lexicon('shepherd.article_err_remove'));
 
return $modx->error->success('', $article);