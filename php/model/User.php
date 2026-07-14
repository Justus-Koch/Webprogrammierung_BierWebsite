<?php
    class User{
        private int $id;
        private string $email;
        private string $password;
        private ?string $nickname;
        private ?string $profile_picture;
        public $favorites;
        private bool $is_active;
        private ?string $token;
        
        public function __construct(int $id, string $email, string $password, string $token = "abc", string $nickname=null, string $profile_picture=null){
            $this->id = $id;
            $this->email = $email;
            $this->password = $password;
            $this->token = $token;
            $this->nickname = $nickname;
            $this->profile_picture = $profile_picture;
            $this->is_active = false;
            $this->favorites = [];
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

        public function getNickname(): ?string{
            return $this->nickname;
        }

        public function getProfilePicture(): ?string{
            return $this->profile_picture;
        }

        public function activate(){
            $this->is_active = true;
        }

        public function isActive(){
            return $this->is_active;
        }

        public function getToken(){
            return $this->token;
        }

        public function update($nickname, $profile_picture){
            if (!empty($nickname)){
                $this->nickname = $nickname;
            }
            if (!empty($profile_picture)){
                $this->profile_picture = $profile_picture;
            }
        }

        public function addFavorite($reviewID){
            $this->favorites[] = $reviewID;
        }

        public function removeFavorite($reviewID){
            if ($this->favorites === null) {
                $this->favorites = [];
            }
            $key = array_search($reviewID, $this->favorites);
            if ($key !== false) {
                unset($this->favorites[$key]);
            }
        }

        public function containsFavorite($reviewID){
            $favorites = $this->favorites ?? [];
            return in_array($reviewID, $favorites);
        }
    }
?>