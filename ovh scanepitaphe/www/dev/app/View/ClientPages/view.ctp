<?php if(!empty($clientpage['ClientPage']['password']) && $password != 'ok' && $clientpage['ClientPage']['protect'] == 1) : ?>
<div class="row footgrey headpage">
	<div class="small-12 medium-6 large-6 columns">
		<h4>Cette page est protégée par un mot de passe</h4>
		<p>Pour voir le contenu, veuillez renseigner le mot de passe :</p>
		<?php
		 echo $this->Form->create('ClientPage');
            echo $this->Form->input('client_page_id', array('type' => 'hidden', 'value' => $clientpage['ClientPage']['id'])); 
            echo $this->Form->input('password',array('label' => 'Renseignez le mot de passe'));
            echo $this->Form->submit('Valider',array('class'=>'button postfix')); 
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
						echo 'Lieu sépulture : '.$personne['Defunt']['lieu'];
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
	<div class="small-12 medium-4 large-4 columns">
		<ul>
			<?php 
				if($img >= 2){
				echo '<li style="margin:0.3em;" class="buttonvioletl [radius round]">';
				echo $this->Html->link('Galerie photos',
						array(
							'controller'=>'clientpages',
							'action'=>'photo',
							$personne['Defunt']['id'])						
						);
				echo '</li>';
				}
				foreach ($cats as $key => $value) {
					echo '<li style="margin:0.3em;" class="buttonvioletl [radius round]">';
					echo $this->Html->link($value['Category']['name'],
						array(
							'controller'=>'clientpages',
							'action'=>'viewcat',
							$personne['Defunt']['id'],$value['Category']['id'])						
						);
					echo '</li>';
				}
			?>
	</div>
	<div class="small-12 medium-8 large-8 columns">
		<?php
			foreach ($timeline as $key => $value) {
				
				
				
				if(!empty($value['Album']['name'])){
					echo '<div class="pagecont">';
					$cover = $this->requestAction('media/getcover/'.$value['Album']['id']);
					
					echo '<h3><small>'.strftime('%d %B %Y',strtotime($value['Album']['date'])).'</small> Album ';
					echo $this->Html->link($value['Album']['name'],array('controller'=>'clientpages','action'=>'album',$value['Album']['defunt_id'],$value['Album']['id']));
					echo '</h3>';
					if (!empty($cover['Media']['nomfichier'])) {
						echo '<div class="relative center">';
						echo $this->Html->image(
							'medias'. DS .'defunts'. DS .'defunt_'.$cover['Media']['defunt_id'] . DS . $cover['Media']['nomfichier'],array(
								'url'=>array('controller'=>'clientpages','action'=>'album',$value['Album']['defunt_id'],$value['Album']['id'])));
						echo '<div class="legende"><p>Album '.$value['Album']['name'].'</p></div>';
						echo '</div>';
		
					}
					echo '</div>';
				}else{
					
				if ($value['Media']['type'] == 'typevideo'){
					if (!empty($value['Media']['adressevideo'])) {
						echo '<div class="pagecont">';
						echo '<h3><small>'.strftime('%d %B %Y',strtotime($value['Media']['date'])).'</small> '.$value['Media']['name'].'</h3>';
						echo $value['Media']['adressevideo'] . '</br>';
						echo '<p>'.$value['Media']['content'].'</p>';
						foreach ($value['Tag'] as $key => $v) {
						if(!empty($v['title'])){
							echo '<span class="black radius secondary label" style="margin:1%;">'.$this->Html->link($v['title'],array('controller'=>'clientpages','action'=>'viewtag',$personne['Defunt']['id'],$v['id'])).'</span>';
						}
					}
					if($value['Media']['comment']==1){
						$comments = $this->requestAction('comments/getcomments/'.$value['Media']['id']);
						
						foreach ($comments as $key => $val) {
							echo '<div class="row">';
							echo '<div class="small-3 medium-3 large-3 columns">';
							$commentdate=strftime('%d %B %Y',strtotime($val['Comment']['created']));
							echo '<span class="violet">'.$val['Comment']['autor_name'].'</span><br/><small>'.$commentdate.'</small>';
							echo '</div><div class="small-8 medium-8 large-8 columns">';
							echo '<p>'.$val['Comment']['content'].'</p>';
							$userc = $this->requestAction('comments/getucomments/'.$val['Comment']['id']);
							if(!empty($user)){
							if($userc['User']['id'] == $user['User']['id']){
							echo $this->Form->postLink(
                '[X]',
                array('controller'=> 'comments','action' => 'deleteb', $val['Comment']['id']),
                array('class'=>'suppressioncom'),
                array('confirm' => 'Etes-vous sûr ?')).'</a>';
							}	
						}
							echo '</div></div>';						
						}
						if(!empty($user)){
							echo '<div class="row">';
						echo '<div class="small-11 medium-11 large-11 columns">';
							echo $this->Form->create('Comment', array('controller'=>'comments','action' => 'add/'.$value['Media']['defunt_id']));
							echo $this->Form->input('media_id', array('type'=>'hidden','value'=>$value['Media']['id']));
							echo $this->Form->input('autor_name', array('type'=>'hidden','value'=>$user['User']['username']));
							echo $this->Form->input('content', array('label'=>'','placeholder'=>'écrire un commentaire'));
							echo '</div><div class="small-1 medium-1 large-1 columns">';
							echo $this->Form->submit('Ok',array('class'=>'buttonvioletok postfix')); 
				            echo $this->Form->end();
				            echo '</div></div>';
						}else{
							echo '<div class="row">';
						echo '<div class="small-12 medium-12 large-12 columns">';
							echo '<p>Vous devez être '.$this->Html->link('connecté',array('controller'=>'users','action'=>'login')).' pour ajouter un commentaire</p>';
				            echo '</div></div>';
						}
						
						
					}
						echo '</div>';
					}
				}elseif ($value['Media']['type'] == 'typeimage' && empty($value['Media']['album_id'])){
					if (!empty($value['Media']['nomfichier'])) {
						echo '<div class="pagecont">';
						echo '<h3><small>'.strftime('%d %B %Y',strtotime($value['Media']['date'])).'</small> '.$value['Media']['name'].'</h3>';
						echo '<div class="relative center">';
						echo $this->Html->image(
							'medias'. DS .'defunts'. DS .'defunt_'.$value['Media']['defunt_id'] . DS . $value['Media']['nomfichier']);
						echo '<div class="legende"><p>'.$value['Media']['content'].'</p></div>';
						echo '</div>';
						foreach ($value['Tag'] as $key => $v) {
						if(!empty($v['title'])){
							echo '<span class="black radius secondary label" style="margin:1%;">'.$this->Html->link($v['title'],array('controller'=>'clientpages','action'=>'viewtag',$personne['Defunt']['id'],$v['id'])).'</span>';
						}
						}
						if($value['Media']['comment']==1){
						$comments = $this->requestAction('comments/getcomments/'.$value['Media']['id']);
						
						foreach ($comments as $key => $val) {
							echo '<div class="row">';
							echo '<div class="small-3 medium-3 large-3 columns">';
							$commentdate=strftime('%d %B %Y',strtotime($val['Comment']['created']));
							echo '<span class="violet">'.$val['Comment']['autor_name'].'</span><br/><small>'.$commentdate.'</small>';
							echo '</div><div class="small-8 medium-8 large-8 columns">';
							echo '<p>'.$val['Comment']['content'].'</p>';
							$userc = $this->requestAction('comments/getucomments/'.$val['Comment']['id']);
							if(!empty($user)){
							if($userc['User']['id'] == $user['User']['id']){
							echo $this->Form->postLink(
                '[X]',
                array('controller'=> 'comments','action' => 'deleteb', $val['Comment']['id']),
                array('class'=>'suppressioncom'),
                array('confirm' => 'Etes-vous sûr ?')).'</a>';
							}	
						}
							echo '</div></div>';						
						}
						if(!empty($user)){
							echo '<div class="row">';
						echo '<div class="small-11 medium-11 large-11 columns">';
							echo $this->Form->create('Comment', array('controller'=>'comments','action' => 'add/'.$value['Media']['defunt_id']));
							echo $this->Form->input('media_id', array('type'=>'hidden','value'=>$value['Media']['id']));
							echo $this->Form->input('autor_name', array('type'=>'hidden','value'=>$user['User']['username']));
							echo $this->Form->input('content', array('label'=>'','placeholder'=>'écrire un commentaire'));
							echo '</div><div class="small-1 medium-1 large-1 columns">';
							echo $this->Form->submit('Ok',array('class'=>'buttonvioletok postfix')); 
				            echo $this->Form->end();
				            echo '</div></div>';
						}else{
							echo '<div class="row">';
						echo '<div class="small-12 medium-12 large-12 columns">';
							echo '<p>Vous devez être '.$this->Html->link('connecté',array('controller'=>'users','action'=>'login')).' pour ajouter un commentaire</p>';
				            echo '</div></div>';
						}
						
						
					}	
						echo '</div>';
					}
				}elseif ($value['Media']['type'] == 'typeson'){
					if (!empty($value['Media']['nomfichier'])) {
						echo '<div class="pagecont">';
						echo '<h3><small>'.strftime('%d %B %Y',strtotime($value['Media']['date'])).'</small> '.$value['Media']['name'].'</h3>';
						echo $this->Html->media(
									'../img/medias'. DS .'defunts'. DS .'defunt_'.$value['Media']['defunt_id'] . DS . $value['Media']['nomfichier'],
									array(
										'text' => 'Fallback text',
										'fullBase' => true,
										'type' => "audio/mpeg; codecs='mp3'",
										'tag' => 'audio',
										'controls' => 'true',
										)
								);
								echo '<p>'.$value['Media']['content'].'</p>';
								foreach ($value['Tag'] as $key => $v) {
						if(!empty($v['title'])){
							echo '<span class="black radius secondary label" style="margin:1%;">'.$this->Html->link($v['title'],array('controller'=>'clientpages','action'=>'viewtag',$personne['Defunt']['id'],$v['id'])).'</span>';
						}
						}
						if($value['Media']['comment']==1){
						$comments = $this->requestAction('comments/getcomments/'.$value['Media']['id']);
						
						foreach ($comments as $key => $val) {
							echo '<div class="row">';
							echo '<div class="small-3 medium-3 large-3 columns">';
							$commentdate=strftime('%d %B %Y',strtotime($val['Comment']['created']));
							echo '<span class="violet">'.$val['Comment']['autor_name'].'</span><br/><small>'.$commentdate.'</small>';
							echo '</div><div class="small-8 medium-8 large-8 columns">';
							echo '<p>'.$val['Comment']['content'].'</p>';
							$userc = $this->requestAction('comments/getucomments/'.$val['Comment']['id']);
							if(!empty($user)){
							if($userc['User']['id'] == $user['User']['id']){
							echo $this->Form->postLink(
                '[X]',
                array('controller'=> 'comments','action' => 'deleteb', $val['Comment']['id']),
                array('class'=>'suppressioncom'),
                array('confirm' => 'Etes-vous sûr ?')).'</a>';
							}	
						}
							echo '</div></div>';						
						}
						if(!empty($user)){
							echo '<div class="row">';
						echo '<div class="small-11 medium-11 large-11 columns">';
							echo $this->Form->create('Comment', array('controller'=>'comments','action' => 'add/'.$value['Media']['defunt_id']));
							echo $this->Form->input('media_id', array('type'=>'hidden','value'=>$value['Media']['id']));
							echo $this->Form->input('autor_name', array('type'=>'hidden','value'=>$user['User']['username']));
							echo $this->Form->input('content', array('label'=>'','placeholder'=>'écrire un commentaire'));
							echo '</div><div class="small-1 medium-1 large-1 columns">';
							echo $this->Form->submit('Ok',array('class'=>'buttonvioletok postfix')); 
				            echo $this->Form->end();
				            echo '</div></div>';
						}else{
							echo '<div class="row">';
						echo '<div class="small-12 medium-12 large-12 columns">';
							echo '<p>Vous devez être '.$this->Html->link('connecté',array('controller'=>'users','action'=>'login')).' pour ajouter un commentaire</p>';
				            echo '</div></div>';
						}
						
						
					}
						echo '</div>';
					}
				}elseif ($value['Media']['type'] == 'typetext'){
					echo '<div class="pagecont">';
					echo '<h3><small>'.strftime('%d %B %Y',strtotime($value['Media']['date'])).'</small> '.$value['Media']['name'].'</h3>';
					echo '<p>'.$value['Media']['content'].'</p>';
					foreach ($value['Tag'] as $key => $v) {
						if(!empty($v['title'])){
							echo '<span class="black radius secondary label" style="margin:1%;">'.$this->Html->link($v['title'],array('controller'=>'clientpages','action'=>'viewtag',$personne['Defunt']['id'],$v['id'])).'</span>';
						}
					}
					if($value['Media']['comment']==1){
						$comments = $this->requestAction('comments/getcomments/'.$value['Media']['id']);
						
						foreach ($comments as $key => $val) {
							echo '<div class="row">';
							echo '<div class="small-3 medium-3 large-3 columns">';
							$commentdate=strftime('%d %B %Y',strtotime($val['Comment']['created']));
							echo '<span class="violet">'.$val['Comment']['autor_name'].'</span><br/><small>'.$commentdate.'</small>';
							echo '</div><div class="small-8 medium-8 large-8 columns">';
							echo '<p>'.$val['Comment']['content'].'</p>';
							$userc = $this->requestAction('comments/getucomments/'.$val['Comment']['id']);
							if(!empty($user)){
							if($userc['User']['id'] == $user['User']['id']){
							echo $this->Form->postLink(
                '[X]',
                array('controller'=> 'comments','action' => 'deleteb', $val['Comment']['id']),
                array('class'=>'suppressioncom'),
                array('confirm' => 'Etes-vous sûr ?')).'</a>';
							}	
						}
							echo '</div></div>';						
						}
						if(!empty($user)){
							echo '<div class="row">';
						echo '<div class="small-11 medium-11 large-11 columns">';
							echo $this->Form->create('Comment', array('controller'=>'comments','action' => 'add/'.$value['Media']['defunt_id']));
							echo $this->Form->input('media_id', array('type'=>'hidden','value'=>$value['Media']['id']));
							echo $this->Form->input('autor_name', array('type'=>'hidden','value'=>$user['User']['username']));
							echo $this->Form->input('content', array('label'=>'','placeholder'=>'écrire un commentaire'));
							echo '</div><div class="small-1 medium-1 large-1 columns">';
							echo $this->Form->submit('Ok',array('class'=>'buttonvioletok postfix')); 
				            echo $this->Form->end();
				            echo '</div></div>';
						}else{
							echo '<div class="row">';
						echo '<div class="small-12 medium-12 large-12 columns">';
							echo '<p>Vous devez être '.$this->Html->link('connecté',array('controller'=>'users','action'=>'login')).' pour ajouter un commentaire</p>';
				            echo '</div></div>';
						}
						
						
					}
					echo '</div>';
				}elseif ($value['Media']['type'] == 'typepdf'){
					echo '<div class="pagecont">';
					echo '<h3><small>'.strftime('%d %B %Y',strtotime($value['Media']['date'])).'</small> '.$value['Media']['name'].'</h3>';

					echo '<object  class="pdf" data="/img/medias'. DS .'defunts'. DS .'defunt_'.$value['Media']['defunt_id'] . DS . 'pdf'.DS.$value['Media']['nomfichier'].'" type="application/pdf">
        <p>It appears you don\'t have Adobe Reader or PDF support in this web browser. <a href="/img/medias'. DS .'defunts'. DS .'defunt_'.$value['Media']['defunt_id'] . DS . 'pdf'.DS.$value['Media']['nomfichier'].'">Click here to download the PDF</a>. Or <a href="http://get.adobe.com/reader/" target="_blank">click here to install Adobe Reader</a>.</p>
       <embed src="/img/medias'. DS .'defunts'. DS .'defunt_'.$value['Media']['defunt_id'] . DS . 'pdf'.DS.$value['Media']['nomfichier'].'" type="application/pdf" />
    </object>';
				
					echo '<a class="media" href="/img/medias'. DS .'defunts'. DS .'defunt_'.$value['Media']['defunt_id'] . DS . 'pdf'.DS.$value['Media']['nomfichier'].'">Télécharger le pdf</a> ';
					foreach ($value['Tag'] as $key => $v) {
						if(!empty($v['title'])){
							echo '<span class="black radius secondary label" style="margin:1%;">'.$this->Html->link($v['title'],array('controller'=>'clientpages','action'=>'viewtag',$personne['Defunt']['id'],$v['id'])).'</span>';
						}
					}
					if($value['Media']['comment']==1){
						$comments = $this->requestAction('comments/getcomments/'.$value['Media']['id']);
						
						foreach ($comments as $key => $val) {
							echo '<div class="row">';
							echo '<div class="small-3 medium-3 large-3 columns">';
							$commentdate=strftime('%d %B %Y',strtotime($val['Comment']['created']));
							echo '<span class="violet">'.$val['Comment']['autor_name'].'</span><br/><small>'.$commentdate.'</small>';
							echo '</div><div class="small-8 medium-8 large-8 columns">';
							echo '<p>'.$val['Comment']['content'].'</p>';
							$userc = $this->requestAction('comments/getucomments/'.$val['Comment']['id']);
							if(!empty($user)){
							if($userc['User']['id'] == $user['User']['id']){
							echo $this->Form->postLink(
                '[X]',
                array('controller'=> 'comments','action' => 'deleteb', $val['Comment']['id']),
                array('class'=>'suppressioncom'),
                array('confirm' => 'Etes-vous sûr ?')).'</a>';
							}	
						}
							echo '</div></div>';						
						}
						if(!empty($user)){
							echo '<div class="row">';
						echo '<div class="small-11 medium-11 large-11 columns">';
							echo $this->Form->create('Comment', array('controller'=>'comments','action' => 'add/'.$value['Media']['defunt_id']));
							echo $this->Form->input('media_id', array('type'=>'hidden','value'=>$value['Media']['id']));
							echo $this->Form->input('autor_name', array('type'=>'hidden','value'=>$user['User']['username']));
							echo $this->Form->input('content', array('label'=>'','placeholder'=>'écrire un commentaire'));
							echo '</div><div class="small-1 medium-1 large-1 columns">';
							echo $this->Form->submit('Ok',array('class'=>'buttonvioletok postfix')); 
				            echo $this->Form->end();
				            echo '</div></div>';
						}else{
							echo '<div class="row">';
						echo '<div class="small-12 medium-12 large-12 columns">';
							echo '<p>Vous devez être '.$this->Html->link('connecté',array('controller'=>'users','action'=>'login')).' pour ajouter un commentaire</p>';
				            echo '</div></div>';
						}
						
						
					}
					echo '</div>';
				}

			}
			
			}
		?>
	</div>
</div>
<div class="row">
	<?php
	if(!empty($families)){
	echo '<h4 style="background: #333333;color: white;padding: 1%;">Les autres membres de la famille '. $family['Family']['name'].'<h4>';
		foreach ($families as $key => $value) {
			if(!empty($value['Defunt']['avatar'])){
				echo $this->Html->image('medias/defunts/'.'defunt_'.$value['Defunt']['id'].'/'.$value['Defunt']['avatar'], 
	              array(
	                'alt' => 'photo de profil de '.$value['Defunt']['firstname'].' '.$value['Defunt']['name'] ,
	                'width'=>'150',
	                'height'=>'150',
	                'title'=>'Aller sur la page de '.$value['Defunt']['firstname'].' '.$value['Defunt']['name'],
	                'url' => array('controller' => 'clientpages', 'action' => 'view', $value['Defunt']['id'])
	                )); 
			}else{
				echo $this->Html->image('http://placehold.it/150x150', 
	              array(
	                'alt' => 'photo de profil de '.$value['Defunt']['firstname'].' '.$value['Defunt']['name'] ,
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