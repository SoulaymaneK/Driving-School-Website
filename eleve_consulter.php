<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>eleve_consulter</title>
    <link rel="stylesheet" type="text/css" href="monsite.css">
  </head>
  <body>
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

          $query = "SELECT e.*,COUNT(i.idseance) as c FROM eleves as e INNER JOIN inscription as i ON i.ideleve=e.ideleve
          INNER JOIN seances as s ON s.idseance=i.idseance
          WHERE e.ideleve=$ideleve and s.Dateseance<CURDATE()";
          //on récupère les infos de l'élève selectionné et son nombre de séances futures
          $info_eleve = mysqli_query($connect,$query);

          $q2 = "SELECT AVG(i.note) as n FROM inscription as i INNER JOIN eleves as e ON i.ideleve=e.ideleve
          WHERE e.ideleve=$ideleve and i.note>=0 and i.note<=40";
          //on récupère le nombre de fautes moyens à toutes ses séances de code effectuées
          $moyenne =  mysqli_query($connect,$q2);

          if (!$info_eleve or !$moyenne) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          else {
            echo "<h2>Informations de l'élève :</h2><br><br>";
            foreach ($info_eleve as $info) {
              echo "<p>Il s'agit de l'élève <b>$info[nom] $info[prenom]</b>.<br><br>";
              echo "Il est né le <b>".date('d/m/Y',strtotime($info['datenaissance']))."</b>.<br><br>";
              echo "Il est inscrit depuis le <b>".date('d/m/Y',strtotime($info['dateinscription']))."</b>.<br><br>";
              if ($info['c']==0) {
                echo "Il n'a effectué aucune séance de code jusqu'à aujourd'hui.<br><br></p>";
              }
              else {
                echo "Il a effectué <b>$info[c] séances</b> de code jusqu'à aujourd'hui.<br><br>";
                foreach ($moyenne as $m) {
                  echo "Son nombre de fautes moyen actuellement est de <b>".round($m['n'],2)." faute(s)</b>.<p>";
                }
              }
            }
          }
          echo "<p><a href='eleve_consult.php'>Cliquer ici pour consulter un autre élève</a></p>";
          mysqli_close($connect);
         ?>
      </div>
    </div>

  </body>
</html>
