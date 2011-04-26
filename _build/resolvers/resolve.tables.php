<?php
if ($object->xpdo) {
  switch ($options[xPDOTransport::PACKAGE_ACTION]) {
  case xPDOTransport::ACTION_INSTALL:
    $modx =& $object->xpdo;
    $modelPath = $modx->getOption('shepherd.core_path',null,$modx->getOption('core_path').'components/shepherd/').'model/';
    $modx->addPackage('shepherd',$modelPath);
 
    $manager = $modx->getManager();
 
    $manager->createObjectContainer('Shepherd');
 
    break;
  case xPDOTransport::ACTION_UPGRADE:
    break;
  }
 }
return true;