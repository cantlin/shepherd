<?php
$xpdo_meta_map['Article']= array (
  'package' => 'shepherd',
  'table' => 'articles',
  'fields' => 
  array (
    'title' => '',
    'content' => '',
    'createdon' => NULL,
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
    'createdon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
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
  'aggregates' => 
  array (
    'CreatedBy' => 
    array (
      'class' => 'modUser',
      'local' => 'createdby',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Related' => 
    array (
      'class' => 'modDocument',
      'local' => 'related',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
