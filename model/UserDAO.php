<?php
    require_once 'User.php';

    interface UserDAO{
        function saveUser(User $user);
        function findUser(string $username);
        function updateUser(User $newUser);
        function deleteUser(string $username);
    }
?>