
<?php


function fChoixAdresse($pLogin,$pConnection)
{
	
	$vSql="Select nom from adresse where utilisateur='$pLogin';";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		echo "<option value=\"".$vResult['nom']."\">".$vResult['nom']."</option>";
	}
}

function fNbAdresse($pLogin,$pConnection)
{
	$vSql="Select count(nom) as resultat from adresse where utilisateur='$pLogin';";
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC); 
	return $vResult["resultat"];
}


function fgetId($pLogin,$pConnection) 

{
	
	$vSql="SELECT max(id) as id from panier where panier.client='$pLogin' AND recurrent=0 AND panier.date=(SELECT max(panier.date) from panier WHERE client='$pLogin' AND recurrent=0);";
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC); 
	return $vResult["id"];
}
function fafficherPanier($plogin,$pConnection)

{	
	$odd=1;
	$ind=1;
	$indPanier=1;
	$id=fgetId($plogin,$pConnection);
	echo "<strong>Panier courant :</strong>";
	echo "<br/>";
	echo "<TABLE width=\"335\" class=\"catalogue\">"; 
    echo "<TR class=\"catalogue\"><TH  class=\"catalogue\">Code</TH><TH  class=\"catalogue\">Nom</TH><TH class=\"catalogue\">Prix</TH><TH class=\"catalogue\">quantité</TH><TH class=\"catalogue\">actions</TH></TR>";
	$vSql = "SELECT produit.code, produit.nom, produit.prix, contenupanier.quantite as qte FROM contenupanier, produit WHERE contenupanier.panier = $id AND produit.code=contenupanier.produit;";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
	
		    echo "<TR class=\"catalogueODD\">"; 
			echo "<TD class=\"catalogueODD\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["prix"]."</TD>";
			echo "<TD class=\"catalogueODD\">".strval($vResult['qte'])."</TD>";
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"resAchatProduit.php\"  method=\"POST\" id=\"sub_".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">supprimer</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;

		}
			
		
		else
		{
			echo "<TR class=\"catalogueEVEN\">"; 
			echo "<TD class=\"catalogueEVEN\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["prix"]."</TD>";	
			echo "<TD class=\"catalogueEVEN\">".strval($vResult['qte'])."</TD>";			
			echo "<TD class=\"catalogueEVEN\">";	
			echo "<form action=\"resAchatProduit.php\"  method=\"POST\" id=\"sub_".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">supprimer</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
			
		}
	}
	echo "</table>";
	echo "<div class=\"form_row\">";
	
	echo "<form method=\"POST\" action=\"resCommande.php\" id=\"commandeCour\">";
	echo "<input type=\"hidden\" name=\"inputPanier\" value=".$id."/>";
	echo "<input type=\"checkbox\" name= \"recurrent\" /><label for=\"recurrent\"> Panier recurrent</label>";
	echo "<br/>";
	if (fNbAdresse($plogin,$pConnection)!=0)
	{	
	echo "Adresse de livraison: ";
	echo "<select name=\"choiceadresse\">";
	fChoixAdresse($plogin,$pConnection);
	echo "</select>";				
	echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">commander</a>";
	echo "</form>";
	echo "</div>";
	}
	else
	{
		echo "<a href=\"newAdresse.php\" class=\"login\">commander</a>";
		echo "</form>";
		echo "</div>";
	}
	$vSql3 = "SELECT id from panier where client='$plogin' AND recurrent=1;";
	
	$vQuery3 = pg_query($pConnection,$vSql3);
	while ($vResult3 = pg_fetch_array($vQuery3, null, PGSQL_ASSOC))
	{ 

		echo "<br/>";
		echo "<br/>";
		echo "<br/>";
		echo "<strong>Panier recurrent ".$indPanier." :</strong>";
		echo "<br/>";
		echo "<TABLE width=\"335\" class=\"catalogue\">";
		echo "<TR class=\"catalogue\"><TH  class=\"catalogue\">Code</TH><TH  class=\"catalogue\">Nom</TH><TH class=\"catalogue\">Prix</TH><TH class=\"catalogue\">quantité</TH><TH class=\"catalogue\">actions</TH></TR>";
			$vSql2 = 'SELECT produit.code, produit.nom, produit.prix, contenupanier.quantite as qte FROM contenupanier, produit WHERE contenupanier.panier= '.$vResult3["id"].' AND produit.code=contenupanier.produit;';
			$vQuery2 = pg_query($pConnection,$vSql2);
			while ($vResult2 = pg_fetch_array($vQuery2, null, PGSQL_ASSOC))
			{ 
				if ($odd==1)
				{      
	
		   			 echo "<TR class=\"catalogueODD\">"; 
			   		echo "<TD class=\"catalogueODD\">".$vResult2["code"]."</TD>"; 	
					echo "<TD class=\"catalogueODD\">".$vResult2["nom"]."</TD>";
					echo "<TD class=\"catalogueODD\">".$vResult2["prix"]."</TD>";
					echo "<TD class=\"catalogueODD\">".strval($vResult2['qte'])."</TD>";
					echo "<TD class=\"catalogueODD\">";
					echo "<form action=\"resAchatProduit.php\"  method=\"POST\" id=\"sub_".$ind."\">";
					echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult2['code']."'/>";
					echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">supprimer</a>";
					echo "</form>";
					echo "</TD>";
					echo "</TR>";
					$odd=$odd*-1;
					$ind=$ind+1;

				}
			
		
				else
				{
						echo "<TR class=\"catalogueEVEN\">"; 
						echo "<TD class=\"catalogueEVEN\">".$vResult2["code"]."</TD>"; 	
						echo "<TD class=\"catalogueEVEN\">".$vResult2["nom"]."</TD>";
						echo "<TD class=\"catalogueEVEN\">".$vResult2["prix"]."</TD>";	
						echo "<TD class=\"catalogueEVEN\">".strval($vResult2['qte'])."</TD>";			
						echo "<TD class=\"catalogueEVEN\">";	
						echo "<form action=\"resAchatProduit.php\"  method=\"POST\" id=\"sub_".$ind."\">";
						echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult2['code']."'/>";
						echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">supprimer</a>";
						echo "</form>";
						echo "</TD>";
						echo "</TR>";
						$odd=$odd*-1;
						$ind=$ind+1;
			
		}
			
			
			
			}
				
		echo"</table>";
		echo "<div class=\"form_row\">";
	echo "<form method=\"POST\" action=\"resCommande.php\" id=\"commandeCour\">";
	echo "<input type=\"hidden\" name=\"inputPanier\" value=".$vResult3["id"]."/>";			
	if (fNbAdresse($plogin,$pConnection)!=0)
	{	
	echo "Adresse de livraison: ";
	echo "<select name=\"choiceadresse\">";
	fChoixAdresse($plogin,$pConnection);
	echo "</select>";				
	echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">commander</a>";
	echo "</form>";
	echo "</div>";
	}
	else
	{
		echo "<a href=\"newAdresse.php\" class=\"login\">commander</a>";
		echo "</form>";
		echo "</div>";
	}
	echo "</form>";
		$indPanier=$indPanier+1;
	}
}
function fverificationStock($pCode,$pQte,$pConnection)
{
	$vSql = "SELECT stock FROM produit WHERE code ='$pCode';";
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	if ($vResult ['stock']<$pQte)
	return 0;
	else 
	return 1;
}

function fafficherProduitAchete($pCode,$pQte,$pConnection)
{
	$odd=1;
	$ind=1;
	$vSql = "SELECT code, nom, prix FROM produit WHERE code ='$pCode';";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
		echo "<TR class=\"catalogueODD\">"; 
			echo "<TD class=\"catalogueODD\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["prix"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$pQte."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"resAchatProduit.php\"  method=\"POST\" id=\"sub_".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"subQte\" value=\"1\"/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">supprimer</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;

					}
			
		
		else
		{
			echo "<TR class=\"catalogueEVEN\">"; 
			echo "<TD class=\"catalogueEVEN\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["prix"]."</TD>";		
			echo "<TD class=\"catalogueEVEN\">";	
			echo "<form action=\"resAchatProduit.php\"  method=\"POST\" id=\"sub_".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"subQte\" value=\"1\"/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Ajouter au panier</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
			
		}
	}
	
	
}

function fchoixPanierRecurrent($pLogin,$pConnection)
{
	$vSql = "SELECT id FROM panier WHERE client ='$pLogin' AND recurrent=1;";
	$vQuery = pg_query($pConnection,$vSql);
	$ind=1;
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		echo "<option value=\"".$vResult['id']."\">Panier reccurent ".$ind."</option>";
		$ind=$ind+1;
	}
	
}



function fAfficherProduitSelect($pCodeP,$pConnection)
{//******************************************************* A PIERRE - ADRIEN ***********************************************
 //******************************************************* A PIERRE - ADRIEN ***********************************************
 //******************************************************* A PIERRE - ADRIEN ***********************************************
 //******************************************************* A PIERRE - ADRIEN ***********************************************
 //******************************************************* A PIERRE - ADRIEN ***********************************************

 //else echo "<p class=\"resFalse\">Nous ne possédons pas la quantité demandée du ".$vResult["nom"]." </p>"; }	
 
 //                                      IL FAUT QUE TU RECUPERES PAR POST : inputProduit et la quantité subQte CHECK!!!
 //										
 //				 VERIFIE SI LE MEC EST CONNECTE (faire un test sur $_SESSION['login'] voir sur la barre de menu pour choisir entre 'sidentifier et se deconnecter par exemple)	
 //              SI PAS CONNECTE, REDIRIGER VERS LA PAGE DE LOGIN CHECK!!!!
 //				 SI CONNECTE, IL FAUT AUSSI QUE TU VERIFIES LES STOCKS DISPOS AVANT D'ACCEPTER		
 
 //******************************************************* A PIERRE - ADRIEN ***********************************************
 //******************************************************* A PIERRE - ADRIEN ***********************************************
 //******************************************************* A PIERRE - ADRIEN ***********************************************
 //******************************************************* A PIERRE - ADRIEN ***********************************************
 //******************************************************* A PIERRE - ADRIEN ***********************************************
	$odd=1;
	$ind=1;
	$vSql = "SELECT code, nom, prix, stock FROM produit WHERE code ='$pCodeP';";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
		echo "<TR class=\"catalogueODD\">"; 
			echo "<TD class=\"catalogueODD\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["prix"]."</TD>";
			
			echo "<TD class=\"catalogueODD\" STYLE=\"text-align:center;\">";
			echo "<form action=\"resAchatProduit.php\" method=\"POST\" id=\"".$ind."\">";
			echo"<a href=\"#\" class=\"hehe\" onclick=\"plus(this);return false;\">+</a>"; 
		echo"<input type=\"text\" name=\"qte\" value=\"1\" disabled=\"disabled\" STYLE=\"text-align:center;width=10px;background-color:#FFFFFF;color=#000000; maxlength=\"3\"\"     />"; 		
			echo"<a href=\"#\" class=\"hehe\" onclick=\"minus(this);return false;\">-</a>";
			echo "</form>";
			echo"</TD>";
			
			echo "<TD class=\"catalogueODD\">";
			if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))
				{
					echo "<form action=\"resAchatProduit.php\"  method=\"POST\" id=\"sub_".$ind."\">";
					echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
					echo "<input type=\"hidden\" class=\"login_input\" name=\"subQte\" value=\"1\"/>";
					echo "<select name=\"choicepanier\">";
    				echo "<option value=\"0\">Panier courant</option>";
					fchoixPanierRecurrent($_SESSION['login'],$pConnection);
					echo "</select>";
					echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Ajouter au panier</a>";
					echo "</form>";
					echo "</TD>";
					echo "</TR>";
					$odd=$odd*-1;
					$ind=$ind+1;}
				
			
			else
			{
			echo "<form action=\"login.php\"  method=\"POST\" id=\"sub_".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"subQte\" value=\"1\"/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Ajouter au panier</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;}
		}
		else
		{
			echo "<TR class=\"catalogueEVEN\">"; 
			echo "<TD class=\"catalogueEVEN\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["prix"]."</TD>";
			
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"resAchatProduit.php\" method=\"POST\" id=\"".$ind."\">";
			echo"<a href=\"#\"  onclick=\"plus(this);return false;\">+</a>"; 
			echo"<input type=\"text\" name=\"qte\" value=\"1\" disabled=\"disabled\" STYLE=\"width=10px;background-color:#FFFFFF;color=#000000; maxlength=\"3\"\"     />"; 		
			echo"<a href=\"#\" class=\"hehe\" onclick=\"minus(this);return false;\">-</a>";
			echo "</form>";
			echo"</TD>";
			
			echo "<TD class=\"catalogueEVEN\">";	
			echo "<form action=\"resAchatProduit.php\"  method=\"POST\" id=\"sub_".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"subQte\" value=\"1\"/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Ajouter au panier</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
	}
	
	
}
function fAfficherDetailCatalogueClient($pCatalogue,$pConnection)
{
	$odd=1;
	$ind=1;
	$vSql = "SELECT nom, description FROM rubrique WHERE rubrique.nom in (SELECT rubrique FROM contenucatalogue WHERE catalogue='$pCatalogue');";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
			echo "<TR class=\"catalogueODD\">";  	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"detailRubriqueClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Produits</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
		else 
		{
			echo "<TR class=\"catalogueEVEN\">";  	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detailRubriqueClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Produits</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
	}
}
function fAfficherSousRubriqueClient($pRubrique,$pConnection)
{
	$odd=1;
	$ind=1;
	$vSql = "SELECT nom, description FROM rubrique WHERE pere='$pRubrique'";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
			echo "<TR class=\"catalogueODD\">";  	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"detailRubriqueClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Produits</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
		else 
		{
			echo "<TR class=\"catalogueEVEN\">";  	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detailRubriqueClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Produits</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
	}
}



function fAfficherProduitRubriqueClient($pRubrique,$pConnection)
{
	$odd=1;
	$ind=1;
	$vSql = "SELECT code, nom, prix, description, stock FROM produit, contenurubrique WHERE produit.code=contenurubrique.produit AND contenurubrique.rubrique='$pRubrique';";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
		echo "<TR class=\"catalogueODD\">"; 
			echo "<TD class=\"catalogueODD\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["prix"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["stock"]."</TD>";
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"detailClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Fiche produit</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
		else
		{
			echo "<TD class=\"catalogueEVEN\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["prix"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["stock"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detailClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Fiche produit</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
	}
	
	
}

function fAfficherCatalogueClient($pConnection)
{
	$odd=1;
	$ind=1;
	$vSql = "SELECT nom, date_fin, date_debut, description FROM catalogue;";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
			echo "<TR class=\"catalogueODD\">";  	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["date_debut"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["date_fin"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"detailCatalogueClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Rubriques</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}
		else 
		{
			echo "<TR class=\"catalogueEVEN\">";  	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["date_debut"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["date_fin"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detailCatalogueClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Rubriques</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
	}
}

function ftriNomCatalogue ($pConnection)
{

	$odd=1;
	$ind=1;
	$vSql = "SELECT nom, date_fin, date_debut, description FROM catalogue ORDER BY nom ASC;";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
			echo "<TR class=\"catalogueODD\">";  	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["date_debut"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["date_fin"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"detailCatalogue.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Rubriques</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
		else 
		{
			echo "<TR class=\"catalogueEVEN\">";  	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["date_debut"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["date_fin"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detailCatalogue.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Rubriques</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
	}
}
function ftriDebutCatalogue ($pConnection)
{

	$odd=1;
	$ind=1;
	$vSql = "SELECT nom, date_fin, date_debut, description FROM catalogue ORDER BY date_debut ASC;";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
			echo "<TR class=\"catalogueODD\">";  	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["date_debut"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["date_fin"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"detailCatalogue.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Rubriques</a>";
			echo "</form>";
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
		else 
		{
			echo "<TR class=\"catalogueEVEN\">";  	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["date_debut"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["date_fin"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detailCatalogue.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Rubriques</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
	}
}

function fgetNomProduit ($pCodeP, $pC)
{
	$vSql ="SELECT nom from produit WHERE  code='$pCodeP';";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["nom"];
	
}
function fAfficherCommande($pC)
{
$vSql ="SELECT produit.code, produit.nom, quantite.quantite from commandes, panier,quantite produit WHERE  commande.cle_etrangere_vers_pnier = panier.cle_primaire AND quantitie.cle_etrangere_vers_panier=panier.cle_primaire AND quantite.cle_etrangere_vers_produit=produit.cle_primaire;";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["nom"];
}
function fAfficherProduitSimilaire($pRubrique,$pCodeP,$pConnection)
{	
	$odd=1;
	$vSql = "SELECT nom FROM produit, contenurubrique WHERE produit.code=contenurubrique.produit AND contenurubrique.rubrique='$pRubrique' AND produit.code != '$pCodeP';";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
	
		}
		}
		function fAfficherProduitSimilaire2($pRubrique,$pCodeP,$pConnection)
{	
	$odd=1-1;
	$vSql = "SELECT nom FROM produit, contenurubrique WHERE produit.code=contenurubrique.produit AND contenurubrique.rubrique='$pRubrique' AND produit.code != '$pCodeP';";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==0)
		{      
		echo "<TR class=\"catalogueODD\">"; 
			echo "<TD class=\"catalogueODD\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			//echo "<br/>";
			echo "</TD>";
			echo "</TR>";
	
}
}}
		function fAfficherProduitSimilaire3($pRubrique,$pCodeP,$pConnection)
{	
	$odd=0-1;
	$vSql = "SELECT nom FROM produit, contenurubrique WHERE produit.code=contenurubrique.produit AND contenurubrique.rubrique='$pRubrique' AND produit.code != '$pCodeP';";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==(-1))
		{      
		echo "<TR class=\"catalogueEVEN\">"; 
			echo "<TD class=\"catalogueEVEN\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			//echo "<br/>";
			echo "</TD>";
			echo "</TR>";
	
}
}}

function fgetNomProduitSimilaire ($pCodeP, $pC)
{
	$vSql ="SELECT rubrique from contenurubrique WHERE  produit='$pCodeP';";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["rubrique"];
	
}

function fgetDescProduit ($pCodeP, $pC)
{
	$vSql ="SELECT description from produit WHERE  code='$pCodeP';";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["description"];
	
}

function fStockProduit ($pCodeP, $pC)
{
	$vSql ="SELECT stock from produit WHERE  code='$pCodeP';";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["stock"];
	
}

function fdisponibiliteProduit ($pCodeP, $pC)
{

	if(fStockProduit($pCodeP, $pC)==0)
	
		echo "<p class=\"resFalse\">Stock épuisé. Désolé!</p>";
	else
		
			echo "<p class=\"resTrue\">livraison sous 48h</p>";



}
function fPrixProduit ($pCodeP, $pC)
{
	$vSql ="SELECT prix from produit WHERE  code='$pCodeP';";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["prix"];
	
}

function fImageProduit ($pCodeP, $pC)
{
	$vSql ="SELECT lien from imageproduit WHERE  produit=$pCodeP;";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["lien"];
	
}

function fAjoutRubrique($pNom,$pDesc,$pConnection)
{
	$vSql = "INSERT INTO rubrique (nom,description) VALUES ('$pNom','$pDesc');";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">La rubrique ".$pNom." n'a pas pu etre ajoute a la base</p>";
	}
	else 
	{
		echo "<p class=\"resTrue\">La rubrique ".$pNom." a bien ete ajoute a la base.</p>";
	}
}

function fUpdateContenuCatalogue($pNom,$pCatalogue,$pConnection)
{
	$vSql = "INSERT INTO contenucatalogue (catalogue,rubrique) VALUES ('$pCatalogue','$pNom');";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">La rubrique ".$pNom." n'a pas pu etre ajoutee au catalogue ".$pCatalogue."</p>";
	}
	else 
	{
		echo "<p class=\"resTrue\">La rubrique ".$pNom." a ete ajoutee au catalogue ".$pCatalogue." avec succes</p>";
	}
}

 function fAjoutProduit($pCode,$pNom,$pPrix,$pDesc,$pStock,$pMasse,$pLargeur,$pHauteur,$pProfondeur,$pConnection)
 
{
	$vSql = "INSERT INTO produit (code,nom,prix,description,stock,masse,largeur,hauteur,profondeur) VALUES ('$pCode','$pNom','$pPrix','$pDesc','$pStock','$pMasse','$pLargeur','$pHauteur','$pProfondeur');";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le produit ".$pNomP." n'a pas pu etre ajoute a la base</p>";
	}
	else 
	{
		echo "<p class=\"resTrue\">Le produit ".$pNomP." a bien ete ajoute a la base.</p>";
	}
}
function fUpdateContenuRubrique($pCode,$pCurrentRubrique,$pConnection)
{
	$vSql = "INSERT INTO contenurubrique (rubrique,produit) VALUES ('$pCurrentRubrique','$pCode');";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le produit ".$pNom." n'a pas pu etre ajoutee a la rubrique ".$pCurrentRubrique."</p>";
	}
	else 
	{
		echo "<p class=\"resTrue\">Le produit ".$pNom." a ete ajoutee a la rubrique ".$pCurrentRubrique." avec succes</p>";
	}
}
function fAjoutsousRubrique($pNom,$pDesc,$pCurrentRubrique,$pConnection)
{
	$vSql = "INSERT INTO rubrique (nom,description,pere) VALUES ('$pNom','$pDesc','$pCurrentRubrique');";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">La sous rubrique ".$pNom." n'a pas pu etre ajoute a la base</p>";
	}
	else 
	{
		echo "<p class=\"resTrue\">La sous rubrique ".$pNom." a bien ete ajoute a la base.</p>";
	}
}



?>