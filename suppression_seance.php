<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>suppression_seance</title>
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
    </div>
    <!--Page de droite-->
    <div class="pdroite">
        <?php
          include("connexion.php");

          $q2 ='SELECT s.idseance,s.Dateseance,s.EffMax,t.nom FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
          WHERE s.Dateseance>=CURDATE()
          ORDER BY s.Dateseance';
          //on selectionne toutes les séances futures
          $liste_seances = mysqli_query($connect,$q2);

          echo "<h2>Suppression d'une séance</h2><br><br>";
          if (!$liste_seances) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          elseif (!mysqli_num_rows($liste_seances)) {//test s'il y a bien des séances futures qui existent
            echo "<p>Il n'y a pas de future séance !</p>";
            echo "<img src='icone_rejet.png'>";
            echo "<p><a href='autoecole.html'>Cliquer ici pour retourner à l'acceuil</a></p>";
          }
          else {//si oui , on les affiche
            echo "<form action='supprimer_seance.php' method='POST'>";
            echo "<p>Séance : <SELECT NAME='seance' REQUIRED>";
            echo "<option value='' selected disabled hidden>-- choisissez une séance --</option>";
            //option permettant d'afficher un texte non selectionnable dans le select
            foreach ($liste_seances as $seance) {
              $q3 = "SELECT COUNT(i.ideleve) as c FROM inscription as i INNER JOIN seances as s ON i.idseance=s.idseance
              WHERE s.idseance = $seance[idseance]";
              //requête pour récuperer le nombre d'inscrits pour chaque séance future existante (souci d'affichage)
              $nombre_eleves = mysqli_query($connect,$q3);
              foreach ($nombre_eleves as $nb) {
                echo "<OPTION VALUE='$seance[idseance]'>";
                echo "$seance[nom] - ".date('d/m/Y',strtotime($seance['Dateseance']))." - $nb[c] inscrit(s)";
                echo "</OPTION>";
              }
            }
            echo "</SELECT></p>";
            echo "<p><input type='reset' value='Réinitialiser'> ";
            echo "<input type='submit' value='Supprimer'></p>";
            echo "</form>";
          }
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
