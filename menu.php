<?php
function css_classes($page) {
  $classes='class="';
  if ($page==basename($_SERVER["SCRIPT_FILENAME"], '.php')) $classes.='active ';
  return $classes.'"';
}
 ?>
 <ul class="menu">
   <li><a href="eleve_consult.php" <?= css_classes('eleve_consult') ?>>Home</a></li>
   <li><a href="ajout_seance.php" <?= css_classes('ajout_seance') ?>>About</a></li>
 </ul>
