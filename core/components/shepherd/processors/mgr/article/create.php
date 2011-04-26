<?php

if(empty($scriptProperties['title']))
  $modx->error->addField('title', $modx->lexicon('shepherd.article_err_ns_title'));
else {
  $criteria = array(
    'title' => $scriptProperties['title']
  );
  if($modx->getObject('Article', $criteria))
    $modx->error->addField('title',$modx->lexicon('shepherd.article_err_ae'));
}
 
if($modx->error->hasError())
  return $modx->error->failure();
 
$article = $modx->newObject('Article');
$article->fromArray($scriptProperties);
 
if ($article->save() == false)
  return $modx->error->failure($modx->lexicon('shepherd.article_err_save'));
 
return $modx->error->success('', $article);