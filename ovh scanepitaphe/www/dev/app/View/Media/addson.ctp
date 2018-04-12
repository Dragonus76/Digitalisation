<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Ajouter un contenu sonore (mp3) sur la page d'une personne</h3>
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
        <?php if($limit['Limit']['sound'] != 0) :?>
        <?php
            echo $this->Form->create('Media',array('type' => 'file'));
            echo $this->Form->input('type', array('type' => 'hidden', 'value' => 'typeson')); 
            foreach ($personnes as $key => $value) {
                    $k=$value['Defunt']['id'];
                    $array[$k]=$value['Defunt']['firstname'].' '.$value['Defunt']['name'];
                }
            echo $this->Form->input('defunt_id', array(
                      'label' => '1 - Choississez la personne concernée',
                      'options' => $array,
                      'empty'=>'Choisissez une personne'));
            echo $this->Form->input('name',array('label' => '2 - Ajoutez un titre à ce contenu sonore', 'placeholder'=>'renseignez le titre de votre contenu sonore','class' => 'ckeditor'));
            echo $this->Form->input('date', array(
                                'label' => '3 - Renseignez la date de l\'évènement concerné',
                                'dateFormat' => 'DMY',
                                'minYear' => date('Y') - 2000,
                                'maxYear' => date('Y'),
                                 'separator' =>''
                                ));    
            echo $this->Form->input('content',array('label' => '4 - Ajoutez une description','rows' => '5','placeholder'=>'description de votre son', 'class' => 'ckeditor'));
            echo $this->Form->input('tags',array('label'=>'5 - Renseignez des mots clés (séparés par une virgule) (facultatif) <a href="#" data-reveal-id="myModal" data-reveal title="Besoin d\'aide?"><i class="fa fa-question-circle"></i></a>
                  <div id="myModal" class="reveal-modal" data-reveal>
                    <h2>Les mots clés</h2>
                    <p>Scanepitaphe vous permet de renseigner des mots clés à chaque contenu que vous ajoutez. Ces mots clés permettent de regrouper des contenus et ce, même s\'ils appartiennent à des catégories différentes. Par exemple, vous pouvez ajouter une photo et un texte concernant un même voyage au Maroc. La photo pourra être classée dans la catégorie "Photos", le texte dans une autre, mais grâce au mot clé "Voyage au Maroc" renseigné pour les deux contenus, vous pourrez filtrer ces deux contenus sur la page perso.</p>
                    <p>Vous pouvez ajouter autant de mots clés que vous souhaitez.</p>
                    <a class="close-reveal-modal">&#215;</a>
                  </div>','type'=>'text')); 
            echo $this->Form->input('nomfichier_url',array('label' => '6 - Choississez un fichier sonore (mp3)', 'type' => 'file'));

            echo $this->Form->input('category_id', 
                              array(
                              'label' => '7 - Choississez une éventuelle catégorie pour ce fichier sonore (facultatif) <a href="#" data-reveal-id="myModal2" data-reveal title="Besoin d\'aide?"><i class="fa fa-question-circle"></i></a>
                  <div id="myModal2" class="reveal-modal" data-reveal>
                    <h2>Les catégories</h2>
                    <p>Pour ajouter un contenu à une catégorie, vous devez avoir créé cette catégorie au préalalble.</p>
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
            echo $this->Form->input('comment',array('label' => '8 - Autoriser les commentaires'));
            
            echo $this->Form->submit('Ajouter ce contenu sonore',array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
        ?>
        <?php else : ?>
        <p>Vous avez atteint votre limite de <?php echo $limit['Limit']['limitsound']; ?> sons. Pour obtenir des contenus supplémentaires, rendez vous dans le Scanshop (bientôt disponible).</p>
        <?php endif ?>
      </div>
    </div>
</div>