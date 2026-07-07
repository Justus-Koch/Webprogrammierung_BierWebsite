<?php
function getConnection()
{
  global $abs_path;
  $db_file = $abs_path . '/db/prostProtokoll.db';
  if (!file_exists($db_file)) {
      createDB();
  }

  try {
    $user = 'root';
    $pw = null;
    $dsn = 'sqlite:' . $abs_path . '/db/prostProtokoll.db';
    $db = new PDO($dsn, $user, $pw);
    $db->exec("PRAGMA foreign_keys = ON;");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("PRAGMA busy_timeout = 3000;");
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
            CREATE TABLE IF NOT EXISTS user (
                user_id         INTEGER PRIMARY KEY AUTOINCREMENT,
                nickname        VARCHAR(50),
                profile_picture VARCHAR(255),
                password        VARCHAR(50) NOT NULL UNIQUE,
                email           VARCHAR(50) NOT NULL,
                token           TEXT,
                is_active       INTEGER DEFAULT 0
            );

            CREATE UNIQUE INDEX IF NOT EXISTS idx_user_email_active
            ON user(email)
            WHERE is_active = 1;

            CREATE TABLE IF NOT EXISTS review (
                review_id        INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id          INT NOT NULL,
                date             DATETIME DEFAULT CURRENT_TIMESTAMP,
                beer_type        VARCHAR(50),
                rating           INT CHECK (rating BETWEEN 1 AND 5),
                content          TEXT,
                picture          VARCHAR(255),
                alcohol_content  DECIMAL(4,2),
                original_gravity DECIMAL(4,2),
                beer_name        VARCHAR(50) NOT NULL,
                FOREIGN KEY (user_id) REFERENCES user(user_id)
                    ON DELETE CASCADE ON UPDATE CASCADE
            );

            CREATE TABLE IF NOT EXISTS likes (
                user_id   INT NOT NULL,
                review_id INT NOT NULL,
                PRIMARY KEY (user_id, review_id),
                FOREIGN KEY (user_id)   REFERENCES user(user_id)
                    ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (review_id) REFERENCES review(review_id)
                    ON DELETE CASCADE ON UPDATE CASCADE
            );
        ");

    $userCount = $db->query('SELECT COUNT(*) FROM user')->fetchColumn();
    if ($userCount == 0) {
      $stmt = $db->prepare(
        "INSERT INTO user (email, password, nickname, profile_picture, token, is_active)
                 VALUES (?, ?, ?, ?, ?, ?)"
      );
      $stmt->execute([
        'schluckspecht@prost.de',
        password_hash('bier123', PASSWORD_DEFAULT),
        'Schluckspecht',
        'profile_picture.jpg',
        'abc', 1
      ]);
      $user1Id = $db->lastInsertId();

      $stmt->execute([
        'bierabetiker@prost.de',
        password_hash('bier456', PASSWORD_DEFAULT),
        'Bierabetiker',
        'profile_picture.jpg',
        'abc', 1
      ]);
      $user2Id = $db->lastInsertId();

      $reviewStmt = $db->prepare(
        "INSERT INTO review
                    (beer_name, beer_type, alcohol_content, original_gravity,
                     rating, content, picture, user_id)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
      );

      $reviewStmt->execute([
        'Paulaner Helles', 'Helles', 5.0, 11.9, 4,
        'Ein leckeres helles Bier aus Bayern. Gschichten ausm Paulaner Garten.',
        'bier.jpg', $user1Id
      ]);
      $reviewStmt->execute([
        'Staropramen Dunkel', 'Dunkles', 5.2, 12.7, 3,
        'Ein Schluck Tschechien. Prost meine Mit-Bierabetiker.',
        'bier.jpg', $user2Id
      ]);
      $reviewStmt->execute([
        'Augustiner Lagerbier Hell', 'Helles', 5.2, 11.7, 5,
        'Das beste Bier Münchens. Punkt.',
        'bier.jpg', $user1Id
      ]);
    }
    unset($db);
  } catch (PDOException $e) {
    error_log('createDB fehlgeschlagen: ' . $e->getMessage());
  }
}
