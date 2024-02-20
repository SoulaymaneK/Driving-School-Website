<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>visualiser_calendrier_eleve</title>
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

          $ideleve = $_POST['eleve'];

          $query = "SELECT e.nom,e.prenom,s.Dateseance,t.nom as nomt FROM eleves as e INNER JOIN inscription as i ON e.ideleve=i.ideleve
          INNER JOIN seances as s ON s.idseance=i.idseance INNER JOIN themes as t ON t.idtheme=s.idtheme
          WHERE e.ideleve=$ideleve AND s.Dateseance>=CURDATE()
          ORDER BY s.Dateseance";
          //selectionne les infos de l'élève ainsi que la liste de ses futures séances
          $seances_eleve = mysqli_query($connect,$query);

          echo "<h2>Prochaine(s) séance(s) de l'élève :</h2><br><br>";

          if (!$seances_eleve) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          elseif (!mysqli_num_rows($seances_eleve)) {//si l'élève n'a pas de futures séances 
            $q2 = "SELECT nom,prenom FROM eleves WHERE ideleve=$ideleve";
            $eleve = mysqli_query($connect,$q2);
            if (!$eleve) {
              echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
              exit;
            }
            foreach ($eleve as $e) {
              echo "<p>L'élève $e[nom] $e[prenom] n'est inscrit à aucune séance future !</p>";
              echo "<img src='icone_rejet.png'>";
            }
          }
          else {
            foreach ($seances_eleve as $seance) {
              echo "<p>L'élève <b>$seance[nom] $seance[prenom]</b> est inscrit à : </p>";
              foreach ($seances_eleve as $seance) {
                echo "<p>La séance sur $seance[nomt] du ".date('d/m/Y',strtotime($seance['Dateseance'])).".</p>";
              }
            }
          }
          echo "<p><a href='visualisation_calendrier_eleve.php'>Cliquer ici pour consulter les séances d'un autre élève</a></p>";
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
