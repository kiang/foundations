<div id="FoundationsIndex">
    <h2><?php echo __('Foundations', true); ?></h2>
    <div class="clear actions">
        <ul>
        </ul>
    </div>
    <p>
        <?php
        $url = array();

        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?></p>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="FoundationsIndexTable">
        <thead>
            <tr>

                <th><?php echo $this->Paginator->sort('Foundation.active_id', 'Active ID', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.name', 'Name', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.type', 'Type', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.representative', 'Representative', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.founded', 'Founded', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.address', 'Address', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.purpose', 'Purpose', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.donation', 'Donation', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.approved_by', 'Approved By', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.fund', 'Fund', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.closed', 'Closed', array('url' => $url)); ?></th>
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

                    <td><?php
                    echo $item['Foundation']['active_id'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['name'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['type'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['representative'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['founded'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['address'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['purpose'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['donation'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['approved_by'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['fund'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['closed'];
                    ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View', true), array('action' => 'view', $item['Foundation']['id']), array('class' => 'FoundationsIndexControl')); ?>
                    </td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="FoundationsIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function() {
            $('#FoundationsIndexTable th a, div.paging a, a.FoundationsIndexControl').click(function() {
                $('#FoundationsIndex').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>