<?php
    require_once 'UserDao.php';
    require_once 'User.php';

    //session_start();

    class MockUser implements UserDAO{
        private const mockUserField = "mockUser";

        public function __construct(){
            if (!isset($_SESSION[self::mockUserField])){
                $_SESSION[self::mockUserField] = new User("bier@gmail.com", password_hash("bier", PASSWORD_DEFAULT), "bierliebhaber", "bier.jpg");
            }
        }

        public function saveUser(User $user){
            if (!isset($_SESSION[self::mockUserField])){
                $_SESSION[self::mockUserField] = new User("bier@gmail.com", password_hash("bier", PASSWORD_DEFAULT), "bierliebhaber", "bier.jpg");
            }
        }

        public function findUser(string $username): ?User{
            if (isset($_SESSION[self::mockUserField])){
                return $_SESSION[self::mockUserField];
            }
            return null;
        }

        public function updateUser(User $newUser): bool{
            if (!isset($_SESSION[self::mockUserField])){
                return false;
            }
            return true;
        }

        public function deleteUser(string $username){
            unset($_SESSION[self::mockUserField]);
        }
    }
?>