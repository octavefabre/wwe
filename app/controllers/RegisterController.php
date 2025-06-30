<?php

namespace App\Controllers;

use App\Controllers\AbstractController;

class RegisterController extends AbstractController
{
 

    public function registerpage()
    {

        return $this->render(
            "register.php",
        );
    }
}
