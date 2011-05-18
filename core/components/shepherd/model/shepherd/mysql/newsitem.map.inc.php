<?php
$xpdo_meta_map['NewsItem']= array (
  'package' => 'shepherd',
  'table' => 'shepherd_news_items',
  'fields' => 
  array (
    'title' => '',
    'content' => '',
    'createdon' => 'CURRENT_TIMESTAMP',
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'content' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'createdon' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'default' => 'CURRENT_TIMESTAMP',
      'null' => true,
    ),
  ),
);
