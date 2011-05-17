<?php

$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'title');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');
$parent = $modx->getOption('parent', $scriptProperties);
$template = $modx->getOption('template', $scriptProperties);

$target = 'modResource';

$c = $modx->newQuery($target);

$whereArray = array();

if($parent)
  $whereArray['parent'] = $parent;
  
if($template)
  $whereArray['template'] = $template;

if(!empty($whereArray))
  $c->where($whereArray);

$count = $modx->getCount($target, $c);

$authors = $modx->getIterator($target, $c);

$list = array();

foreach ($authors  as $author) {

  $list[] = $author->toArray();

}

return $this->outputArray($list,$count);