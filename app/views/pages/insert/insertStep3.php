<div class="insertform2">
    <h2 class="format-title">Choisissez le type de match (par nombre de participants)</h2>

    <form method="POST" action="index.php?controller=insert&action=insertStep4" class="ppv-form-grid">
        <input type="hidden" name="show_type_id" value="<?= htmlspecialchars($show_type_id) ?>">
        <?php if ($show_name): ?>
            <input type="hidden" name="show_name" value="<?= htmlspecialchars($show_name) ?>">
        <?php endif; ?>
        <?php if ($show_number): ?>
            <input type="hidden" name="show_number" value="<?= htmlspecialchars($show_number) ?>">
        <?php endif; ?>

        <?php foreach ($match_formats as $format): ?>
            <button type="submit" name="match_format_id" value="<?= $format['id'] ?>" class="ppv-match-button">
                <?= htmlspecialchars($format['name_type']) ?>
            </button>
        <?php endforeach; ?>
    </form>
</div>