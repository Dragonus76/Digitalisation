<div class="row minha">
       <?php echo $this->element('bord'); ?>
    <div class="small-12 medium-8 large-8 columns">
        <div class="row marginbot">
            <h4><?php echo __('Vos familles');?> <a href="#" data-reveal-id="myModal" data-reveal title="<?php echo __('Besoin d\'aide?');?>"><i class="fa fa-question-circle"></i></a>
                  <div id="myModal" class="reveal-modal" data-reveal>
                    <h2><?php echo __('Les familles');?></h2>
                    <p><?php echo __('Scanepitaphe vous permet de créer des familles. Chaque famille regroupe plusieurs personnes ou groupes de personnes correspondant à des pages individuelles. Vous êtes libre de créer les familles que vous souhaitez et ce sans limite.');?></p>
                    <a class="close-reveal-modal">&#215;</a>
                  </div></h4>
            <?php
                foreach ($families as $key => $value) {
                    echo '<p>'.__('Famille ').$value['Family']['name'].' - '.$this->Html->link(__('Modifier cette famille'),array('controller'=>'families','action'=>'edit',$value['Family']['id'])).' - '.$this->Html->link(__('Ajouter / Modifier les personnes de cette famille'),array('controller'=>'defunts','action'=>'liste',$value['Family']['id'])).' - '.$this->Html->link(__('Supprimer cette famille'),array('controller'=>'families','action'=>'delete',$value['Family']['id'],null,__('Voulez vous vraiment supprimer cette famille ? Cette action est DEFINITIVE.'))).
                    '</p>';
                }
            ?>
            <span class="custom-label"><?php echo $this->Html->link(__('Créer une famille'),array('controller'=>'families','action'=>'add')); ?></span>
        </div>


    </div>

</div>


            