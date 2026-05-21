<?php
    require_once 'UserDao.php';
    require_once 'User.php';

    session_start();

    class MockUser implements UserDAO{
        private const mockUserField = "mockUser";

        public function saveUser(User $user){
            if (!isset($_SESSION[mockUserField])){
                $_SESSION[mockUserField] = new User("bier@gmail.com", "bier", "bierliebhaber", "bier.jpg");
            }
        }

        public function findUser(string $username): ?User{
            if (isset($_SESSION[mockUserField])){
                return $_SESSION[mockUserField];
            }
            return null;
        }

        public function updateUser(User $newUser): bool{
            if (!isset($_SESSION[mockUserField])){
                return false;
            }
            return true;
        }

        public function deleteUser(string $username){
            unset($_SESSION[mockUserField]);
        }
    }
?>