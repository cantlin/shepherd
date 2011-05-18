<?php

if(empty($scriptProperties['id']))
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_ns'));

$newsitem = $modx->getObject('NewsItem',$scriptProperties['id']);

if(empty($newsitem))
  return $modx->error->failure($modx->lexicon('shepherd.newsitem_err_nf'));
 
$newsitem->fromArray($scriptProperties);
 
if($newsitem->save() == false)
  return $modx->error->failure($modx->lexicon('newsitems.newsitem_err_save'));

$sql = "SELECT resource_id AS id FROM modx_shepherd_news_items_to_resources " .
       "WHERE news_item_id = " . $newsitem->getPrimaryKey();

if(!$query = $modx->db->query($sql))
  error_log(var_dump($modx->db->getLastError()));

$related_to_from_form = (isset($scriptProperties['related_to'])) ? $scriptProperties['related_to'] : array();
$related_to_from_db = array();

while($row = $modx->db->getRow($query))
  $related_to_from_db[] = $row['id'];

foreach($related_to_from_db as $val) {
  if(!in_array($val, $related_to_from_form)) {

    // A prior association is not in the array of submitted values, remove it

    $sql = "DELETE FROM modx_shepherd_news_items_to_resources " .
           "WHERE news_item_id = " . $newsitem->getPrimaryKey() . " AND resource_id = " . $val;
  
    if(!$query = $modx->db->query($sql))
      error_log($sql);

  }
}

foreach($related_to_from_form as $val) {
  if(!in_array($val, $related_to_from_db)) {

    // A submitted value is not in the array of prior associations, add it

    $sql = "INSERT INTO modx_shepherd_news_items_to_resources " .
           "(news_item_id, resource_id) " .
           "VALUES " .
           "(" . $newsitem->getPrimaryKey() . ", " . $val . ")";

    if(!$query = $modx->db->query($sql))
      error_log($sql);

  }
}

return $modx->error->success('', $newsitem);