<div class="row minha">
    <div class="small-12 medium-4 large-4 columns">
        <h6>Création d'une famille</h6>
    </div>
    <div class="small-12 medium-8 large-8 columns justify">
        <h4>Premiers pas sur Scanepitaphe</h4>
        <p>Félicitations, vous venez de créer votre compte Scanépitaphe.</p>
        <p>Désormais vous allez pouvoir rédiger les mémoires de vos proches ou les votres. Vous pourrez ainsi écrire du texte, ajouter des photos ou encore des vidéos et compléter ainsi une page internet retraçant la vie de vos proches ou la votre. Libre à vous de partagez ensuite ces pages ou d'en restreindre l'accès, et ce à tout moment.</p>
        <p>Afin de vous aider à utiliser Scanepitaphe, nous vous proposons un court didacticiel. Vous pouvez à tout moment mettre fin à ce didactitiel en utilisant le lien "Aller directement à mon tableau de bord" en bas de page.</p>
        <p>Première étape, commençons avec la création d'une famille. Sur Scanépitaphe, les familles permettent de regrouper plusieurs proches ou groupes de proches.</p>
        <?php
        	echo $this->Form->create('Family');
				echo $this->Form->input('name',array('label' => 'Nom de la famille','placeholder'=>'renseignez le nom de la famille'));
				echo $this->Form->input('description',array('label' => 'Description de la famille (facultatif)','placeholder'=>'description de la famille (facultatif)'));
				echo $this->Form->submit('Créer la famille',array('class'=>'button postfix')); 
    			echo $this->Form->end();
        ?>
        <br/>
        <div class="row">
            <p><?php echo $this->Html->link('Aller directement à mon tableau de bord',array('controller'=>'users','action'=>'account'));?></p>
        </div>
    </div>

</div>           