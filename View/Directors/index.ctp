<div id="DirectorsIndex col-md-12">
    <h2><?php echo $name; ?></h2>
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
        $i = 0;
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
                        '/foundations/view/' . $item['Foundation']['id'],
                        array('escape' => false)
                    );
                ?>
            </div>
            <div class="col-md-12">
                <div class="foundation-list-attr">
                    <?php
                    echo '<span class="text-muted"><i class="glyphicon glyphicon-user"></i>&nbsp;職稱</span>&nbsp;';
                    echo $this->Html->tag('span', $item['Director']['title']);
                    echo '<br>';
                    echo '<span class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;到職日</span>&nbsp;';
                    echo $this->Html->tag('span', $item['Foundation']['submitted']);
                    ?>
                </div>
            </div>
        </div>
        <?php } ?>
    <div class="paginator-wrapper"><?php echo $this->element('paginator'); ?></div>
</div>