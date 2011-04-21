<?php

$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'title');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
 
/* build query */
$c = $modx->newQuery('Article');
$count = $modx->getCount('Article',$c);
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$articles = $modx->getIterator('Article', $c);

/* iterate */
$list = array();
foreach ($articles as $article) {
  $articleArray = $article->toArray();
  $list[]= $articleArray;
}

return $this->outputArray($list,$count);