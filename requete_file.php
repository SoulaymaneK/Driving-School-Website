- desinscription_seance.php :

/*SELECT t.nom,s.Dateseance,e.nom,e.prenom FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
INNER JOIN inscription as i ON s.idseance=i.idseance INNER JOIN eleves as e ON i.ideleve=e.ideleve WHERE
s.Dateseance>CURDATE()
ORDER BY s.Dateseance ;

SELECT s.idseance,s.Dateseance,t.nom FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
INNER JOIN inscription as i ON s.idseance=i.idseance INNER JOIN eleves as e ON i.ideleve=e.ideleve WHERE
s.Dateseance>CURDATE()
ORDER BY s.Dateseance ;

SELECT s.idseance,e.nom,e.prenom FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
INNER JOIN inscription as i ON s.idseance=i.idseance INNER JOIN eleves as e ON i.ideleve=e.ideleve WHERE
s.Dateseance>CURDATE()
ORDER BY s.Dateseance*/

- inscription_eleve.php :

/*$q2 = 'SELECT s.idseance,s.Dateseance,s.EffMax,t.nom FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme
WHERE s.Dateseance>=CURDATE() and t.supprime=FALSE and s.Effmax>(SELECT COUNT(e.ideleve) FROM eleves as e INNER JOIN
inscription as i WHERE e.ideleve=i.ideleve) ORDER BY s.Dateseance';*/

- validation_seance.php :

/*$q1 = 'SELECT t.nom,s.Dateseance,s.idseance FROM seances as s INNER JOIN themes as t ON s.idtheme=t.idtheme WHERE
s.Dateseance<=CURDATE() and 1<=(SELECT COUNT(e.ideleve) FROM eleves as e INNER JOIN inscription as i ON
e.ideleve=i.ideleve)
ORDER BY s.Dateseance DESC';*/

- visualisation_calendrier_eleve.php :

/*$query = 'SELECT DISTINCT e.nom,e.prenom FROM eleves as e INNER JOIN inscription as i ON e.ideleve=i.ideleve';
$liste_eleves = mysqli_query($connect,$query);*/
