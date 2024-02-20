<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>supprimer_theme</title>
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

          $idtheme = $_POST['theme'];

          $q1 = "SELECT * FROM themes where idtheme=$idtheme";
          $theme = mysqli_query($connect,$q1);
          if (!$theme) {
            echo "<p> La requête 1 a échoué : ". mysqli_error($connect) . "</p>";
            mysqli_close($connect);
            exit;
          }

          $q2 = "UPDATE themes SET supprime=True WHERE idtheme=$idtheme";
          //on rend innactif le thème selectionné
          $theme_supprimer= mysqli_query($connect,$q2);
          if (!$theme_supprimer) {
            echo "<p> La requête 2 a échoué : ". mysqli_error($connect) . "</p>";
          }
          else {
            echo "<h2>Confirmation de suppression du thème</h2><br><br>";
            foreach ($theme as $t) {//pour affiche les données du thème
              echo "<p><font color='blue'>Le thème <b>$t[nom]</b> a bien été supprimé. Les séances futures sur ce thème ont été conservées.</font color></p>";
            }
          }

          /*Le bout de code ci-dessou a été laissé volontairement suite à un doute que j'ai eu de lénoncé. Je n'était pas sûr
          s'il fallait supprimer toutes les futures séances du thème supprimé et donc de desinscrire les élèves qui y étaient
          inscris. Ce code sert à ça*/

          /*$q3 = "SELECT t.nom,s.Dateseance,s.idseance FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme WHERE t.idtheme=$idtheme
          AND s.Dateseance>=CURDATE()
          ORDER BY s.Dateseance";
          $liste_seance_supprimer = mysqli_query($connect,$q3);
          if (!$liste_seance_supprimer) {
            echo "<p> La requête 3 a échoué : ". mysqli_error($connect) . "</p>";
            mysqli_close($connect);
            exit;
          }

          if (mysqli_num_rows($liste_seance_supprimer)) {
            foreach ($liste_seance_supprimer as $seance) {
              $q5 = "SELECT e.nom,e.prenom FROM eleves as e INNER JOIN inscription as i ON
              i.ideleve=e.ideleve INNER JOIN seances as s ON i.idseance=s.idseance INNER JOIN themes as t ON s.idtheme=t.idtheme
              WHERE s.idseance=$seance[idseance]";
              $liste_eleves = mysqli_query($connect,$q5);
              if (!$liste_eleves) {
                echo "<p> La requête 5 a échoué : ". mysqli_error($connect) . "</p>";
                mysqli_close($connect);
                exit;
              }

              if (!mysqli_num_rows($liste_eleves)) {
                echo "<p>La séance sur <b>$seance[nom]</b> prévu le <b>".date('d/m/Y',strtotime($seance['Dateseance']))."</b> a aussi été supprimée.
                Elle ne contenait pas d'élèves.</p>";
              }
              else {
                echo "<p>La séance sur <b>$seance[nom]</b> prévu le <b>".date('d/m/Y',strtotime($seance['Dateseance']))."</b> a aussi été supprimée.
                Le(s) élève(s) : </p>";
                echo "<p>";
                foreach ($liste_eleves as $eleve) {
                  echo "$eleve[prenom] $eleve[nom]<br><br>";
                }
                //echo "</ul>";
                echo "ont été désinscrit de cette séance.</p>";
              }

              $q6 = "DELETE FROM inscription WHERE idseance=$seance[idseance]";
              $insc_supp = mysqli_query($connect,$q6);
              if (!$insc_supp) {
                echo "<p> La requête 5 a échoué : ". mysqli_error($connect) . "</p>";
                mysqli_close($connect);
                exit;
              }
            }

            $q4 = "DELETE FROM seances WHERE idtheme=$idtheme AND Dateseance>=CURDATE()";
            $seances_supprimer = mysqli_query($connect,$q4);
            if (!$seances_supprimer) {
              echo "<p> La requête 4 a échoué : ". mysqli_error($connect) . "</p>";
              mysqli_close($connect);
              exit;
            }
          }*/
          echo "<img src='icone_validation.png'>";
          echo "<p><a href='suppression_theme.php'>Cliquer ici pour supprimer un autre thème</a></p>";
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
