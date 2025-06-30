<?php 
// Si $participantsNumber n'existe pas encore, on le met à 0 par défaut
if (!isset($participantsNumber)) {
    $participantsNumber = 0;
} 

// Liste des types de matchs en équipe (par exemple : 2 vs 2, 3 vs 3, etc.)
$teamMatchTypes = [2, 3, 4, 50]; 

// Vérifie si le type de match actuel est un match en équipe
$isTeamMatch = in_array((int)$matchTypeId, $teamMatchTypes);

// Si aucun nombre de participants n’a encore été envoyé, on affiche le premier formulaire
if (empty($participantsNumber)): ?>
    
    <!-- Formulaire pour choisir le nombre de participants -->
    <div class="insert-match-container">
        <form method="POST" action="index.php?controller=insert&action=insertStep5" class="insert-match-wrapper">
            <h2 class="insert-match-title">Nombre de participants :</h2>

            <!-- Champs cachés pour transmettre les infos du show et du match -->
            <input type="hidden" name="format_id" value="<?= htmlspecialchars($formatId) ?>">
            <input type="hidden" name="show_id" value="<?= htmlspecialchars($showId) ?>">
            <input type="hidden" name="match_type_id" value="<?= htmlspecialchars($matchTypeId) ?>">
            <input type="hidden" name="show_type_id" value="<?= htmlspecialchars($showTypeId) ?>">
            <input type="hidden" name="show_name" value="<?= htmlspecialchars($showName) ?>">
            <input type="hidden" name="show_number" value="<?= htmlspecialchars($showNumber) ?>">

            <!-- Champ pour entrer le nombre de participants -->
            <div class="insert-match-input-group">
                <input type="number" name="custom_participants" min="2" max="30" required class="insert-match-number-input">
            </div>

            <!-- Bouton pour passer à l'étape suivante -->
            <div class="insert-match-actions">
                <button type="submit" class="insert-match-button">Continuer</button>
            </div>
        </form>
    </div>

<?php else: ?>
    <!-- Si le nombre de participants est défini, on affiche le formulaire de sélection des catcheurs -->
    <form method="POST" action="index.php?controller=insert&action=saveResult" class="insert-match-form">
        
        <!-- Champs cachés pour garder les infos du match -->
        <input type="hidden" name="format_id" value="<?= htmlspecialchars($formatId) ?>">
        <input type="hidden" name="show_id" value="<?= htmlspecialchars($showId) ?>">
        <input type="hidden" name="match_type_id" value="<?= htmlspecialchars($matchTypeId) ?>">
        <input type="hidden" name="show_type_id" value="<?= htmlspecialchars($showTypeId) ?>">
        <input type="hidden" name="participants_number" value="<?= $participantsNumber ?>">

        <h2 class="insert-match-title">Choisissez les catcheurs</h2>

        <?php if ($isTeamMatch): ?>
            <?php
            // Si nombre pair et supérieur à 4, on divise en équipes égales
            $teams = ($participantsNumber >= 4 && $participantsNumber % 2 === 0) ? $participantsNumber / 2 : 2;
            $perTeam = floor($participantsNumber / $teams); // Nombre de catcheurs par équipe
            $i = 0;
            for ($t = 1; $t <= $teams; $t++): ?>
                
                <!-- Carte pour une équipe -->
                <div class="insert-match-team-card">
                    <h3 class="insert-match-team-title">Équipe <?= $t ?></h3>
                    <div class="insert-match-team-members">

                        <!-- Sélection des catcheurs de cette équipe -->
                        <?php for ($j = 1; $j <= $perTeam; $j++, $i++): ?>
                            <div class="insert-match-wrestler-select-group">
                                <label for="wrestler_<?= $i ?>" class="insert-match-label">Catcheur <?= $i + 1 ?> :</label>
                                
                                <!-- Liste déroulante avec les catcheurs -->
                                <select name="wrestlers[]" id="wrestler_<?= $i ?>" required class="insert-match-select">
                                    <option value="">-- Choisir --</option>
                                    <?php foreach ($wrestlers as $wrestler): ?>
                                        <option value="<?= htmlspecialchars($wrestler['id']) ?>"><?= htmlspecialchars($wrestler['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Champ caché pour indiquer à quelle équipe appartient le catcheur -->
                                <input type="hidden" name="teams[]" value="<?= $t ?>">
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endfor; ?>

            <!-- Choix de l'équipe gagnante -->
            <div class="insert-match-winner-section">
                <h3 class="insert-match-section-title">Sélectionnez l'équipe gagnante</h3>
                <div class="insert-match-winner-options">
                    <?php for ($t = 0; $t < $teams; $t++): ?>
                        <label class="insert-match-radio-option">
                            <input type="radio" name="winner_team_index" value="<?= $t ?>" required class="insert-match-radio">
                            Équipe <?= $t + 1 ?>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>

        <?php else: ?>
            <!-- Si ce n'est pas un match en équipe (match individuel) -->

            <div class="insert-match-individual-section">
                <?php for ($i = 0; $i < $participantsNumber; $i++): ?>
                    <div class="insert-match-wrestler-select-group">
                        <label for="wrestler_<?= $i ?>" class="insert-match-label">Catcheur <?= $i + 1 ?> :</label>
                        
                        <!-- Sélection du catcheur -->
                        <select name="wrestlers[]" id="wrestler_<?= $i ?>" required class="insert-match-select">
                            <option value="">-- Choisir --</option>
                            <?php foreach ($wrestlers as $wrestler): ?>
                                <option value="<?= htmlspecialchars($wrestler['id']) ?>"><?= htmlspecialchars($wrestler['name']) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Champ caché pour que chaque catcheur ait une "équipe" différente -->
                        <input type="hidden" name="teams[]" value="<?= $i + 1 ?>">
                    </div>
                <?php endfor; ?>
            </div>

            <!-- Choix du ou des gagnants -->
            <div class="insert-match-winner-section">
                <h3 class="insert-match-section-title">Sélectionnez le(s) gagnant(s)</h3>
                <div class="insert-match-winner-options">
                    <?php for ($i = 0; $i < $participantsNumber; $i++): ?>
                        <label class="insert-match-checkbox-option">
                            <input type="checkbox" name="winners[]" value="<?= $i ?>" class="insert-match-checkbox">
                            Catcheur <?= $i + 1 ?>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Section pour dire si le match est pour un titre -->
        <div class="insert-match-title-section">
            <h3 class="insert-match-section-title">Match pour un titre</h3>
            <select name="title_id" class="insert-match-select">
                <option value="">-- Aucun titre --</option>
                <?php foreach ($titles as $title): ?>
                    <option value="<?= $title['id'] ?>"><?= htmlspecialchars($title['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Checkbox pour marquer ce match comme "Main Event" -->
        <div class="insert-match-main-event">
            <label class="insert-match-checkbox-option">
                <input type="checkbox" name="is_main_event" value="1" class="insert-match-checkbox">
                ⭐ Main Event
            </label>
        </div>

        <!-- Bouton pour valider le formulaire -->
        <div class="insert-match-actions">
            <button type="submit" class="insert-match-button">Valider</button>
        </div>
    </form>
<?php endif; ?>