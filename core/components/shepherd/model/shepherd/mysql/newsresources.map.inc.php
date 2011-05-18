<?php
$xpdo_meta_map['NewsResources']= array (
  'package' => 'shepherd',
  'table' => 'shepherd_news_items_to_resources',
  'fields' => 
  array (
    'news_item_id' => NULL,
    'resource_id' => NULL,
  ),
  'fieldMeta' => 
  array (
    'news_item_id' => 
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
    'NewsItems' => 
    array (
      'class' => 'NewsItem',
      'local' => 'news_item_id',
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
