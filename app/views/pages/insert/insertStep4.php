<div class="insertform2">
    <h2 class="format-title">Choose the match format + stipulation</h2>

    <div class="ppv-form-grid">
        <?php foreach ($formatsTypes as $row): ?>
            <form method="POST" action="index.php?controller=insert&action=insertStep5">
                <input type="hidden" name="show_type_id" value="<?= htmlspecialchars((string)$show_type_id) ?>">
                <input type="hidden" name="show_id" value="<?= htmlspecialchars($show_id) ?>">
                <input type="hidden" name="format_id" value="<?= htmlspecialchars((string)($row['id'] ?? '')) ?>">
                <input type="hidden" name="match_type_id" value="<?= htmlspecialchars($row['match_type_id']) ?>">

                <?php if ($show_type_id == 3): // PPV 
                ?>
                    <input type="hidden" name="show_name" value="<?= htmlspecialchars((string)($show_name ?? '')) ?>">
                <?php else: ?>
                    <input type="hidden" name="show_number" value="<?= htmlspecialchars((string)($show_number ?? '')) ?>">
                <?php endif; ?>

                <button type="submit" class="ppv-match-button2">
                    <?= htmlspecialchars(($row['format_name'] ?? 'Unknown Format') . ' - ' . ($row['type_name'] ?? 'Unknown Type')) ?>
                </button>
            </form>
        <?php endforeach; ?>
    </div>
</div>