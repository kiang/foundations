<?php

App::uses('AppModel', 'Model');

class Foundation extends AppModel {

    var $name = 'Foundation';
    var $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field is required',
            ),
        ),
    );
    var $actsAs = array(
    );
    var $hasMany = array(
        'Director' => array(
            'foreignKey' => 'Foundation_id',
            'dependent' => false,
            'className' => 'Director',
        ),
    );

    function afterSave($created, $options = array()) {
        
    }

}
