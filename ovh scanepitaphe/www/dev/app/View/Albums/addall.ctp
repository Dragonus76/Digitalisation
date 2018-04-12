<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Ajouter un album pour une personne</h3>
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
            echo $this->Form->create('Category');
             foreach ($personnes as $key => $value) {
                    $k=$value['Defunt']['id'];
                    $array[$k]=$value['Defunt']['firstname'].' '.$value['Defunt']['name'];
                }
            
            if(!empty($array)){echo $this->Form->input('defunt_id', array(
                      'label' => '1- Choississez la personne concernée par l\'ajout',
                      'options' => $array));}
            echo $this->Form->input('name',array('label' => '2 - Nom de l\'album', 'placeholder'=>'renseignez le nom de l\'album','class' => 'ckeditor'));
          echo $this->Form->input('date', array(
                                            'label' => '3 - Date de l\'évènement',
                                            'dateFormat' => 'DMY',
                                            'minYear' => date('Y') - 2000,
                                            'maxYear' => date('Y'),
                                            'separator'=>'',
                                            'empty'=>true
                    ));
            echo $this->Form->submit('Ajouter cet album',array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
        ?>
      </div>
    </div>
</div>    

