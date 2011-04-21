<?php

require_once MODX_CORE_PATH . 'model/modx/modrequest.class.php';

class ShepherdControllerRequest extends modRequest {
  public $shepherd = null;
  public $actionVar = 'action';
  public $defaultAction = 'index';
 
  function __construct(Shepherd &$shepherd) {
    parent :: __construct($shepherd->modx);
    $this->shepherd =& $shepherd;
  }
 
  public function handleRequest() {
    $this->loadErrorHandler();
 
    /* save page to manager object. allow custom actionVar choice for extending classes. */
    $this->action = isset($_REQUEST[$this->actionVar]) ? $_REQUEST[$this->actionVar] : $this->defaultAction;
 
    $modx =& $this->modx;
    $shepherd =& $this->shepherd;
    $viewHeader = include $this->shepherd->config['corePath'].'controllers/mgr/header.php';
 
    $f = $this->shepherd->config['corePath'].'controllers/mgr/'.$this->action.'.php';
    if (file_exists($f)) {
      $viewOutput = include $f;
    } else {
      $viewOutput = 'Controller not found: '.$f;
    }
 
    return $viewHeader.$viewOutput;
  }
}