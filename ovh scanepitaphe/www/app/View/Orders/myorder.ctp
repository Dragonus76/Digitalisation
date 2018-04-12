<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Récapitulatif de mes commandes');?></h3>
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
      <div class="small-12 medium-12 large-12 lignetop">
          <?php if(!empty($orderlist)) : ?>
          <table>
            <tr>
              <th><?php echo __('Date');?></th>
              <th><?php echo __('Reference de la commande');?></th>
              <th><?php echo __('Nom du client');?></th>
              <th><?php echo __('Montant');?></th>
            </tr>
          <!-- Here is where we loop through our $posts array, printing out post info -->
          <?php foreach ($orderlist as $order): ?>
            <tr>
              <td><?php echo $order['Order']['created']; ?></td>
              <td><?php echo $this->Html->link($order['Order']['cleref'],array('controller'=>'orders','action'=>'view',$order['Order']['id'])); ?></td>
              <td><?php echo $order['Order']['uname']; ?></td>
              <td><?php echo $order['Order']['ttc']; ?></td>
            </tr>
          <?php endforeach; ?>
          <?php unset($order); ?>
          </table>
          <?php else: ?>
          <p><?php echo __('Vous n\'avez pas effectué de commande.');?></p>
          <?php endif ?>
      </div>
    </div>
</div>