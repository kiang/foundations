<?php

App::uses('AppModel', 'Model');

class Director extends AppModel {

    var $name = 'Director';
    var $actsAs = array(
    );
    var $belongsTo = array(
        'Foundation' => array(
            'foreignKey' => 'Foundation_id',
            'className' => 'Foundation',
        ),
    );

    function afterSave($created, $options = array()) {
        
    }

}
