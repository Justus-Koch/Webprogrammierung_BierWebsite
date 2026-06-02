<?php
    require_once 'User.php';

    class InternalErrorException extends Exception{}

    class UserNotFoundException extends Exception{}

    interface UserManagementDAO{

        /**
         * Saves a new user with the given email, password, nickname and a optional profile picture
         * Throws an InternalErrorException if there is an internal error.
         */
        function saveUser($email, $password, $nickname, $profile_picture);
        /**
         * Return the user with the given id.
         * Throws an UserNotFoundException if an user with this id does not exist.
         * Throws an InternalErrorException if there is an internal error.
         */
        function findUser($id);
        /**
         * Updates the user with the given id with the given nickname and profile picture if those are not null.
         * Throws an UserNotFoundException if an user with this id does not exist.
         * Throws an InternalErrorException if there is an internal error.
         */
        function updateUser($id, $nickname, $profile_picture);
        /**
         * Deletes the user with the given id.
         * Throws an UserNotFoundException if an user with this id does not exist.
         * Throws an InternalErrorException if there is an internal error.
         */
        function deleteUser($id);
        /**
         * Checks if an user can login with the given email and password.
         * Returns the userID of the user the client will be logged in with.
         * Return -1 if no user exists with the given email and password.
         * Throws an InternalErrorException if there is an internal error.
         */
        function login($email, $password);
    }
?>

