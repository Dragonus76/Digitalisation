<?php
/**
* Website Name: Memories
* Description: The aim of this site is to offer the possibility to user to create a personal webpage to write * their biography of the one of lost one.
* Author: Benjamin Guimond
* Author URI: http://push-infographiste.fr
* Version: 1
* Tags: online memorials, biography, e-commerce, individual webpage
*/
?>
<!DOCTYPE html>
<!-- Website Name: Memories
Description: The aim of this site is to offer the possibility to user to create a personal webpage to write their biography of the one of lost one.
Author: Benjamin Guimond
Author URI: http://push-infographiste.fr
Version: 1
Tags: online memorials, biography, e-commerce, individual webpage
-->
<html itemscope itemtype="http://schema.org/WebPage">
<head>
<?php echo $this->Html->charset(); ?>

<?php $title = $this->requestAction('options/webtitle/'); ?>

<?php 
	if(!empty($personne['Defunt']['title'])){
if(!empty($personne['Defunt']['firstname'])){
	if(!empty($personne['Defunt']['name'])){
		echo '<title itemprop="name">Scanepitaphe - '.$personne['Defunt']['title'].' '.$personne['Defunt']['firstname'].' '.$personne['Defunt']['name'].'</title>';
	}else{
		echo '<title itemprop="name">Scanepitaphe - '.$personne['Defunt']['title'].' '.$personne['Defunt']['firstname'].'</title>';
	}
}else{
	if(!empty($personne['Defunt']['name'])){
		echo '<title itemprop="name">Scanepitaphe - '.$personne['Defunt']['title'].' '.$personne['Defunt']['name'].'</title>';
	}else{
		echo '<title itemprop="name">Scanepitaphe - '.$personne['Defunt']['title'].'</title>';
	}
}
}else{
	if(!empty($personne['Defunt']['firstname'])){
		if(!empty($personne['Defunt']['name'])){
			echo '<title itemprop="name">Scanepitaphe - '.$personne['Defunt']['firstname'].' '.$personne['Defunt']['name'].'</title>';
		}else{
			echo '<title itemprop="name">Scanepitaphe - '.$personne['Defunt']['firstname'].'</title>';
		}
	}else{
		if(!empty($personne['Defunt']['name'])){
			echo '<title itemprop="name">Scanepitaphe - '.$personne['Defunt']['name'].'</title>';
		}else{
			echo '<title itemprop="name">'.$title['Option']['content'].'</title>';
		}
	}
}
?>	

<?php echo $this->element('scripttop'); ?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?php echo $this->element('header'); ?>
		</div>
		<article id="content">
			<?php if(!empty($clientpage['ClientPage']['backgroundimg'])){ 
				echo '<div class="bckpage"
				style="background:url(http://scanepitaphe.fr/img/medias/defunts/'.'defunt_'.$clientpage['ClientPage']['defunt_id'].'/'.$clientpage['ClientPage']['backgroundimg'].')no-repeat center;
				-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;"></div>';				
			}
			?>
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</article>
		<footer>
			<?php echo $this->element('divfoot'); ?>
			<?php echo $this->element('footer'); ?>
		</footer>
	</div>
</body>
</html>
