<?php
namespace AppBundle\Entity;

class Job
{
    public $title;
    public $company;
    public $href;
    public $date;
    public $image;

    public function __construct($title, $company, $href, $date = null, $image = null)
    {
        $this->title = $title;
        $this->company = $company;
        $this->href = $href;
        $this->date = $date;
        $this->image = $image;
    }
}