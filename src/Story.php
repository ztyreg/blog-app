<?php

class Story
{
    private $id;
    private $user_id;
    private $title;
    private $content;
    private $link;

    /**
     * Story constructor.
     * @param $id
     * @param $user_id
     * @param $title
     * @param $content
     * @param $link
     */
    public function __construct($id, $user_id, $title, $content, $link)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->content = $content;
        $this->link = $link;
    }

    public static function select_story_by_id(int $story_id)
    {
        global $database;
        $stmt = $database->connection->prepare("SELECT id, user_id, title, content, link FROM stories WHERE id=?");
        $stmt->bind_param('i', $story_id);
        return self::execute_select($stmt);
    }

    public static function select_story_by_user_id(int $user_id)
    {
        global $database;
        $stmt = $database->connection->prepare("SELECT id, user_id, title, content, link FROM stories WHERE user_id=?");
        $stmt->bind_param('i', $user_id);
        return self::execute_select($stmt);
    }

    public static function select_all_stories()
    {
        global $database;
        $stmt = $database->connection->prepare("SELECT id, user_id, title, content, link FROM stories ORDER BY id DESC LIMIT 50");
        return self::execute_select($stmt);
    }

    private static function execute_select($stmt)
    {
        $stmt->execute();
        $id = $user_id = $title = $body = $link = "";
        $stmt->bind_result($id, $user_id, $title, $body, $link);
        $result_array = array();
        while ($stmt->fetch()) {
            $result_array[] = new Story($id, $user_id, $title, $body, $link);
        }
        $stmt->close();
        return $result_array;
    }

    public static function delete_story(int $story_id)
    {
        global $database;
        // also need to delete comments
        $stmt = $database->connection->prepare("DELETE FROM comments WHERE story_id=?");
        $stmt->bind_param('i', $story_id);
        $stmt->execute();
        $stmt->close();
        // delete story
        $stmt = $database->connection->prepare("DELETE FROM stories WHERE id=?");
        $stmt->bind_param('i', $story_id);
        $stmt->execute();
        $stmt->close();
    }

    public static function create_story($title, $body, $user_id)
    {
        global $database;
        $title = $database->escape_string($title);
        $body = $database->escape_string($body);

        // get next story id to create link
        $stmt = $database->connection->prepare("SELECT auto_increment FROM information_schema.tables WHERE table_name='stories';");
        $stmt->execute();
        $next_id = 0;
        $stmt->bind_result($next_id);
        $stmt->fetch();
        $stmt->close();

        // insert story
        $stmt = $database->connection->prepare("INSERT INTO stories (user_id, title, content, link) VALUES (?, ?, ?, ?);");
        $stmt->bind_param('isss', $user_id, $title, $body, $next_id);
        $stmt->execute();
        $stmt->close();
        return $next_id;
    }

    public static function update_story($new_title, $new_content, $id)
    {
        global $database;
        $new_title = $database->escape_string($new_title);
        $new_content = $database->escape_string($new_content);

        $stmt = $database->connection->prepare("UPDATE stories SET title=?, content=? WHERE id=?;");
        $stmt->bind_param('sss', $new_title, $new_content, $id);
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
    public function getTitle()
    {
        return $this->title;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

}

