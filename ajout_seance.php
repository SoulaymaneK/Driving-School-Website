<html>

  <head>
    <meta charset="utf-8">
    <title>ajout_seance</title>
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
    <!-- Page de droite-->
    <div class="pdroite">
        <?php
          include("connexion.php");

          /*On fait une requête pour afficher tous les thèmes actifs*/
          $q1 = 'SELECT * FROM themes WHERE supprime=FALSE';
          $liste_theme = mysqli_query($connect, $q1);
          if (!$liste_theme) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          /*On les affiches dans un formulaire grâce à un select en demandant aussi la date et l'effectif*/
          echo <<<FIN
            <p><h2>Ajout d'une séance</h2></p><br><br>
            <FORM METHOD="POST" ACTION="ajouter_seance.php">
            <p>Choix du thème :
            <SELECT name="idtheme" REQUIRED>
            <option value="" selected disabled hidden>-- choisissez un thème --</option>
          FIN;
          /*cette option permet d'afficher un text non selectionnable sur le select*/
          foreach ($liste_theme as $theme) {
            echo <<<FIN
              <option value="$theme[idtheme]">
              $theme[nom]
              </option>
            FIN;
          }
          echo <<<FIN
            </select></p>
            <p>Date de la séance : <INPUT type="date" name=Dateseance REQUIRED></p>
            <p>Effectif maximimum : <INPUT type="number" name=effmax placeholder="nombre" min='1' REQUIRED></p>
            <p><INPUT type="reset" value="Réinitialiser">
            <INPUT type="submit" value="Enregistrer séance"></p>
            </FORM>
          FIN;
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
