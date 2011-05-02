<?php

$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'title');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');

$target = 'modResource';

$c = $modx->newQuery($target);

$c->where(array(
   'parent' => 10
));

$count = $modx->getCount($target, $c);

$authors = $modx->getIterator($target, $c);

$list = array();

foreach ($authors  as $author) {

  $authorArray = $author->toArray();
  $authorArray['pagetitle'] = reset(explode(' (', $authorArray['pagetitle']));
  $list[] = $authorArray;

}

return $this->outputArray($list,$count);