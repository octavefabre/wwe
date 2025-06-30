<div class="showlist-container">
    <h2 class="showlist-title"><?= htmlspecialchars($title) ?></h2>

    <?php
    $alreadyDisplayed = [];

    foreach ($shows as $row):
        $showKey = $row['show_name'] . '#' . $row['show_number'];
        if (!in_array($showKey, $alreadyDisplayed)):
            if (!empty($alreadyDisplayed)) echo "</div>"; 
            echo '<div class="showlist-show-box">';
            echo '<h3 class="showlist-show-name">';
            $showType = $row['show_type_name'] ?? '';
            $showName = $row['show_name'] ?? '';
            $showNumber = $row['show_number'] ?? '';

            if (strtoupper($showType) === 'PPV') {
                echo !empty($showName) ? htmlspecialchars($showName) : 'PPV sans nom';
            } elseif (!empty($showType) && isset($showNumber)) {
                echo htmlspecialchars($showType . ' #' . $showNumber);
            } else {
                echo 'Show non identifié';
            }
            echo '</h3>';

            $alreadyDisplayed[] = $showKey;
        endif;
    ?>

        <div class="showlist-match">
            <p class="showlist-match-format">
                <?php if (!empty($row['is_main_event'])): ?>
                    <span class="showlist-main-event">Main Event</span>
                    <br>
                <?php endif; ?>
                <?= htmlspecialchars($row['match_type']) ?>
            </p>

            <?php if (!empty($row['title_name'])): ?>
                <p class="showlist-match-title">Titre en jeu : <?= htmlspecialchars($row['title_name']) ?></p>
            <?php endif; ?>

            <div class="showlist-match-participants">
                <?php
                $participants = $row['participants_full'];
                $winners = $row['winners'] ?? [];

                $teams = [];
                foreach ($participants as $p) {
                    $teamNum = (int) $p['team_number'];
                    $teams[$teamNum][] = $p['name'];
                }

                $teamStrings = [];
                foreach ($teams as $team) {
                    $parts = [];
                    foreach ($team as $wrestler) {
                        $label = htmlspecialchars($wrestler);
                        if (in_array($wrestler, $winners)) {
                            $label .= " 🏆";
                        }
                        $parts[] = $label;
                    }
                    $teamStrings[] = implode(' & ', $parts);
                }

                for ($i = 0; $i < count($teamStrings); $i++) {
                    echo '<p class="showlist-participant-line">' . $teamStrings[$i] . '</p>';
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