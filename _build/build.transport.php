<?php

$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);
 
define('PKG_NAME', 'Shepherd');
define('PKG_NAME_LOWER', 'shepherd');
define('PKG_VERSION', '0.24');
define('PKG_RELEASE', 'alpha');
 
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
	 'root' => $root,
	 'build' => $root . '_build/',
	 'data' => $root . '_build/data/',
	 'resolvers' => $root . '_build/resolvers/',
	 'chunks' => $root.'core/components/'.PKG_NAME_LOWER.'/chunks/',
	 'lexicon' => $root . 'core/components/'.PKG_NAME_LOWER.'/lexicon/',
	 'docs' => $root.'core/components/'.PKG_NAME_LOWER.'/docs/',
	 'elements' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/',
	 'source_assets' => $root.'assets/components/'.PKG_NAME_LOWER,
	 'source_core' => $root.'core/components/'.PKG_NAME_LOWER,
);
unset($root);
 
require_once $sources['build'] . 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
 
$modx= new modX();
$modx->initialize('mgr');

$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

echo '<pre>';

$modx->loadClass('transport.modPackageBuilder','',false, true);

$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');

$category= $modx->newObject('modCategory');
$category->set('id', 1);
$category->set('category', PKG_NAME);

$modx->log(modX::LOG_LEVEL_INFO,'Packaging in snippets...');
$snippets = include $sources['data'].'transport.snippets.php';

if(empty($snippets))
  $modx->log(modX::LOG_LEVEL_ERROR,'Could not package in snippets.');

$category->addMany($snippets);
 
$snippet_vehicle_attr = array(
      xPDOTransport::UNIQUE_KEY => 'category',
      xPDOTransport::PRESERVE_KEYS => false,
      xPDOTransport::UPDATE_OBJECT => true,
      xPDOTransport::RELATED_OBJECTS => true,
      xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
	 'Snippets' => array(
           xPDOTransport::PRESERVE_KEYS => false,
	   xPDOTransport::UPDATE_OBJECT => true,
	   xPDOTransport::UNIQUE_KEY => 'name',
	 ),
     ),
 );

$vehicle = $builder->createVehicle($category, $snippet_vehicle_attr);

$modx->log(modX::LOG_LEVEL_INFO,'Adding file resolvers to category...');
$vehicle->resolve('file', array(
       'source' => $sources['source_assets'],
       'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$vehicle->resolve('file', array(
       'source' => $sources['source_core'],
       'target' => "return MODX_CORE_PATH . 'components/';",
));

$builder->putVehicle($vehicle);

$modx->log(modX::LOG_LEVEL_INFO, 'Packaging in menu...');
$menu = include $sources['data'].'transport.menu.php';

if(empty($menu))
  $modx->log(modX::LOG_LEVEL_ERROR,'Could not package in menu.');

$menu_vehicle_attr = array(
       xPDOTransport::PRESERVE_KEYS => true,
       xPDOTransport::UPDATE_OBJECT => true,
       xPDOTransport::UNIQUE_KEY => 'text',
       xPDOTransport::RELATED_OBJECTS => true,
       xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array(
	  'Action' => array(
	     xPDOTransport::PRESERVE_KEYS => false,
	     xPDOTransport::UPDATE_OBJECT => true,
	     xPDOTransport::UNIQUE_KEY => array('namespace', 'controller')
	  )
      )
);

$vehicle= $builder->createVehicle($menu, $menu_vehicle_attr);

$modx->log(modX::LOG_LEVEL_INFO,'Adding in PHP resolvers...');
$vehicle->resolve('php', array(
     'source' => $sources['resolvers'] . 'resolve.tables.php',
));

$modx->log(modX::LOG_LEVEL_INFO,'Adding in PHP resolvers...');
$builder->putVehicle($vehicle);
unset($vehicle,$menu);
 
$modx->log(modX::LOG_LEVEL_INFO, 'Packing up transport package zip...');
$builder->pack();

$tend= explode(" ", microtime());
$tend= $tend[1] + $tend[0];
$totalTime= sprintf("%2.4f seconds",($tend - $tstart));

$modx->log(modX::LOG_LEVEL_INFO, 'Built package in '.$builder->directory.' successfully ('.$totalTime.").\n");

exit();