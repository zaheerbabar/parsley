<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/Site/Library/Initialize.php');

use Site\Handlers as Handlers;

$userHandler = new Handlers\User\Account();
$userHandler->logout();
?>