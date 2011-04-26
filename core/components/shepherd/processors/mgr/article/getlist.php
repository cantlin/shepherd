<?php

$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'title');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');
 
$c = $modx->newQuery('Article');

if(!empty($query)) {
  $c->where(array(
    'title:LIKE' => '%'.$query.'%',
    'OR:content:LIKE' => '%'.$query.'%',
  ));
}

$count = $modx->getCount('Article',$c);

// $c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);

$articles = $modx->getIterator('Article', $c);
$list = array();

foreach ($articles as $article) {

  $article_array = $article->toArray();

  $list[] = array_merge(
		      $article_array,
		      array(
			    'content' => substr(strip_tags($article_array['content']), 0, 255)
			    )
		      );

}

return $this->outputArray($list,$count);