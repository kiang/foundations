<?php
if (!isset($url)) {
    $url = array();
}

if (!empty($foreignId) && !empty($foreignModel)) {
    $url = array($foreignModel, $foreignId);
}
?>
<div id="DirectorsAdminIndex">
    <h2><?php echo __('Directors', true); ?></h2>
    <div class="btn-group">
        <?php echo $this->Html->link(__('Add', true), array_merge($url, array('action' => 'add')), array('class' => 'btn dialogControl')); ?>
    </div>
    <div><?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?></div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DirectorsAdminIndexTable">
        <thead>
            <tr>
                <?php if (empty($scope['Director.Foundation_id'])): ?>
                    <th><?php echo $this->Paginator->sort('Director.Foundation_id', 'Foundations', array('url' => $url)); ?></th>
                <?php endif; ?>

                <th><?php echo $this->Paginator->sort('Director.name', 'Name', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Director.title', 'Title', array('url' => $url)); ?></th>
                <th class="actions"><?php echo __('Action', true); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($items as $item) {
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <?php if (empty($scope['Director.Foundation_id'])): ?>
                        <td><?php
                if (empty($item['Foundation']['id'])) {
                    echo '--';
                } else {
                    echo $this->Html->link($item['Foundation']['id'], array(
                        'controller' => 'foundations',
                        'action' => 'view',
                        $item['Foundation']['id']
                    ));
                }
                        ?></td>
                    <?php endif; ?>

                    <td><?php
                    echo $item['Director']['name'];
                    ?></td>
                    <td><?php
                    echo $item['Director']['title'];
                    ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View', true), array('action' => 'view', $item['Director']['id']), array('class' => 'dialogControl')); ?>
                        <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $item['Director']['id']), array('class' => 'dialogControl')); ?>
                        <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $item['Director']['id']), null, __('Delete the item, sure?', true)); ?>
                    </td>
                </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="DirectorsAdminIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function() {
            $('#DirectorsAdminIndexTable th a, #DirectorsAdminIndex div.paging a').click(function() {
                $('#DirectorsAdminIndex').parent().load(this.href);
                return false;
            });
    });
    //]]>
    </script>
</div>