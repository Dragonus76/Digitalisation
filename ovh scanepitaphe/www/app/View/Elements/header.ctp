<nav class="top-bar headr" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <div class="logohead">
    <?php 
    echo $this->Html->image('logo-home.png', 
              array(
                'alt' => __('logo retour accueil du site'),
                'width'=>'80px',

                'url' => array('language'=>Configure::read('Config.language'),'controller' => 'pages', 'action' => 'display', 'home','admin'=>false)
                )); 
     ?>
  </div>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span><?php echo __('Menu');?></span></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Right Nav Section -->
    <ul class="right">
      <?php 
      if($this->params['admin']==false){
      if (isset($this->passedArgs['0'])){ 
        echo $this->Html->image('uk.jpg', 
              array(
                'alt' => __('anglais'),
                'width'=>'20',
                'url' => array('language' => 'eng',$this->passedArgs['0'],'admin'=>false)
                )); 
        echo $this->Html->image('fr.jpg', 
              array(
                'alt' => __('français'),
                'width'=>'20',
                'url' => array('language' => 'fra',$this->passedArgs['0'],'admin'=>false)
                )); 
           
            }else{ 
            echo $this->Html->image('uk.jpg', 
              array(
                'alt' => __('anglais'),
                'width'=>'20',
                'url' => array('language' => 'eng','admin'=>false)
                )); 
      echo $this->Html->image('fr.jpg', 
              array(
                'alt' => __('français'),
                'width'=>'20',
                'url' => array('language' => 'fra','admin'=>false)
                ));
             } 
            }
      
      if($this->Session->read('Auth.User.id')){

        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-files-o"></i>',
          array(
              'language'=>Configure::read('Config.language'),
              'controller' => 'albums', 
              'action' => 'addall',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => __('ajouter un album à une personne')
                  ));
        echo '</li>';
        

        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-tag"></i>',
          array(
            'language'=>Configure::read('Config.language'),
              'controller' => 'categories', 
              'action' => 'addall',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => __('ajouter une catégorie de contenus à une personne')
                  ));
        echo '</li>';

        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-file-pdf-o"></i>',
          array(
            'language'=>Configure::read('Config.language'),
              'controller' => 'media', 
              'action' => 'addpdf',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => __('ajouter un pdf sur la page d\'une personne')
                  ));
        echo '</li>';

        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-youtube-play"></i>',
          array(
            'language'=>Configure::read('Config.language'),
              'controller' => 'media', 
              'action' => 'addvideo',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => __('ajouter une vidéo sur la page d\'une personne')
                  ));
        echo '</li>';
        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-music"></i>',
          array(
            'language'=>Configure::read('Config.language'),
              'controller' => 'media', 
              'action' => 'addson',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => __('ajouter un son sur la page d\'une personne')
                  ));
        echo '</li>';
        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-picture-o"></i>',
          array(
            'language'=>Configure::read('Config.language'),
              'controller' => 'media', 
              'action' => 'addimage',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => __('ajouter une image sur la page d\'une personne')
                  ));
        echo '</li>';
        echo '<li>';
        echo $this->Html->link(
          '<i class="fa fa-pencil"></i>',
          array(
            'language'=>Configure::read('Config.language'),
              'controller' => 'media', 
              'action' => 'addtexte',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => __('ajouter un contenu texte sur la page d\'une personne')
                  ));
        echo '</li>';
        echo '<li>';
        echo $this->Html->link(
            __('Tableau de bord'),
            array(
              'language'=>Configure::read('Config.language'),
              'controller' => 'users', 
              'action' => 'account',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => __('mon tableau de bord')
                  ));
        echo '</li>';
        echo '<li>';
        echo $this->Html->link(
            __('Se déconnecter'),
            array(
              'controller' => 'users', 
              'action' => 'logout',
              'admin'=>false
              ),
            array(
                    'escapeTitle' => false, 'title' => __('se déconnecter')
                  ));
        echo '</li>';
      }
    ?>      
    </ul>

  </section>
</nav>