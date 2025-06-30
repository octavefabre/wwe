<?php
    session_start();
    /* 
        Défintion de la constante ROOT_DIR : 
        permet d'accéder facilement au dossier racine du MVC 
        (depuis n'importe quel fichier du projet).
    */
    define('ROOT_DIR', getcwd());

    /*
        Inclusion :
        - du système de chargement automatique des classes (au sein du dossier de dépendances annexes)
        - de l'en-tête du document HTML.
    */
    require_once ROOT_DIR . '/vendor/autoload.php';
    require_once("./app/views/generic/header.php");

    use App\Core\Router;
    new Router();

?>

<?php
$controller = $_GET['controller'] ?? '';
$action = $_GET['action'] ?? '';

if (!($controller === 'home' && $action === 'accueil')) {
    require_once("./app/views/generic/footer.php");
}
?>