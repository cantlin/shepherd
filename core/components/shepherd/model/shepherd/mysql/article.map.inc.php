<?php
$xpdo_meta_map['Article']= array (
  'package' => 'shepherd',
  'table' => 'shepherd_articles',
  'fields' => 
  array (
    'title' => '',
    'content' => '',
    'createdon' => 'CURRENT_TIMESTAMP',
    'status' => 'Published',
    'author_id' => NULL,
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
    'status' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'Promoted\',\'Published\',\'Hidden\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Published',
    ),
    'author_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
  ),
  'aggregates' => 
  array (
    'Author' => 
    array (
      'class' => 'modResource',
      'local' => 'author_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
