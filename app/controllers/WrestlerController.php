<?php
namespace App\Controllers;

use App\Models\WrestlerModel;

class WrestlerController {

    // Suppression d’un catcheur par son ID
    public function delete(int $id) {
        $model = new WrestlerModel();
        $success = $model->delete($id);

        if ($success) {
            echo "Catcheur supprimé avec succès.";
        } else {
            echo "Échec de la suppression du catcheur.";
        }

        // Redirige vers la liste ou une autre page
        // header('Location: /wrestlers');
        // exit;
    }

    public function supprimerFormulaire() {
    $model = new \App\Models\WrestlerModel();
    $wrestlers = $model->findAll(); // récupère tous les catcheurs

    require ROOT_DIR . '/app/views/wrestler/insert.php';
}
}