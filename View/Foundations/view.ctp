<div id="FoundationsView" class="col-md-12">
    <h2><?php echo $this->data['Foundation']['name']; ?></h2>
    <hr>
    <p>&nbsp;</p>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">基本資料</h3>
        </div>
        <div class="panel-body">
            <p>&nbsp;</p>
            <dl class="dl-horizontal">
                <dt>類型</dt>
                <dd><?php echo $this->data['Foundation']['type']; ?>&nbsp;</dd>
                <dt>法人代表</dt>
                <dd><?php echo $this->data['Foundation']['representative']; ?>&nbsp; </dd>
                <dt>設立登記日期</dt>
                <dd><?php echo $this->data['Foundation']['founded']; ?>&nbsp; </dd>
                <dt>主事務所</dt>
                <dd><?php echo $this->data['Foundation']['address']; ?>&nbsp; </dd>
                <dt>目的</dt>
                <dd><?php echo $this->data['Foundation']['purpose']; ?>&nbsp; </dd>
                <dt>捐助方法</dt>
                <dd><?php echo $this->data['Foundation']['donation']; ?>&nbsp;</dd>
                <dt>許可機關日期</dt>
                <dd><?php echo $this->data['Foundation']['approved_by']; ?>&nbsp;</dd>
                <dt>財產總額</dt>
                <dd><span class="fund-currency"><?php echo $this->data['Foundation']['fund']; ?></span>&nbsp;</dd>
                <dt>異動日期</dt>
                <dd><?php echo $this->data['Foundation']['submitted']; ?>&nbsp;</dd>
                <dt>登錄法院</dt>
                <dd><?php echo $this->Olc->courts[$this->data['Foundation']['court']]; ?>&nbsp;</dd>
                <dt>功能</dt>
                <dd>
                    <div class="btn-group">
                        <a target="_blank" href="<?php echo "https://github.com/g0v/foundationtw/blob/master/{$this->data['Foundation']['url_id']}"; ?>" class="btn btn-success btn-sm">JSON 格式</a>
                        <a target="_blank" href="<?php echo $this->data['Foundation']['url']; ?>" class="btn btn-success btn-sm">原始連結</a>
                    </div>
                </dd>
            </dl>
            <p>&nbsp;</p>
        </div>
    </div>
   
    <p>&nbsp;</p>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">董監事</h3>
        </div>
        <div class="panel-body">
            <p>&nbsp;</p>
            <dl class="dl-horizontal">
                <?php
                foreach ($directors AS $director) {
                    echo $this->Html->tag('dt', $director['Director']['title']);
                    echo $this->Html->tag('dd', $this->Html->link($director['Director']['name'], '/directors/index/' . $director['Director']['name']));
                }
                ?>
            </dl>
        </div>
    </div>
    <p>&nbsp;</p>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">異動記錄</h3>
        </div>
        <div class="panel-body">
            <p>&nbsp;</p>
            <div class="row">
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
            <p>&nbsp;</p>
        </div>
    </div>
</div>
<?php echo $this->Html->script('index.js', array('inline' => false, 'block' => 'scriptBottom')); ?>