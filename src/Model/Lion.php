<?php

namespace App\Model;

use App\Services\Animal;



class Lion implements Animal
{

    function getNoise() : string
    {
        return "Yo ich bin ein Löwe";
    }


}
