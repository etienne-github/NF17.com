
<?php
function fAfficherCommandeClient($pLogin, $pConnection)
{
	$odd=1;
	$ind=1;
	$vSql ="SELECT id, client, panier, date, etat from commande WHERE client='$pLogin' ORDER BY date ASC;";
	$vQuery = pg_query($pConnection,$vSql);
	
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
		echo "<TR class=\"catalogueODD\">"; 
			$ind=$ind+1;
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"infoPanierClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputPanier\"value='".$vResult['panier']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">".$vResult['panier']."</a>";
			echo "</form>";
			echo "</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["date"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["etat"]."</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;

		}
			
		
		else
		{
			echo "<TR class=\"catalogueEVEN\">"; 
			$ind=$ind+1;
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"infoPanierClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputPanier\"value='".$vResult['panier']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">".$vResult['panier']."</a>";
			echo "</form>";
			echo "</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["date"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["etat"]."</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}	
		}
	
	
	
}

function fCountPanier($pLogin,$pConnection)
{
	
	$vSql ="SELECT count(*) as somme FROM contenupanier WHERE panier=(SELECT max(id) from panier where panier.client='$pLogin' AND recurrent=0 AND panier.date=(SELECT max(panier.date) from panier WHERE client='$pLogin' AND recurrent=0));" ;
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC); 
	return $vResult["somme"];
}

function fPrixPanier($pLogin,$pConnection)
{
	
	$vSql ="SELECT sum(contenupanier.quantite*produit.prix) as somme FROM contenupanier,produit WHERE contenupanier.produit=produit.code AND panier=(SELECT max(id) from panier where panier.client='$pLogin' AND recurrent=0 AND panier.date=(SELECT max(panier.date) from panier WHERE client='$pLogin' AND recurrent=0));" ;
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC); 
	return $vResult["somme"];
}


function fAfficherCommandeAdministrateur($pConnection)
{
	$odd=1;
	$ind=1;
	$vSql ="SELECT id, client, panier, date, etat from commande ORDER BY date ASC;";
	$vQuery = pg_query($pConnection,$vSql);
	
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
		echo "<TR class=\"catalogueODD\">"; 
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"infoClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCommande\"value='".$vResult['id']."'/>";
			//echo "<input type=\"hidden\" class=\"login_input\" name=\"inputPanier\"value='".$vResult['panier']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">".$vResult['client']."</a>";
			echo "</form>";
			echo "</TD>";
			$ind=$ind+1;
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"infoPanier.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputPanier\"value='".$vResult['panier']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">".$vResult['panier']."</a>";
			echo "</form>";
			echo "</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["date"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["etat"]."</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;

		}
			
		
		else
		{
			echo "<TR class=\"catalogueEVEN\">"; 
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"infoClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCommande\"value='".$vResult['id']."'/>";
			//echo "<input type=\"hidden\" class=\"login_input\" name=\"inputPanier\"value='".$vResult['panier']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">".$vResult['client']."</a>";
			echo "</form>";
			echo "</TD>";
			$ind=$ind+1;
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"infoPanier.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputPanier\"value='".$vResult['panier']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">".$vResult['panier']."</a>";
			echo "</form>";
			echo "</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["date"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["etat"]."</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}	
		}
	
	
	
}

function fAfficherInfoClient($pCommande,$pConnection)
{
	$odd=1;
	$ind=1;
	$vSql ="SELECT  utilisateur.nom as nom, utilisateur.prenom as prenom,utilisateur.email as email, livraison.adresse_nom as adresse from utilisateur, commande, livraison where commande.id=$pCommande AND utilisateur.email=commande.client AND livraison.commande=$pCommande;";
	$vQuery = pg_query($pConnection,$vSql);
	

	
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      			
			echo "<TR class=\"catalogueODD\">"; 
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["prenom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["email"]."</TD>";	
			echo "<TD class=\"catalogueODD\">".$vResult["adresse"]."</TD>";
			//echo "<TD class=\"catalogueODD\">".$vResult["rue"]."  ".$vResult["codepostal"]." ".$vResult["ville"]."</TD>";	
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;

		}
			
		
		else
		{
			echo "<TR class=\"catalogueEVEN\">"; 
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["prenom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["email"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["rue"]."   ".$vResult["codepostal"]."   ".$vResult["ville"]."</TD>";		

			$odd=$odd*-1;
			$ind=$ind+1;
		}	
		}
	
	
	
}
function fAfficherInfoPanier($pPanier,$pConnection)
{
	$odd=1;
	$ind=1;

	$vSql ="SELECT produit, quantite, nom from contenupanier, produit where contenupanier.produit=produit.code AND contenupanier.panier= $pPanier;";
	$vQuery = pg_query($pConnection,$vSql);
	

	
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      			
			echo "<TR class=\"catalogueODD\">"; 
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["quantite"]."</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;

		}
			
		
		else
		{
			echo "<TR class=\"catalogueEVEN\">"; 
			echo "<TD class=\"catalogueEVEN\">".$vResult["produit"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["quantite"]."</TD>";
			echo "</TR>";
			$odd=$odd*-1;
			$ind=$ind+1;
		}	
		}
	
	
	
}
function fImageProduit2 ($pCodeP, $pC)
{
	$vSql ="SELECT lien from imageproduit WHERE  produit=$pCodeP;";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["lien"];
	
}

function fAfficherProduitRecent($pConnection)
{
	$odd=1;
	$ind=1;
	$vSql = "SELECT  code, nom, prix FROM produit ORDER BY date_ajout ASC;";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		echo "<form method=\"POST\" id=\"".$ind."\" action=\"detailClient.php\">";
		echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
		echo"</form>";
		$ind=$ind+1;
		
		
		echo "<div class=\"prod_box\">";
		echo "<div class=\"top_prod_box\"></div>";
		echo "<div class=\"center_prod_box\"> ";
		
		echo "<form method=\"POST\" id=\"".$ind."\" action=\"detailClient.php\">";
		echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
		echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">".$vResult['nom']."</a>";
		echo"</form>";
		$ind=$ind+1;
		
		echo "<div class=\"product_img\"><a href=\"detailClient.php\"><img src=\"images/".fImageProduit2($vResult['code'],$pConnection)."\" alt=\"\" title=\"\" border=\"0\" /></a></div>";
		echo "<div class=\"prod_price\"><span  <span class=\"price\">".$vResult['prix']."€</span></div>"; 
		echo "</div>";
		echo "<div class=\"bottom_prod_box\"></div>"; 
		echo "<div class=\"prod_details_tab\">";
		
		echo "<form method=\"POST\" id=\"".$ind."\" action=\"detailClient.php\">";
		echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
		echo "<a href=\"#\" onclick=\"submitform2(this);return false;\" title= \"header=[Add to cart] body=[&nbsp;] fade=[on]\"><img src=\"images/cart.gif\" alt=\"\" title=\"\" border=\"0\" class=\"left_bt\" /></a>";
		echo"</form>";
		$ind=$ind+1;
		
		echo "<div class=\"prod_details_tab2\">";
		echo "<form method=\"POST\" id=\"".$ind."\" action=\"detailClient.php\">";
		echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
		echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Details</a>";
		echo"</form>";
		$ind=$ind+1;
		
		echo "</div>";
		echo "</div>";
		echo "</div>";
		$ind=$ind+1;

	
	}
}

?>