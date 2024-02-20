<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>suppression_theme</title>
    <link rel="stylesheet" type="text/css" href="monsite.css">
  </head>
  <body>
    <div class="MonSite">
      <!-- Barre latérale à gauche qui fait office de menu à inclure dans tous les fichiers-->
      <div class="pgauche">
        <ul>
          <li><a href="autoecole.html" class="active"><h2>UTDrive</h2></a></li>
          <li><a href="eleve_consult.php" class="categorie">Élèves</a></li>
          <li><a href="ajout_eleve.html" class="souscat">Inscrire</a></li>
          <li><a href="visualisation_calendrier_eleve.php" class="souscat">Calendrier</a></li>
          <li><a href="theme_consult.php" class="categorie">Thèmes</a></li>
          <li><a href="ajout_theme.html" class="souscat">Ajouter</a></li>
          <li><a href="suppression_theme.php" class="souscat">Supprimer</a></li>
          <li><a href="seance_consult.php" class="categorie">Séances</a></li>
          <li><a href="ajout_seance.php" class="souscat">Créer</a></li>
          <li><a href="validation_seance.php" class="souscat">Noter</a></li>
          <li><a href="inscription_eleve.php" class="souscat">Inscrire un élève</a></li>
          <li><a href="desinscription_seance.php" class="souscat">Désinscrire</a></li>
          <li><a href="suppression_seance.php" class="souscat">Supprimer</a></li>
      </ul>
    </div>
    <!--Page de droite-->
    <div class="pdroite">
        <?php
          include("connexion.php");
          $query = 'SELECT * FROM themes where supprime=False';
          //on selectionne que les thèmes encore actif
          $liste_themes = mysqli_query($connect,$query);
          echo "<h2>Quel thème souhaitez-vous supprimer ?</h2><br><br>";

          if (!$liste_themes) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          elseif (!mysqli_num_rows($liste_themes)) {//test s'il existe bien des thèmes actifs
            echo "<p> Il n'existe pas de thème pour l'instant !</p>";
            echo "<img src='icone_rejet.png'>";
          }
          else {
            echo "<form action='supprimer_theme.php' method='POST'>";
            echo "<p>Thème : <SELECT NAME='theme' REQUIRED>";
            echo "<option value='' selected disabled hidden>-- choisissez un thème --</option>";
            //option permettant d'afficher un texte non selectionnable dans le select
            foreach ($liste_themes as $theme) {
              echo "<OPTION VALUE='$theme[idtheme]'>";
              echo "$theme[nom]";
              echo "</OPTION>";
            }
            echo "</SELECT></p>";
            echo "<p><input type='submit' value='Supprimer Thème'></p>";
            echo "</FORM>";
          }
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
