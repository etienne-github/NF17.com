<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include"lib.php"; ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>NF17.com - Detail produit</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script>
PositionX = 100;
PositionY = 100;


defaultWidth  = 500;
defaultHeight = 500;
var AutoClose = true;

if (parseInt(navigator.appVersion.charAt(0))>=4){
var isNN=(navigator.appName=="Netscape")?1:0;
var isIE=(navigator.appName.indexOf("Microsoft")!=-1)?1:0;}
var optNN='scrollbars=no,width='+defaultWidth+',height='+defaultHeight+',left='+PositionX+',top='+PositionY;
var optIE='scrollbars=no,width=150,height=100,left='+PositionX+',top='+PositionY;
function popImage(imageURL,imageTitle){
if (isNN){imgWin=window.open('about:blank','',optNN);}
if (isIE){imgWin=window.open('about:blank','',optIE);}
with (imgWin.document){
writeln('<html><head><title>Loading...</title><style>body{margin:0px;}</style>');writeln('<sc'+'ript>');
writeln('var isNN,isIE;');writeln('if (parseInt(navigator.appVersion.charAt(0))>=4){');
writeln('isNN=(navigator.appName=="Netscape")?1:0;');writeln('isIE=(navigator.appName.indexOf("Microsoft")!=-1)?1:0;}');
writeln('function reSizeToImage(){');writeln('if (isIE){');writeln('window.resizeTo(300,300);');
writeln('width=300-(document.body.clientWidth-document.images[0].width);');
writeln('height=300-(document.body.clientHeight-document.images[0].height);');
writeln('window.resizeTo(width,height);}');writeln('if (isNN){');       
writeln('window.innerWidth=document.images["George"].width;');writeln('window.innerHeight=document.images["George"].height;}}');
writeln('function doTitle(){document.title="'+imageTitle+'";}');writeln('</sc'+'ript>');
if (!AutoClose) writeln('</head><body bgcolor=ffffff scroll="no" onload="reSizeToImage();doTitle();self.focus()">')
else writeln('</head><body bgcolor=ffffff scroll="no" onload="reSizeToImage();doTitle();self.focus()" onblur="self.close()">');
writeln('<img name="George" src='+imageURL+' style="display:block"></body></html>');
close();		
}}

</script>
<script type="text/javascript" src="js/boxOver.js"></script>
</head>
<?php
/* Connexion � la base de donn�es*/
include "connect_class.php";
$vC = new Connect;
$vC->mConnect();
?>
<body>

<div id="main_container">
	<div class="top_bar">
    	<div class="top_search">
        	<div class="search_text"><a href="#">Recherche</a></div>
            <input type="text" class="search_input" name="search" />
            <input type="image" src="images/search.gif" class="search_bt"/>
        </div>
        
        <div class="languages">
        	<div class="lang_text">Langue:</div>
            <a href="#" class="lang"><img src="images/en.gif" alt="" title="" border="0" /></a>
            <!--<a href="#" class="lang"><img src="images/de.gif" alt="" title="" border="0" /></a>-->       
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
                <div class="oferta_pagination">
                
                     <span class="current">1</span>
                     <a href="#?page=2">2</a>
                     <a href="#?page=3">3</a>
                     <a href="#?page=3">4</a>
                     <a href="#?page=3">5</a>  
                             
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
<li><a href="#" class="nav5">Livraison </a></li>
<li class="divider"></li>
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
    Navigation: <a href="index.php">Accueil</a> &lt; <span class="current">Categories</span>
    
    </div>              
    
    
   <div class="left_content">
    <div class="title_box">Categories</div>
    
        <ul class="left_menu">
        <li class="odd"><a href="services.html">Processors</a></li>
        <li class="even"><a href="services.html">Motherboards</a></li>
         <li class="odd"><a href="services.html">Desktops</a></li>
        <li class="even"><a href="services.html">Laptops & Notebooks</a></li>
         <li class="odd"><a href="services.html">Processors</a></li>
         <li class="even"><a href="services.html">Motherboards</a></li>
        <li class="odd"><a href="services.html">Processors</a></li>
        <li class="even"><a href="services.html">Motherboards</a></li>
         <li class="odd"><a href="services.html">Desktops</a></li>
        <li class="even"><a href="services.html">Laptops & Notebooks</a></li>
         <li class="odd"><a href="services.html">Processors</a></li>
         <li class="even"><a href="services.html">Motherboards</a></li>
        </ul> 
        
        
     <div class="title_box">Offres</div>  
     <div class="border_box">
         <div class="product_title"><a href="detail.php">Motorola 156 MX-VL</a></div>
         <div class="product_img"><a href="detail.php"><img src="images/laptop.png" alt="" title="" border="0" /></a></div>
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
  

   
   <div class="center_content">
   	<div class="center_title_bar">Motorola 156 MX-VL</div>
    
    	<div class="prod_box_big">
        	<div class="top_prod_box_big"></div>
            <div class="center_prod_box_big">            
                 
                 <div class="product_img_big">
                 <a href="javascript:popImage('images/big_pic.jpg','Some Title')" title="header=[Zoom] body=[&nbsp;] fade=[on]"><img src="images/laptop.gif" alt="" title="" border="0" /></a>
                 <div class="thumbs">
                 <a href="#" title="header=[Thumb1] body=[&nbsp;] fade=[on]"><img src="images/thumb1.gif" alt="" title="" border="0" /></a>
                 <a href="#" title="header=[Thumb2] body=[&nbsp;] fade=[on]"><img src="images/thumb1.gif" alt="" title="" border="0" /></a>
                 <a href="#" title="header=[Thumb3] body=[&nbsp;] fade=[on]"><img src="images/thumb1.gif" alt="" title="" border="0" /></a>
                 </div>
                 </div>
                     <div class="details_big_box">
                         <div class="product_title_big">My Cinema-U3000/DVBT, USB 2.0 TV BOX External, White</div>
                         <div class="specifications">
                            Disponibilit�: <span class="blue">24h</span><br />

                            Garantie: <span class="blue">2 ans</span><br />
                            
                            Transport: <span class="blue">Colis</span><br />
                            
                            Taxes: <span class="blue">TVA</span><br />
                         </div>
                         <div class="prod_price_big"><span class="reduce">350$</span> <span class="price">270$</span></div>
                         
                         <a href="#" class="addtocart">Acheter</a>
                         <a href="#" class="compare">Comparer</a>
                     </div>                        
            </div>
            <div class="bottom_prod_box_big"></div>                                
        </div>
    
    
 

 
 
 
 <div class="center_title_bar">Produits similaires</div>
 
 
      	<div class="prod_box">
        	<div class="top_prod_box"></div>
            <div class="center_prod_box">            
                 <div class="product_title"><a href="detail.php">Motorola 156 MX-VL</a></div>
                 <div class="product_img"><a href="detail.php"><img src="images/laptop.gif" alt="" title="" border="0" /></a></div>
                 <div class="prod_price"><span class="reduce">350$</span> <span class="price">270$</span></div>                        
            </div>
            <div class="bottom_prod_box"></div>             
            <div class="prod_details_tab">
            <a href="#" title="header=[Add to cart] body=[&nbsp;] fade=[on]"><img src="images/cart.gif" alt="" title="" border="0" class="left_bt" /></a>
            <a href="#" title="header=[Specials] body=[&nbsp;] fade=[on]"><img src="images/favs.gif" alt="" title="" border="0" class="left_bt" /></a>
            <a href="#" title="header=[Gifts] body=[&nbsp;] fade=[on]"><img src="images/favorites.gif" alt="" title="" border="0" class="left_bt" /></a>           
            <a href="detail.php" class="prod_details">details</a>            
            </div>                     
        </div>
    
    
 
     	<div class="prod_box">
        	<div class="top_prod_box"></div>
            <div class="center_prod_box">            
                 <div class="product_title"><a href="detail.php">Iphone Apple</a></div>
                 <div class="product_img"><a href="detail.php"><img src="images/p4.gif" alt="" title="" border="0" /></a></div>
                 <div class="prod_price"><span class="price">270$</span></div>                        
            </div>
            <div class="bottom_prod_box"></div>             
            <div class="prod_details_tab">
            <a href="#" title="header=[Add to cart] body=[&nbsp;] fade=[on]"><img src="images/cart.gif" alt="" title="" border="0" class="left_bt" /></a>
            <a href="#" title="header=[Specials] body=[&nbsp;] fade=[on]"><img src="images/favs.gif" alt="" title="" border="0" class="left_bt" /></a>
            <a href="#" title="header=[Gifts] body=[&nbsp;] fade=[on]"><img src="images/favorites.gif" alt="" title="" border="0" class="left_bt" /></a>           
            <a href="detail.php" class="prod_details">details</a>             
            </div>                     
        </div>
 
     	<div class="prod_box">
        	<div class="top_prod_box"></div>
            <div class="center_prod_box">            
                 <div class="product_title"><a href="detail.php">Samsung Webcam</a></div>
                 <div class="product_img"><a href="detail.php"><img src="images/p5.gif" alt="" title="" border="0" /></a></div>
                 <div class="prod_price"><span class="reduce">350$</span> <span class="price">270$</span></div>                        
            </div>
            <div class="bottom_prod_box"></div>             
            <div class="prod_details_tab">
            <a href="#" title="header=[Add to cart] body=[&nbsp;] fade=[on]"><img src="images/cart.gif" alt="" title="" border="0" class="left_bt" /></a>
            <a href="#" title="header=[Specials] body=[&nbsp;] fade=[on]"><img src="images/favs.gif" alt="" title="" border="0" class="left_bt" /></a>
            <a href="#" title="header=[Gifts] body=[&nbsp;] fade=[on]"><img src="images/favorites.gif" alt="" title="" border="0" class="left_bt" /></a>           
            <a href="detail.php" class="prod_details">details</a>            
            </div>                     
        </div> 
 
 
 
 
    
    
   
   </div><!-- end of center content -->
   
   <div class="right_content">
   		<div class="shopping_cart">
        	<div class="cart_title">Panier</div>
            
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
        <a href="index.php">home</a>
        <a href="services.html">about</a>
        <a href="services.html">sitemap</a>
        <a href="services.html">rss</a>
        <a href="contact.html">contact us</a>
        </div>   
   
   </div>                 


</div>
<!-- end of main_container -->
</body>
</html>