<?php

class Shepherd {

  public $modx;
  public $config = array();

  public function __construct(modX &$modx, array $config = array()) {

    $this->modx =& $modx;

    $basePath = $this->modx->getOption('shepherd.core_path', $config, $this->modx->getOption('core_path').'components/shepherd/');
    $assetsUrl = $this->modx->getOption('shepherd.assets_url', $config, $this->modx->getOption('assets_url').'components/shepherd/');

    $this->config = array_merge(
        array(
	      'basePath' => $basePath,
	      'corePath' => $basePath,
	      'modelPath' => $basePath.'model/',
	      'processorsPath' => $basePath.'processors/',
	      'chunksPath' => $basePath.'elements/chunks/',
	      'jsUrl' => $assetsUrl.'js/',
	      'cssUrl' => $assetsUrl.'css/',
	      'assetsUrl' => $assetsUrl,
	      'connectorUrl' => $assetsUrl.'connector.php'
	), 
	$config
    );

    $this->modx->addPackage('shepherd', $this->config['modelPath']);

  }

  public function initialize($ctx = 'web') {
    switch ($ctx) {
    case 'mgr':
      $this->modx->lexicon->load('shepherd:default');
      if (!$this->modx->loadClass('ShepherdControllerRequest',$this->config['modelPath'].'shepherd/request/',true,true)) {
	return 'Could not load controller request handler from \''.$this->config['modelPath'].'shepherd/request/\'.';
      }
      $this->request = new shepherdControllerRequest($this);
      return $this->request->handleRequest();
    break;
    }
    return true;
  }

  public function getChunk($name,$properties = array()) {

    $chunk = null;
    if (!isset($this->chunks[$name])) {
      $chunk = $this->_getTplChunk($name);
      if (empty($chunk)) {
	$chunk = $this->modx->getObject('modChunk',array('name' => $name));
	if ($chunk == false) return false;
      }
      $this->chunks[$name] = $chunk->getContent();
    } else {
      $o = $this->chunks[$name];
      $chunk = $this->modx->newObject('modChunk');
      $chunk->setContent($o);
    }
    $chunk->setCacheable(false);
    return $chunk->process($properties);

  }
 
  private function _getTplChunk($name,$postfix = '.chunk.tpl') {
   
    $chunk = false;
    $f = $this->config['chunksPath'].strtolower($name).$postfix;
    if (file_exists($f)) {
      $o = file_get_contents($f);
      $chunk = $this->modx->newObject('modChunk');
      $chunk->set('name',$name);
      $chunk->setContent($o);
    }
    return $chunk;

  }

}