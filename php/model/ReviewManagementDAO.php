<?php

class ReviewNotFoundException extends Exception{}

interface ReviewManagementDAO
{
    /**
     * Returns an array with all Reviews.
     * Throws an InternalErrorException if there is an internal error.
     */
    public function findAll();

    /**
     * Returns the review with the specified id.
     * Throws an ReviewNotFoundException if a review with this id does not exist.
     * Throws an InternalErrorException if there is an internal error.
     */
    public function findById($id);

    /**
     * Returns the favourite reviews of the user with the given user id.
     * Throws an InternalErrorException if there is an internal error.
     */
    public function findFavouritesByUserId($id);

    /**
     * Returns a list of all reviews with the specified userId.
     * Throws an InternalErrorException if there is an internal error.
     */
    public function findByUserId($id);

    /**
     * Returns a list of reviews that fit the specified search query.
     * Throws an InternalErrorException if there is an internal error.
     */
    public function search($query);

    /**
     * Creates a new review with the provided beer details.
     * Throws an InternalErrorException if there is an internal error.
     */
    public function createReview(
        $beerName,
        $beerType,
        $alcoholContent,
        $rating,
        $authorId,
        $createdAt,
        $content,
        $originalExtract,
        $picture
    );

    /**
     * Updates the given review.
     * Throws a ReviewNotFoundException if the review does not exist.
     * Throws an InternalErrorException if there is an internal error.
     */
    public function update($review, $user_id);

    /**
     * Deletes the given review.
     * Throws a ReviewNotFoundException if the review does not exist.
     * Throws an InternalErrorException if there is an internal error.
     */
    public function delete($review, $user_id);
}
