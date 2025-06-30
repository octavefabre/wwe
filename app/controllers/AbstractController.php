<?php

namespace App\Controllers;

/**
 * Abstract controller
 * 
 * @author Yohann MOY & Octave Fabre-Garrus
 * @version 1.0
 * 
 */
abstract class AbstractController {

    protected string $folder;

    /**
     * Render view
     * 
     * @param string $view La vue à charger suivi de son extension (.php)
     * @param array $data Tableau associatif qui permet de faire passer des infos dynamiques à la vue. Ces infos sont récupérables au sein de la vue avec $data.
     * @return string Rendu de la vue, au format HTML.
     */
    protected function render(string $view, array $data = []): string {

    $this->setFolder();

    // Récupère les informations de configuration générales.
    $config = json_decode(file_get_contents(ROOT_DIR.'/config.json'), true);

    // Récupère le chemin complet du fichier de la vue passée en paramètre.
    $viewPath =  $config['paths']['views'].$this->folder."/".$view;
    // Si le chemin du fichier associé à la vue n'existe pas.
    if (!file_exists($viewPath)) {
        throw new \Exception("Le fichier $viewPath n'existe pas.");
    }

    $data['view'] = $viewPath; // Stocke le chemin du fichier de la vue au sein de la variable $view.
    $data['controller'] = $this->getController(); // Stocke le nom du controlleur au sein de la variable $controller.

    ob_start();
    extract($data); // ← ***Ligne essentielle ajoutée !***


    require $viewPath; // Récupère le fichier de la vue
    return ob_get_clean(); // Retourne la vue au format HTML
}
    /**
     * Se base sur le nom de la classe qui hérite d'AbstractController pour associer le dossier contenant les vues. (setFolderByControllerName)
     * 
     * Cette méthode est utilisée pour déterminer dynamiquement le dossier des vues associé au contrôleur sans nécessiter d'une configuration explicite de celui-ci.
     * Exemple : Si le nom de la classe est `HomeController`, la méthode définira `$this->folder` à `"home"`.
     * 
     * @return void
     */
    private function setFolder():void {
        $folder = str_replace("Controller", "", $this->getController());
        $this->folder = strtolower($folder);
    }

    /**
     * Récupère le nom du controlleur qui hérite d'AbstractController.
     */
    private function getController() {
        $loadedController = new \ReflectionClass($this);
        return $loadedController->getShortName();
    }

}