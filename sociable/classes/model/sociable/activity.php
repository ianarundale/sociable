<?php
defined('SYSPATH') or die('No direct script access.');

/*
 * @author Ian Arundale
 */

class Model_Sociable_Activity extends ORM
{

    /*
     * Structure
     *
     * id
     * name
     * content
     * author_id
     * updated_time
     * topic_id
     */

    //Relationships
    protected $_has_many = array('users' => array('through' => 'author_articles'),
                                 'contentboxes' => array(),
                                 'archivedarticlecontent' => array()
    );

    protected $_belongs_to = array('topic' => array(),
                                   'archivedarticlecontents' => array()
    );

    protected $_rules = array(
        'title' => array('not_empty' => array()),
    );

    protected $_filters = array(
        TRUE => array('trim' => array()),
    );

    /* validation rules */
    public function rules()
    {
        return array(
            'title' => array(
                array('not_empty'),
            )
        );
    }

    public function __construct($id = NULL)
    {
        parent::__construct($id);
    }

    /**
     * @return array containing latest article contents, article authors and article status
     */
    public function getArticleInformation()
    {
        $article_content = $this->archivedarticlecontent->where('chosen_for_frontend', '=', '1')->find();
        $status = 'ok';
        $authors = array();

        /* Article is not ready yet */
        if ($article_content->article_html == null) {
            if ($this->users->count_all() == 0) {
                // Article has not even been assigned yet
                $status = 'no-author';
            }
            else // Article just hasnt been approved yet
            {
                $status = 'being-written';
            }
        }

        if ($status == 'ok') {
            // Get the author information
            foreach ($article_content->users->find_all() as $author)
            {
                $author_details = array(
                    'name' => $author->firstname . ' ' . $author->lastname,
                    'network' => $author->network->name
                );

                array_push($authors, $author_details);
            }
        } elseif ($status == 'being-written') {
            // Get the author information
            foreach ($this->users->find_all() as $author)
            {
                $author_details = array(
                    'name' => $author->firstname . ' ' . $author->lastname,
                    'network' => $author->network->name
                );

                array_push($authors, $author_details);
            }
        }

        $article_info = array(
            'id' => $this->id,
            'title' => $this->title,
            'content' => $article_content->article_html,
            'status' => $status,
            'authors' => $authors,
        );

        return $article_info;
    }
}

?>
