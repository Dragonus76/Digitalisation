<div class="row minha">
         <?php echo $this->element('bord'); ?>
    <div class="small-12 medium-8 large-8 columns">
        <h4>Modifier un contenu pdf sur la page de <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'edit',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => 'modifier les informations de cette personne'
                  ));?></h4>
        <?php
        if(!empty($media['Media']['nomfichier']) ){
            echo '<object  class="pdf" data="/img/medias/defunts/defunt_'.$media['Media']['defunt_id'] . '/pdf/'.$media['Media']['nomfichier'].'" type="application/pdf"><p>It appears you don\'t have Adobe Reader or PDF support in this web browser. <a href="/img/medias'. DS .'defunts'. DS .'defunt_'.$media['Media']['defunt_id'] . DS . 'pdf'.DS.$media['Media']['nomfichier'].'">Click here to download the PDF</a>. Or <a href="http://get.adobe.com/reader/" target="_blank">click here to install Adobe Reader</a>.</p><embed src="/img/medias'. DS .'defunts'. DS .'defunt_'.$media['Media']['defunt_id'] . DS . 'pdf'.DS.$media['Media']['nomfichier'].'" type="application/pdf" /></object>';
  }
            echo $this->Form->create('Media');
            echo $this->Form->input('id', array('type' => 'hidden'));
            echo $this->Form->input('name',array('label' => '1 - Titre du pdf', 'placeholder'=>'renseignez le titre de votre pdf','class' => 'ckeditor'));
            echo $this->Form->input('date', array(
                                'label' => '2 -Date de l\'évenement concerné',
                                'dateFormat' => 'DMY',
                                'minYear' => date('Y') - 2000,
                                'maxYear' => date('Y'),
                                 'separator' =>''
                                ));    
            foreach ($cats as $key => $value) {
                    $l=$value['Category']['id'];
                    $arrayd[$l]=$value['Category']['name'];
                }
            if(!empty($arrayd)){
            echo $this->Form->input('category_id', array(
                      'label' => '3 - Choississez une éventuelle catégorie (facultatif)',
                      'options' => $arrayd,
                      'empty' => ''));
            }else{
               echo '<p>Vous n\'avez pas créé de catégories pour cette personne. '.$this->Html->link('Créer une catégorie',array('controller'=>'categories','action'=>'add',$personne['Defunt']['id'])).'</p>'; 
            }
             echo $this->Form->input('tags',array('label'=>'4 - Renseignez des mots clés (séparés par une virgule) (facultatif) <a href="#" data-reveal-id="myModal" data-reveal title="Besoin d\'aide?"><i class="fa fa-question-circle"></i></a>
                  <div id="myModal" class="reveal-modal" data-reveal>
                    <h2>Les mots clés</h2>
                    <p>Scanepitaphe vous permet de renseigner des mots clés à chaque contenu que vous ajoutez. Ces mots clés permettent de regrouper des contenus et ce, même s\'ils appartiennent à des catégories différentes. Par exemple, vous pouvez ajouter une photo et un texte concernant un même voyage au Maroc. La photo pourra être classée dans la catégorie "Photos", le texte dans une autre, mais grâce au mot clé "Voyage au Maroc" renseigné pour les deux contenus, vous pourrez filtrer ces deux contenus sur la page perso.</p>
                    <p>Vous pouvez ajouter autant de mots clés que vous souhaitez.</p>
                    <a class="close-reveal-modal">&#215;</a>
                  </div>','type'=>'text'));
            echo '<p>';
            foreach($tags as $k=>$v){
              echo '<span class="label notice tag">';
              echo $v['title'];
              echo ' ['.$this->Html->link("x",array('controller'=>'MediaTags', 'action'=>'delTag',$v['MediaTag']['id']),null,'Voulez vous vraiment supprimer ce tag ?').']';
              echo ' </span></p>';
            }
            echo $this->Form->input('comment',array('label' => '5 - Autoriser les commentaires'));

            echo $this->Form->submit('Modifier ce pdf',array('class'=>'button postfix')); 
            echo $this->Form->end();
        ?>
    </div>
</div>            

