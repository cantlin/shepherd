<?php

if(empty($scriptProperties['id']))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_ns'));

$article = $modx->getObject('Article',$scriptProperties['id']);

if(empty($article))
  return $modx->error->failure($modx->lexicon('shepherd.article_err_nf'));
 
$article->fromArray($scriptProperties);
 
if($article->save() == false)
  return $modx->error->failure($modx->lexicon('articles.article_err_save'));

$sql = "SELECT resource_id AS id FROM modx_shepherd_articles_to_resources " .
       "WHERE article_id = " . $article->getPrimaryKey();

if(!$query = $modx->db->query($sql))
  error_log(var_dump($modx->db->getLastError()));

$related_to_from_form = (isset($scriptProperties['related_to'])) ? $scriptProperties['related_to'] : array();
$related_to_from_db = array();

while($row = $modx->db->getRow($query))
  $related_to_from_db[] = $row['id'];

foreach($related_to_from_db as $val) {  
  if(!in_array($val, $related_to_from_form)) {

    // A prior association is not in the array of submitted values, remove it

    $sql = "DELETE FROM modx_shepherd_articles_to_resources " .
           "WHERE article_id = " . $article->getPrimaryKey() . " AND resource_id = " . $val;
  
    if(!$query = $modx->db->query($sql))
      error_log($sql);

  } else error_log($val . ' was in ' . implode(',', $related_to_from_db));
}

foreach($related_to_from_form as $val) {
  if(!in_array($val, $related_to_from_db)) {

    // A submitted value is not in the array of prior associations, add it

    $sql = "INSERT INTO modx_shepherd_articles_to_resources " .
           "(article_id, resource_id) " .
           "VALUES " .
           "(" . $article->getPrimaryKey() . ", " . $val . ")";

    if(!$query = $modx->db->query($sql))
      error_log($sql);

  } else error_log($val . ' was in ' . implode(',', $related_to_from_form));
}

return $modx->error->success('', $article);