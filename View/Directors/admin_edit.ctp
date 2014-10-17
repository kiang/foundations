<div id="DirectorsAdminEdit">
    <?php echo $this->Form->create('Director', array('type' => 'file')); ?>
    <div class="Directors form">
        <fieldset>
            <legend><?php
                echo __('Edit Directors', true);
                ?></legend>
            <?php
            echo $this->Form->input('Director.id');
            foreach ($belongsToModels AS $key => $model) {
                echo $this->Form->input('Director.' . $model['foreignKey'], array(
                    'type' => 'select',
                    'label' => $model['label'],
                    'options' => $$key,
                    'div' => 'form-group',
                    'class' => 'form-control',
                ));
            }
            echo $this->Form->input('Director.name', array(
                'label' => 'Name',
                'div' => 'form-group',
                'class' => 'form-control',
            ));
            echo $this->Form->input('Director.title', array(
                'label' => 'Title',
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