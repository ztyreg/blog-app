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