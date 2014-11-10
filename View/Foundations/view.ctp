<div id="FoundationsView">
    <h3><?php echo $this->data['Foundation']['name']; ?></h3>
    <div class="col-md-12">
        <div class="col-md-2">類型</div>
        <div class="col-md-10"><?php echo $this->data['Foundation']['type']; ?>&nbsp;</div>
        <div class="col-md-2">法人代表</div>
        <div class="col-md-10"><?php echo $this->data['Foundation']['representative']; ?>&nbsp; </div>
        <div class="col-md-2">設立登記日期</div>
        <div class="col-md-10"><?php echo $this->data['Foundation']['founded']; ?>&nbsp; </div>
        <div class="col-md-2">主事務所</div>
        <div class="col-md-10"><?php echo $this->data['Foundation']['address']; ?>&nbsp; </div>
        <div class="col-md-2">目的</div>
        <div class="col-md-10"><?php echo $this->data['Foundation']['purpose']; ?>&nbsp; </div>
        <div class="col-md-2">捐助方法</div>
        <div class="col-md-10"><?php echo $this->data['Foundation']['donation']; ?>&nbsp;</div>
        <div class="col-md-2">許可機關日期</div>
        <div class="col-md-10"><?php echo $this->data['Foundation']['approved_by']; ?>&nbsp;</div>
        <div class="col-md-2">財產總額</div>
        <div class="col-md-10"><span class="fund-currency"><?php echo $this->data['Foundation']['fund']; ?></span>&nbsp;</div>
        <div class="col-md-2">異動日期</div>
        <div class="col-md-10"><?php echo $this->data['Foundation']['submitted']; ?>&nbsp;</div>
        <div class="col-md-2">登錄法院</div>
        <div class="col-md-10"><?php echo $this->Olc->courts[$this->data['Foundation']['court']]; ?>&nbsp;</div>
        <div class="col-md-2">功能</div>
        <div class="col-md-10 btn-group">
            <?php $prefix = substr($this->data['Foundation']['url_id'], -3); ?>
            <a target="_blank" href="<?php echo "https://github.com/g0v/foundationtw/blob/master/output/details/{$this->data['Foundation']['court']}/{$prefix}/{$this->data['Foundation']['url_id']}.json"; ?>" class="btn btn-default">JSON 格式</a>
            <a target="_blank" href="<?php echo $this->data['Foundation']['url']; ?>" class="btn btn-default">原始連結</a>
        </div>
    </div>
    <div class="clearfix"><br /></div>
    <h3>董監事</h3>
    <div class="col-md-12">
        <?php
        foreach ($directors AS $director) {
            ?><div class="col-md-2">
                <?php echo $director['Director']['title']; ?>：
                <?php echo $this->Html->link($director['Director']['name'], '/directors/index/' . $director['Director']['name']); ?>
            </div><?php
        }
        ?>
    </div>
    <div class="clearfix"><br /></div>
    <h3>異動記錄</h3>
    <div class="clearfix"><br /></div>
    <div class="col-md-12">
        <?php
        $firstCol = true;
        foreach ($logs AS $id => $submitted) {
            if (!$firstCol) {
                echo '<div class="col-md-2">';
                if ($id !== $this->data['Foundation']['id']) {
                    echo $this->Html->link($submitted, '/foundations/view/' . $id);
                } else {
                    echo '<strong>' . $submitted . '</strong>';
                }
                echo '</div>';
            } else {
                $firstCol = false;
                echo '<div class="col-md-12">';
                if ($id !== $this->data['Foundation']['id']) {
                    echo $this->Html->link($submitted, '/foundations/view/' . $id);
                } else {
                    echo '<strong>' . $submitted . '</strong>';
                }
                echo '</div>';
            }
        }
        ?>
    </div>
    <div class="clearfix"><br /></div>
    <script>
        $(function () {
            $('span.fund-currency').each(function () {
                $(this).html(zhutil.approximate($(this).html(), {base: '萬', extra_decimal: 0}));
            });
        })
    </script>
</div>