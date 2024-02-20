<html>
  <head>
    <meta charset="utf-8">
    <title>seance_consulter</title>
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

          $idseance=$_POST['seance'];

          $q1  = "SELECT 	e.nom, e.prenom, t.nom as nomt,s.Dateseance,s.EffMax FROM eleves as e INNER JOIN inscription as i ON
          e.ideleve=i.ideleve INNER JOIN seances as s ON i.idseance=s.idseance INNER JOIN themes as t ON t.idtheme=s.idtheme
          WHERE i.idseance=$idseance
          ORDER BY e.nom";
          //on selectionne toutes les informations de la séance pour l'idseance récupéré ainsi que tous les éléves inscrits à cette séance
          $seance_info= mysqli_query($connect, $q1);

          if (!$seance_info) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          else {
            echo "<h2>Informations de la séance</h2><br><br>";
            if (mysqli_num_rows($seance_info)!=0) {//s'il y a bien des élèves inscrits à cette séance, on les affiche
              foreach ($seance_info as $seance) {
                echo "<p>Il s'agit de la séance sur <b>$seance[nomt]</b> du <b>".date('d/m/Y',strtotime($seance['Dateseance']))."</b> ayant un effectif max de
                <b>$seance[EffMax] personnes</b>.</p>";
                  echo "<p>Le(s) élève(s) inscrit(s) à cette séance sont : </p>";
                  foreach ($seance_info as $seance) {
                    echo "<p>$seance[prenom] $seance[nom]</p>";
                }
              }
            }
            else {//sinon on affiche juste les informations de la séance
              $q2="SELECT t.nom,s.Dateseance,s.EffMax FROM themes as t INNER JOIN seances as s ON s.idtheme=t.idtheme
              WHERE s.idseance=$idseance";
              $info_seance = mysqli_query($connect, $q2);
              if (!$info_seance) {
                echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
              }
              foreach ($info_seance as $seance) {
                echo "<p>Il s'agit de la séance sur <b>$seance[nom]</b> du <b>".date('d/m/Y',strtotime($seance['Dateseance']))."</b> ayant un effectif max de
                <b>$seance[EffMax]</b> personnes.</p>";
                echo "<p>Il n'y a pas d'élève inscrit à cette séance.</p>";
              }
            }
          }
          echo "<p><a href='seance_consult.php'>Cliquer ici pour consulter une autre séance</a></p>";
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
