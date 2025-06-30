 <form method="POST" action="index.php?controller=insert&action=insertStep3" class="insertform">
     <input type="hidden" name="show_type_id" value="<?= htmlspecialchars((string)$show_type_id) ?>">

     <?php if ($show_type_id == 3): ?>
         <div class="ppvform">
             <div class="ppvform2">
                 <label For="show_name" class="ppv-name">
                     Nom du PPV :
                 </label>
                 <input type="text" name="show_name" id="show_name" required class="input-ppv-name" />

                 <button type="submit" class="button-ppv-choice">
                     Suivant
                 </button>
             </div>
         </div>
     <?php else: ?>
         <div class="ppv-number">
             <div class="ppv-number2">
                 <label For="show_number" class="ppv-name2">
                     Numéro du show :
                 </label>
                 <input type="number" name="show_number" id="show_number" required class="ppv-input" />

                 <button type="submit" class="ppv-button">
                     Suivant
                 </button>
             </div>
         </div>
     <?php endif; ?>

     <button type="submit">Suivant</button>
 </form>