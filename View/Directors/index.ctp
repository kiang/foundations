<div id="DirectorsIndex">
    <h2><?php echo $name; ?></h2>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DirectorsIndexTable">
        <thead>
            <tr>
                <th>法人名稱</th>
                <th>職稱</th>
                <th>到職日</th>
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
                        echo $this->Html->link($item['Foundation']['name'], '/foundations/view/' . $item['Foundation']['id']);
                        ?></td>
                    <td><?php
                        echo $item['Director']['title'];
                        ?></td>
                    <td><?php
                        echo $item['Foundation']['submitted'];
                        ?></td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="DirectorsIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('#DirectorsIndexTable th a, div.paging a, a.DirectorsIndexControl').click(function () {
                $('#DirectorsIndex').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>