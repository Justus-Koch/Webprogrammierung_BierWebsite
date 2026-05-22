<?php
    require_once 'User.php';
    require_once 'UserManagementDAO.php';

    class UserManagementSession implements UserManagementDAO{
        private static $instance = null;
        /**
         * Returns the current instance of UserManagementSession.
         * Initializes a new UserManagementSession if it does not exist yet.
         */
        public static function getInstance()
        {
            if (self::$instance == null) {
                self::$instance = new UserManagementSession();
            }

            return self::$instance;
        }

        private $users = array();

        private function __construct(){
            if(isset($_SESSION["users"])){
                $this->users = unserialize($_SESSION["users"]);
            }else{
                // Dummy Daten einfügen
                $numOfUsers = 3;
                for ($i=0; $i < $numOfUsers; $i++){
                    $this->users[$i] = new User($i, "bier@gmail.com", "bier", "Bierliebhaber", "bier.jpg");
                }
                $_SESSION["users"] = serialize($users);
                $_SESSION["nextID"] = $numOfUsers;
            }
        }

        public function saveUser($id, $email, $password, $nickname="Bier", $profile_picture="profile_picture.jpg"){
            $newUser = new User($id, $email, $password, $nickname, $profile_picture);
            $id = $_SESSION["nextID"];
            $users[$id] = $newUser;
            $_SESSION["nextID"] = $id + 1;
            $_SESSION["users"] = serialize($users);
        }

        public function findUser($id){
            if (isset($users[$id])){
                return $users[$id];
            }else{
                throw new UserNotFoundException();
            }
        }
        
        public function updateUser($id, $email=null, $password=null, $nickname=null, $profile_picture=null){
            if (isset($users[$id])){
                $users[$id]->update($email, $password, $nickname, $profile_picture);
                $_SESSION["users"] = serialize($users);
            }else{
                throw new UserNotFoundException();
            }
        }

        public function deleteUser($id){
            if (isset($users[$id])){
                unsset($users[$id]);
                $_SESSION["users"] = serialize($users);
            }else{
                throw new UserNotFoundException();
            }
        }
    }
?>