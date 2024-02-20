<html>

  <head>
    <meta charset="utf-8">
    <title>validation_seance</title>
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

          $q1  = 'SELECT DISTINCT t.nom,s.Dateseance,s.idseance FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme INNER JOIN
          inscription as i ON i.idseance=s.idseance WHERE s.Dateseance<=CURDATE()
          ORDER BY s.Dateseance DESC';
          /*selectionne les séances passées avec leur nom de thème.*/

          $liste_seances= mysqli_query($connect, $q1);
          echo "<h2>Noter les élèves d'une séance</h2><br><br>";
          if (!$liste_seances) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          elseif (mysqli_num_rows($liste_seances)) {//test s'il y a des séances
            echo "<FORM METHOD='POST' ACTION='valider_seance.php'>";
            echo "<p>Choix de la séance : <SELECT name='seance' REQUIRED>";
            echo "<option value='' selected disabled hidden>-- choisissez une séance --</option>";
            //option permettant d'afficher un texte non selectionnable dans un select
            foreach ($liste_seances as $seance) {
              echo "<option value=$seance[idseance]>";
              echo "$seance[nom] - ".date('d/m/Y',strtotime($seance['Dateseance']));
              echo "</option>";
            }
            echo "</select></p>";
            echo "<p><INPUT type='reset' value='Réinitialiser'> ";
            echo "<INPUT type='submit' value='Noter séance'></p>";
            echo "</FORM>";
          }
          else {
            echo "</p>Il n'y a pas de séance à notée !</p>";
            echo "<img src='icone_rejet.png'>";
          }
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
