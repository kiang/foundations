<?php

App::uses('AppController', 'Controller');

class FoundationsController extends AppController {

    public $name = 'Foundations';
    public $paginate = array();
    public $helpers = array();

    function index($name = null) {
        $scope = array(
            'Foundation.active_id IS NULL',
        );
        if (!empty($name)) {
            $scope['Foundation.name LIKE'] = "%{$name}%";
        }
        $this->paginate['Foundation'] = array(
            'limit' => 20,
            'order' => array('Foundation.submitted' => 'DESC'),
        );
        $this->set('url', array($name));
        $this->set('items', $this->paginate($this->Foundation, $scope));
    }

    function view($id = null) {
        if (!empty($id)) {
            $this->data = $this->Foundation->find('first', array(
                'conditions' => array('Foundation.id' => $id),
            ));
            if (!empty($this->data['Foundation']['linked_id'])) {
                $linkedId = $this->data['Foundation']['linked_id'];
            } else {
                $linkedId = $this->data['Foundation']['id'];
            }
            if (!empty($this->data['Foundation']['active_id'])) {
                $activeId = $this->data['Foundation']['active_id'];
            } else {
                $activeId = $this->data['Foundation']['id'];
            }
        }
        if (empty($this->data)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        } else {
            $directors = $this->Foundation->Director->find('all', array(
                'conditions' => array('Director.Foundation_id' => $linkedId),
            ));
            $logs = $this->Foundation->find('list', array(
                'conditions' => array(
                    'OR' => array(
                        'Foundation.active_id' => $activeId,
                        'Foundation.id' => $activeId,
                    ),
                ),
                'fields' => array('id', 'submitted'),
                'order' => array('Foundation.submitted' => 'DESC'),
            ));
            $this->set('directors', $directors);
            $this->set('logs', $logs);
        }
    }

    function admin_index() {
        $this->paginate['Foundation'] = array(
            'limit' => 20,
        );
        $this->set('items', $this->paginate($this->Foundation, array('Foundation.active_id IS NULL')));
    }

    function admin_view($id = null) {
        if (!$id || !$this->data = $this->Foundation->read(null, $id)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Foundation->create();
            if ($this->Foundation->save($this->data)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            if ($this->Foundation->save($this->data)) {
                $this->Session->setFlash(__('The data has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Something was wrong during saving, please try again', true));
            }
        }
        $this->set('id', $id);
        $this->data = $this->Foundation->read(null, $id);
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Please do following links in the page', true));
        } else if ($this->Foundation->delete($id)) {
            $this->Session->setFlash(__('The data has been deleted', true));
        }
        $this->redirect(array('action' => 'index'));
    }

}
