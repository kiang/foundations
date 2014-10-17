<div id="FoundationsIndex">
    <p>
        <?php
        $url = array();
        ?></p>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="FoundationsIndexTable">
        <thead>
            <tr>
                <th>名稱</th>
                <th>代表人</th>
                <th>成立目的</th>
                <th><?php echo $this->Paginator->sort('Foundation.fund', '財產總額', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.founded', '創立日期', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Foundation.submitted', '更新日期', array('url' => $url)); ?></th>
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
                    echo $item['Foundation']['name'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['representative'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['purpose'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['fund'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['founded'];
                    ?></td>
                    <td><?php
                    echo $item['Foundation']['submitted'];
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
</div>