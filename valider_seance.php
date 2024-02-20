<html>

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
    <!--Page de droite-->
    <div class="pdroite">
        <?php
          include("connexion.php");

          $idseance = $_POST["seance"];

          $q1 = "SELECT e.ideleve, e.nom, e.prenom, i.note FROM eleves as e INNER JOIN inscription as i ON e.ideleve=i.ideleve
          WHERE i.idseance=$idseance";
          //selectionne les eleves et leur note de la séance reçue
          $liste_eleves = mysqli_query($connect,$q1);

          if(!$liste_eleves) {
            echo "<p> La requête a échoué : ". mysqli_error($connect) . "</p>";
          }
          else {
            $i = 0 ;//compteur qui va permettre d'envoyer les notes et les ideleves
            echo "<h2>Noter les élèves en insérant leur nombre de fautes</h2><br><br>";
            echo "<FORM METHOD='POST' ACTION='noter_eleves.php'>";
            foreach ($liste_eleves as $eleve) {
              echo "<p>$eleve[nom] $eleve[prenom] ";
              if ($eleve["note"]>=0 and $eleve["note"]<=40) {
                echo "<INPUT type='hidden' name='ideleve"."$i' value=$eleve[ideleve]>";//sert à transmettre les valeurs sans les faire apparaitre
                echo "<INPUT type='number' name='note"."$i' value='$eleve[note]' placeholder='$eleve[note]' min='0' max='40' required></p>";
              }
              else {
                echo "<INPUT type='hidden' name='ideleve"."$i' value=$eleve[ideleve]>";
                echo "<INPUT type='number' name='note"."$i' min='0' max='40' required></p>";
              }
              $i+=1;
            }
            echo "<INPUT type='hidden' name='index' value='$i'>";
            echo "<INPUT type='hidden' name='idseance' value='$idseance'>";
            echo "<p><INPUT type='reset' value='Réinitialiser'>  ";
            echo "<INPUT type='submit' value='Enregistrer Note(s)'></p>";
            echo "</FORM>";
          }
          mysqli_close($connect);
        ?>
      </div>
    </div>
  </body>
</html>
