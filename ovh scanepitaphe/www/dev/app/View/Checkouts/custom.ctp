<div class="row">
    <div class="small-12 medium-12 large-12">
</div><p>1 - Placez le QR code et le texte sur l'image.<br/>
2 - Redimensionnez le texte si besoin (en utilisant le petit carré rouge en bas à droite de votre texte).<br/>
3 - Validez pour ajouter à vote panier.</p></div>
</div>
<div id="content">
    <div id="background" class="background ui-widget-header">
       <?php 
            $name= explode('.', $vars['Checkout']['picture_file']['name']);
            echo '<img id="obj_0" src="/img/medias/defunts/defunt_'.$vars['Checkout']['defunt_id'].'/tmp/upload.jpg"/>';
        ?>
    </div>
<!--  
    <div id="tools">
    </div>
  -->
    <div id="objects">
        
        <?php
            echo '<div class="obj_item"><img id="obj_1" width="50" height="50" class="ui-widget-content" src="http://scanepitaphe.fr/img/medias/defunts/defunt_'.$vars['Checkout']['defunt_id'].'/qrcode_'.$vars['Checkout']['defunt_id'].'.png" alt="el"/></div>';
            ?>
       
        
        <?php
        echo '<div id="resizable" class="obj_item"><img id="obj_2"  class="ui-widget-content" src="http://scanepitaphe.fr/img/medias/defunts/defunt_'.$vars['Checkout']['defunt_id'].'/tmp/texte.png" alt="el"/></div>';
        ?>
    </div>
 
    <a id="submit"><span></span></a>
            <form id="jsonform" action="http://scanepitaphe.fr/checkouts/merge" method="POST">
                <input id="jsondata" name="jsondata" type="hidden" value="" autocomplete="off"></input>
            </form>
 
</div>
<script type="text/javascript">  
  function exist_object(id){
      for(var i = 0;i<data.images.length;++i){
          if(data.images[i].id == id)
              return i;
      }
      return -1;
  }
   count_dropped_hits = 0;
   data = {
      "images": [
          {"id" : "obj_0" ,"src" : "<?php echo 'http://scanepitaphe.fr/img/medias/defunts/defunt_'.$vars['Checkout']['defunt_id'].'/tmp/upload.'.$name[1]; ?>"   ,"width" : "1181", "height" : "1772"}
      ]
  };
  $(function() {
    $( "#resizable" ).resizable();
    $( "#objects div" ).draggable();
    $( "#background" ).droppable({
        drop: function(event, ui) {
            var $this = $(this);
            ++count_dropped_hits;
            var draggable_elem = ui.draggable;
            draggable_elem.css('z-index',count_dropped_hits);
            /* object was dropped : register it */
            var objsrc      = draggable_elem.find('.ui-widget-content').attr('src');
            var objwidth    = parseFloat(draggable_elem.css('width'),10);
            var objheight   = parseFloat(draggable_elem.css('height'),10);
        
            /* for top and left we decrease the top and left of the droppable element */
            var objtop      = ui.offset.top - $this.offset().top;
            var objleft     = ui.offset.left - $this.offset().left;
                           
            var objid       = draggable_elem.find('.ui-widget-content').attr('id');
        
            var index       = exist_object(objid);
            
              if(index!=-1) { //if exists update top and left
                  data.images[index].top  = objtop;
                  data.images[index].left = objleft;
              }else{                   
              /* register new one */
              var newObject = { 
                    'id'        : objid,
                    'src'       : objsrc,
                    'width'     : objwidth,
                    'height'    : objheight,
                    'top'       : objtop,
                    'left'      : objleft,
                    'rotation'  : '0'
                    };
              data.images.push(newObject);
            }
      }
    });
    /* User presses the download button */
                $('#submit').bind('click',function(){
                    var dataString  = JSON.stringify(data);
                    $('#jsondata').val(dataString);
                    $('#jsonform').submit();
                });
  });
  </script>