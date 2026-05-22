<?php
    require_once 'User.php';

    class InternalErrorException extends Exception{}

    class UserNotFoundException extends Exception{}

    interface UserManagementDAO{
        function saveUser($email, $password, $nickname, $profile_picture);
        function findUser($id);
        function updateUser($id, $nickname, $profile_picture);
        function deleteUser($id);
        function canLogin($email, $password);
    }
?>