<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>desinscription_seance</title>
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

          $q1 = 'SELECT DISTINCT s.idseance,s.Dateseance,t.nom FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
          INNER JOIN inscription as i ON s.idseance=i.idseance INNER JOIN eleves as e ON i.ideleve=e.ideleve WHERE
          s.Dateseance>CURDATE()
          ORDER BY s.Dateseance';
          /*On select toutes les futurs sénces avec leur nom de thème associé et sutout qui CONTIENNENT des élèves,
          on n'affichera donc pas à l'utilisateur des seances contenant 0 eleves grâce à cette requête*/
          $liste_seances = mysqli_query($connect,$q1);

          if (!$liste_seances) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            mysqli_close($connect);
            exit;
          }
          echo "<h2>Desinscription à une séance</h2><br><br>";
          if (!mysqli_num_rows($liste_seances)) {//S'il n'y a aucune séance future avec des élèves on affiche un message
            echo "<p>Il n'y a pas de séances contenant des élèves prévues ultèrieurement !</p>";
            echo "<img src='icone_rejet.png'>";
            echo "<p><a href='autoecole.html'>Cliquer ici pour revenir à l'acceuil</a></p>";
          }
          else {
            $q2 = 'SELECT s.idseance,e.nom,e.prenom,e.ideleve FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
            INNER JOIN inscription as i ON s.idseance=i.idseance INNER JOIN eleves as e ON i.ideleve=e.ideleve WHERE
            s.Dateseance>CURDATE()
            ORDER BY s.Dateseance';
            /*cette requête va servir à afficher les nom,prenom des eleves de chaque séances et de select les idseances et
            ideleves de chaque élève et chaque séances pour les envoyer*/
            $liste_eleves = mysqli_query($connect,$q2);
            if (!$liste_eleves) {
              echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
              mysqli_close($connect);
              exit;
            }
            $i = 0 ;/*on initialise un compteur pour renvoyer le nombre d'élève affiché, cela sera
            important pour récupérer les ideleves et idseance*/
            echo "<FORM METHOD='POST' ACTION='desinscrire_seance.php'>";
            foreach ($liste_seances as $seance) {
              echo "<p>Séance sur <b>$seance[nom] - ".date('d/m/Y',strtotime($seance['Dateseance']))." :</b></p>";
              /*on affiche chaque séance puis en dessous de chaque séance on affiche tous les élèves inscrits à cette séance sous forme
              de checkbox. Ce choix a été fait par soucis d'optimisation. Il est plus optimal de pouvoir desinscrire plusieurs élèves
              différents de plusieurs séances différentes en même temps*/
              foreach ($liste_eleves as $eleve) {
                if ($seance['idseance']==$eleve['idseance']) {
                  echo "<p><INPUT type='checkbox' name='eleve"."$i' value='$eleve[ideleve]_$seance[idseance]'> $eleve[prenom] $eleve[nom]</p>";
                  /*on sépare dans le value l'idseance et l'ideleve par un "_" qui va nous permettre de les récupérer respectivement
                  proprement*/
                  $i += 1;
                }
              }
            }
            echo "<INPUT type='hidden' name='count' value='$i'>";
            echo "<p><INPUT type='reset' value='Reinitialiser'>  ";
            echo "<INPUT type='submit' value='Desinscrire'></p>";
            echo "</FORM";
          }
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
