<link rel="stylesheet" type="text/css" href="style.css" />
<?php
function fAjoutAdresse($pLogin,$pNomAdresse,$pRue,$pCode_postal,$pVille,$pPays,$pConnection)
{
	//APPEL D'UNE FONCTION PLPSQL STOCKEE : fajouter_adresse QUI 
	/*
------ SI ON CHANGE LE PAYS N'EXISTE PAS LE CREE : --------------------------
------ SI LA VILLE N'EXISTE PAS LA CREE : -------// UTILISE POUR SE FAIRE, UNE SEQUENCE POSTGRE---
------ SI L'ADRESSE N'EXISTE PAS DEJA, L'AJOUTE------------------------------

ET RETOURNE :

1  :  si c'est ok


-1 : Les champs n'ont pas été correctement remplis
-2 : si le nouveau pays n'a pas pu être ajouté
-3 : si la nouvelle ville n'a pas pu être ajoutée
-4 : si le nom de l'adresse qu'on essaye d'ajouter existe déja

*/	

	$vSql = "SELECT fajout_adresse('$pLogin', '$pNomAdresse', '$pRue', '$pVille',$pCode_postal, '$pPays');";
	$vQuery = pg_query($pConnection,$vSql);
	$vResult = pg_fetch_row($vQuery);
	{
		switch($vResult[0])
		{
			case 1:
				echo "<p class=\"resTrue\">Adresse ajoutee avec succes !</p>";
				break;
	
			case -1:
				echo "<p class=\"resFalse\">Erreur -1 : Champs renseignes invalides</p>";
				break;
			case -2:
				echo "<p class=\"resFalse\">Erreur -2 : L'ajout a echoue.</p>";
				break;
			case -3:
				echo "<p class=\"resFalse\">Erreur -3 : L'ajout a echoue.</p>";
				break;
			case -4:
				echo "<p class=\"resFalse\">Erreur -4 : Le nom de l'adresse a ajouter, existe deja.</p>";
				break;

			default : //CE CAS NE DOIT PAS SE PRODUIRE
				echo "<p class=\"resFalse\">Erreur -8 : La modification a echoue.</p>"; 
				break;
		}
	}
	
}
         
function fCommander($pLogin,$pPanier,$pAdresseNom,$pRecu,$pConnection)
{
	$vSql = "SELECT fcommander('$pLogin', $pPanier, '$pAdresseNom', $pRecu);";
	$vQuery = pg_query($pConnection,$vSql);
	$vResult = pg_fetch_row($vQuery);
	{
		switch($vResult[0])
		{
			case 1:
				echo "<p class=\"resTrue\">Votre commande a ete effectuee avec succes !</p>";
				break;
	
			case -1:
				echo "<p class=\"resFalse\">Erreur -1 : Adresse invalide</p>";
				break;
	
			default : //CE CAS NE DOIT PAS SE PRODUIRE
				echo "<p class=\"resFalse\">Erreur -2 : La commande a echoue.</p>"; 
				break;
		}
	}

}



function fAjoutPanier($pLogin,$pPanier,$pProduit,$pQte,$pConnection)
{
	$vSql = "SELECT fajout_panier('$pLogin', $pPanier, $pProduit, $pQte);";
	$vQuery = pg_query($pConnection,$vSql);
	$vResult = pg_fetch_row($vQuery);
	{
		switch($vResult[0])
		{
			case 1:
				echo "<p class=\"resTrue\">Produit ajoute au panier avec succes !</p>";
				break;
	
			case -1:
				echo "<p class=\"resFalse\">Erreur -1 : Stocks Insuffisants</p>";
				break;
			case -6:
				echo "<p class=\"resFalse\">Erreur -6 : On essaye</p>";
				break;
			default : //CE CAS NE DOIT PAS SE PRODUIRE
				echo "<p class=\"resFalse\">Erreur -2 : L'achat a echoue.</p>"; 
				break;
		}
	}

}




function fAfficherAdresse($pLogin,$pConnection)
{
	
	$vSql = "Select nom,rue,villepays.ville as ville,code_postal,pays FROM adresse,villepays WHERE adresse.ville=villepays.id AND adresse.utilisateur='$pLogin';";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
	echo "<TABLE width=\"335\" class=\"catalogue\">"; 
    echo "<TR class=\"catalogue\"><TH width=\"20%\" class=\"catalogue\">".$vResult["nom"]."</TH></TR>";
	echo "<TR class=\"catalogue\"><TD class=\"catalogueODD\">".$vResult["rue"]."</TD></TR>";
	echo "<TR class=\"catalogue\"><TD class=\"catalogueEVEN\">".$vResult["ville"]."</TD></TR>";
	echo "<TR class=\"catalogue\"><TD class=\"catalogueODD\">".strval($vResult["code_postal"])."</TD></TR>";
	echo "<TR class=\"catalogue\"><TD class=\"catalogueEVEN\">".$vResult["pays"]."</TD></TR>";
	echo "<input type=\"hidden\" class=\"login_input\" name=\"inputNomAdresse\"value='".$vResult['nom']."'/>";
	echo "<TR class=\"catalogue\"><TD class=\"catalogueODD\"><a href=\"#\" onclick=\"submitform1(this);return false;\">Modifier</a>  <a href=\"#\" onclick=\"submitform2(this);return false;\">Supprimer</a></TD></TR>";
	echo "</TABLE>";
	echo "</br>";
	echo "</br>";
	
	}
}







function fAfficherCommande1($pC)
{
$vSql ="SELECT produit.code, produit.nom, commandes.quantite from panier, contenupanier, commandes WHERE  commande.cle_etrangere_vers_pnier = panier.cle_primaire AND quantitie.cle_etrangere_vers_panier=panier.cle_primaire AND quantite.cle_etrangere_vers_produit=produit.cle_primaire;";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["nom"];
}


function fLogout() {
	$_SESSION['login']='';
	$_SESSION['adminlogin']='';
	$_SESSION['admindroit']=0;
	$_SESSION['droit']=0;
}

function fLogin ($pEmail, $pMdp, $pC) {
	$vSql ="SELECT email as login FROM utilisateur WHERE  email='$pEmail' AND   mot_passe='$pMdp';";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["login"];
}

function fChmod($pEmail, $pC)
{
	$vSql ="SELECT administrateur as droit FROM utilisateur WHERE  email='$pEmail';";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["droit"];
	
}



function emailExist($pEmail,$pC)
{
	
	$vSql ="SELECT count(email) as resultat FROM utilisateur WHERE  email='$pEmail';";
	$vQuery=pg_query($pC,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult[resultat];
}



function fmenuGauche($pConnection)
{
$odd=1;
$ind=0;
$vSql = "SELECT nom FROM catalogue ORDER BY nom ASC;";
$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{
			
			echo "<form action=\"detailCatalogueClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<li class=\"odd\"><a href=\"#\" onclick=\"submitformIndex(this);return false;\">".$vResult['nom']."</a></li>";
			echo "</form>";
			$odd=$odd*-1;
			$ind++;
		}
		else
		{
			echo "<form action=\"detailCatalogueClient.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<li class=\"even\"><a href=\"#\" onclick=\"submitformIndex(this);return false;\">".$vResult['nom']."</a></li>";
			echo "</form>";
			$odd=$odd*-1;
			$ind++;
		}
	}

}





function fModifierUtilisateur($pCurrentMail,$pCurrentMdp,$pNewMail,$pNewMail2,$pNewNom,$pNewPrenom,$pNewMdp,$pNewMdp2,$pConnection)
{
	//APPEL D'UNE FONCTION PLPSQL STOCKEE : modif_utilisateur QUI 
	/*
------ SI ON CHANGE LA CLE PRIMAIRE : ------------------------------------------------
- cree un nouvel utilisateur avec le nouvel email et les nouvelles infos
- met a jour les clé étrangères de la table adresse pour pointer ce nouvel utilisateur
-supprimer l'utilisateur initial

------ SI ON NE CHANGE PAS LA CLE PRIMAIRE : -----------------------------------------
-met à jour les données
______________________________________________________________________________________

ET RETOURNE :

1  :  si c'est ok sans changement de clé primaire
2 : si c'est ok avec changement de clé primaire

-1 : erreur au niveau du insert d'une copie de l'utilisateur
-2 : le nouveau mail existe déjà
-3 : erreur au niveau du delete de l'utilisateur originial 
-4 : erreur au niveau du update simple
-5 : erreur au niveau du mot de passe actuel
-6 : erreur au niveau des nouveaux mot de passe
-7 : erreur au niveau des nouvelles adresses mail
*/
	$vSql = "SELECT modif_utilisateur('$pCurrentMail','$pCurrentMdp','$pNewMail','$pNewMail2','$pNewNom','$pNewPrenom','$pNewMdp','$pNewMdp2');";
	$vQuery = pg_query($pConnection,$vSql);
	$vResult = pg_fetch_row($vQuery);
	{
		switch($vResult[0])
		{
			case 1:
				echo "<p class=\"resTrue\">Modifications effectuees avec succes !</p>";
				break;
			case 2:
				echo "<p class=\"resTrue\">Modifications effectuees avec succes !</p>";
				$_SESSION['login']=$pNewMail;
				break;
			case -1:
				echo "<p class=\"resFalse\">Erreur -1 : La modification a echoue.</p>";
				break;
			case -2:
				echo "<p class=\"resFalse\">Erreur -2 : La modification a echoue.</p>";
				break;
			case -3:
				echo "<p class=\"resFalse\">Erreur -3 : La modification a echoue.</p>";
				break;
			case -4:
				echo "<p class=\"resFalse\">Erreur -4 : La modification a echoue.</p>";
				break;
			case -5:
				echo "<p class=\"resFalse\">Erreur -5 : La modification de la table commande echoue.</p>";
				break;
			case -6:
				echo "<p class=\"resFalse\">Erreur -6 : Les nouveaux mots de passe ne sont pas identiques.</p>";
				break;
			case -7:
				echo "<p class=\"resFalse\">Erreur -7 : Les nouvelles adresses email ne sont pas identiques.</p>";
				break;
			default : //CE CAS NE DOIT PAS SE PRODUIRE
				echo "<p class=\"resFalse\">Erreur -8 : La modification a echoue.</p>"; 
				break;
		}
	}
	
}

function fModifierCatalogue($pCurrentNom,$pNewNom,$pNewDebut,$pNewFin,$pNewDesc,$pConnection)	
{
	$vSql = "SELECT fmodif_catalogue('$pCurrentNom','$pNewNom','$pNewDebut','$pNewFin','$pNewDesc');";
	$vQuery = pg_query($pConnection,$vSql);
	$vResult = pg_fetch_row($vQuery);
	{
		switch($vResult[0])
		{
			case  1:
				echo "<p class=\"resTrue\">Modifications effectuees avec succes !</p>";
				break; 
			case  2:
				echo "<p class=\"resTrue\">Modifications effectuees avec succes !</p>";
				break;
			case -1:
				echo "<p class=\"resFalse\">Erreur -1 : Nouvelle date de debut superieure a nouvelle date de fin.</p>";
				break;
			case  -2:
				echo "<p class=\"resFalse\">Erreur -2 : Nouvelle date de debut superieure a la date de fin.</p>";
				break;
			case  -3:
				echo "<p class=\"resFalse\">Erreur -3 : Noucelle date de fin inferieure a la date de debut.</p>";
				break;
			case  -4://CE CAS NE DOIT PAS SE PRODUIRE
				echo "<p class=\"resFalse\">Erreur -4 : La modification a echoue.</p>";
				break;
			case  -5://CE CAS NE DOIT PAS SE PRODUIRE
				echo "<p class=\"resFalse\">Erreur -5 : La modification a echoue.</p>";
				break;
			case  -6:
				echo "<p class=\"resFalse\">Erreur -6 : La modification a echoue.</p>";
				break;
			case  -7:
				echo "<p class=\"resFalse\">Erreur -7 : La modification a echoue.</p>";
				break;
			case  -8:
				echo "<p class=\"resFalse\">Erreur -8 : La modification a echoue.</p>";
				break;
			default : //CE CAS NE DOIT PAS SE PRODUIRE
				echo "<p class=\"resFalse\">Erreur -9 : La modification a echoue.</p>"; 
				break;
				
			
		}
	}
	
	
}

function fModifierRubrique($pNouveau,$pNom,$pDesc,$pPere,$pConnection)
{
	$vSql = "SELECT fmodif_rubrique('$pNouveau','$pNom','$pDesc','$pPere');";
	$vQuery = pg_query($pConnection,$vSql);
	$vResult = pg_fetch_row($vQuery);
	{
		switch($vResult[0])
		{
			case  1:
				echo "<p class=\"resTrue\">Modifications effectuees avec succes !</p>";
				$_SESSION['poursuivre']=$pNom;
				break; 
			case  2:
				echo "<p class=\"resTrue\">Modifications effectuees avec succes !</p>";
				$_SESSION['poursuivre']=$pNouveau;
				break;			
			case  -6:
				echo "<p class=\"resFalse\">Erreur -6 : La modification a echoue.</p>";
				break;
			case  -7:
				echo "<p class=\"resFalse\">Erreur -7 : La modification a echoue.</p>";
				break;
			case  -8:
				echo "<p class=\"resFalse\">Erreur -8 : La modification a echoue.</p>";
				break;
			case -10:
				echo "<p class=\"resFalse\">Erreur -8 : La modification a echoue car la rubrique mere n'existe pas.</p>";
				break;
			default : //CE CAS NE DOIT PAS SE PRODUIRE
				echo "<p class=\"resFalse\">Erreur -9 : La modification a echoue.</p>"; 
				break;
				
			
		}
	}
	
	
}


function fInscrire ($pEmail, $pMdp,$pNom,$pPrenom,$pConnection)
{
	
	
	if(!emailExist($pEmail,$pConnection))
	{
		
		$vSql ="INSERT INTO utilisateur (email,nom,prenom,mot_passe,administrateur) VALUES ('$pEmail','$pNom','$pPrenom','$pMdp',0);";

		if(!pg_query($pConnection,$vSql))
		{
			echo "<p class=\"resFalse\">L'inscription a echouee !</p>";
			die('Error: ' . mysql_error());
		}
		else
		{
			echo "<p class=\"resTrue\">Votre inscription est reussie. Bienvenue !</p>";
		}
	}
	else
	{
		echo "<p class=\"resFalse\">Le login choisi est deja utilise, merci d'en choisir un autre.</p>";
	}
}

function fAjoutCatalogue($pNom,$pDate_debut,$pDate_fin,$pDescription,$pConnection)
{
	$vSql = "INSERT INTO catalogue (nom,date_debut,date_fin,description) VALUES ('$pNom','$pDate_debut','$pDate_fin','$pDescription');";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le catalogue n'a pas pu etre ajoute a la base</p>";
	}
	else 
	{
		echo "<p class=\"resTrue\">Le catalogue a bien ete ajoute a la base.</p>";
	}
}

function fAfficherCatalogue($pConnection)
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
			echo "<form action=\"detailCatalogue.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Detail</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"modifyCatalogue.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Modifier</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"deleteCatalogue.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Supprimer</a>";
			echo "</form>";
			$ind=$ind+1;
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
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Detail</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"modifyCatalogue.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Modifier</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"deleteCatalogue.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputCatalogue\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Supprimer</a>";
			echo "</form>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
	}
}




function fAfficherDetailCatalogue($pCatalogue,$pConnection)
{
	$odd=1;
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
			echo "<form action=\"detailRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Detail</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"modifyRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Modifier</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"deleteRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"Catalogue\"value='".$pCatalogue."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Supprimer</a>";
			echo "</form>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
		else 
		{
			echo "<TR class=\"catalogueEVEN\">";  	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detailRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Detail</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"modifyRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Modifier</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"deleteRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"Catalogue\"value='".$pCatalogue."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Supprimer</a>";
			echo "</form>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
	}
}

function fAfficherSousRubrique($pRubrique,$pConnection)
{
	$odd=1;
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
			echo "<form action=\"detailRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Detail</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"modifyRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Modifier</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"deleteRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Supprimer</a>";
			echo "</form>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
		else 
		{
			echo "<TR class=\"catalogueEVEN\">";  	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detailRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Detail</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"modifyRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Modifier</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"deleteRubrique.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputRubrique\"value='".$vResult['nom']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Supprimer</a>";
			echo "</form>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
	}
}



function fAfficherProduitRubrique($pRubrique,$pConnection)
{
	$odd=1;
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
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Detail</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"modifyProduit.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Modifier</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"deleteProduit.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Supprimer</a>";
			echo "</form>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
		else
		{
			echo "<TD class=\"catalogueEVEN\">".$vResult["code"]."</TD>"; 	
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["prix"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["description"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["stock"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"detail.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<a href=\"#\" onclick=\"submitform3(this);return false;\">Detail</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"modifyProduit.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<a href=\"#\" onclick=\"submitform3(this);return false;\">Modifier</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "<form action=\"deleteProduit.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputProduit\"value='".$vResult['code']."'/>";
			echo "<a href=\"#\" onclick=\"submitform3(this);return false;\">Supprimer</a>";
			echo "</form>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
	}
	
	
}

function copyUtilisateur($pNewMail,$pCurrentEmail,$pConnection) //duplique un utilisateur en ne changeant que le nom
{	
$vSql="INSERT INTO utilisateur (email, nom, prenom, mot_passe, administrateur) VALUES ('$pNewMail',(SELECT nom FROM utilisateur where email='$pCurrentEmail'),(SELECT prenom FROM utilisateur where email='$pCurrentEmail'),(SELECT mot_passe FROM utilisateur where email='$pCurrentEmail'),(SELECT administrateur FROM utilisateur where email='$pCurrentEmail'));";
if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">L'adresse e-mail existe deja, veuillez en chosir une autre</p>";
	}//else = ok !
}
	
function updateForeignkey($pNewMail,$pCurrentMail,$pConnection)
{
	$vSql="UPDATE panier SET client = '$pNewMail' WHERE client = '$pCurrentMail';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le changement d'adresse mail a echoue</p>";
	}//else = ok !
	$vSql="UPDATE adresse SET utilisateur = '$pNewMail' WHERE utilisateur = '$pCurrentMail';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le changement d'adresse mail a echoue</p>";
	}//else = ok !
	$vSql="UPDATE commande SET client = '$pNewMail' WHERE client = '$pCurrentMail';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le changement d'adresse mail a echoue</p>";
	}//else = ok !
}

function changePassword($pNewMail,$pNewMdp,$pConnection)
{
	$vSql="UPDATE utilisateur SET mot_passe = '$pNewMdp' WHERE email = '$pNewMail';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le changement de mot de passe a echoue</p>";
	}
	else
	{
		echo "<p class=\"resTrue\">Changement de mot de passe effectue</p>";
	}
}

function changeNom($pNewMail,$pNewNom,$pConnection)
{
	$vSql="UPDATE utilisateur SET nom = '$pNewNom' WHERE email = '$pNewMail';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le changement de nom a echoue</p>";
	}
	else
	{
		echo "<p class=\"resTrue\">Changement de nom effectue</p>";
	}
}

function changePrenom($pNewMail,$pNewPrenom,$pConnection)
{
	$vSql="UPDATE utilisateur SET prenom = '$pNewPrenom' WHERE email = '$pNewMail';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">Le changement de prenom a echoue</p>";
	}
	else
	{
		echo "<p class=\"resTrue\">Changement de prenom effectue</p>";
	}
}

function deleteUser($pNewMail,$pConnection)
{
	$vSql="DELETE FROM utilisateur WHERE email='$pNewMail';";
	if(!pg_query($pConnection,$vSql))
	{
		echo "<p class=\"resFalse\">La mise a jour de votre profil a echouee</p>";
	}
}

function afficherNom($pLogin,$pConnection)
{
	$vSql="SELECT nom FROM utilisateur WHERE email='$pLogin';";
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["nom"];
}

function afficherPrenom($pLogin,$pConnection)
{
	$vSql="SELECT prenom FROM utilisateur WHERE email='$pLogin';";
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["prenom"];
}

function afficherLogin($pLogin,$pConnection)
{
	$vSql="SELECT email FROM utilisateur WHERE email='$pLogin';";
	$vQuery=pg_query($pConnection,$vSql);
	$vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	return $vResult["email"];
}



function fAfficherUser($pConnection)
{
	$odd=1;
	$ind=1;
	$vSql = "SELECT email, prenom, nom FROM utilisateur where administrateur=0;";
	$vQuery = pg_query($pConnection,$vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC))
	{ 
		if ($odd==1)
		{      
			echo "<TR class=\"catalogueODD\">";  	
			echo "<TD class=\"catalogueODD\">".$vResult["email"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["prenom"]."</TD>";
			echo "<TD class=\"catalogueODD\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueODD\">";
			echo "<form action=\"resSubLogin.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputUser\"value='".$vResult['email']."'/>";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputMdp\"value='".$vResult['mot_passe']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Connection</a>";
			echo "</form>";
			$ind=$ind+1;
			echo "<form action=\"resGrant.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputUser\"value='".$vResult['email']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Nommer Admin</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
		else 
		{
				echo "<TR class=\"catalogueEVEN\">";  	
			echo "<TD class=\"catalogueEVEN\">".$vResult["email"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["prenom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">".$vResult["nom"]."</TD>";
			echo "<TD class=\"catalogueEVEN\">";
			echo "<form action=\"resSubLogin.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputUser\"value='".$vResult['email']."'/>";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputMdp\"value='".$vResult['mot_passe']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Connection</a>";
			echo "</form>";
			$ind=$ind+1;
			echo "<form action=\"resGrant.php\" method=\"POST\" id=\"".$ind."\">";
			echo "<input type=\"hidden\" class=\"login_input\" name=\"inputUser\"value='".$vResult['email']."'/>";
			echo "<a href=\"#\" onclick=\"submitform2(this);return false;\">Nommer Admin</a>";
			echo "</form>";
			//echo "<br/>";
			$ind=$ind+1;
			echo "</TD>";
			echo "</TR>";
			$odd=$odd*-1;
		}
	}
}


function fGrant($pUser,$pConnection)
{
	
	
	$vSql = "SELECT fGrant('$pUser');";
	$vQuery = pg_query($pConnection,$vSql);
	$vResult = pg_fetch_row($vQuery);
	{
		switch($vResult[0])
		{
			case 1:
				echo "<p class=\"resTrue\">Promotion effectuee!</p>";
				break;
			case 2:
				echo "<p class=\"resTrue\">Promotion echouee !</p>";
				break;
			default:
				echo "<p class=\"resTrue\">Promotion echouee !</p>";
				$_SESSION['login']=$pNewMail;
				break;
		}
	}
			
	
	
}

function fSubLogin($pUser,$pMdp)
{	
	$_SESSION['adminlogin']=$_SESSION['login'];
	$_SESSION['login']=$pUser;
	$_SESSION['usermdp']=$pMdp;
	$_SESSION['admindroit']=$_SESSION['droit'];
	$_SESSION['droit']=0;
	echo "<p class=\"resTrue\">Vous etes maintenant connecte sous ".$_SESSION['login']." avec le droit utilisateur !</p>";
}


function fUnSubLogin()
{
	$_SESSION['login']=$_SESSION['adminlogin'];
	$_SESSION['adminlogin']='';
	$_SESSION['droit']=$_SESSION['admindroit'];
	$_SESSION['admindroit']='';
	$_SESSION['usermdp']='';
	echo "<p class=\"resTrue\">Vous etes maintenant de retour en tant qu'administrateur</p>";
}

