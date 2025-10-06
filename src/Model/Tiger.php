<?php

namespace App\Model;

use App\Services\Animal;



class Tiger implements Animal
{

    function getNoise() : string
    {
        return "Yo ich bin ein tiger";
    }


}
