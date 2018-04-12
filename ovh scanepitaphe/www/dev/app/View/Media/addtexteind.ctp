<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Ajouter un contenu texte sur la page de <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
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
      <?php if($limit['Limit']['text'] != 0) :?>
        <?php
            echo $this->Form->create('Media');
            echo $this->Form->input('defunt_id', array('type' => 'hidden', 'value' => $personne['Defunt']['id']));
            echo $this->Form->input('type', array('type' => 'hidden', 'value' => 'typetext')); 
            echo $this->Form->input('name',array('label' => '1 - Ajoutez un titre du texte', 'placeholder'=>'renseignez le titre de votre texte','class' => 'ckeditor'));
            echo $this->Form->input('date', array(
                                'label' => '2 - Renseignez la date de l\'évènement décrit',
                                'dateFormat' => 'DMY',
                                'minYear' => date('Y') - 2000,
                                'maxYear' => date('Y'),
                                 'separator' =>''
                                ));    
            echo $this->Form->input('content',array('label' => '3 - Ajoutez votre texte','rows' => '5','placeholder'=>'écrivez votre texte', 'class' => 'ckeditor'));
            echo $this->Form->input('tags',array('label'=>'4 - Renseignez des mots clés (séparés par une virgule) (facultatif) <a href="#" data-reveal-id="myModal" data-reveal title="Besoin d\'aide?"><i class="fa fa-question-circle"></i></a>
                  <div id="myModal" class="reveal-modal" data-reveal>
                    <h2>Les mots clés</h2>
                    <p>Scanepitaphe vous permet de renseigner des mots clés à chaque contenu que vous ajoutez. Ces mots clés permettent de regrouper des contenus et ce, même s\'ils appartiennent à des catégories différentes. Par exemple, vous pouvez ajouter une photo et un texte concernant un même voyage au Maroc. La photo pourra être classée dans la catégorie "Photos", le texte dans une autre, mais grâce au mot clé "Voyage au Maroc" renseigné pour les deux contenus, vous pourrez filtrer ces deux contenus sur la page perso.</p>
                    <p>Vous pouvez ajouter autant de mots clés que vous souhaitez.</p>
                    <a class="close-reveal-modal">&#215;</a>
                  </div>','type'=>'text')); 
             foreach ($cats as $key => $value) {
                    $l=$value['Category']['id'];
                    $arrayd[$l]=$value['Category']['name'];
                }
            if(!empty($arrayd)){
            echo $this->Form->input('category_id', array(
                      'label' => '5 - Choississez une éventuelle catégorie pour ce texte (facultatif)',
                      'options' => $arrayd,
                      'empty' => ''));
            }else{
               echo '<p>Vous n\'avez pas créé de catégories pour cette personne. '.$this->Html->link('Créer une catégorie',array('controller'=>'categories','action'=>'add',$personne['Defunt']['id'])).'</p>'; 
            }
            echo $this->Form->input('comment',array('label' => '6 - Autoriser les commentaires'));
            
            echo $this->Form->submit('Ajouter ce texte',array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
        ?>
        <?php else : ?>
        <p>Vous avez atteint votre limite de <?php echo $limit['Limit']['limittext']; ?> textes. Pour obtenir des contenus supplémentaires, rendez vous dans le Scanshop (bientôt disponible).</p>
        <?php endif ?>
      </div>
    </div>
</div>        

