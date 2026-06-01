<?php

class DummyReviewManagementDAO implements ReviewManagementDAO
{
  private static $instance = null;
  private $reviews = [];

  private function __construct(){
    $tempReview = new Review(1, "Paulaner Helles", "Helles", "5,0", 4, "Schluckspecht", "22/05/2026");
    $tempReview->setOriginalExtract("11,9");
    $tempReview->setContent("Ein leckeres helles Bier aus Bayern. Gschichten ausm Paulaner Garten");
    $tempReview->setPicture("Kein Bild Vorhanden");

    $tempReview2 = new Review(2, "Staropramen Dunkel", "Dunkles", "5,2", 3, "Bierabetiker", "22/05/2026");
    $tempReview2->setOriginalExtract("12,7");
    $tempReview2->setContent("Ein Schluck Tschechien. Prost meine mit-Bierabetiker");
    $tempReview2->setPicture("./img/bier.jpg");

    $this->reviews = [$tempReview, $tempReview2];
  }
  public static function getInstance() {
    if (self::$instance === null) {
      self::$instance = new DummyReviewManagementDAO();
    }
    return self::$instance;
  }

  public function findAll()
  {
    return $this->reviews;
  }

  public function findById($id)
  {
    foreach($this->reviews as $review){
      if ($review->getId() === $id) {return $review;}
    }
    return null;
  }

  public function findByUserId($id)
  {
    foreach($this->reviews as $review){
      if ($review->getAuthorId() === $id) {return $review;}
    }
    return null;
  }

  public function search($query)
  {
    $res = [];
    foreach($this->reviews as $review){
      if (strpos($review->getContent(), $query) != false) {$res[] = $review;}
    }
    return $res;
  }

  public function create($review)
  {
    $this->reviews[] = $review;
  }

  public function update($review)
  {
    foreach($this->reviews as $key => $value){
      if ($value->getId() === $review->getId()){
        $this->reviews[$key] = $review;
        return true;
      }
    }
    return false;
  }

  public function delete($review)
  {
    foreach($this->reviews as $key => $value){
      if ($value->getId() === $review->getId()){
        array_splice($this->reviews, $key, 1);
        return true;
      }
    }
    return false;
  }
}
