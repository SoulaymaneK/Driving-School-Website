<html>
  <head>
    <meta charset="utf-8">
    <title>seance_consult</title>
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
          $date = date("Y\-m\-d");//date du jour

          /*On va selectionner d'un coté les séances passées et d'un autre coté les séances futures par souci d'affichage et
          d'optimisation. On aurait pu sélectionner toutes les séances d'un coup*/
          $q1  = 'SELECT t.nom,s.Dateseance,s.idseance FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
          WHERE s.Dateseance<=CURDATE()
          ORDER BY s.Dateseance';
          $seance_passe= mysqli_query($connect, $q1);

          $q2 = 'SELECT t.nom,s.Dateseance,s.idseance FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
          WHERE s.Dateseance>CURDATE()
          ORDER BY s.Dateseance';
          $seance_futur= mysqli_query($connect, $q2);

          echo "<h2>Consulter les informations d'une séance</h2><br><br>";

          if (!$seance_passe or !$seance_futur) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          elseif (mysqli_num_rows($seance_passe) or mysqli_num_rows($seance_futur)) {
            echo "<FORM METHOD='POST' ACTION='seance_consulter.php'>";
            echo "<p>Choix de la séance : <SELECT name='seance' REQUIRED>";
            echo "<option value='' selected disabled hidden>-- choisissez une séance --</option>";
            //option pour afficher un texte non selectionnable dans le select
            if (mysqli_num_rows($seance_passe)) {//s'il y a des séances passées on les affiches entres elles
              echo "<optgroup label='-- Séance passée --'>";
              foreach ($seance_passe as $seance) {
                echo "<option value=$seance[idseance]>";
                echo "$seance[nom] - ".date('d/m/Y',strtotime($seance['Dateseance']));
                echo "</option>";
              }
              echo "</optgroup>";
            }
            if (mysqli_num_rows($seance_futur)) {//s'il y'a des séances futures on les affiches entres elles
              echo "<optgroup label='-- Séance future --'>";
              foreach ($seance_futur as $seance) {
                echo "<option value=$seance[idseance]>";
                echo "$seance[nom] - ".date('d/m/Y',strtotime($seance['Dateseance']));
                echo "</option>";
              }
              echo "</optgroup>";
            }
            echo "</select></p>";
            echo "<p><INPUT type='reset' value='Réinitialiser'> ";
            echo "<INPUT type='submit' value='Consulter'></p>";
            echo "</FORM>";
          }
          else {//sinon message d'erreur
            echo "</p>Il n'y a pas de séance à consulter!</p>";
            echo "<img src='icone_rejet.png'>";
          }
          mysqli_close($connect);
        ?>
      </div>
    </div>
    </form>
  </body>
</html>
