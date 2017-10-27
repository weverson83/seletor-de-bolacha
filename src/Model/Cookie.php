<?php
namespace Cookies\Model;

class Cookie
{
    /** @var string $id */
    private $id;

    /** @var integer $diameter in nanometers */
    private $diameter;

    public function __construct(Int $diameter)
    {
        $this->id = uniqid();
        $this->diameter = $diameter;
    }

    /**
     * @return String
     */
    public function getId(): String
    {
        return $this->id;
    }

    /**
     * @return Int
     */
    public function getDiameter(): Int
    {
        return $this->diameter;
    }
}
