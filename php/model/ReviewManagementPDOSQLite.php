<?php
if (!isset($abs_path)) {
    require_once "../../path.php";
}
require_once 'Review.php';
require_once 'ReviewManagementDAO.php';
require_once 'PDOSQLite.php';

class ReviewManagementPDOSQLite implements ReviewManagementDAO
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new ReviewManagementPDOSQLite();
        }
        return self::$instance;
    }

    public function findAll()
    {
        try {
            $db = getConnection();
            $sql = "SELECT * FROM review ORDER BY date DESC";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            $command->execute();
            return $this->fetchAllAsReviews($command);
        } catch (PDOException $e) {
            throw new InternalErrorException();
        }
    }

    public function findById($id)
    {
        try {
            $db = getConnection();
            $sql = "SELECT * FROM review WHERE review_id = ?";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            $command->execute([$id]);
            $row = $command->fetchObject();
            if (empty($row)) {
                return null;
            }
            return $this->rowToReview($row);
        } catch (PDOException $e) {
            throw new InternalErrorException();
        }
    }

    public function findByUserId($id)
    {
        try {
            $db = getConnection();
            $sql = "SELECT * FROM review WHERE user_id = ? ORDER BY date DESC";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            $command->execute([$id]);
            return $this->fetchAllAsReviews($command);
        } catch (PDOException $e) {
            throw new InternalErrorException();
        }
    }

    public function findFavouritesByUserId($id)
    {
        try {
            $db = getConnection();
            $sql = "SELECT r.* FROM review r
                    INNER JOIN likes l ON r.review_id = l.review_id
                    WHERE l.user_id = ?
                    ORDER BY r.date DESC";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            $command->execute([$id]);
            return $this->fetchAllAsReviews($command);
        } catch (PDOException $e) {
            throw new InternalErrorException();
        }
    }

    public function search($query)
    {
        try {
            $db = getConnection();
            $like = '%' . $query . '%';
            $sql = "SELECT * FROM review
                    WHERE beer_name LIKE ? OR content LIKE ?
                    ORDER BY date DESC";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            $command->execute([$like, $like]);
            return $this->fetchAllAsReviews($command);
        } catch (PDOException $e) {
            throw new InternalErrorException();
        }
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
        $picture
    ) {
        try {
            $db = getConnection();
            $sql = "INSERT INTO review
                        (beer_name, beer_type, alcohol_content, original_gravity,
                         rating, content, picture, user_id, date)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            if (!$command->execute([
                $beerName,
                $beerType,
                $alcoholContent,
                $originalExtract,
                $rating,
                $content,
                $picture,
                $authorId,
                $createdAt
            ])) {
                throw new InternalErrorException();
            }
            return $db->lastInsertId();
        } catch (PDOException $e) {
            throw new InternalErrorException();
        }
    }

    public function update($review)
    {
        try {
            $db = getConnection();
            $sql = "UPDATE review
                    SET beer_name        = ?,
                        beer_type        = ?,
                        alcohol_content  = ?,
                        original_gravity = ?,
                        rating           = ?,
                        content          = ?,
                        picture          = ?
                    WHERE review_id = ?";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            if (!$command->execute([
                $review->getBeerName(),
                $review->getBeerType(),
                $review->getAlcoholContent(),
                $review->getOriginalExtract(),
                $review->getRating(),
                $review->getContent(),
                $review->getPicture(),
                $review->getId()
            ])) {
                throw new InternalErrorException();
            }
            return $command->rowCount() > 0;
        } catch (PDOException $e) {
            throw new InternalErrorException();
        }
    }
    
    public function delete($id)
    {
        try {
            $db = getConnection();
            $sql = "DELETE FROM review WHERE review_id = ?";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            if (!$command->execute([$id])) {
                throw new InternalErrorException();
            }
            return $command->rowCount() > 0;
        } catch (PDOException $e) {
            throw new InternalErrorException();
        }
    }

    // -----------------------------------------------------------------------
    // Helper Methods
    // -----------------------------------------------------------------------

    private function rowToReview($row)
    {
        $review = new Review(
            $row->review_id,
            $row->beer_name,
            $row->beer_type,
            $row->alcohol_content,
            $row->rating,
            $row->user_id,
            $row->date
        );
        $review->setOriginalExtract($row->original_gravity);
        $review->setContent($row->content);
        $review->setPicture($row->picture);
        return $review;
    }

    private function fetchAllAsReviews($statement)
    {
        $reviews = [];
        while ($row = $statement->fetchObject()) {
            $reviews[] = $this->rowToReview($row);
        }
        return $reviews;
    }
}
