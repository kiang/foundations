<div id="DirectorsIndex">
    <h2><?php echo __('Directors', true); ?></h2>
    <div class="clear actions">
        <ul>
        </ul>
    </div>
    <p>
        <?php
        $url = array();

        if (!empty($foreignId) && !empty($foreignModel)) {
            $url = array($foreignModel, $foreignId);
        }

        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?></p>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DirectorsIndexTable">
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
                        <?php echo $this->Html->link(__('View', true), array('action' => 'view', $item['Director']['id']), array('class' => 'DirectorsIndexControl')); ?>
                    </td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="DirectorsIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function() {
            $('#DirectorsIndexTable th a, div.paging a, a.DirectorsIndexControl').click(function() {
                $('#DirectorsIndex').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>