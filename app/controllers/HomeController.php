<?php

    namespace App\Controllers;
    use App\Controllers\AbstractController;
    use App\Models\LivreModel;

    /**
    * Class HomeController - Controlleur par défaut.
    * Vous pouvez vous baser sur ce controlleur en guise d'exemple.
    * 
    * @author Yohann MOY
    * @version 1.0
    *
    */
    class HomeController extends AbstractController {

        /**
         * Rends le fichier "accueil.php" au format HTML.
         * @return string Rendu du fichier "accueil.php", au format HTML.
        */
         public function accueil(): string {
        
                     return $this->render(
                     "accueil.php", // Nom de la vue suivi de son extension (.php)
                        [ // Tableau associatif des variables à passer à la vue
                            "pagename" => "Accueil"
                        ]
                  
                );
         }

    }

        /* 
            Liste des méthodes supportées par chaque model :
            -> findAll() : Récupère tous les enregistrements de la table qui porte le même nom que le model. (retourne un tableau associatif)

            -> find($id) : Récupère un enregistrement spécifiquement identifié de la table qui porte le même nom que le model. (retourne un objet)

            -> insert() : Insère un enregistrement dans la table qui porte le même nom que le model. (retourne un booleen)

            -> delete($id) : Supprime un enregistrement de la table qui porte le même nom que le model. (retourne un booleen)

            -> deleteAll() : Supprime tous les enregistrements de la table qui porte le même nom que le model. (retourne un booleen)
            */