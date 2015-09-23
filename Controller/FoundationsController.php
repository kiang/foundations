<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class FoundationsController extends AppController {

    public $name = 'Foundations';
    public $paginate = array();
    public $helpers = array('Olc');

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('index', 'view');
        }
    }

    function index($name = null) {
        $cPage = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : '1';
        $cSort = isset($this->request->params['named']['sort']) ? $this->request->params['named']['sort'] : '';
        $cDirection = isset($this->request->params['named']['direction']) ? $this->request->params['named']['direction'] : '';
        $cacheKey = "FoundationsIndex{$cSort}{$cDirection}{$name}{$cPage}";
        $result = Cache::read($cacheKey, 'long');
        if (!$result) {
            $result = array();
            $scope = array(
                'Foundation.active_id IS NULL',
            );
            if (!empty($name)) {
                $name = Sanitize::clean($name);
                $scope['Foundation.name LIKE'] = "%{$name}%";
            }
            $this->paginate['Foundation'] = array(
                'limit' => 20,
                'order' => array('Foundation.submitted' => 'DESC'),
            );

            $result['items'] = $this->paginate($this->Foundation, $scope);
            $result['paging'] = $this->request->params['paging'];
            Cache::write($cacheKey, $result, 'long');
        } else {
            $this->request->params['paging'] = $result['paging'];
        }

        $this->set('url', array($name));
        if (!empty($name)) {
            $name = "{$name} 相關";
        }
        $this->set('title_for_layout', $name . '法人一覽 @ ');
        $this->set('items', $result['items']);
    }

    function view($id = null) {
        if (!empty($id)) {
            $this->data = $this->Foundation->find('first', array(
                'conditions' => array('Foundation.id' => $id),
            ));
            if (!empty($this->data['Foundation']['linked_id'])) {
                $linkedId = $this->data['Foundation']['linked_id'];
            } elseif (isset($this->data['Foundation']['id'])) {
                $linkedId = $this->data['Foundation']['id'];
            }
            if (!empty($this->data['Foundation']['active_id'])) {
                $activeId = $this->data['Foundation']['active_id'];
            } elseif (isset($this->data['Foundation']['id'])) {
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
            $this->set('title_for_layout', $this->data['Foundation']['name'] . ' @ ');
            $this->set('desc_for_layout', "{$this->data['Foundation']['name']} {$this->data['Foundation']['purpose']} / ");
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
