<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>desinscrire_seance</title>
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

          $nbeleves = $_POST["count"];

          for ($i=0; $i < $nbeleves; $i++) {
            $couple = explode("_", $_POST["eleve"."$i"] ?? "");
            /*cette fonction va permettre de récupérer le couple ideleve_idseance séparemment en enlevant le séparateur.
            Si le couple n'existe pas car par exemple l'élève : eleve5 n'a pas été selectionné dans le checkbox, alors
            on renvoie une chaine vide grâce à ??*/
            if ($couple[0]!="") {//si le couple existe on le supprime de la table inscription en le convertissant en entier
              $query = "DELETE FROM inscription WHERE ideleve=".intval($couple[0])." AND idseance=".intval($couple[1]);
              $suppression = mysqli_query($connect,$query);
              if (!$suppression) {
                echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
                mysqli_close($connect);
                exit;
              }
            }
          }
          echo "<h2>Desinscription à une séance</h2><br><br>";
          echo "<p><font color='blue'>La desinscription a bien été effectuée !</font color></p>";
          echo "<img src='icone_validation.png'>";
          echo "<p><a href='desinscription_seance.php'>Cliquer ici pour désinscire d'autres élèves</a></p>";
          mysqli_close($connect);
         ?>
      </div>
    </div>
  </body>
</html>
