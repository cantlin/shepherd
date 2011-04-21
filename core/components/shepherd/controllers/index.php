<?php

require_once dirname(dirname(__FILE__)).'/model/shepherd/shepherd.class.php';

$shepherd = new Shepherd($modx);

return $shepherd->initialize('mgr');