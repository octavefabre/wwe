<?php if (!isset($participantsNumber)) {
    $participantsNumber = 0;
} 

$teamMatchTypes = [2, 3, 4, 50]; 
$isTeamMatch = in_array((int)$matchTypeId, $teamMatchTypes);

 if (empty($participantsNumber)): ?>
    <!-- Étape 1 : choix du nombre de participants -->
    <div class="insert-match-container">
        <form method="POST" action="index.php?controller=insert&action=insertStep5" class="insert-match-wrapper">
            <h2 class="insert-match-title">Nombre de participants :</h2>

            <input type="hidden" name="format_id" value="<?= htmlspecialchars($formatId) ?>">
            <input type="hidden" name="show_id" value="<?= htmlspecialchars($showId) ?>">
            <input type="hidden" name="match_type_id" value="<?= htmlspecialchars($matchTypeId) ?>">
            <input type="hidden" name="show_type_id" value="<?= htmlspecialchars($showTypeId) ?>">
            <input type="hidden" name="show_name" value="<?= htmlspecialchars($showName) ?>">
            <input type="hidden" name="show_number" value="<?= htmlspecialchars($showNumber) ?>">

            <div class="insert-match-input-group">
                <input type="number" name="custom_participants" min="2" max="30" required class="insert-match-number-input">
            </div>

            <div class="insert-match-actions">
                <button type="submit" class="insert-match-button">Continuer</button>
            </div>
        </form>
    </div>

<?php else: ?>
    <!-- Étape 2 : sélection des participants -->
    <form method="POST" action="index.php?controller=insert&action=saveResult" class="insert-match-form">
        <input type="hidden" name="format_id" value="<?= htmlspecialchars($formatId) ?>">
        <input type="hidden" name="show_id" value="<?= htmlspecialchars($showId) ?>">
        <input type="hidden" name="match_type_id" value="<?= htmlspecialchars($matchTypeId) ?>">
        <input type="hidden" name="show_type_id" value="<?= htmlspecialchars($showTypeId) ?>">
        <input type="hidden" name="participants_number" value="<?= $participantsNumber ?>">

        <h2 class="insert-match-title">Choisissez les catcheurs</h2>

        <?php if ($isTeamMatch): ?>
            <?php
            $teams = ($participantsNumber >= 4 && $participantsNumber % 2 === 0) ? $participantsNumber / 2 : 2;
            $perTeam = floor($participantsNumber / $teams);
            $i = 0;
            for ($t = 1; $t <= $teams; $t++): ?>
                <div class="insert-match-team-card">
                    <h3 class="insert-match-team-title">Équipe <?= $t ?></h3>
                    <div class="insert-match-team-members">
                        <?php for ($j = 1; $j <= $perTeam; $j++, $i++): ?>
                            <div class="insert-match-wrestler-select-group">
                                <label for="wrestler_<?= $i ?>" class="insert-match-label">Catcheur <?= $i + 1 ?> :</label>
                                <select name="wrestlers[]" id="wrestler_<?= $i ?>" required class="insert-match-select">
                                    <option value="">-- Choisir --</option>
                                    <?php foreach ($wrestlers as $wrestler): ?>
                                        <option value="<?= htmlspecialchars($wrestler['id']) ?>"><?= htmlspecialchars($wrestler['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="teams[]" value="<?= $t ?>">
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endfor; ?>

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
            <div class="insert-match-individual-section">
                <?php for ($i = 0; $i < $participantsNumber; $i++): ?>
                    <div class="insert-match-wrestler-select-group">
                        <label for="wrestler_<?= $i ?>" class="insert-match-label">Catcheur <?= $i + 1 ?> :</label>
                        <select name="wrestlers[]" id="wrestler_<?= $i ?>" required class="insert-match-select">
                            <option value="">-- Choisir --</option>
                            <?php foreach ($wrestlers as $wrestler): ?>
                                <option value="<?= htmlspecialchars($wrestler['id']) ?>"><?= htmlspecialchars($wrestler['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="teams[]" value="<?= $i + 1 ?>">
                    </div>
                <?php endfor; ?>
            </div>

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

        <div class="insert-match-title-section">
            <h3 class="insert-match-section-title">Match pour un titre</h3>
            <select name="title_id" class="insert-match-select">
                <option value="">-- Aucun titre --</option>
                <?php foreach ($titles as $title): ?>
                    <option value="<?= $title['id'] ?>"><?= htmlspecialchars($title['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="insert-match-main-event">
            <label class="insert-match-checkbox-option">
                <input type="checkbox" name="is_main_event" value="1" class="insert-match-checkbox">
                ⭐ Main Event
            </label>
        </div>

        <div class="insert-match-actions">
            <button type="submit" class="insert-match-button">Valider</button>
        </div>
    </form>
<?php endif; ?>