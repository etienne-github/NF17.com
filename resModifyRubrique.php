<?php
session_start();
?>

<?php if((!isset($_SESSION['droit'])) || ($_SESSION['droit']!=1)) { ?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>PAGE 404</title>
<meta http-equiv="REFRESH" content="0;url=http://tuxa.sme.utc/~nf17p066/index.php"></HEAD>
<BODY>
Vous N'avez pas les droits d'acceder a cette zone du site, vous allez etre rediriger vers l'acceuil...
</BODY>
</HTML>

<? } else { ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php
/* Connexion à la base de données*/
include "connect_class.php";
include "lib_KENZA.php";
include "lib.php";
$vC = new Connect;
$vC->mConnect();
?>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />


<title>NF17.com - Modifier Catalogue</title>

<link rel="stylesheet" type="text/css" href="style.css" />

<!--[if IE 6]>

<link rel="stylesheet" type="text/css" href="iecss.css" />

<![endif]-->


<script type="text/javascript">
function submitform()
{
    document.forms["test"].submit();
}
</script>

<script type="text/javascript" src="js/boxOver.js"></script>

</head>
<body><div id="content"></div>

<div id="main_container">
<div class="top_bar">
<div class="top_search">
		    
<div class="search_text"><a href="javascript: submitform()">Recherche</a></div>
<form method="POST" id="search" action="recherche.php">			
<input type="text" class="search_input" name="search" />
<input type="image" src="images/search.gif" class="search_bt"/>
</form>
</div>


<div class="languages">
<div class="lang_text">Langue:</div>
<a href="#" class="lang"><img src="images/en.gif" alt="" title="" border="0" /></a>
<!--<a href="#" class="lang"><img src="images/de.gif" alt="" title="" border="0" /></a> -->
</div>

</div>
<div id="header">

<div id="logo">
<a href="index.php"><img src="images/logo.png" alt="" title="" border="0" width="237" height="140" /></a>
</div>

<div class="oferte_content">
<div class="top_divider"><img src="images/header_divider.png" alt="" title="" width="1" height="164" /></div>
<div class="oferta">

<div class="oferta_content">
<img src="images/laptop.png" width="94" height="92" border="0" class="oferta_img" />

<div class="oferta_details">
<div class="oferta_title">Samsung GX 2004 LM</div>
<div class="oferta_text">
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
</div>
<a href="detail.php" class="details">details</a>
</div>
</div>


</div>
<div class="top_divider"><img src="images/header_divider.png" alt="" title="" width="1" height="164" /></div>

</div> <!-- end of oferte_content-->


</div>

<div id="main_content"> 

<div id="menu_tab">
<div class="left_menu_corner"></div>
<ul class="menu">
<li><a href="index.php" class="nav1"> Accueil </a></li>
<li class="divider"></li>
<li><a href="catalogue.php" class="nav2">Produits</a></li>
<li class="divider"></li>
<!-- <li><a href="#" class="nav3">Specials</a></li>-->
<!--<li class="divider"></li>-->
<?php
	if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))
	{
		if((isset($_SESSION['droit'])) && ($_SESSION['droit']==1))
		{
			echo"<li><a href=\"myAdminAccount.php\" class=\"nav4\">Gestion</a></li>";	
		}
		else
		{
			echo"<li><a href=\"myaccount.php\" class=\"nav4\">Mon Compte</a></li>";	
		}
	}
	else
	{
		echo "<li><a href=\"login.php\" class=\"nav4\">Mon Compte</a></li>";
	}
?>
<li class="divider"></li>
<?php
	if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))
	{
		echo"<li><a href=\"resLogout.php\" class=\"nav4\">Se deconnecter</a></li>";		
	}
	else
	{
		echo "<li><a href=\"login.php\" class=\"nav4\">S'identifier</a></li>";
	}
?>
<li class="divider"></li>
<?php
	if ((isset($_SESSION['adminlogin'])) && (!empty($_SESSION['adminlogin'])) && ($_SESSION['adminlogin']!=''))
	{
		echo "<li><a href=\"resUnSubLogin.php\" class=\"nav4\">Vers Administrateur</a></li>";		
	}
	
?>


<li class="divider"></li> 
<li><?php

if ((isset($_SESSION['login'])) && (!empty($_SESSION['login'])))
	{
		echo"<li><a href=\"resLogout.php\" class=\"nav4\">Livraison</a></li>";		
	}
	echo "<li class=\"divider\"></li>";
	?>

	</li>

<li><a href="contact.html" class="nav6">Nous contacter</a></li>
<li class="divider"></li>
<!--<li class="currencies">Currencies-->
<!--<select>
<option>US Dollar</option>
<option>Euro</option>
</select>-->
</li>
</ul>
<div class="right_menu_corner"></div>
</div><!-- end of menu tab -->

            

     <div class="crumb_navigation">

     Navigation: <a href="index.php">Accueil</a> &lt; <a href="myAdminAccount.php">Gestion</a> &lt; <span class="current">Modifier rubrique</span> 

    

    </div>              

    

    

   <div class="left_content">

    <div class="title_box">Categories</div>

    

        <ul class="left_menu">
<?php fmenuGauche($vC->fConn);?>
</ul> 

        

        

     <div class="title_box">Offres</div>  

     <div class="border_box">

         <div class="product_title">Motorola 156 MX-VL</div>

         <div class="product_img"><a href="#"><img src="images/laptop.png" alt="" title="" border="0" /></a></div>

         <div class="prod_price"><span class="reduce">350$</span> <span class="price">270$</span></div>

     </div>  

     

     

     <div class="title_box">Newsletter</div>  

     <div class="border_box">

		<input type="text" name="newsletter" class="newsletter_input" value="your email"/>

        <a href="#" class="join">join</a>

     </div>  

     

     <div class="banner_adds">

     

     <a href="#"><img src="images/bann2.jpg" alt="" title="" border="0" /></a>

     </div>    

        

    

   </div><!-- end of left content -->

  



   <?php $vNouveau=$_POST['inputModifyRubrique']; ?>

   <div class="center_content">

   	<div class="center_title_bar">Modifier rubrique <?php echo $vNouveau;?></div>

    

    	<div class="prod_box_big">

        	<div class="top_prod_box_big"></div>

            <div class="center_prod_box_big">            

                 
              	<div class="login_form">

                         <?php
						
/* Récupération des variables passées par le fomulaire */
$vNom=$_POST['nomC'];
$vDesc=$_POST['descC'];
$vPere=$_POST['pereC'];


/* Inscription 
	NB : si aucun login n'est passé, c'est que la page est appelé uniquement pour avoir la liste des inscrits
		sans procéder à une nouvelle inscrition*/

/*if (($vNom)&&($vNom!='')) { //SI ON MODIFIE LA CLE PRIMAIRE

	//ALORS ON CREER UN DUPLICATA DU CATALOGUE AVEC LE NOUVEAU NOM
	fcopyCatalogue($vNouveau,$vNom,$vC->fConn);

	//ON REDIRIGE LES FOREIGN KEYS DE CONTENUCATALOGUE VERS CE DUPLICATA
	fupdateForeignKeyContenuCatalogue($vNouveau,$vNom,$vC->fConn); 

	//ON SUPPRIME LE CATALOGUE DE DEPART
	fdeleteCatalogue($vNouveau,$vC->fConn);

	
	if($vDateDebut!=fgetDateDebut($vNom,$vC->fConn)) // SI BESOIN ON MODIFIE LE RESTE
	{
		fchangeDateDebut($vNom,$vDateDebut,$vC->fConn);

	}
	if($vDateFin!=fgetDateFin($vNom,$vC->fConn))
	{
		fchangeDateFin($vNom,$vDateFin,$vC->fConn);
	
	}
	if(($vDesc)&&($vDesc!=''))
	{
		fchangeDesc($vNom,$vDesc,$vC->fConn);
	
	}
	
}
else //SI ON NE CHANGE PAS LA CLE PRIMAIRE
{

	if($vDateDebut!=fgetDateDebut($vNouveau,$vC->fConn)) //ON MODIFIE SEULEMENT
	{
		fchangeDateDebut($vNouveau,$vDateDebut,$vC->fConn);
	
	}
	if($vDateFin!=fgetDateFin($vNouveau,$vC->fConn))
	{
		fchangeDateFin($vNouveau,$vDateFin,$vC->fConn);
	
	}
	if(($vDesc)&&($vDesc!=''))
	{
		fchangeDesc($vNouveau,$vDesc,$vC->fConn);

	}
}*/
//$_SESSION['poursuivre']='';
fModifierRubrique($vNouveau,$vNom,$vDesc,$vPere,$vC->fConn);

/*if((isset($_SESSION['poursuivre']))&&(!empty($_SESSION['poursuivre']))&&($_SESSION['poursuivre']!=''))
{
	$vNouveau=$_SESSION['poursuivre'];
}*/


?> 
<input type="hidden" class="login_input" name="inputRubrique" value="<?php echo $_SESSION['poursuivre'];?>"/>
<!--<form action="gestionCatalogue.php" method="POST" id="poursuivre">
<input type="hidden" class="login_input" name="inputCatalogue" value="<?php //echo $vNouveau;?>"/>
</form> -->
   				<br/>
                <br/>
                <br/>
                <br/>

                
	
            
            
                
					<div class="form_row">
					<a href="gestionCatalogue.php" class="login">Poursuivre</a>
                                     

           			 </div>
				</div>
                </div>
            <div class="bottom_prod_box_big"></div>                                

        </div>

       

    

   

   </div><!-- end of center content -->

   

   <div class="right_content">

   		<div class="shopping_cart">

        	<div class="cart_title">Shopping cart</div>

            

            <div class="cart_details">

            3 articles <br />

            <span class="border_cart"></span>

            Total: <span class="price">350$</span>

            </div>

            

            <div class="cart_icon"><a href="#" title="header=[Checkout] body=[&nbsp;] fade=[on]"><img src="images/shoppingcart.png" alt="" title="" width="48" height="48" border="0" /></a></div>

        

        </div>

   

   

     <div class="title_box">Quoi de neuf ?</div>  

     <div class="border_box">

         <div class="product_title">Motorola 156 MX-VL</div>

         <div class="product_img"><a href="detail.php"><img src="images/p2.gif" alt="" title="" border="0" /></a></div>

         <div class="prod_price"><span class="reduce">350$</span> <span class="price">270$</span></div>

     </div>  

     

     

     

    <div class="title_box">Marques</div>

    

        <ul class="left_menu">

        <li class="odd"><a href="services.html">Sony</a></li>

        <li class="even"><a href="services.html">Samsung</a></li>

         <li class="odd"><a href="services.html">Daewoo</a></li>

        <li class="even"><a href="services.html">LG</a></li>

         <li class="odd"><a href="services.html">Fujitsu Siemens</a></li>

         <li class="even"><a href="services.html">Motorola</a></li>

        <li class="odd"><a href="services.html">Phillips</a></li>

        <li class="even"><a href="services.html">Beko</a></li>

        </ul>      

     

     <div class="banner_adds">

     

     <a href="#"><img src="images/bann1.jpg" alt="" title="" border="0" /></a>

     </div>        

     

   </div><!-- end of right content -->   

   

            

   </div><!-- end of main content -->

   

   

   

   <div class="footer">

   



        <div class="left_footer">

        <img src="images/footer_logo.png" alt="" title="" width="170" height="49"/>

        </div>

        

        <div class="center_footer">

        Template name. All Rights Reserved 2008<br />

          <a href="http://csscreme.com"><img src="images/csscreme.jpg" alt="csscreme" title="csscreme" border="0" /></a><br />

        <img src="images/payment.gif" alt="" title="" />

        </div>

        

        <div class="right_footer">

        <a href="index.php">Accueil</a>

        <a href="services.html">à propos</a>

        <a href="services.html">Plan du site</a>

        <a href="services.html">rss</a>

        <a href="contact.html">Nous contacter</a>

        </div>   

   

   </div>                 





</div>

<!-- end of main_container -->

</body>

</html>

<?php } ?>