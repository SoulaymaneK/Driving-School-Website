<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>theme_consult</title>
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
          /*on selectionne les themes supprimés et les themes actifs pour pouvoir les affichers regroupés entres eux*/
          $query = 'SELECT * FROM themes WHERE supprime=FALSE';
          $themes_actif = mysqli_query($connect,$query);
          $q2 = 'SELECT * FROM themes WHERE supprime=TRUE';
          $themes_innactif = mysqli_query($connect,$q2);

          if (!$themes_actif or !$themes_innactif) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          elseif (mysqli_num_rows($themes_actif) or mysqli_num_rows($themes_innactif)) {//test s'il exite des thèmes
            echo "<h2>De quel thème souhaitez-vous visualiser les informations ?</h2><br><br>";
            echo "<p><form action='theme_consulter.php' method='POST'>";
            echo "<p>Thème : <SELECT NAME='theme' REQUIRED>";
            echo "<option value='' selected disable hidden>-- choisissez un thème --</option>";
            /*option permettant d'afficher un texte non selectionnable dans un select*/
            if (mysqli_num_rows($themes_actif)) {//test s'il y'a des themes actifs
              echo "<optgroup label='-- Thème actif --'>";
              foreach ($themes_actif as $theme) {
                echo "<OPTION VALUE='$theme[idtheme]'>";
                echo "$theme[nom]";
                echo "</OPTION>";
              }
              echo "</optgroup>";
            }
            if (mysqli_num_rows($themes_innactif)) {//test s'il y a des themes supprimés
              echo "<optgroup label='-- Thème innactif --'>";
              foreach ($themes_innactif as $theme) {
                echo "<OPTION VALUE='$theme[idtheme]'>";
                echo "$theme[nom]";
                echo "</OPTION>";
              }
              echo "</optgroup>";
            }
            echo "</SELECT></p>";
            echo "<p><input type='submit' value='Consulter'></p>";
            echo "</form>";
          }
          else {
            echo "<p> Il n'existe pas encore de thème !</p>";
            echo "<img src='icone_rejet.png'>";
            echo "<p><a href='autoecole.html'>Cliquer ici pour revenir à l'acceuil</a></p>";
          }
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
