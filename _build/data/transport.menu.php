<?php

$action= $modx->newObject('modAction');
$action->fromArray(array(
	 'id' => 1,
	 'namespace' => 'shepherd',
	 'parent' => 0,
	 'controller' => 'controllers/index',
	 'haslayout' => true,
	 'lang_topics' => 'shepherd:default',
	 'assets' => '',
), '', true, true);
 
$menu= $modx->newObject('modMenu');
$menu->fromArray(array(
       'text' => 'shepherd',
       'parent' => 'components',
       'description' => 'shepherd.desc',
       'icon' => 'images/icons/plugin.gif',
       'menuindex' => 0,
       'params' => '',
       'handler' => '',
), '', true, true);

$menu->addOne($action);
unset($menus);
 
return $menu;