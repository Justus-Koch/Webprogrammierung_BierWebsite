<?php
    class User{
        private string $email;
        private string $password;
        private string $nickname;
        private ?string $profile_picture;
        
        public function __construct(string $email, string $password, string $nickname, string $profile_picture=null){
            $this->email = $email;
            $this->password = $password;
            $this->nickname = $nickname;
            $this->profile_picture = $profile_picture;
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
    }
?>