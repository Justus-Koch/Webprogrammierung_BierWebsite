<?php
require_once "UserManagementSession.php";
require_once "UserManagementPDOSQLite.php";

class UserManagement
{
    public static function getInstance()
    {
        return UserManagementPDOSQLite::getInstance();
    }
}
?>

