<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>supprimer_seance</title>
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

          $idseance = $_POST["seance"];

          echo "<h2>Supprimer une séance </h2><br><br>";

          $q1 = "SELECT e.ideleve,e.nom,e.prenom,s.Dateseance,t.nom as nomt FROM eleves as e INNER JOIN inscription as i ON
          i.ideleve=e.ideleve INNER JOIN seances as s ON i.idseance=s.idseance INNER JOIN themes as t ON s.idtheme=t.idtheme
          WHERE s.idseance=$idseance";
          //on récupère les infos de la séance et les élèves inscrits à cette séance
          $info_seance = mysqli_query($connect,$q1);

          if (!$info_seance) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            mysqli_close($connect);
            exit;
          }

          $q2 = "DELETE FROM seances WHERE idseance=$idseance";
          //on supprime la séance
          $seancesupp = mysqli_query($connect,$q2);
          if (!$seancesupp) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            mysqli_close($connect);
            exit;
          }

          $q3 = "DELETE FROM inscription WHERE idseance=$idseance";
          /*on supprime les lignes de la table inscription contenant l'idseance de la séance supprimée,
          désinscrivant ainsi les élèves inscrits à cette séance*/
          $elevesupp = mysqli_query($connect,$q3);
          if (!$elevesupp) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            mysqli_close($connect);
            exit;
          }

          if (!mysqli_num_rows($info_seance)) {//s'il n'y a pas d'inscrit à cette séance
            echo "<p>La séance a été supprimée, il n'y avait pas d'inscrits.</p>";
          }
          else {//s'il y a des inscrits, on les affiche
            foreach ($info_seance as $seance) {
              echo "<p>La séance du <b>".date('d/m/Y',strtotime($seance['Dateseance']))."</b> sur <b>$seance[nomt]</b> a bien été supprimée. Le(s) élève(s) : </p>";
              echo "<p>";
              foreach ($info_seance as $eleve) {
                echo "$eleve[prenom] $eleve[nom]<br><br>";
              }
              echo "</p>";
            }
            echo "<p>ont été désinscrit de cette séance.</p>";
          }
          echo "<img src='icone_validation.png'>";
          echo "<p><a href='suppression_seance.php'>Cliquer ici pour supprimer une autre séance</a></p>";
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
