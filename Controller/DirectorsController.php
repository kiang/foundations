<?php

App::uses('AppController', 'Controller');

class DirectorsController extends AppController {

    public $name = 'Directors';
    public $paginate = array();
    public $helpers = array();

    function index($name = null) {
        if (!empty($name)) {
            $this->paginate['Director'] = array(
                'fields' => array(
                    'Director.title',
                    'Foundation.id',
                    'Foundation.name',
                    'Foundation.submitted',
                ),
                'limit' => 20,
                'contain' => array(
                    'Foundation',
                ),
                'order' => array(
                    'Foundation.submitted' => 'DESC',
                ),
            );
            $items = $this->paginate($this->Director, array('Director.name' => $name));
        }
        if (!empty($items)) {
            $this->set('items', $items);
            $this->set('url', array($name));
            $this->set('name', $name);
        } else {
            $this->Session->setFlash('輸入的條件找不到結果');
            $this->redirect('/');
        }
    }

    function admin_index($foreignModel = null, $foreignId = 0, $op = null) {
        $foreignId = intval($foreignId);
        $foreignKeys = array();

        $foreignKeys = array(
            'Foundation' => 'Foundation_id',
        );


        $scope = array();
        if (array_key_exists($foreignModel, $foreignKeys) && $foreignId > 0) {
            $scope['Director.' . $foreignKeys[$foreignModel]] = $foreignId;
        } else {
            $foreignModel = '';
        }
        $this->set('scope', $scope);
        $this->paginate['Director']['limit'] = 20;
        $items = $this->paginate($this->Director, $scope);

        $this->set('items', $items);
        $this->set('foreignId', $foreignId);
        $this->set('foreignModel', $foreignModel);
    }

    function admin_view($id = null) {
        if (!$id || !$this->data = $this->Director->read(null, $id)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_add($foreignModel = null, $foreignId = 0) {
        $foreignId = intval($foreignId);
        $foreignKeys = array(
            'Foundation' => 'Foundation_id',
        );
        if (array_key_exists($foreignModel, $foreignKeys) && $foreignId > 0) {
            if (!empty($this->data)) {
                $this->data['Director'][$foreignKeys[$foreignModel]] = $foreignId;
            }
        } else {
            $foreignModel = '';
        }
        if (!empty($this->data)) {
            $this->Director->create();
            if ($this->Director->save($this->data)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
        $this->set('foreignId', $foreignId);
        $this->set('foreignModel', $foreignModel);

        $belongsToModels = array(
            'listFoundation' => array(
                'label' => 'Foundations',
                'modelName' => 'Foundation',
                'foreignKey' => 'Foundation_id',
            ),
        );

        foreach ($belongsToModels AS $key => $model) {
            if ($foreignModel == $model['modelName']) {
                unset($belongsToModels[$key]);
                continue;
            }
            $this->set($key, $this->Director->$model['modelName']->find('list'));
        }
        $this->set('belongsToModels', $belongsToModels);
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->Director->save($this->data)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
        $this->set('id', $id);
        $this->data = $this->Director->read(null, $id);

        $belongsToModels = array(
            'listFoundation' => array(
                'label' => 'Foundations',
                'modelName' => 'Foundation',
                'foreignKey' => 'Foundation_id',
            ),
        );

        foreach ($belongsToModels AS $key => $model) {
            $this->set($key, $this->Director->$model['modelName']->find('list'));
        }
        $this->set('belongsToModels', $belongsToModels);
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Please do following links in the page', true));
        } else if ($this->Director->delete($id)) {
            $this->Session->setFlash(__('The data has been deleted', true));
        }
        $this->redirect(array('action' => 'index'));
    }

}
