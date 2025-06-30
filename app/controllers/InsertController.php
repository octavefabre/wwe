<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\ShowTypeModel;
use App\Models\MatchFormatModel;
use App\Models\WrestlerModel;
use App\Models\TitleModel;

class InsertController extends AbstractController
{
    public function insert()
    {

        $showTypeModel = new ShowTypeModel();
        $show_types = $showTypeModel->findAll();

        return $this->render("insert.php", [
            'show_types' => $show_types
        ]);
    }
    public function insertStep2()
    {
        $show_type_id = $_POST['show_type_id'] ?? null;

        return $this->render("insertStep2.php", [
            "show_type_id" => $show_type_id
        ]);
    }

    public function insertStep3()
    {

        $show_type_id = $_POST['show_type_id'] ?? null;
        $show_name = $_POST['show_name'] ?? null;
        $show_number = $_POST['show_number'] ?? null;

        if (!$show_type_id) {
            die("Erreur : type de show non défini.");
        }

        $matchFormatModel = new MatchFormatModel();
        $match_formats = $matchFormatModel->findAll();

        return $this->render("insertStep3.php", [
            'show_type_id' => $show_type_id,
            'show_name' => $show_name,
            'show_number' => $show_number,
            'match_formats' => $match_formats
        ]);
    }

    public function insertStep4()
    {
        $show_type_id = $_POST['show_type_id'] ?? null;
        $show_name = $_POST['show_name'] ?? null;
        $show_number = $_POST['show_number'] ?? null;
        $match_format_id = $_POST['match_format_id'] ?? null;

        if (!$match_format_id || !$show_type_id) {
            throw new \Exception("Données incomplètes.");
        }

        $db = new \PDO('mysql:host=localhost;dbname=wwe;charset=utf8', 'root', 'root');

        $stmt = $db->prepare("INSERT INTO shows (show_type_id, number, name) VALUES (?, ?, ?)");
        $stmt->execute([
            $show_type_id,
            $show_number !== '' ? $show_number : null,
            $show_name !== '' ? $show_name : null
        ]);
        $showId = $db->lastInsertId();

        $matchTypeModel = new \App\Models\MatchTypeModel();
        $match_types = $matchTypeModel->findByFormatId((int)$match_format_id);

        $formatsTypesModel = new \App\Models\FormatsMatchsTypesMatchsModel();
        $formatsTypes = $formatsTypesModel->findByFormatId((int)$match_format_id);

        return $this->render("insertStep4.php", [
            'match_types' => $match_types,
            'match_format_id' => $match_format_id,
            'show_id' => $showId,
            'show_type_id' => $show_type_id,
            'formatsTypes' => $formatsTypes
        ]);
    }

    public function insertStep5()
    {

        $formatTypeId = $_POST['format_id'] ?? null;
        $matchTypeId = $_POST['match_type_id'] ?? null;
        $showName = $_POST['show_name'] ?? null;
        $showNumber = $_POST['show_number'] ?? null;
        $showTypeId = $_POST['show_type_id'] ?? null;
        $showId = $_POST['show_id'] ?? null;
        $customCount = $_POST['custom_participants'] ?? null;

        if (!isset($formatTypeId, $matchTypeId, $showTypeId, $showId)) {
            throw new \Exception("Données manquantes pour l'insertion du match.");
        }

        $formatsTypesModel = new \App\Models\FormatsMatchsTypesMatchsModel();
        $format = $formatsTypesModel->find($formatTypeId);

        if (!$format) {
            throw new \Exception("Format introuvable.");
        }

        $matchFormatModel = new \App\Models\MatchFormatModel();
        $matchFormat = $matchFormatModel->find($format->matchformats_id);
        $defaultCount = $matchFormat->default_participant_count ?? null;

 
        if ($defaultCount === null && $customCount === null) {
            return $this->render('insertStep5.php', [
                'participantsNumber' => 0,
                'wrestlers' => (new WrestlerModel())->findAll(),
                'formatId' => $formatTypeId,
                'matchTypeId' => $matchTypeId,
                'showName' => $showName,
                'showNumber' => $showNumber,
                'showTypeId' => $showTypeId,
                'showId' => $showId,
                'titles' => (new TitleModel())->findAll()
            ]);
        }

        // Priorité au defaultCount, sinon customCount
        if ($defaultCount !== null) {
            $participantsNumber = (int) $defaultCount;
        } else {
            $participantsNumber = (int) $customCount;
        }

        // Sinon, afficher le vrai formulaire avec les sélections
        $wrestlerModel = new WrestlerModel();
        $titleModel = new TitleModel();

        return $this->render('insertStep5.php', [
            'participantsNumber' => $participantsNumber,
            'wrestlers' => $wrestlerModel->findAll(),
            'formatId' => $formatTypeId,
            'matchTypeId' => $matchTypeId,
            'showName' => $showName,
            'showNumber' => $showNumber,
            'showTypeId' => $showTypeId,
            'showId' => $showId,
            'titles' => $titleModel->findAll()
        ]);
    }
    public function saveResult()
    {

        $formatTypeId = $_POST['format_id'] ?? null;
        $matchTypeId = $_POST['match_type_id'] ?? null;
        $showTypeId = $_POST['show_type_id'] ?? null;
        $showId = $_POST['show_id'] ?? null;
        $wrestlerIds = $_POST['wrestlers'] ?? [];
        $participantsNumber = $_POST['participants_number'] ?? null;
        $winnerIndexes = $_POST['winners'] ?? [];
        $isMainEvent = isset($_POST['is_main_event']) ? 1 : 0;
        $titleId = $_POST['title_id'] ?? null;

        if (!$matchTypeId || !$showTypeId || !$showId || empty($wrestlerIds)) {
            throw new \Exception("Champs manquants.");
        }

        $db = new \PDO('mysql:host=localhost;dbname=wwe;charset=utf8', 'root', 'root');

        $titleId = $titleId === '' ? null : (int)$titleId;

        $stmt = $db->prepare("INSERT INTO matches (show_id, formats_matchs_types_matchs_id, is_main_event, title_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$showId, $formatTypeId, $isMainEvent, $titleId]);

        $matchId = $db->lastInsertId();

        $winnerTeamIndex = $_POST['winner_team_index'] ?? null;
        $isTagTeam = $participantsNumber !== null && $participantsNumber > 0 && isset($_POST['winner_team_index']);

        $teams = $_POST['teams'] ?? [];

        foreach ($wrestlerIds as $index => $wrestlerId) {
            $teamNumber = isset($teams[$index]) ? (int)$teams[$index] : 0;
            $isWinner = 0;

            if ($isTagTeam) {
                if ($teamNumber == $winnerTeamIndex + 1) {
                    $isWinner = 1;
                }
            } else {
                $isWinner = in_array($index, $winnerIndexes) ? 1 : 0;
            }

            $stmt = $db->prepare("INSERT INTO match_participants (match_id, wrestler_id, is_winner, team_number) VALUES (?, ?, ?, ?)");
            $stmt->execute([$matchId, $wrestlerId, $isWinner, $teamNumber]);
        }

        echo "<script>
                     alert('Match enregistré avec succès !');
                     window.location.href = 'index.php?controller=home&action=accueil';
            </script>";
    }
}
