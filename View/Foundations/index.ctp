<div id="FoundationsIndex" class="col-md-12">
    <?php $url = array(); ?>
    <div class="paginator-wrapper"><?php echo $this->element('paginator'); ?></div>
    <?php
    if (empty($items)) {
        echo '<p>&nbsp;</p>';
        echo $this->Html->tag(
            'h1',
            '<i class="glyphicon glyphicon-info-sign text-info"></i>',
            array('escape' => false, 'style' => 'text-align: center')
        );
        echo $this->Html->tag(
            'h2',
            '噢不，沒有相關結果 :(',
            array('class' => 'text-muted', 'style' => 'text-align: center')
        );
        echo '<p>&nbsp;</p>';
    }
    foreach ($items as $item) {
    ?>
        <div class="row foundation-list jumbotron">
            <div class="col-md-12">
                <?php
                    echo $this->Html->link(
                        $this->Html->tag(
                            'h2',
                            $item['Foundation']['name']
                            ),
                        array('action' => 'view', $item['Foundation']['id']),
                        array('escape' => false)
                    );
                ?>
            </div>
            <div class="col-md-12">
                <?php 
                echo $this->Html->tag(
                    'blockquote',
                    $item['Foundation']['purpose'],
                    array(
                        'class' => 'text-muted',
                        'title' => $item['Foundation']['purpose']
                    )
                );
                ?>
            </div>
            <div class="col-md-12">
                <div class="foundation-list-attr">
                    <?php
                    echo '<span class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;創立於</span>&nbsp;';
                    echo $this->Html->tag('span', $item['Foundation']['founded']);
                    ?>
                </div>
                <div class="foundation-list-attr">
                    <?php
                    echo '<span class="text-muted"><i class="glyphicon glyphicon-usd"></i>&nbsp;財產總額</span>&nbsp;';
                    echo $this->Html->tag('span', $item['Foundation']['fund'], array('class' => 'fund-currency'));
                    ?>
                </div>
            </div>
        </div>
    <?php }; // End of foreach ($items as $item) {  ?>
    <div class="paginator-wrapper"><?php echo $this->element('paginator'); ?></div>
    <div id="FoundationsIndexPanel"></div>
</div>
<?php echo $this->Html->script('index.js', array('inline' => false, 'block' => 'scriptBottom')); ?>