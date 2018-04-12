<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Gestion des co-auteurs pour la page de');?> <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('modifier les informations de cette personne')
                  ));?></h3>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                __('Retour à la page précédente'),
                                $this->request->referer(),
                                array('title'=>__('bouton pour revenir à la page précédente'))
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 tdb lignetop">
        <?php

            foreach ($users as $key => $value) {

                $user = $this->requestAction('users/getuserbyid/'.$value['DefuntUsers']['user_id']);

                 if(!empty($user['User']['avatar'])){
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe " style="position: relative;background:url(http://scanepitaphe.fr/img/medias/users/'.'user_'.$user['User']['id'].'/'.$user['User']['avatar'].')no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">'; 
                    }else{
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe" style="position: relative;background:url(http://scanepitaphe.fr/img/fond-gris-no-avatar.jpg)no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">';                   
                    }

                // echo '<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe" style="padding:0;">';

                    echo '<p class="top">'.$user['User']['username'].'<br/>'.$user['User']['firstname'].' '.$user['User']['name'].'</p>';
                    if($admin==1){
                        if($user['User']['id'] != $uid){
                    echo '<p class="bottom">'.$this->Html->link(__('Supprimer cet auteur'),array('controller'=>'users','action'=>'delinvite',$user['User']['id'],$personne['Defunt']['id'],null,__('Voulez vous vraiment supprimer cet album ? Cette action est DEFINITIVE.')));
                    echo '</p>';
                    }
                    }
                    echo '</div>';
            }
        ?>
      </div>
  </div>
  <?php if($admin ==1): ?>
  <div class="row margecinq">
    <div class="small-12 medium-12 large-12 tdb center">  
      <?php
                    echo $this->Form->create('User', array('controller'=>'users','action' => 'invite/'));
                    echo $this->Form->input('email', array('label'=> __('Email de la personne que vous souhaitez inviter en co-auteur'),'placeholder' => __('renseignez son email')));
                    echo $this->Form->input('family_id', array('type' => 'hidden','value'=>$personne['Defunt']['family_id']));
                    echo $this->Form->input('defunt_id', array('type' => 'hidden','value'=>$personne['Defunt']['id']));
                    echo $this->Form->submit(__('Inviter cette personne à devenir co-auteur'),array('class'=>'buttonvioletokfull postfix')); 
                    echo $this->Form->end();
                ?>
            </div>
    </div>
<?php endif ?>
</div>