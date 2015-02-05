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
                    <td>
                        <?php echo $this->Html->link($item['Foundation']['name'], array('action' => 'view', $item['Foundation']['id'])); ?></td>
                    <td><?php
                        echo $this->Html->link($item['Foundation']['representative'], '/directors/index/' . $item['Foundation']['representative']);
                        ?></td>
                    <td class="col-md-4"><?php
                        echo $item['Foundation']['purpose'];
                        ?></td>
                    <td><span class="fund-currency"><?php
                            echo $item['Foundation']['fund'];
                            ?></span></td>
                    <td><?php
                        echo $item['Foundation']['founded'];
                        ?></td>
                    <td><?php
                        echo $item['Foundation']['submitted'];
                        ?></td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="FoundationsIndexPanel"></div>
</div>
<script>
    setTimeout(function () {
        $('span.fund-currency').each(function () {
            $(this).html(zhutil.approximate($(this).html(), {base: '萬', extra_decimal: 0}));
        });
    }, 800);
</script>