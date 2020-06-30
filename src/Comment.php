<?php

class Comment
{
    private $id;
    private $user_id;
    private $story_id;
    private $content;

    /**
     * Comment constructor.
     * @param $id
     * @param $user_id
     * @param $story_id
     * @param $content
     */
    public function __construct($id, $user_id, $story_id, $content)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->story_id = $story_id;
        $this->content = $content;
    }

    public static function select_comment_by_story_id($story_id)
    {
        global $database;
        $stmt = $database->connection->prepare("SELECT id, user_id, story_id, content FROM comments WHERE story_id=? ORDER BY id;");
        $stmt->bind_param('s', $story_id);
        return self::execute_select($stmt);
    }

    public static function select_comment_by_user_id($user_id)
    {
        global $database;
        $stmt = $database->connection->prepare("SELECT id, user_id, story_id, content FROM comments WHERE user_id=? ORDER BY id;");
        $stmt->bind_param('s', $user_id);
        return self::execute_select($stmt);
    }

    private static function execute_select($stmt)
    {
        $stmt->execute();
        $id = $user_id = $story_id = $content = "";
        $stmt->bind_result($id, $user_id, $story_id, $content);
        $result_array = array();
        while ($stmt->fetch()) {
            $result_array[] = new Comment($id, $user_id, $story_id, $content);
        }
        $stmt->close();
        return $result_array;
    }

    public static function create_comment($user_id, $story_id, $content)
    {
        global $database;
        $content = $database->escape_string($content);

        // insert comment
        echo $user_id . '<br>';
        echo $story_id . '<br>';
        echo $content . '<br>';
        $stmt = $database->connection->prepare("INSERT INTO comments (user_id, story_id, content) VALUES (?, ?, ?);");
        $stmt->bind_param('iss', $user_id, $story_id, $content);
        if (!$stmt->execute()) {
            echo 'error';
        }
        $stmt->close();
    }

    public static function delete_comment(int $comment_id)
    {
        global $database;
        $stmt = $database->connection->prepare("DELETE FROM comments WHERE id=?");
        $stmt->bind_param('i', $comment_id);
        $stmt->execute();
        $stmt->close();
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getStoryId()
    {
        return $this->story_id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }


}