<section class="section-image">
		<div class="small-12 medium-12 large-12 textureaccueil">
		 &nbsp;
		</div>
		<div class="small-12 medium-12 large-12 imgaccueil">
		 &nbsp;
		</div>
		<div class="text-intro">
			<h1>Ecrivez l‘histoire de vos proches</h1>
			<h3>Partagez vos souvenirs</h3>
			<?php
				if (!empty($user)) {
					echo $this->Html->link('Mon tableau de bord',
					array(
						'controller'=>'users',
						'action'=>'account',
						'admin'=>false
						),
					array(
						'class'=>'buttonlight'
						)
					);
				}else{
				echo $this->Html->link('Commencer à rédiger gratuitement',
					array(
						'controller'=>'users',
						'action'=>'register',
						'admin'=>false
						),
					array(
						'class'=>'buttonlight'
						)
					);
				}
			?>
		</div>

</section>

<section class="section-rejoindre">
	<div class="row">
		<div class="small-12 medium-12 large-12 columns">
			<h1>Partagez vos souvenirs</h1>
			<div class="small-12 medium-12 large-12 columns">
				<p>
				Quand un être cher s'en va, seuls les souvenirs nous restent, sources de réconfort… mais si fragiles. 
				<br/>
				<br/>
				Scanepitaphe a été conçu dans le but de faire perdurer ces souvenirs et de les partager avec ses proches.
				<br/>
				<br/>
				Scanepitaphe vous permet de créer, pour vos proches disparus, un espace gratuit et personnalisable, lieu de recueil et de mémoire. Au travers de textes, d'images, de vidéos ou encore de fichiers sonores, vous réécrivez l'histoire de vos proches, vous redonnez vie aux souvenirs. 
				<br/>
				<br/>
				Scanepitaphe offre également la possibilité, si vous le souhaitez, d'être un lieu d'échanges et de partage. Les membres d'une famille sont aujourd'hui souvent séparés géographiquement. Scanepitaphe a été pensé afin que chaque membre d'une famille ou d'un cercle de proches puisse réagir aux contenus et ainsi partager ses propres souvenirs.
				Soucieux de la vie privée de ses utilisateurs Scanepitaphe offre la possibilité de restreindre l'accès aux espaces personnalisables et s'interdit toute publicité sur le site. 
				<br/>
				<br/>
				En cliquant sur l'image ci-dessus (ou en scannant le QR code), vous aurez un aperçu de Scanepitaphe.

				</p>
			</div>
			<div class="logohome small-12 medium-12 large-12 columns">
				<?php 
		    echo $this->Html->image('accueil/accueil-demo.jpg', 
		              array(
		                'alt' => 'visitez la page de demonstration',
		                'url' => array('controller' => 'clientpages', 'action' => 'view', 195)
		                )); 
		     ?>
			</div>
		</div>
	</div>
</section>

<section class="section-points">
	<div class="row">
		<div class="small-12 medium-3 large-3 columns">
			<i class="fa fa-lock"></i>
			<h6>Possibilité de restreindre l'accès à vos pages</h6>
			
		</div>
		<div class="small-12 medium-3 large-3 columns">
			<i class="fa fa-mobile"></i>
			<h6>Des pages adaptées à tous les supports</h6>
			
		</div>
		<div class="small-12 medium-3 large-3 columns">
			<i class="fa fa-qrcode"></i>
			<h6>Un accès rapide via QR code</h6>
			
		</div>
		<div class="small-12 medium-3 large-3 columns">
			<i class="fa fa-share-alt"></i>
			<h6>Un réseau social pour la famille</h6>
			
		</div>
	</div>
</section>

<section class="section-presentation">
	<div class="row">
		<div class="small-12 medium-12 large-12 columns"><h1>Les engagements de Scanepitaphe</h1></div>
		
			<h4>Respect de la vie privée</h4>
			<p> Chaque utilisateur est libre de paramétrer l'accès aux pages individuelles qu'il a créé. Il est ainsi possible de restreindre  l'accès avec un mot de passe. A tout moment, il vous est possible de fermer votre compte et ainsi d'effacer l'ensemble de vos contenus.</p>
			<h4>Zéro publicité</h4>
			<p>Lieu de recueil et de mémoire, aucune publicité n'est présente sur Scanepitaphe. De même, toute publicité émanant des utilisateurs est interdite.</p>
			<h4>Liberté</h4>
			<p>L'inscription à Scanepitaphe est gratuite. Vous pouvez créer autant de pages individuelles que vous le souhaitez et en partager la gestion avec vos proches.</p>

		
		
	</div>
</section> 