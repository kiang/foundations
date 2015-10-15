<div class="col-md-12">
    <?php
    echo $this->Form->create('Member', array('action' => 'login'));
    echo $this->Form->input('username', array('class' => 'form-control'));
    echo $this->Form->input('password', array('class' => 'form-control'));
    echo '<p>&nbsp;</p>';
    echo $this->Form->submit('登入', array('class' => 'btn btn-primary btn-lg'));
    echo $this->Form->end();
    ?>
</div>