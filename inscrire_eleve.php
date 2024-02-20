<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>inscrire_eleve</title>
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

          $ideleve = $_POST["eleve"];
          $idseance = $_POST["seance"];

          $qverif = "SELECT * FROM inscription WHERE ideleve=$ideleve and idseance=$idseance";
          $rverif = mysqli_query($connect,$qverif);//On verifie que l'élève n'est pas déjà inscrit à la séance

          echo "<h2>Inscription à une séance</h2><br><br>";
          if (mysqli_num_rows($rverif)) {//Si l'élève est déjà inscrit
            $q2 = "SELECT e.nom, e.prenom, t.nom as nomt, s.Dateseance FROM eleves as e INNER JOIN seances as s ON e.ideleve=$ideleve AND
            s.idseance=$idseance INNER JOIN themes as t ON t.idtheme=s.idtheme";
            /*on select les informations de l'élève et de la séance pour pouvoir les afficher à l'utilisateur*/
            $info_insc = mysqli_query($connect,$q2);
            if (!$info_insc) {
              echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            }
            //on affiche un message d'erreur
            foreach ($info_insc as $insc) {
              echo "<p>L'élève $insc[nom] $insc[prenom] est déja inscrit à la séance du ".date('d/m/Y',strtotime($insc['Dateseance']))." sur $insc[nomt].</p>";
              echo "<img src='icone_rejet.png'>";
            }
          }
          else {//Sinon on inscrit l'élève à la séance
            $q1 = "INSERT INTO inscription VALUES($idseance,$ideleve,-1)";
            $r1 = mysqli_query($connect,$q1);
            if (!$r1) {
              echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            }

            $q2 = "SELECT e.nom, e.prenom, t.nom as nomt, s.Dateseance FROM eleves as e INNER JOIN seances as s ON e.ideleve=$ideleve AND
            s.idseance=$idseance INNER JOIN themes as t ON t.idtheme=s.idtheme";
            /*on select les informations de l'élève et de la séance pour pouvoir les afficher à l'utilisateur*/
            $info_insc = mysqli_query($connect,$q2);
            if (!$info_insc) {
              echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            }

            foreach ($info_insc as $insc) {
              echo "<p><font color='blue'>L'élève $insc[nom] $insc[prenom] a bien été inscrit à la séance du ".date('d/m/Y',strtotime($insc['Dateseance']))."
              sur $insc[nomt].</font color></p>";
              echo "<img src='icone_validation.png'>";
            }
          }
          echo "<p><a href='inscription_eleve.php'>Cliquer ici pour inscrire un nouvel élève</a></p>";
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
