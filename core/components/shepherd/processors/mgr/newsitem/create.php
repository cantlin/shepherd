<?php

if(empty($scriptProperties['title']))
  $modx->error->addField('title', $modx->lexicon('shepherd.newsitem_err_ns_title'));

if($modx->error->hasError())
  return $modx->error->failure();

$related_to = (isset($scriptProperties['related_to'])) ? $scriptProperties['related_to'] : array();
unset($scriptProperties['related_to']);
 
$newsitem = $modx->newObject('NewsItem');
$newsitem->fromArray($scriptProperties);

if ($newsitem->save() == false)
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_save'));

$new_news_item_id = $newsitem->get('id');

foreach($related_to as $resource_id) {

  $sql = "INSERT INTO modx_shepherd_news_items_to_resources " .
         "(news_item_id, resource_id) " .
         "VALUES " .
         "($new_news_item_id, $resource_id)";

  if(!$modx->db->query($sql))
    error_log('Could not add map for news_item_id \'' . $new_news_item_id . '\' to resource_id \'' . $resource_id . '\'');

}

return $modx->error->success('', $newsitem);