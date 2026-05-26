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
                    $this->users[$i] = new User($i, "bier@gmail.com", "bier", "Bierliebhaber".$i, "bier.jpg");
                }
                $_SESSION["users"] = serialize($this->users);
                $_SESSION["nextID"] = $numOfUsers;
            }
        }

        public function saveUser($email, $password, $nickname=null, $profile_picture=null){
            $id = $_SESSION["nextID"];
            if(empty($nickname)){
                $nickname="Bierliebhaber".$id;
            }
            if(empty($profile_picture)){
                $profile_picture="profile_picture.jpg";
            }
            
            $newUser = new User($id, $email, $password, $nickname, $profile_picture);
            $this->users[$id] = $newUser;
            $_SESSION["nextID"] = $id + 1;
            $_SESSION["users"] = serialize($this->users);
        }

        public function findUser($id){
            if (isset($this->users[$id])){
                return $this->users[$id];
            }else{
                throw new UserNotFoundException();
            }
        }
        
        public function updateUser($id, $nickname, $profile_picture){
            if (isset($this->users[$id])){
                $this->users[$id]->update($nickname, $profile_picture);
                $_SESSION["users"] = serialize($this->users);
            }else{
                throw new UserNotFoundException();
            }
        }

        public function deleteUser($id){
            if (isset($this->users[$id])){
                unset($this->users[$id]);
                $_SESSION["users"] = serialize($this->users);
                error_log("User gelöscht: ".$id);
            }else{
                throw new UserNotFoundException();
            }
        }

        public function login($email, $password){
            foreach ($this->users as $user){
                if($email === $user->getEmail() && $password === $user->getPassword()){
                    return $user->getID();
                }
            }
            return -1;
        }
    }
?>