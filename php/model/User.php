<?php
    class User{
        private int $id;
        private string $email;
        private string $password;
        private ?string $nickname;
        private ?string $profile_picture;
        
        public function __construct(int $id, string $email, string $password, string $nickname=null, string $profile_picture=null){
            $this->id = $id;
            $this->email = $email;
            $this->password = $password;
            $this->nickname = $nickname;
            $this->profile_picture = $profile_picture;
        }

        public function getId(): int{
            return $this->id;
        }

        public function getEmail(): string{
            return $this->email;
        }

        public function getPassword(): string{
            return $this->password;
        }

        public function getNickname(): string{
            return $this->nickname;
        }

        public function getProfilePicture(): string{
            return $this->profile_picture;
        }

        public function update($email, $password, $nickname, $profile_picture){
            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->email = email;
            }
            if (!empty($password)){
                $this->password = $password;
            }
            if (!empty($nickname)){
                $this->nickname = $nickname;
            }
            if (!empty($profile_picture)){
                $this->profile_picture = $profile_picture;
            }
        }
    }
?>