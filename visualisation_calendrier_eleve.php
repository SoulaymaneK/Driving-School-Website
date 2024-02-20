<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>visualisation_calendrier_eleve</title>
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

          $query = 'SELECT * FROM eleves';
          $liste_eleves = mysqli_query($connect,$query);
          if (!$liste_eleves) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }

          elseif (!mysqli_num_rows($liste_eleves)) {//test s'il ya des élèves
            echo "Il n'y a pas d'élève inscrit dans votre autoécole !";
          }

          else {//si oui
            echo "<h2>De quel élève souhaitez-vous visualiser les séances ?</h2><br><br>";
            echo "<form action='visualiser_calendrier_eleve.php' method='POST'>";
            echo "<p>Élève : ";
            echo "<SELECT NAME='eleve' REQUIRED>";
            echo "<option value='' selected disabled hidden>-- choisissez un élève --</option>";
            //option permettant d'afficher un texte non selectionnable dans un select
            foreach ($liste_eleves as $eleve) {
              echo "<OPTION VALUE='$eleve[ideleve]'>";
              echo "$eleve[prenom] $eleve[nom]";
              echo "</OPTION>";
            }
            echo "</SELECT></p>";
            echo "<p><input type='submit' value='Consulter'></p>";
            echo "</form>";
            mysqli_close($connect);
          }
         ?>
      </div>
    </div>
  </body>
</html>
