<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ajouter_eleve</title>
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
    <!-- Page de droite-->
    <div class="pdroite">
        <?php
        include("connexion.php");

        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $ddn = $_POST["ddn"];
        $choix = $_POST["choix"];
        $ddi = date("Y\-m\-d");/*date du jour*/

        $nom_echap = mysqli_real_escape_string($connect,$nom);//pour mettre des apostrophes dans les noms pour eviter les injections sql
        $prenom_echap = mysqli_real_escape_string($connect,$prenom);

        echo "<h2>Resultat ajout eleve</h2><br><br>";
        //On récupère les choix, si oui(1) on insert les valeurs, sinon on annule l'inscription
        if ($choix=='1')
        {
            $query = "INSERT INTO eleves VALUES(NULL, '$nom_echap', '$prenom_echap', '$ddn', '$ddi')";
            $result = mysqli_query($connect, $query);
            if (!$result)
            {
              echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
            }
            else
            {
              echo "<p><font color='blue'>L'élève <b>$prenom $nom</b> a bien été ajouté.</font color></p>";
            }

        }
        elseif ($choix=='0')
        {
          echo "<p><font color='blue'>L'inscription a bien été annulée.</font color></p>";
        }
        echo "<img src='icone_validation.png'>";
        echo "<p><a href='ajout_eleve.html'>Cliquer ici pour ajouter un nouvel élève</a></p>";
        mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
