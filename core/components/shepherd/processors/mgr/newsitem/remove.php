<?php

if(empty($scriptProperties['id']))
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_ns'));

$newsitem = $modx->getObject('NewsItem', $scriptProperties['id']);

if(empty($newsitem))
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_nf'));
 
if($newsitem->remove() == false)
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_remove'));

$sql = "DELETE FROM modx_shepherd_news_items_to_resources " .
       "WHERE news_item_id = " . $scriptProperties['id'];
  
if(!$query = $modx->db->query($sql))
  error_log($sql);
 
return $modx->error->success('', $newsitem);