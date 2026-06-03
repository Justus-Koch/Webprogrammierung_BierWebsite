<?php

/**
 * optional Values: original Extract, content, picture
 */
class Review
{
  private $id;
  private $beerName;
  private $beerType;
  private $originalExtract;
  private $alcoholContent;
  private $rating;
  private $content;
  private $picture;
  private $authorId;
  private $createdAt;

  /**
   * @param $id
   * @param $beerName
   * @param $beerType
   * @param $alcoholContent
   * @param $rating
   * @param $authorId
   * @param $createdAt
   * @param $picture
   */
  public function __construct($id, $beerName, $beerType, $alcoholContent, $rating, $authorId, $createdAt)
  {
    $this->id = $id;
    $this->beerName = $beerName;
    $this->beerType = $beerType;
    $this->alcoholContent = $alcoholContent;
    $this->rating = $rating;
    $this->authorId = $authorId;
    $this->createdAt = $createdAt;
  }

  /**
   * @param mixed $originalExtract
   */
  public function setOriginalExtract($originalExtract)
  {
    $this->originalExtract = $originalExtract;
  }

  /**
   * @param mixed $content
   */
  public function setContent($content)
  {
    $this->content = $content;
  }

  /**
   * @param mixed $picture
   */
  public function setPicture($picture)
  {
    $this->picture = $picture;
  }


  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getBeerName()
  {
    return $this->beerName;
  }

  /**
   * @return mixed
   */
  public function getBeerType()
  {
    return $this->beerType;
  }

  /**
   * @return mixed
   */
  public function getOriginalExtract()
  {
    return $this->originalExtract;
  }

  /**
   * @return mixed
   */
  public function getAlcoholContent()
  {
    return $this->alcoholContent;
  }

  /**
   * @return mixed
   */
  public function getRating()
  {
    return $this->rating;
  }

  /**
   * @return mixed
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * @return mixed
   */
  public function getPicture()
  {
    return $this->picture;
  }

  /**
   * @return mixed
   */
  public function getAuthorId()
  {
    return $this->authorId;
  }

  /**
   * @return mixed
   */
  public function getCreatedAt()
  {
    return $this->createdAt;
  }

}
