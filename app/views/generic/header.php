<?php


$controller = $_GET['controller'] ?? '';
$action = $_GET['action'] ?? '';

// Initialisation de la variable $chaine
$chaine = "";

if ($controller === 'home' && $action === 'accueil') {
    $chaine = "class='home'";
} elseif ($controller === 'show' && $action === 'smackdown') {
    $chaine = "class='smackdown'";
} elseif ($controller === 'show' && $action === 'raw') {
    $chaine = "class='raw'";
} elseif ($controller === 'show' && $action === 'ppv') {
    $chaine = "class='ppv'";
} elseif ($controller === 'insert' && $action === 'insert') {
    $chaine = "class='insert'";
} elseif ($controller === 'insert' && $action === 'insertStep2') {
    $chaine = "class='insertStep2'";
} elseif ($controller === 'insert' && $action === 'insertStep3') {
    $chaine = "class='insertStep3'";
} elseif ($controller === 'insert' && $action === 'insertStep4') {
    $chaine = "class='insertStep4'";
} elseif ($controller === 'insert' && $action === 'insertStep5') {
    $chaine = "class='insertStep5'";
} elseif ($controller === 'register' && $action === 'registerpage') {
    $chaine = "class='register'";
} elseif ($controller === 'login' && $action === 'loginpage') {
    $chaine = "class='login'";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./public/webfiles/js/script.js" defer></script>
    <link rel="stylesheet" href="./public/webfiles/css/style.css">
    <title>WWE</title>
</head>

<body <?php echo $chaine; ?>>
    <header>
        <nav class="navbar-wwe-nav">
            <ul class="navbar-wwe-nav-list">
                <li class="navbar-wwe-nav-item">
                    <a href="index.php?controller=home&action=accueil" class="navbar-wwe-logo">
                        WWE
                    </a>
                </li>
                <li class="navbar-wwe-nav-item">
                    <?php if (isset($_SESSION['username'])): ?>
                        <span class="navbar-wwe-user-info">
                            Pseudo: <?= htmlspecialchars($_SESSION['username']) ?>
                        </span>
                        <a href="index.php?controller=user&action=logout" class="navbar-wwe-nav-btn">Déconnexion</a>
                    <?php else: ?>
                        <a href="index.php?controller=login&action=loginpage" class="navbar-wwe-nav-btn">Login</a>
                        <a href="index.php?controller=register&action=registerpage" class="navbar-wwe-nav-btn">Register</a>
                    <?php endif; ?>
                </li>
                <li class="navbar-wwe-nav-item">
                    <a href="index.php?controller=insert&action=insert" class="navbar-wwe-nav-btn add-show">
                        Ajouter un show
                    </a>
                </li>
            </ul>
        </nav>
    </header>