<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Modifier un album pour la page de <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
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
      <div class="small-12 medium-12 large-12 columns">
        <?php
            echo $this->Form->create('Album');
            echo $this->Form->input('id', array('type' => 'hidden'));
            echo $this->Form->input('defunt_id', array('type' => 'hidden'));
            echo $this->Form->input('name',array('label' => 'Nom de l\'album', 'placeholder'=>'renseignez le nom de l\'album','class' => 'ckeditor'));
            echo $this->Form->input('date', array(
                                            'label' => 'Date de l\'évènement',
                                            'dateFormat' => 'DMY',
                                            'minYear' => date('Y') - 2000,
                                            'maxYear' => date('Y'),
                                            'separator'=>'',
                                            'empty'=>true
                    ));
            foreach ($cats as $key => $value) {
                    $l=$value['Category']['id'];
                    $arrayd[$l]=$value['Category']['name'];
                }
            if(!empty($arrayd)){
            echo $this->Form->input('category_id', array(
                      'label' => '4 - Choississez une éventuelle catégorie (facultatif)',
                      'options' => $arrayd,
                      'empty' => ''));
            }else{
               echo '<p>Vous n\'avez pas créé de catégories pour cette personne. '.$this->Html->link('Créer une catégorie',array('controller'=>'categories','action'=>'add',$personne['Defunt']['id'])).'</p>'; 
            }
            echo $this->Form->submit('Sauvegarder les modifications',array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
        ?>
      </div>
    </div>
</div>