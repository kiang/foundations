<div id="FoundationsAdminView">
    <h3><?php echo __('View Foundations', true); ?></h3><hr />
    <div class="col-md-12">

        <div class="col-md-2">Active ID</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['active_id']) {

                echo $this->data['Foundation']['active_id'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Name</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['name']) {

                echo $this->data['Foundation']['name'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Type</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['type']) {

                echo $this->data['Foundation']['type'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Representative</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['representative']) {

                echo $this->data['Foundation']['representative'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Founded</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['founded']) {

                echo $this->data['Foundation']['founded'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Address</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['address']) {

                echo $this->data['Foundation']['address'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Purpose</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['purpose']) {

                echo $this->data['Foundation']['purpose'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Donation</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['donation']) {

                echo $this->data['Foundation']['donation'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Approved By</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['approved_by']) {

                echo $this->data['Foundation']['approved_by'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Fund</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['fund']) {

                echo $this->data['Foundation']['fund'];
            }
?>&nbsp;
        </div>
        <div class="col-md-2">Closed</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Foundation']['closed']) {

                echo $this->data['Foundation']['closed'];
            }
?>&nbsp;
        </div>
    </div>
    <hr />
    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Foundation.id')), null, __('Delete the item, sure?', true)); ?></li>
            <li><?php echo $this->Html->link(__('Foundations List', true), array('action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('View Related Directors', true), array('controller' => 'directors', 'action' => 'index', 'Foundation', $this->data['Foundation']['id']), array('class' => 'FoundationsAdminViewControl')); ?></li>
        </ul>
    </div>
    <div id="FoundationsAdminViewPanel"></div>
<?php
echo $this->Html->scriptBlock('

');
?>
    <script type="text/javascript">
        //<![CDATA[
        $(function() {
            $('a.FoundationsAdminViewControl').click(function() {
                $('#FoundationsAdminViewPanel').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>