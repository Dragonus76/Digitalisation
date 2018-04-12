<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Famille <?php echo $this->request->data['Family']['name']; ?></h3>
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
        <div class="small-12 medium-12 large-12 tdb lignetop">
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-male" style="padding-bottom:0.1em;"></i><p>Ajouter une personne (ou groupe de personnes) et créer sa page</p></div>',array('controller'=>'defunts','action'=>'add',$this->request->data['Family']['id']),array(
                    'escapeTitle' => false, 'title' => 'créer une famille (groupe de personnes)'
                  ));
                ?>                                
            
            <?php
                $personnes = $this->requestAction('defunts/getallbyfamily/'.$this->request->data['Family']['id']);
                foreach ($personnes as $key => $value) {
                    if(!empty($value['Defunt']['avatar'])){
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe " style="position: relative;background:url(http://scanepitaphe.fr/img/medias/defunts/'.'defunt_'.$value['Defunt']['id'].'/'.$value['Defunt']['avatar'].')no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">'; 
                    }else{
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe" style="position: relative;background:url(http://scanepitaphe.fr/img/fond-gris.jpg)no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">';                   
                    }
                    echo '<p class="top">'.$value['Defunt']['title'].'<br/>'.$value['Defunt']['firstname'].' '.$value['Defunt']['name'].'</p>';
                    echo '<p class="bottom">'.$this->Html->link('Modifier',array('controller'=>'defunts','action'=>'editprinc',$value['Defunt']['id'])).'<br/>'.$this->Html->link('Voir la page',array('controller'=>'clientpages','action'=>'view',$value['Defunt']['id']));
                    echo '</p></div>';
                    }
                ?>

                <?php
                    echo '<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-times"></i><p>';
                    echo $this->Html->link('Supprimer cette famille',array('controller'=>'families','action'=>'delete',$this->request->data['Family']['id']));
                    echo '</p></div>';
                ?> 

            
        </div>
    </div>
    <div class="row margecinq">
        <div class="small-12 medium-12 large-12 tdb center">          
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-4b large-4b center bgvert left margergttdb"><i class="fa fa-cog"></i><p>Paramètres de la famille</p></div>',array('controller'=>'families','action'=>'edit',$this->request->data['Family']['id']),array(
                    'escapeTitle' => false, 'title' => 'paramètres de votre compte'
                  ));
                ?>                
            
           
                <?php
                    echo $this->Html->link(' <div class="small-12 medium-4b large-4b center bgvert left"><i class="fa fa-question"></i><p>Besoin d\'aide ?</p></div>',array('controller'=>'pages','action'=>'display','help'),array(
                    'escapeTitle' => false, 'title' => 'posez nous votre question'
                  ));
                ?>
                
            
        </div>
    </div>
</div>