<?php

interface ReviewManagementDAO
{

  /**
   * Returns an array with all Reviews
   *
   * @return mixed
   */
  public function findAll();

  /**
   * Returns the review with the specified id
   *
   * @param $id
   * @return mixed
   */
  public function findById($id);

  /**
   * Returns a list of all reviews with the specified userId
   *
   * @param $id
   * @return mixed
   */
  public function findByUserId($id);

  /**
   * Returns a list of reviews that fit the specified search query
   *
   * @param $query
   * @return mixed
   */
  public function search($query);

  /**
   * Creates a new review
   *
   * @param $review
   * @return mixed
   */
  public function create($review);

  /**
   * Updates a review
   *
   * @param $review
   * @return mixed
   */
  public function update($review);

  /**
   * Deletes a review
   *
   * @param $review
   * @return mixed
   */
  public function delete($review);
}
