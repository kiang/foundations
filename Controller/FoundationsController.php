<?php

App::uses('AppController', 'Controller');

class FoundationsController extends AppController {

    public $name = 'Foundations';
    public $paginate = array();
    public $helpers = array();

    function index() {
        $this->paginate['Foundation'] = array(
            'limit' => 20,
            'order' => array('Foundation.submitted' => 'DESC'),
        );
        $this->set('items', $this->paginate($this->Foundation, array('Foundation.active_id IS NULL')));
    }

    function view($id = null) {
        if (!$id || !$this->data = $this->Foundation->read(null, $id)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
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
