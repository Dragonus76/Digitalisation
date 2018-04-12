
<?php if(!empty($clientpage['ClientPage']['password']) && $password != 'ok' && $clientpage['ClientPage']['protect'] == 1) : ?>
<div class="row footgrey headpage">
	<div class="small-12 medium-6 large-6 columns">
		<h4><?php echo __('Cette page est protégée par un mot de passe');?></h4>
		<p><?php echo __('Pour voir le contenu, veuillez renseigner le mot de passe : ');?></p>
		<?php
		 echo $this->Form->create('ClientPage');
            echo $this->Form->input('client_page_id', array('type' => 'hidden', 'value' => $clientpage['ClientPage']['id'])); 
            echo $this->Form->input('password',array('label' => __('Renseignez le mot de passe')));
            echo $this->Form->submit(__('Valider'),array('class'=>'button postfix')); 
            echo $this->Form->end();
		?>
	</div>
</div>
<?php else : ?>
<div class="row footgrey headpage">
	<div class="small-12 medium-6 large-6 columns">
		<?php
			if(!empty($personne['Defunt']['avatar'])){
				echo $this->Html->image('medias/defunts/'.'defunt_'.$personne['Defunt']['id'].'/'.$personne['Defunt']['avatar'],array(
					'witdh'=>317,
					'height'=>210,
					'url'=>array('controller'=>'clientpages','action'=>'view',$personne['Defunt']['id'])
					));
				
			}else{
				echo $this->Html->Image('http://placehold.it/317x210'); 
			}
	     ?>
	</div>
	<div class="small-12 medium-6 large-6 columns">
		<?php 
		setlocale(LC_TIME, 'fr_FR.utf8');
			if(!empty($personne['Defunt']['birthdate'])) {$dateone=strftime('%d %B %Y',strtotime($personne['Defunt']['birthdate']));}else{$dateone="";}
		if(!empty($personne['Defunt']['deathdate'])){$datetwo=strftime('%d %B %Y',strtotime($personne['Defunt']['deathdate']));}else{$datetwo="";}
		?>
		<h1><?php if(!empty($personne['Defunt']['title'])){
			echo $personne['Defunt']['title'].' '.$personne['Defunt']['firstname'].' '.$personne['Defunt']['name'];
		}else{echo $personne['Defunt']['firstname'].' '.$personne['Defunt']['name'];}?>
	<ul class="share" >
				<li>
					<a href='http://www.facebook.com/sharer.php?u=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>' onclick="return popitup('http://www.facebook.com/sharer.php?u=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>')" title="partager sur facebook">
						<i class="fa fa-facebook"></i>
					</a>
				</li>
				<li>					
					<a   href="https://plus.google.com/share?url=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" onclick="return popitup('https://plus.google.com/share?url=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>')">
		        		<i class="fa fa-google-plus"></i>
		      		</a>
		      	</li>
		      	<li>
		      		<a href="http://twitter.com/share"  onclick="return popitup('http://twitter.com/share')">
        				<i class="fa fa-twitter"></i>
        			</a>
        			
		      	</li>	
		     </ul></h1>
		<?php echo $dateone.' - '.$datetwo;?>
		<p>
			<small>
				<?php 
					if(!empty($personne['Defunt']['lieu'])){
						echo __('Lieu sépulture : ').$personne['Defunt']['lieu'];
						}
				?>
			</small>
		</p>
		<p><i>
			<?php
				if(isset($personne['Defunt']['intro'])){
						echo $personne['Defunt']['intro'];
						}
			?>
			</i>
		</p>	

	</div>
</div>

<div class="row">
	<div class="small-12 medium-12 large-12 columns" >
	<h2><?php echo __('Galerie de l\'album ');?><?php echo $album['Album']['name'];?></h2>
	<div style="float:right">
	<?php echo $this->Html->link(
                        __('Retour à la page '),
                        $this->request->referer(),
                        array('title'=>__('bouton pour revenir à la page précédente'),'class'=>'button')
                        ); ?>
                    </div>
                       </div>
                   </div>
<div class="row">
	<div class="small-12 medium-12 large-12 columns" id="container" >
		<ul class="footgrey headpage small-block-grid-1 medium-block-grid-3 large-block-grid-4 clearing-thumbs" data-clearing>
		<?php
			foreach ($medias as $key => $value) {				
				if ($value['Media']['type'] == 'typeimage'){
					if (!empty($value['Media']['nomfichier'])) {
						echo '<li class="item round">';
						echo '<div class="relative center">';
						echo $this->Html->image(
							'medias'. DS .'defunts'. DS .'defunt_'.$value['Media']['defunt_id'] . DS . $value['Media']['nomfichier'],array(
								'url'=>'/img/medias'. DS .'defunts'. DS .'defunt_'.$value['Media']['defunt_id'] . DS . $value['Media']['nomfichier']));
						echo '<div class="legendep"><p>'.$value['Media']['content'].'</p></div>';
						echo '</div>';
						
					echo '</li>';
					}
				}
			
				
			}
		?>
	</ul>
	</div>
</div>
<div class="row">
	<?php
	if(!empty($families)){
	echo '<h4 style="background: #333333;color: white;padding: 1%;">'.__('Les autres membres de la famille '). $family['Family']['name'].'<h4>';
		foreach ($families as $key => $value) {
			if(!empty($value['Defunt']['avatar'])){
				echo $this->Html->image('medias/defunts/'.'defunt_'.$value['Defunt']['id'].'/'.$value['Defunt']['avatar'], 
	              array(
	                'alt' => __('photo de profil de ').$value['Defunt']['firstname'].' '.$value['Defunt']['name'] ,
	                'width'=>'150',
	                'height'=>'150',
	                'title'=>__('Aller sur la page de ').$value['Defunt']['firstname'].' '.$value['Defunt']['name'],
	                'url' => array('controller' => 'clientpages', 'action' => 'view', $value['Defunt']['id'])
	                )); 
			}else{
				echo $this->Html->image('http://placehold.it/150x150', 
	              array(
	                'alt' => __('photo de profil de ').$value['Defunt']['firstname'].' '.$value['Defunt']['name'] ,
	                'width'=>'150',
	                'height'=>'150',
	                'url' => array('controller' => 'clientpages', 'action' => 'view', $value['Defunt']['id'])
	                )); 

			}
		}
	}
	?>
</div>
<?php endif ?>