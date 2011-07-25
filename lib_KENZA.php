<?php

function fcopyCatalogue($pCatalogue,$pNom,$pConnection)
{
	$vSql="INSERT INTO catalogue(nom, date_debut, date_fin, description) VALUES ('$pNom',(SELECT date_debut from catalogue WHERE nom ='$pCatalogue'),(SELECT date_fin from catalogue WHERE nom='$pCatalogue'),(SELECT description from catalogue WHERE nom='$pCatalogue'));";
	if(!pg_query($pConnection,$vSql))
	{
	echo "<p class=\"resFalse\">Le nom du catalogue ".$pCatalogue." n'a pas pu etre modifie, ".$pCatalogue." n'existe pas ou ".$pNom." existe deja</p>";
	}
	else 
	{
		echo "<p class=\"resTrue\">Le nom du catalogue ".$pCatalogue." a ete modifie en ".$pNom." avec succes</p>";
	}
}


function fdeleteAdresse($pAdresse, $pConnection) //supprime l'adresse $pAdresse de la table adresse
{

	$vSql="DELETE FROM adresse WHERE (SELECT NOM FROM adresse where nom=$pCatalogue.nom) AND (SELECT utilisateur FROM adresse where utilisateur=$pCatalogue.utilisateur);";
	
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">L'adresse n'a pas pu etre supprimee</p>";
	}
}
/*function fAjoutAdresse($pNom,$pRue,$pCodePostal,$pVille,$pUtilisateur,$pConnection)
{
	$vSql = "INSERT INTO adresse (nom,utilisateur,rue,code_postal,ville) VALUES ('$pNom','$pUtilisateur','$pRue,'$pCodePostal','$pVille);";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">L'adresse dr ".$pNom." n'a pas pu etre ajoutee a la base</p>";
	}
	else 
	{
		echo "<p class=\"resTrue\">L'adresse de ".$pNom." a bien ete ajoutee a la base.</p>";
	}
}*/
function fdeleteProduit($pProduit,$pConnection) //supprime le produit $pProduit de la table produit
{
	$vSql="DELETE FROM produit p WHERE p.code~*'$pProduit';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le produit n'a pas pu etre supprime</p>";
	}
	else
	{
		echo"<p class=\"resTrue\">Le produit $pProduit a ete supprime avec succes !</p>";
	}
}
function fdeleteRubrique($pRubrique,$pConnection) //supprime la rubrique $pRubrique de la table rubrique
{

	$vSql="DELETE FROM rubrique WHERE nom~*'$pRubrique';";
	
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">La rubrique n'a pas pu etre supprimee</p>";
	}
	else
	{
		echo"<p class=\"resTrue\">La rubrique $pRubrique a ete supprimee avec succès !</p>";
	}
}

function fchangeDateDebut($pCatalogue,$pDateDebut,$pConnection) //change la date de debut du catalogue $pCatalogue

{
	$vSql="UPDATE catalogue SET date_debut = '$pDateDebut' WHERE nom = '$pCatalogue';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le changement de date de debut a echoue</p>";
	}
	else
	{
		echo "<p class=\"resTrue\">Changement de date de debut a ete effectue</p>";
	}
}

function fchangeDateFin($pCatalogue,$pDateFin,$pConnection) //change la date de fin du catalogue $pCatalogue

{
	$vSql="UPDATE catalogue SET date_fin = '$pDateFin' WHERE nom = '$pCatalogue';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le changement de date de fin a echoue</p>";
	}
	else
	{
		echo "<p class=\"resTrue\">Changement de date de fin a ete effectue</p>";
	}
}


function fgetDateDebut($pNom,$pConnection) //retourne la date de debut du catalogue $pCatalogue

{
	$vSql="SELECT date_debut as date FROM catalogue WHERE nom='$pNom';";
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC); 
	return $vResult["date"];
}

function fgetDateFin($pNom,$pConnection) //retourne la date de fin du catalogue $pCatalogue

{
	$vSql="SELECT date_fin as date FROM catalogue WHERE nom='$pNom';";
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC); 
	return $vResult["date"];
}

function fchangeDesc($pCatalogue,$pDesc,$pConnection) //change la description du catalogue $pCatalogue

{
	$vSql="UPDATE catalogue SET description = '$pDesc' WHERE nom = '$pCatalogue';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le changement de description a echoue</p>";
	}
	else
	{
		echo "<p class=\"resTrue\">Changement de description a ete effectue</p>";
	}
}




function fupdateForeignKeyContenuCatalogue($pCatalogue,$pNom,$pConnection) /*passe la table contenu catalogue et change 
les entrees dont "catalogue" vaut $pCatalogue en $pNom

*/
{
	$vSql="UPDATE contenucatalogue SET catalogue = '$pNom' WHERE catalogue = '$pCatalogue';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">La mise a jour du contenu de ce catalogue n'a pu etre effectuee</p>";
	}//else = ok !
}

function ModifieAdresseUtilisateur($pAdresse,$pAncienneAdresse,$pConnection) /*modifie l'adresse d'un utilisateur donné*/
{	
$vSql="UPDATE utilisateur SET email='$pAdresse' WHERE email='$pAncienneAdresse';";
if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">L'adresse e-mail n'a pas ete modifiee</p>";
	}//else = ok !
}	
function AjoutAdresseUtilisateur($pAdresse,$pAncienneAdresse,$pConnection) /*ajoute une adresse à un utilisateur donné*/
{	
$vSql="INSERT INTO utilisateur(email) VALUES ('$pAdresse') WHERE email='$pAncienneAdresse';";
if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">L'adresse e-mail n'a pas ete ajoutee</p>";
	}//else = ok !
}



?>