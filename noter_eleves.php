<html>

  <head>
    <meta charset="utf-8">
    <title>noter_eleves</title>
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

          $idseance = $_POST['idseance'];
          $nbeleve = $_POST['index'];//on récupère le nombre d'élève pour pouvoir récupérer son ideleve et sa note associée
          $verif = 0 ;//compteur pour bien vérifier
          for ($i=0; $i < $nbeleve; $i++)
          {
            $note = $_POST["note"."$i"];
            $ideleve = $_POST["ideleve"."$i"];
            /*if ($note<0 || $note>40) {
              echo "le nombre de fautes doit être compris en 0 et 40.";
              mysqli_close($connect);
              exit;
            }*/
            $query = "UPDATE inscription SET note=$note WHERE ideleve=$ideleve AND idseance=$idseance";
            $notation = mysqli_query($connect,$query);//on modifie la note
            if (!$notation) {
              echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
              mysqli_close($connect);
              exit;
            }
            $verif += 1;
          }
          echo "<h2>Enregistrement des notes</h2><br><br>";
          if ($verif==$nbeleve) {//verifie que le nombre d'élève est égal au compteur 
            echo "<p><font color='blue'>C'est bon, les notes ont été enregistrées !</font color></p>";
            echo "<img src='icone_validation.png'>";
          }
          else {
            echo "<p><font color='red'>Erreur dans l'enregistrement des notes !</font color></p>";
            echo "<img src='icone_rejet.png'>";
          }
          echo "<p><a href='validation_seance.php'>Cliquer ici pour noter une autre séance</a></p>";
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
