<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Gestion des co-auteurs pour la page de <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => 'modifier les informations de cette personne'
                  ));?></h3>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                'Retour à la page précédente',
                                $this->request->referer(),
                                array('title'=>'bouton pour revenir à la page précédente')
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 tdb lignetop">
        <?php

            foreach ($users as $key => $value) {

                $user = $this->requestAction('users/getuserbyid/'.$value['DefuntUsers']['user_id']);

                echo '<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe" style="padding:0;">';

                    echo '<p class="top">'.$user['User']['username'].'</p>';
                    echo '<p class="bottom">'.$this->Html->link("Supprimer cet auteur",array('controller'=>'users','action'=>'delinvite',$user['User']['id'],$personne['Defunt']['id'],null,'Voulez vous vraiment supprimer cet album ? Cette action est DEFINITIVE.'));
                    echo '</p></div>';
            }
        ?>
      </div>
  </div>
  <div class="row margecinq">
    <div class="small-12 medium-12 large-12 tdb center">  
      <?php
                    echo $this->Form->create('User', array('controller'=>'users','action' => 'invite/'));
                    echo $this->Form->input('email', array('placeholder' => 'renseignez son email'));
                    echo $this->Form->input('defunt_id', array('type' => 'hidden','value'=>$personne['Defunt']['id']));
                    echo $this->Form->submit('Inviter cette personne à devenir co-auteur',array('class'=>'buttonvioletokfull postfix')); 
                    echo $this->Form->end();
                ?>
            </div>
    </div>
</div>