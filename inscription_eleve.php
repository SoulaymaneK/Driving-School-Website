<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>inscription_eleve</title>
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

          $q1 = 'SELECT * FROM eleves';//on récupère tous les élèves
          $liste_eleves = mysqli_query($connect,$q1);
          if (!$liste_eleves) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }

          $q2 ='SELECT s.idseance,s.Dateseance,s.EffMax,t.nom FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
          WHERE s.Dateseance>=CURDATE() AND s.EffMax>=(SELECT COUNT(i.ideleve) FROM seances as s INNER JOIN
          themes as t ON s.idtheme=t.idtheme INNER JOIN inscription as i ON i.idseance=s.idseance WHERE s.Dateseance>=CURDATE()
          AND t.supprime=FALSE ORDER BY s.Dateseance)
          ORDER BY s.Dateseance';
          /*Cette requête permet de selectionner les infos des séances futures et surtout de selectionner directement que les
          séances contenant des un nombre d'élèves inférieure à l'effectif max de la séance*/
          $liste_seances = mysqli_query($connect,$q2);

          if (!$liste_seances) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            exit;
          }
          echo "<h2>Inscription à une séance</h2><br><br>";
          if (!mysqli_num_rows($liste_seances)) {//test s'il y a bien des futures séances existantes ou ayant de la place
            echo "<p>Il n'y a pas de future séance ! </p>";
            echo "<img src='icone_rejet.png'>";
            echo "<p><a href='autoecole.html'>Cliquer ici pour revenir à l'acceuil</a></p>";
          }
          else {
            echo "<form action='inscrire_eleve.php' method='POST'>";
            /*select pour la liste des élèves*/
            echo "<p>Élève : <SELECT NAME='eleve' REQUIRED>";
            echo "<option value='' selected disabled hidden>-- chosissez un élève --</option>";
            /*cette option permet d'afficher un texte non selectionnable dans le select*/
            foreach ($liste_eleves as $eleve) {
              echo "<OPTION VALUE='$eleve[ideleve]'>";
              echo "$eleve[prenom] $eleve[nom]";
              echo "</OPTION>";
            }
            echo "</SELECT></p>";

            echo "<form action='inscrire_eleve.php' method='POST'>";
            /*select pour le liste des séances*/
            echo "<p>Séance : <SELECT NAME='seance' REQUIRED>";
            echo "<option value='' selected disabled hidden>-- chosissez une séance --</option>";
            foreach ($liste_seances as $seance) {
              $q3 = "SELECT COUNT(i.ideleve) as c FROM inscription as i INNER JOIN seances as s ON i.idseance=s.idseance
              WHERE s.idseance = $seance[idseance]";
              /*on select le nombre d'élève déjà inscrits à chaque séance selectionnée pour pouvoir calculer et affiché
              le nombre de places disponibles à l'utilisateur*/
              $nombre_eleves = mysqli_query($connect,$q3);
              $place = 0;
              foreach ($nombre_eleves as $nb) {
                $place = $seance['EffMax'] - $nb['c'];//on calcule le nombre de place dispo dans la séance
                echo "<OPTION VALUE='$seance[idseance]'>";
                echo "$seance[nom] - ".date('d/m/Y',strtotime($seance['Dateseance']))." - $place places ";
                echo "</OPTION>";
              }
            }
            echo "</SELECT></p>";
            echo "<p><input type='reset' value='Réinitialiser'> ";
            echo "<input type='submit' value='Inscrire'></p>";
            echo "</form>";
          }
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
