
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ajouter_thème</title>
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

          $nom_theme = $_POST["nom_theme"];
          $description = $_POST["description"];

          $nom_theme_echap = mysqli_real_escape_string($connect,$nom_theme);//pour mettre des apostrophes dans les noms en evitant les injections sql
          $description_echap = mysqli_real_escape_string($connect,$description);

          $qverif = "SELECT * FROM themes WHERE nom='$nom_theme_echap'";
          $rverif = mysqli_query($connect,$qverif);//On verifie que le thème n'existe pas déjà

          echo "<h2>Résultat ajout thème</h2><br><br>";
          if (mysqli_num_rows($rverif)) {//S'il y a un thème avec le même nom
            foreach ($rverif as $theme) {
              if ($theme['supprime']==TRUE) {//et qu'il a été supprimé
                $q1 = "UPDATE themes set supprime=FALSE, descriptif='$description_echap' where nom = '$nom_theme_echap'";
                $theme_actif = mysqli_query($connect,$q1);//On le rend alors de nouveau actif et on change sa nouvel description
                if (!$theme_actif) {
                  echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
                }
                else {
                  echo "<p><font color='blue'>Le thème existait déjà mais il avait été supprimé. Il a alors été réactivé et sa déscription a été
                  mise à jour !</font color></p>";
                  echo "<img src='icone_validation.png'>";
                }
              }
              else {//S'il n'a pas été supprimé alors c'est que le thème existe déjà et qu'il est toujours actif
                echo "<p><font color='blue'>Le thème existe déjà et il est toujours actif !</font color></p>";
                echo "<img src='icone_rejet.png'>";
              }
            }
          }
          else {//S'il n'y a pas de thème avec le même nom alors on ajoute le nouveau thème
            $query = "INSERT INTO themes VALUES(NULL, '$nom_theme_echap',FALSE,'$description_echap')";
            $result = mysqli_query($connect, $query);
            if (!$result) {
              echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            }
            else {
              echo "<p><font color='blue'>Le thème $nom_theme a bien été ajouté.</font color></p>";
              echo "<img src='icone_validation.png'>";
            }
          }
          echo "<p><a href='ajout_theme.html'>Cliquer ici pour ajouter un nouveau thème</a></p>'";
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
