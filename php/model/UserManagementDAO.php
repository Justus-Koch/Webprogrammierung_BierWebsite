<?php
    require_once 'User.php';
    
    class UserNotFoundException extends Exception
    {
    }

    interface UserManagementDAO{
        function saveUser($id, $email, $password, $nickname, $profile_picture);
        function findUser($id);
        function updateUser($id, $email, $password, $nickname, $profile_picture);
        function deleteUser($id);
    }
?>