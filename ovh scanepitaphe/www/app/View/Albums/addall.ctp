<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Ajouter un album pour une personne');?></h3>
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
      <div class="small-12 medium-12 large-12 columns">
        <?php
            echo $this->Form->create('Album');

            foreach ($personnes as $key => $value) {
                    $k=$value['Defunt']['id'];
                    $array[$k]=$value['Defunt']['firstname'].' '.$value['Defunt']['name'];
                }
            echo $this->Form->input('defunt_id', array(
                      'label' => __('1 - Choississez la personne concernée'),
                      'options' => $array,
                      'empty'=>__('Choisissez une personne')));
            echo $this->Form->input('name',array('label' => __('2 - Nom de l\'album'), 'placeholder'=>__('renseignez le nom de l\'album'),'class' => 'ckeditor'));
          echo $this->Form->input('date', array(
                                            'label' => __('3 - Date de l\'évènement'),
                                            'dateFormat' => 'DMY',
                                            'minYear' => date('Y') - 2000,
                                            'maxYear' => date('Y'),
                                            'separator'=>'',
                                            'empty'=>true
                    ));
           echo $this->Form->input('category_id', 
                              array(
                              'label' => __('3 - Choississez une éventuelle catégorie (facultatif)').' <a href="#" data-reveal-id="myModal2" data-reveal title="'.__('Besoin d\'aide?').'"><i class="fa fa-question-circle"></i></a>
                  <div id="myModal2" class="reveal-modal" data-reveal>
                    <h2>'.__('Les catégories').'</h2>
                    <p>'.__('Pour ajouter un contenu à une catégorie, vous devez avoir créé cette catégorie au préalable.').'</p>
                    <a class="close-reveal-modal">&#215;</a>
                  </div>'));
                $this->Js->get('#AlbumDefuntId')->event('change', 
                $this->Js->request(array('controller'=>'categories','action'=>'getByPersa'), 
                    array(
                    'update'=>'#AlbumCategoryId',
                    'async' => true,
                    'method' => 'post',
                    'dataExpression'=>true,
                    'data'=> $this->Js->serializeForm(array(
                        'isForm' => true,
                        'inline' => true
                        ))
                    ))
                );
            echo $this->Form->submit(__('Ajouter cet album'),array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
        ?>
      </div>
    </div>
</div>    

