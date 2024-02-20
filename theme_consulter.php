<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>theme_consulter</title>
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

        $query = "SELECT t.*,COUNT(s.idtheme) as c FROM themes as t INNER JOIN seances as s ON s.idtheme=t.idtheme
        WHERE t.idtheme = $idtheme AND s.Dateseance>=CURDATE()";
        //select toutes les infos du thème et le nombre de séances à venir sur ce thème
        $info_theme = mysqli_query($connect,$query);
        if (!$info_theme) {
          echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
        }
        else {
          echo "<h2>Informations du thème :</h2><br><br>";
          foreach ($info_theme as $info) {
            echo "<p>Il s'agit du thème <b>$info[nom]</b>.<br><br>";
            echo "<b>Descriptif du thème :</b> $info[descriptif]<br><br>";
            if ($info['supprime']==FALSE) {
              echo "Le thème est toujours <b>actif</b>.<br><br>";
              echo "Il y a <b>$info[c] séance(s)</b> prévue(s) sur ce thème.</p><br><br>";
            }
            else {
              echo "Le thème est <b>inactif</b>.<br><br>";
              echo "Il y a <b>$info[c] séance(s)</b> prévue(s) sur ce thème.</p><br><br>";
            }
          }
        }
        echo "<p><a href='theme_consult.php'>Cliquer ici pour consulter un autre thème</a></p>";
        mysqli_close($connect);
       ?>

  </body>
</html>
