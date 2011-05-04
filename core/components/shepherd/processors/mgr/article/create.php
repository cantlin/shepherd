<?php

if(empty($scriptProperties['title']))
  $modx->error->addField('title', $modx->lexicon('shepherd.article_err_ns_title'));

/* else {
  $criteria = array(
    'title' => $scriptProperties['title']
  );
  if($modx->getObject('Article', $criteria))
    $modx->error->addField('title',$modx->lexicon('shepherd.article_err_ae'));
} */

if($modx->error->hasError())
  return $modx->error->failure();

$sectors = (isset($scriptProperties['sectors'])) ? $scriptProperties['sectors'] : array();
$practice_areas = (isset($scriptProperties['practice_areas'])) ? $scriptProperties['practice_areas'] : array();
unset($scriptProperties['practice_areas'], $scriptProperties['sectors']);
 
$article = $modx->newObject('Article');
$article->fromArray($scriptProperties);

if ($article->save() == false)
  return $modx->error->failure($modx->lexicon('shepherd.article_err_save'));

$new_article_id = $article->get('id');

foreach(array_merge($sectors, $practice_areas) as $resource_id => $v) {

  $sql = "INSERT INTO modx_shepherd_articles_to_resources " .
         "(article_id, resource_id) " .
         "VALUES " .
         "($new_article_id, $resource_id)";

  if(!$modx->db->query($sql))
    error_log('Could not add map for article_id \'' . $new_article_id . '\' to resource_id \'' . $resource_id . '\'');

}

return $modx->error->success('', $article);