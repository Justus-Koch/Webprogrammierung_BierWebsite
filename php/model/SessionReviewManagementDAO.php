<?php

class SessionReviewManagementDAO implements ReviewManagementDAO
{
  private static $instance = null;
  private $reviews = [];

  private function __construct() {
    if (isset($_SESSION["reviews"])) {
      // Reviews aus der Session laden falls vorhanden
      $this->reviews = unserialize($_SESSION["reviews"]);
    } else {
      // Dummy-Daten beim ersten Aufruf
      $tempReview1 = new Review(1, "Paulaner Helles", "Helles", "5.0", 4, "Schluckspecht", date('d/m/Y'));
      $tempReview1->setOriginalExtract("11.9");
      $tempReview1->setContent("Ein leckeres helles Bier aus Bayern. Gschichten ausm Paulaner Garten");
      $tempReview1->setPicture("bier.jpg");

      $tempReview2 = new Review(2, "Staropramen Dunkel", "Dunkles", "5.2", 3, "Bierabetiker", date('d/m/Y'));
      $tempReview2->setOriginalExtract("12.7");
      $tempReview2->setContent("Ein Schluck Tschechien. Prost meine mit-Bierabetiker");
      $tempReview2->setPicture("bier.jpg");

      $this->reviews = [$tempReview1, $tempReview2];
      $_SESSION["reviews"] = serialize($this->reviews);
      $_SESSION["nextReviewID"] = 3;
    }
  }

  public static function getInstance() {
    if (self::$instance === null) {
      self::$instance = new SessionReviewManagementDAO();
    }
    return self::$instance;
  }

  public function findAll() {
    return $this->reviews;
  }

  public function findById($id) {
    foreach ($this->reviews as $review) {
      if ($review->getId() === $id) {
        return $review;
      }
    }
    return null;
  }

  public function findByUserId($authorId) {
    $result = [];
    foreach ($this->reviews as $review) {
      if ($review->getAuthorId() === $authorId) {
        $result[] = $review;
      }
    }
    return $result;
  }

  public function search($query) {
    $result = [];
    foreach ($this->reviews as $review) {
      // Suche in Biername und Inhalt
      if (stripos($review->getBeerName(), $query) !== false ||
        stripos($review->getContent(), $query) !== false) {
        $result[] = $review;
      }
    }
    return $result;
  }

  public function createReview(
    $beerName, 
    $beerType, 
    $alcoholContent, 
    $rating, 
    $authorId, 
    $createdAt, 
    $content, 
    $originalExtract, 
    $picture) {
    // Neue ID aus der Session holen
    $newId = $_SESSION["nextReviewID"];

    $newReview = new Review(
        $newId,
        $beerName,
        $beerType,
        $alcoholContent,
        $rating,
        $authorId,
        $createdAt,
    );

    $newReview->setContent($content ?? '');
    $newReview->setOriginalExtract($originalExtract ?? '');
    $newReview->setPicture($picture ?? "bier.jpg");

    $this->reviews[] = $newReview;
    $_SESSION["nextReviewID"] = $newId + 1;
    $_SESSION["reviews"] = serialize($this->reviews);
}

  public function update($review) {
    foreach ($this->reviews as $key => $value) {
      if ($value->getId() === $review->getId()) {
        $this->reviews[$key] = $review;
        $_SESSION["reviews"] = serialize($this->reviews);
        return true;
      }
    }
    return false;
  }

  public function delete($id) {
    foreach ($this->reviews as $key => $value) {
      if ($value->getId() === $id) {
        array_splice($this->reviews, $key, 1);
        $_SESSION["reviews"] = serialize($this->reviews);
        return true;
      }
    }
    return false;
  }
}
