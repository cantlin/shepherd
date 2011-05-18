<?php

if(empty($scriptProperties['id']))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_ns'));

$article = $modx->getObject('Article', $scriptProperties['id']);

if(empty($article))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_nf'));
 
if($article->remove() == false)
  return $modx->error->failure($modx->lexicon('shepherd.article_err_remove'));
 
$sql = "DELETE FROM modx_shepherd_news_items_to_resources " .
       "WHERE news_item_id = " . $scriptProperties['id'];
  
if(!$query = $modx->db->query($sql))
  error_log($sql);

return $modx->error->success('', $article);