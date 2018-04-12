<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Ajouter une image sur la page de');?> <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('modifier les informations de cette personne')
                  ));?> <?php echo __('dans son album');?> <?php echo $albs['Album']['name']; ?></h3>
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
        <?php if($limit['Limit']['picture'] != 0) :?>
        <?php
            echo $this->Form->create('Media',array('type' => 'file'));
            echo $this->Form->input('type', array('type' => 'hidden', 'value' => 'typeimage')); 
           echo $this->Form->input('defunt_id', array('type' => 'hidden', 'value' => $personne['Defunt']['id']));
            
            echo $this->Form->input('name',array('label' => __('1 - Ajoutez un titre pour l\'image'), 'placeholder'=>__('renseignez le titre de votre image'),'class' => 'ckeditor'));
            echo $this->Form->input('date', array(
                                'label' => __('2 - Renseignez la date de l\'évènement concerné'),
                                'dateFormat' => 'DMY',
                                'minYear' => date('Y') - 2000,
                                'maxYear' => date('Y'),
                                 'separator' =>''
                                
                                ));    
            echo $this->Form->input('content',array('label' => __('3 - Ajoutez une légende pour l\'image'),'rows' => '5','placeholder'=>__('légende de votre image'), 'class' => 'ckeditor'));
            echo $this->Form->input('tags',array('label'=>__('4 - Renseignez des mots clés (séparés par une virgule) (facultatif)').' <a href="#" data-reveal-id="myModal" data-reveal title="'.('Besoin d\'aide?').'"><i class="fa fa-question-circle"></i></a>
                  <div id="myModal" class="reveal-modal" data-reveal>
                    <h2>'.__('Les mots clés').'</h2>
                    <p>'.__('Scanepitaphe vous permet de renseigner des mots clés à chaque contenu que vous ajoutez. Ces mots clés permettent de regrouper des contenus et ce, même s\'ils appartiennent à des catégories différentes. Par exemple, vous pouvez ajouter une photo et un texte concernant un même voyage au Maroc. La photo pourra être classée dans la catégorie "Photos", le texte dans une autre, mais grâce au mot clé "Voyage au Maroc" renseigné pour les deux contenus, vous pourrez filtrer ces deux contenus sur la page perso.').'</p>
                    <p>'.__('Vous pouvez ajouter autant de mots clés que vous souhaitez.').'</p>
                    <a class="close-reveal-modal">&#215;</a>
                  </div>','type'=>'text')); 
            echo $this->Form->input('nomfichier_url',array('label' => __('5 - Choississez un fichier pour l\'image'), 'type' => 'file'));

            echo $this->Form->input('category_id', 
                              array(
                              'label' => __('6 - Choississez une éventuelle catégorie pour cette image (facultatif)').' <a href="#" data-reveal-id="myModal2" data-reveal title="'.__('Besoin d\'aide?').'"><i class="fa fa-question-circle"></i></a>
                  <div id="myModal2" class="reveal-modal" data-reveal>
                    <h2>'.__('Les catégories').'</h2>
                    <p>'.__('Pour ajouter un contenu à une catégorie, vous devez avoir créé cette catégorie au préalable.').'</p>
                    <a class="close-reveal-modal">&#215;</a>
                  </div>'));
                $this->Js->get('#MediaDefuntId')->event('change', 
                $this->Js->request(array('controller'=>'categories','action'=>'getByPers'), 
                    array(
                    'update'=>'#MediaCategoryId',
                    'async' => true,
                    'method' => 'post',
                    'dataExpression'=>true,
                    'data'=> $this->Js->serializeForm(array(
                        'isForm' => true,
                        'inline' => true
                        ))
                    ))
                );
                echo $this->Form->input('album_id', array('type' => 'hidden', 'value' => $albs['Album']['id']));
                
                
            echo $this->Form->input('comment',array('label' => __('7 - Autoriser les commentaires')));
            
            echo $this->Form->submit(__('Ajouter cette image'),array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
        ?>
        <?php else : ?>
        <p><?php echo __('Vous avez atteint votre limite de');?> <?php echo $limit['Limit']['limitpicture']; ?> <?php echo __('images.');?> <?php echo __('Pour obtenir des contenus supplémentaires, rendez vous dans la boutique.');?></p>
        <?php endif ?>
      </div>
    </div>
</div>