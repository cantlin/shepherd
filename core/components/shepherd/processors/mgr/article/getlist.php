<?php

function getRelatedTo($id, $delim = ', ') {
 global $modx;

 $sql = "SELECT satr.resource_id, sc.pagetitle " .
         "FROM modx_shepherd_articles_to_resources AS satr " .
         "JOIN modx_site_content AS sc ON satr.resource_id = sc.id " .
         "WHERE article_id = " . $id;

 $query = $modx->db->query($sql);

 $o = array();

 while($row = $modx->db->getRow($query)) {
   $o['titles'][] = $row['pagetitle'];
   $o['ids'][] = $row['resource_id'];
 }

 $o['ids'] = implode(',', $o['ids']);
 $o['titles'] = implode(', ', $o['titles']);

 return $o;    
}

$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'status');
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

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);

$articles = $modx->getIterator('Article', $c);
$list = array();

foreach ($articles as $article) {

  $author = $modx->getObject('modResource', $article->author_id);
  $related = getRelatedTo($article->getPrimaryKey());

  $list[] = array_merge(
      $article->toArray(),
      array(
	    'author' => reset(explode(' (', $author->pagetitle)),
	    'related_to' => $related['titles'],
    	    'related_ids' => $related['ids']
	    )
      );
}

return $this->outputArray($list,$count);