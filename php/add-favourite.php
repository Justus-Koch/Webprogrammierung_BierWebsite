<?php
if (!isset($abs_path)) {
    require_once "../path.php";
}
require_once $abs_path . "/php/session-start.php";
require_once $abs_path . "/php/controller/UserController.php";

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$userController = new UserController();
$userController->addFavourite($isAjax);

