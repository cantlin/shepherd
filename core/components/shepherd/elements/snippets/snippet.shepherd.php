<?php

$defaultShepherdCorePath = $modx->getOption('core_path').'components/shepherd/';
$shepherdCorePath = $modx->getOption('shepherd.core_path', null, $defautShepherdCorePath);

$shepherd = $modx->getService('shepherd', 'Shepherd', $shepherdCorePath.'model/shepherd/', $scriptProperties);

if (!($shepherd instanceof Shepherd))
   return;

$tpl = $modx->getOption('tpl', $scriptProperties, 'rowTpl');
$sort = $modx->getOption('sort', $scriptProperties, 'title');
$dir = $modx->getOption('dir', $scriptProperties, 'ASC');
$limit = $modx->getOption('limit', $scriptProperties, '10');

/* build query */
$c = $modx->newQuery('Article');
$count = $modx->getCount('Article',$c);
$c->sortby($sort,$dir);
//if ($isLimit) $c->limit($limit,$start);
$c->limit($limit);
$articles = $modx->getIterator('Article', $c);

$output = '';

foreach($articles as $article)
  $output .= $shepherd->getChunk($tpl, $article->toArray());

return $output;