<?php
$xpdo_meta_map['ArticlesResources']= array (
  'package' => 'shepherd',
  'table' => 'shepherd_articles_to_resources',
  'fields' => 
  array (
    'article_id' => NULL,
    'resource_id' => NULL,
  ),
  'fieldMeta' => 
  array (
    'article_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
    'resource_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
  ),
  'aggregates' => 
  array (
    'Articles' => 
    array (
      'class' => 'Article',
      'local' => 'article_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Resources' => 
    array (
      'class' => 'modResource',
      'local' => 'resource_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
