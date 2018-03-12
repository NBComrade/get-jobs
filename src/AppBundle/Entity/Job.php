<?php
namespace AppBundle\Entity;

class Job
{
    public $title;
    public $company;
    public $href;

    public function __construct($title, $company, $href)
    {
        $this->title = $title;
        $this->company = $company;
        $this->href = $href;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }
    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

}