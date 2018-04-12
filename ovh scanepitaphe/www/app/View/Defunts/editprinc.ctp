<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>
                <?php echo $personne['Defunt']['title'].' '.$personne['Defunt']['firstname'].' '.$personne['Defunt']['name']; ?>
            </h3>
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
        <div class="small-12 medium-12 large-12 tdb lignetop">
            <?php
                
                if(!empty($personne['Defunt']['avatar'])){
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe " style="position: relative;background:url(http://scanepitaphe.fr/img/medias/defunts/'.'defunt_'.$personne['Defunt']['id'].'/'.$personne['Defunt']['avatar'].')no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">'; 
                    }else{
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe" style="position: relative;background:url(http://scanepitaphe.fr/img/fond-gris.jpg)no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">';                   
                    }
                    echo '<p class="top">'.$personne['Defunt']['title'].'<br/>'.$personne['Defunt']['firstname'].' '.$personne['Defunt']['name'].'</p>';
                    echo '<p class="bottom">'.$this->Html->link(__('Modifier'),array('controller'=>'defunts','action'=>'edit',$personne['Defunt']['id']));
                    echo '</p></div>'; 

                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-pencil"></i><p>'.__('Textes').'</p></div>',array('controller'=>'media','action'=>'listtext',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('ajouter / modifier un texte')
                  ));

                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-music"></i><p>'.__('Mp3').'</p></div>',array('controller'=>'media','action'=>'listeson',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('ajouter / modifier un Mp3')
                  ));

                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-youtube-play"></i><p>'.__('Vidéos').'</p></div>',array('controller'=>'media','action'=>'listvideo',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('ajouter / modifier une vidéo')
                  ));

                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-file-pdf-o"></i><p>'.__('Pdf').'</p></div>',array('controller'=>'media','action'=>'listepdf',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('ajouter / modifier un pdf')
                  ));

                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-picture-o"></i><p>'.__('Images').'</p></div>',array('controller'=>'media','action'=>'listeimage',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('ajouter / modifier une image')
                  ));

                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-files-o"></i><p>'.__('Albums').'</p></div>',array('controller'=>'albums','action'=>'liste',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('ajouter / modifier un album')
                  ));

                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-tag"></i><p>'.__('Catégories').'</p></div>',array('controller'=>'categories','action'=>'liste',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('ajouter / modifier une catégorie')
                  ));
                ?>  

                <?php
                    echo '<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-trash"></i><p>';
                    echo $this->Html->link(__('Supprimer ce profil'),array('controller'=>'defunts','action'=>'delete',$personne['Defunt']['id'],$personne['Family']['id']));
                    echo '</p></div>';
                ?>     
            
            
            
        </div>
    </div>
    <div class="row margecinq">
        <div class="small-12 medium-12 large-12 tdb center">          
            
                <?php
                    
                    echo $this->Html->link('<div class="small-12 medium-4b large-4b center bgvert left margergttdb"><i class="fa fa-users"></i><p>'.__('Co-auteurs').'</p></div>',array('controller'=>'users','action'=>'pageinvite',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('permettez à vos proches d\'ajouter du contenu sur cette page')
                  ));
                   
                ?>  

                <?php
                    echo $this->Html->link('<div class="small-12 medium-4b large-4b center bgvert left margergttdb"><i class="fa fa-cog"></i><p>'.__('Paramètres de la page').'</p></div>',array('controller'=>'clientpages','action'=>'manage',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('paramètres de la page')
                  ));
                ?>               
            
           
                <?php
                    echo $this->Html->link(' <div class="small-12 medium-4b large-4b center bgvert left"><i class="fa fa-question"></i><p>'.__('Besoin d\'aide ?').'</p></div>',array('controller'=>'pages','action'=>'display','help'),array(
                    'escapeTitle' => false, 'title' => __('posez nous votre question')
                  ));
                ?>
                
            
        </div>
    </div>
</div>