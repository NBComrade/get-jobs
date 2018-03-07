<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ParseData
{
    /**
     * @Assert\NotBlank()
     */
    protected $query;
    /**
     * @Assert\NotBlank()
     */
    protected $city;
    
    protected $days;

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }


    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getDays()
    {
        return $this->days;
    }

    public function setDays($days)
    {
        $this->days = $days;
    }
}