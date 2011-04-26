<?php

function getSnippetContent($filename) {
  $o = file_get_contents($filename);
  $o = trim(str_replace(array('<?php','?>'),'',$o));
  return $o;
}

$snippets = array();

// snippet.shepherd.php
 
$snippet_attr = array(
      'id' => 1,
      'name' => 'Shepherd',
      'description' => 'Displays a list of Articles.',
      'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.shepherd.php')
);

$snippets[$snippet_attr['id']]= $modx->newObject('modSnippet');
$snippets[$snippet_attr['id']]->fromArray($snippet_attr, '', true, true);

// $properties = include $sources['data'].'properties/properties.shepherd.php';

// $snippets[$snippet_attr['id']]->setProperties($properties);
// unset($properties);

return $snippets;