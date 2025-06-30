<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\ShowModel;


class ShowController extends AbstractController
{


    public function raw()
    {
        $showModel = new ShowModel();
        $shows = $showModel->findWithDetailsByType("Raw");

        return $this->render(
            "template.php",
            [
                "title" => "Raw",
                "shows" => $shows,
                "detailed" => true
            ]
        );
    }

    public function smackdown()
    {
        $showModel = new ShowModel();
        $shows = $showModel->findWithDetailsByType("SmackDown");

        return $this->render(
            "template.php",
            [
                "title" => "SmackDown",
                "shows" => $shows,
                "detailed" => true
            ]
        );
    }

public function ppv()
{
    $showModel = new ShowModel();
    $shows = $showModel->findPpvWithDetails(); // méthode complète, vue plus bas

    return $this->render(
        "template.php",
        [
            "title" => "Ppv",
            "shows" => $shows,
            "detailed" => true // option pour activer l'affichage complet dans la vue
        ]
    );
}
    public function insert()
    {

        return $this->render(
            "insert.php",
        );
    }
}
