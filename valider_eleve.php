<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>valider_eleve</title>
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
    <!--page de droite-->
    <div class="pdroite">
        <?php
            include("connexion.php");

            $prenom = $_POST["prenom"];
            $nom = $_POST["nom"];
            $ddn = $_POST["ddn"];

            $ddi = date("Y\-m\-d");

            //variable pour calculer l'écart d'age entre la ddn et la ddi
            $date1 = new DateTime($ddi);
            $date2 = new DateTime($ddn);
            $interval = date_diff($date1,$date2);

             if ($interval->format('%Y') < '15') {//verifie si l'écart est supèrieur ou égal à 15ans
               echo "<p>Inscription impossible, l'élève n'a que ".$interval->format('%Y')." ans. L'âge minimal pour s'inscrire en
               auto-école est 15 ans.</p>";
               echo "<img src='icone_rejet.png'>";
               echo "<p><a href='ajout_eleve.html'>Cliquer ici pour ajouter un nouvel élève</a></p>";
               mysqli_close($connect);
               exit;
             }

            $verif_doublon = "SELECT * FROM eleves WHERE nom='$nom' and prenom='$prenom'";
            /*requête pour verifier s'il y a des élèves avec le même prenom et le même nom*/
            $liste_doublon = mysqli_query($connect, $verif_doublon);
            $doublon = mysqli_fetch_array($liste_doublon, MYSQLI_NUM);

            echo "<h2>Confirmation d'enregistrement</h2>";
            if (mysqli_num_rows($liste_doublon))//test s'il y'en a, si oui on demande à l'utilisateur s'il confirme l'insc
            {
              echo <<<END
              <br><p>L'élève <b>$prenom $nom</b> est déjà inscrit dans votre autoecole.
              Est-ce bien un nouvel élève?</p>
              <FORM METHOD='POST' ACTION='ajouter_eleve.php'>
                <p><INPUT TYPE='radio' VALUE='1' NAME='choix'>
                                  Oui
                <INPUT TYPE='radio' VALUE='0' NAME='choix'>
                                  Non</p>
                  <input type='hidden' name='nom' value='$nom'>
                  <input type='hidden' name='prenom' value='$prenom'>
                  <input type='hidden' name='ddn' value='$ddn'>

                  <p><INPUT TYPE='submit' VALUE='Valider'></p>
                </form>
              END;
            }
            else // Sinon, on demande juste confirmation des infos entrées
        		{
        			echo <<<END
              <br><p>Confirmer votre enregistrement?</p>
                <FORM METHOD='POST' ACTION='ajouter_eleve.php' >
                  <p><INPUT TYPE='radio' VALUE='1' NAME='choix'>
                                    Oui
                  <INPUT TYPE='radio' VALUE='0' NAME='choix'>
                                    Non</p>
                    <input type='hidden' name='nom' value='$nom'>
                    <input type='hidden' name='prenom' value='$prenom'>
                    <input type='hidden' name='ddn' value='$ddn'>

                    <p><INPUT TYPE='submit' VALUE='Valider'></p>
                </form>
              END;
        		}
      ?>
    </div>
  </div>
</body>
</html>
