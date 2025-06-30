<div class="showlist-container">
    <!-- Titre général de la liste (ex : tous les shows, tous les PPV...) -->
    <h2 class="showlist-title"><?= htmlspecialchars($title) ?></h2>

    <?php
    // Tableau pour mémoriser les shows déjà affichés
    $alreadyDisplayed = [];

    // On parcourt tous les matchs reçus dans $shows
    foreach ($shows as $row):
        // Clé unique pour identifier un show (nom + numéro)
        $showKey = $row['show_name'] . '#' . $row['show_number'];

        // Si ce show n'a pas encore été affiché
        if (!in_array($showKey, $alreadyDisplayed)):

            // Si ce n'est pas le tout premier affichage, on ferme la div du show précédent
            if (!empty($alreadyDisplayed)) echo "</div>"; 

            // On commence une nouvelle boîte de show
            echo '<div class="showlist-show-box">';
            echo '<h3 class="showlist-show-name">';

            // On récupère les infos du show
            $showType = $row['show_type_name'] ?? '';
            $showName = $row['show_name'] ?? '';
            $showNumber = $row['show_number'] ?? '';

            // Si c'est un PPV, on affiche son nom
            if (strtoupper($showType) === 'PPV') {
                echo !empty($showName) ? htmlspecialchars($showName) : 'PPV sans nom';

            // Sinon, on affiche le type de show et son numéro (ex : Raw #12)
            } elseif (!empty($showType) && isset($showNumber)) {
                echo htmlspecialchars($showType . ' #' . $showNumber);

            // Sinon, on met une info par défaut
            } else {
                echo 'Show non identifié';
            }

            echo '</h3>';

            // On marque ce show comme déjà affiché
            $alreadyDisplayed[] = $showKey;
        endif;
    ?>

        <!-- Affichage d’un match dans le show -->
        <div class="showlist-match">

            <!-- Type de match et indication "Main Event" si coché -->
            <p class="showlist-match-format">
                <?php if (!empty($row['is_main_event'])): ?>
                    <span class="showlist-main-event">Main Event</span>
                    <br>
                <?php endif; ?>
                <?= htmlspecialchars($row['match_type']) ?>
            </p>

            <!-- Affiche le titre en jeu si présent -->
            <?php if (!empty($row['title_name'])): ?>
                <p class="showlist-match-title">Titre en jeu : <?= htmlspecialchars($row['title_name']) ?></p>
            <?php endif; ?>

            <!-- Affichage des participants -->
            <div class="showlist-match-participants">
                <?php
                // On récupère les participants et les gagnants
                $participants = $row['participants_full'];
                $winners = $row['winners'] ?? [];

                // On regroupe les catcheurs par équipe
                $teams = [];
                foreach ($participants as $p) {
                    $teamNum = (int) $p['team_number'];
                    $teams[$teamNum][] = $p['name'];
                }

                // On prépare les textes à afficher pour chaque équipe
                $teamStrings = [];
                foreach ($teams as $team) {
                    $parts = [];
                    foreach ($team as $wrestler) {
                        $label = htmlspecialchars($wrestler);

                        // Si ce catcheur est gagnant, on ajoute une coupe 🏆
                        if (in_array($wrestler, $winners)) {
                            $label .= " 🏆";
                        }

                        $parts[] = $label;
                    }

                    // On crée une ligne du style "Nom1 & Nom2"
                    $teamStrings[] = implode(' & ', $parts);
                }

                // Affichage des équipes avec "VS" entre elles
                for ($i = 0; $i < count($teamStrings); $i++) {
                    echo '<p class="showlist-participant-line">' . $teamStrings[$i] . '</p>';

                    // Si ce n’est pas la dernière équipe, on affiche "VS"
                    if ($i < count($teamStrings) - 1) {
                        echo '<p class="showlist-vs">VS</p>';
                    }
                }
                ?>
            </div>
        </div>

    <?php endforeach; ?>
</div>  
</div>