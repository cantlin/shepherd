<?php

if(empty($scriptProperties['id']))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_ns'));

$article = $modx->getObject('Article',$scriptProperties['id']);

if(empty($article))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_nf'));
 
$article->fromArray($scriptProperties);
 
if($article->save() == false)
  return $modx->error->failure($modx->lexicon('articles.article_err_save'));
 
return $modx->error->success('', $article);