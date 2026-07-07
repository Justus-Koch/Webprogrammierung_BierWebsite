<?php
    require_once 'User.php';

    class InternalErrorException extends Exception{}

    class UserNotFoundException extends Exception{}

    interface UserManagementDAO{

        /**
         * Saves a new user with the given email, password and nickname.
         * Throws an InternalErrorException if there is an internal error.
         */
        function saveUser($email, $password, $nickname);

        /**
         * Confirms the registration of the user with the given token.
         * Throws an UserNotFoundException if an user with this token does not exist.
         * Throws an InternalErrorException if there is an internal error.
         */
        function confirmUser($token);
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

        /**
         * Removes or adds the review with the given reviewID from/to the user with the given userID.
         * Throws an UserNotFoundException if an user with this id does not exist.
         * Throws an ReviewNotFoundException if an review with this id does not exist.
         * Throws an InternalErrorException if there is an internal error.
         */
        function toggleFavouriteState($userID, $reviewID);
        
        /**
         * Returns if the user with the given userID has an favourite with the given reviewID.
         * Throws an UserNotFoundException if an user with this id does not exist.
         * Throws an InternalErrorException if there is an internal error.
         */
        function userContainsFavourite($userID, $reviewID);
    }
?>

