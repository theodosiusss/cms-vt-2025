<?php
namespace App\Model;

use DateTime;

class Game{

     public function __construct(protected string $paperPlaneModel,protected float $distance,protected float $duration,protected string $name,protected DateTime $date){
     }

    public function getPaperPlaneModel(): string
    {
        return $this->paperPlaneModel;
    }

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): string
    {
        return $this->date->format('Y-m-d');
    }


}
