<?php

    namespace App\Core;

    /**
     * Routeur de l'application : 
     * Considère les paramètres fournis dans l'URL afin de charger le bon controlleur ainsi que d'executer la bonne méthode.
     * 
     * @author Yohann MOY
     * @version 1.0
     * 
     */
    class Router{

        private string $namespace; // Namespace des controlleurs
        private string $controller; // Nom du controlleur renseigné par setController()
        private string $method; // Nom de la métode renseigné par setMethod()

        public function __construct(){
            $this->namespace = 'App\\Controllers\\';
            $this->setController();
            $this->setMethod();

            $this->run();
        }

        /**
         * Renseigne l'attribut `controller` selon l'URL ($_GET["controller"]).
         * Si $_GET["controller"] n'est pas renseigné, le controlleur par défaut (home) est chargé.
         */
        private function setController():void{
            $controller = 'home'; // Controlleur par défaut (si non renseigné dans l'URL)

            // Si l'utilisateur a renseigné un controlleur dans l'URL
            if(isset($_GET["controller"])){
                $controller = $_GET["controller"];
            }

            $this->controller = $controller;
        }

        /**
         * Renseigne l'attribut `method` selon l'URL ($_GET["action"]).
         * Si $_GET["action"] n'est pas renseigné ou vide, la méthode par défaut (accueil) est chargée.
        */
        private function setMethod(){
            $method = 'accueil'; // Méthode par défaut (si non renseignée dans l'URL)

            // Si l'utilisateur a renseigné une action dans l'URL
            if(isset($_GET["action"]) && trim($_GET["action"]) !== ""){
                $method = $_GET["action"];
            }

            $this->method = $method;
        }

        /**
         * Charge le controlleur renseigné dans l'URL et exécute la méthode également spécifiée dans l'URL.
         */
       private function run() {
    $controllerClass = $this->namespace . ucfirst($this->controller) . 'Controller';

    if (class_exists($controllerClass)) {
        $instance = new $controllerClass(); // Instanciation du contrôleur

        if (method_exists($instance, $this->method)) {
            $reflection = new \ReflectionMethod($instance, $this->method);
            $paramCount = $reflection->getNumberOfParameters();

            if ($paramCount === 0) {
                // Appelle la méthode sans argument
                echo $instance->{$this->method}();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                // Appelle la méthode avec l'argument 'id' via POST
                $id = (int) $_POST['id'];
                echo $instance->{$this->method}($id);
            } else {
                throw new \Exception("La méthode '{$this->method}' nécessite un identifiant passé en POST.");
            }
        } else {
            throw new \Exception("L'action '{$this->method}' n'existe pas dans " . ucfirst($this->controller) . "Controller.");
        }
    } else {
        throw new \Exception("Le contrôleur $controllerClass est introuvable.");
    }
}
    }