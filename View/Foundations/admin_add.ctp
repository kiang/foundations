<div id="FoundationsAdminAdd">
        <?php echo $this->Form->create('Foundation', array('type' => 'file')); ?>
    <div class="Foundations form">
        <fieldset>
            <legend><?php
                echo __('Add Foundations', true);
                ?></legend>
            <?php
            echo $this->Form->input('Foundation.active_id', array(
                'label' => 'Active ID',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.name', array(
                'label' => 'Name',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.type', array(
                'label' => 'Type',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.representative', array(
                'label' => 'Representative',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.founded', array(
                'label' => 'Founded',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.address', array(
                'label' => 'Address',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.purpose', array(
                'rows' => '4',
                'cols' => '20',
                'label' => 'Purpose',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.donation', array(
                'label' => 'Donation',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.approved_by', array(
                'label' => 'Approved By',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.fund', array(
                'label' => 'Fund',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Foundation.closed', array(
                'label' => 'Closed',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            ?>
        </fieldset>
    </div>
        <?php
    echo $this->Form->end(__('Submit', true));
    ?>
</div>