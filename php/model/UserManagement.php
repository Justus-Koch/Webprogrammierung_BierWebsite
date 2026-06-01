<?php
require_once "UserManagementSession.php";

class UserManagement
{
    public static function getInstance()
    {
        return UserManagementSession::getInstance();
    }
}
?>

