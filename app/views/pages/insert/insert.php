<form method="POST" action="index.php?controller=insert&action=insertStep2" class="insertform">
    <div class="menu-container">
        <h1 class="menu-title">SELECT SHOW:</h1>
        <div class="show-type-grid">
            <?php foreach ($show_types as $type): ?>
                <div class="show-type-option">
                    <button type="submit" name="show_type_id" value="<?= $type['id'] ?>">
                        <img src="./public/assets/img/<?= strtolower($type['name']) ?>.webp" alt="<?= $type['name'] ?>">
                        <span><?= htmlspecialchars($type['name']) ?></span>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</form>