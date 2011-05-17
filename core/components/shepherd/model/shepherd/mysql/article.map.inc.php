<?php
$xpdo_meta_map['Article']= array (
  'package' => 'shepherd',
  'table' => 'shepherd_articles',
  'fields' => 
  array (
    'title' => '',
    'content' => '',
    'publication' => '',
    'createdon' => 'CURRENT_TIMESTAMP',
    'status' => 'Published',
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
    'publication' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
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
    'status' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'Promoted\',\'Published\',\'Hidden\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Published',
    ),
  ),
);
