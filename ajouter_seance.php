<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ajouter_seance</title>
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

        $date = date("Y\-m\-d");

        $idtheme = $_POST["idtheme"];
        $effmax = $_POST["effmax"];
        $Dateseance = $_POST["Dateseance"];

        $effmax_echap = mysqli_real_escape_string($connect,$effmax);

        echo "<h2>Resultat ajout séance</h2><br><br>";
        if ($effmax<=0 || is_int($effmax)){//on verifie si l'effectif est positif et si c'est un entier
          echo "<p>L'effectif max doit être un entier positif</p>";
          echo "<img src='icone_rejet.png'>";
          echo "<p><a href='ajout_seance.php'>Cliquer ici pour ajouter une nouvelle séance</a></p>";
          mysqli_close($connect);
          exit;
        }

        if ($Dateseance<=$date) {//On verifie que la date entré est une date ultérieure
          echo "<p>La séance doit être enregistrée à une date ultérieur !</p>";
          echo "<img src='icone_rejet.png'>";
          echo "<p><a href='ajout_seance.php'>Cliquer ici pour ajouter une nouvelle séance</a></p>";
          mysqli_close($connect);
          exit;
        }

        $qverif = "SELECT * FROM seances WHERE Dateseance='$Dateseance' and idtheme=$idtheme";
        $rverif = mysqli_query($connect,$qverif);//On verifie qu'il n'existe pas déjà une séance pour le même thème à la même date
        if (mysqli_num_rows($rverif)) {
          echo "<p>Vous ne pouvez pas avoir des séances avec le même thème et la même date !</p>";
          echo "<img src='icone_rejet.png'>";
          echo "<p><a href='ajout_seance.php'>Cliquer ici pour ajouter une nouvelle séance</a></p>";
          mysqli_close($connect);
          exit;
        }

        $q1 = "INSERT INTO seances VALUES(NULL, '$Dateseance', $effmax_echap, $idtheme)";
        $result = mysqli_query($connect, $q1);//on insert la nouvelle séance à la BDD
        if (!$result) {
          echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          mysqli_close($connect);
          exit;
        }
        //On select juste le nom du thème pour un affichage plus pertinent à l'utilisateur 
        $q2 = "SELECT nom FROM themes WHERE idtheme=$idtheme";
        $theme = mysqli_query($connect,$q2);
        if (!$theme) {
          echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          mysqli_close($connect);
          exit;
        }
        foreach ($theme as $t) {
          echo "<p> La séance du thème <b>$t[nom]</b> prévu le <b>".date('d/m/Y',strtotime($Dateseance))."</b> et ayant un effectif max de <b>$effmax_echap</b> personnes a bien été ajoutée.</p>";
        }
        echo "<img src='icone_validation.png'>";
        echo "<p><a href='ajout_seance.php'>Cliquer ici pour ajouter une nouvelle séance</a></p>";
        mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
