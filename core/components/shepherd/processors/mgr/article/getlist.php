<?php
function getRelatedTo($id, $parent = null, $template = null, $delim = ', ') {
  global $modx;

  $sql = "SELECT satr.resource_id, sc.pagetitle " .
         "FROM modx_shepherd_articles_to_resources AS satr " .
         "JOIN modx_site_content AS sc ON satr.resource_id = sc.id";

  if(!is_null($parent))
    $sql .= " AND sc.parent IN (" . $parent . ")";
   
  if(!is_null($template))
    $sql .= " AND sc.template IN (" . $template . ")";

  $sql .= " WHERE article_id = " . $id;

  $query = $modx->db->query($sql);

  $o = array();

  while($row = $modx->db->getRow($query)) {
    $o['titles'][] = $row['pagetitle'];
    $o['ids'][] = $row['resource_id'];
  }

  if(!empty($o)) {
    $o['ids'] = implode(',', $o['ids']);
    $o['titles'] = implode(', ', $o['titles']);
  }

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

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);

$count = $modx->getCount('Article',$c);

$articles = $modx->getIterator('Article', $c);
$list = array();
$i = 0;

foreach ($articles as $article) {
  $i++;
  $related = getRelatedTo($article->getPrimaryKey(), '123,124');
  $people = getRelatedTo($article->getPrimaryKey(), null, '2');

  $list[] = array_merge(
      $article->toArray(),
      array(
	    'related_to' => $related['titles'],
	    'contacts' => $people['titles'],
    	    'related_ids' => $related['ids'] . ',' . $people['ids']
	    )
      );
}

return $this->outputArray($list,$count);