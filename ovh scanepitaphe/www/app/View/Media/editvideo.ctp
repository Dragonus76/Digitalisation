<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Modifier un contenu vidéo sur la page de');?> <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
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
      <div class="small-12 medium-12 large-12 columns">
        <?php
            echo '<p class="center">';
            echo $media['Media']['adressevideo'];
            echo '</p>';
            echo $this->Form->create('Media');
            echo $this->Form->input('id', array('type' => 'hidden'));
            echo $this->Form->input('name',array('label' => __('1 - Titre de la vidéo'), 'placeholder'=>__('renseignez le titre de votre vidéo'),'class' => 'ckeditor'));
            echo $this->Form->input('date', array(
                                'label' => __('2 - Date de l\'évenement concerné'),
                                'dateFormat' => 'DMY',
                                'minYear' => date('Y') - 2000,
                                'maxYear' => date('Y'),
                                 'separator' =>''
                                ));    
            echo $this->Form->input('content',array('label' => __('3 - Description de la vidéo'),'rows' => '5','placeholder'=>__('description de la vidéo'), 'class' => 'ckeditor'));
            foreach ($cats as $key => $value) {
                    $l=$value['Category']['id'];
                    $arrayd[$l]=$value['Category']['name'];
                }
            if(!empty($arrayd)){
            echo $this->Form->input('category_id', array(
                      'label' => __('4 - Choississez une éventuelle catégorie (facultatif)'),
                      'options' => $arrayd,
                      'empty' => ''));
            }else{
               echo '<p>'.__('Vous n\'avez pas créé de catégories pour cette personne. ').$this->Html->link(__('Créer une catégorie'),array('controller'=>'categories','action'=>'add',$personne['Defunt']['id'])).'</p>'; 
            }
            echo $this->Form->input('tags',array('label'=>__('5 - Renseignez des mots clés (séparés par une virgule) (facultatif)').' <a href="#" data-reveal-id="myModal" data-reveal title="'.__('Besoin d\'aide?').'"><i class="fa fa-question-circle"></i></a>
                  <div id="myModal" class="reveal-modal" data-reveal>
                    <h2>'.__('Les mots clés').'</h2>
                    <p>'.__('Scanepitaphe vous permet de renseigner des mots clés à chaque contenu que vous ajoutez. Ces mots clés permettent de regrouper des contenus et ce, même s\'ils appartiennent à des catégories différentes. Par exemple, vous pouvez ajouter une photo et un texte concernant un même voyage au Maroc. La photo pourra être classée dans la catégorie "Photos", le texte dans une autre, mais grâce au mot clé "Voyage au Maroc" renseigné pour les deux contenus, vous pourrez filtrer ces deux contenus sur la page perso.').'</p>
                    <p>'.__('Vous pouvez ajouter autant de mots clés que vous souhaitez.').'</p>
                    <a class="close-reveal-modal">&#215;</a>
                  </div>','type'=>'text'));
            echo '<p>';
            foreach($tags as $k=>$v){
              echo '<span class="label notice tag bgviolet">';
              echo $v['title'];
              echo ' ['.$this->Html->link("x",array('controller'=>'MediaTags', 'action'=>'delTag',$v['MediaTag']['id']),null,__('Voulez vous vraiment supprimer ce tag ?')).']';
              echo ' </span></p>';
            }
            echo $this->Form->input('comment',array('label' => __('6 - Autoriser les commentaires')));
            echo $this->Form->submit(__('Modifier ce texte'),array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
        ?>
      </div>
    </div>
</div>