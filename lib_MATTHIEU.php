<?php
/*
function fdeleteContenuCatalogue($pCatalogue,$pConnection) //SUPPRIME LE CONTENU D'UN CATALOGUE
{
	$vSql= "DELETE FROM contenucatalogue WHERE catalogue='$pCatalogue';";
	if(pg_query($pConnection,$vSql))
	{
		echo"<p class=\"resTrue\">Le contenu du catalogue $pConnection a ete supprime avec succes !</p>";
		echo"<p class=\"resTrue\">Le catalogue $pConnection est maintenant vide.</p>";
	}
	else
	{
		echo "<p class=\"resFalse\"> Le catalogue n'a pas pu etre supprime.</p>";
	}
}
*/
function fdeleteCatalogue($pCatalogue,$pConnection) //SUPPRIME UN CATALOGUE
{
	$vSql= "DELETE FROM catalogue c WHERE c.name~*'$pCatalogue';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\"> Le catalogue n'a pas pu etre supprime.</p>";
	}
	else
	{
		echo"<p class=\"resTrue\">Le catalogue $pCatalogue a ete supprime avec succes !</p>";
	}
}

function fafficheCatalogue($pCatalogue,$pConnection) // Affiche tous les produits d'un catalogue
{
	$vSql= "SELECT p.code, p.nom, p.prix, p.description, p.stock, p.masse, p.largeur, p.hauteur, p.profondeur, p.date_ajout, p.marque FROM afficher_tout p, contenurubrique cr, contenucatalogue cc WHERE p.code=cr.produit AND cr.rubrique=cc.rubrique AND cc.catalogue~*'$pCatalogue';";
	if(pg_query($pConnection,$vSql))
	{
		echo"<p class=\"resTrue\">Voici les produits du catalogue par ordre alphabetique </p>";
	}
	else
	{
		echo "<p class=\"resFalse\"> Le catalogue ne peut pas etre affiche.</p>";
	}
}

function fafficheRubrique($pRubrique,$pConnection) // Affiche tous les produits d'une rubrique
{
	$vSql= "SELECT p.code, p.nom, p.prix, p.description, p.stock, p.masse, p.largeur, p.hauteur, p.profondeur, p.date_ajout, p.marque FROM afficher_tout p, contenurubrique cr WHERE p.code=cr.produit AND cr.rubrique~*'$pRubrique';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\"> La rubrique ne peut pas etre affichee. </p>";
	}
	else
	{
		echo"<p class=\"resTrue\">Voici les produits de la rubrique par ordre alphabetique </p>";
	}
}

function frechercheNom ($pChaine,$pConnection) // Affiche tous les produits dont le nom ou la description contiennent $pChaine
{
	$odd=1;
	$vSql= "SELECT p.code as cod, p.nom as nom, p.prix as prix, p.description as description, p.stock as stock, p.masse, p.largeur, p.hauteur, p.profondeur, p.date_ajout, p.marque FROM afficher_tout p WHERE p.nom~*'$pChaine' OR p.description~*'$pChaine';";
	$vQuery = pg_query($pConnection,$vSql);

	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{
			
			echo "<TR class=\"catalogueODD\">"; 
			echo "<TD class=\"catalogueODD\">".$vResult["cod"]."</TD>"; 	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["prix"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["stock"]."</TD>";
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"detailClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['cod']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Fiche produit</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
		else
		{
			echo "<TD class=\"catalogueEVEN\">".$vResult["cod"]."</TD>"; 	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["prix"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["stock"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detailClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['cod']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Fiche produit</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
	}
}

	
?>



