<?php
function getConnection()
{
    global $abs_path;
    if (!file_exists($abs_path . "/db/prostProtokoll.db")) {
        createDB();
    }

    try {
        $user = 'root';
        $pw = null;
        $dsn = 'sqlite:' . $abs_path . '/db/prostProtokoll.db';
        $db = new PDO($dsn, $user, $pw);
        $db->exec("PRAGMA foreign_keys = ON;");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        throw new InternalErrorException();
    }
}

function createDB()
{
    global $abs_path;
    try {
        $user = 'root';
        $pw = null;
        $dsn = 'sqlite:' . $abs_path . '/db/prostProtokoll.db';
        $db = new PDO($dsn, $user, $pw);

        $db->exec("
                CREATE TABLE user (
                    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nickname VARCHAR(50),
                    profile_picture VARCHAR(255),
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(100) NOT NULL UNIQUE
                );

                CREATE TABLE review (
                    review_id INTEGER PRIMARY KEY AUTOINCREMENT,
                    user_id INT NOT NULL,
                    date DATETIME DEFAULT CURRENT_TIMESTAMP,
                    beer_type VARCHAR(100),
                    rating INT CHECK (rating BETWEEN 1 AND 5),
                    content TEXT,
                    picture VARCHAR(255),
                    alcohol_content DECIMAL(4,2),
                    original_gravity DECIMAL(5,3),
                    beer_name VARCHAR(100) NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
                )

                CREATE TABLE likes (
                    user_id INT NOT NULL,
                    review_id INT NOT NULL,
                    PRIMARY KEY (user_id, review_id),
                    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (review_id) REFERENCES review(review_id) ON DELETE CASCADE ON UPDATE CASCADE
                );
                ");
        unset($db);
    } catch (PDOException $e) {
        // nothing
    }
}
?>