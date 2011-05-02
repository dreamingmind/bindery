<?php
class ExhibitGalleriesController extends AppController {

    var $name = 'ExhibitGalleries';
    var $scaffold;
    var $components = array('TreeCrud');
    var $helpers = array(
        'TreeCrud'
    );
    var $paginate = array('order' => array('lft' => 'asc'));

    function manage_tree($id=null) {
        $this->set('treecrud_data',$this->TreeCrud->tree_crud($this->{$this->modelClass}));
    }

    function fix() {
        $this->ExhibitGallery->recover('tree');
        $this->redirect(array('controller'=>'exhibit_galleries', 'action'=>'manage_tree'));
    }


    function index() {
        $this->ExhibitGallery->recursive = 0;
        $galleries = $this->ExhibitGallery->Gallery->find('list');
        $this->set('galleries',$galleries);
        if ($this->data) {
            $data = $this->paginate = array(
                'conditions' => array('gallery_id' => $this->data['ExhibitGallery']['gallery_id']),
                'order' => 'ExhibitGallery.lft'
                ) ;
            $this->set('exhibitGalleries', $this->paginate());
            //$this->set('exhibitGalleries', $data);
        } else {
            $this->set('exhibitGalleries', $this->paginate());
        }
   }

    function view($id = null) {
        if (!$id) {
            $this->flash(sprintf(__('Invalid %s', true), 'exhibit gallery'), array('action' => 'index'));
        }
        $this->set('exhibitGallery', $this->ExhibitGallery->read(null, $id));
    }

    function add() {
            if (!empty($this->data)) {
                $this->ExhibitGallery->create();
                if ($this->ExhibitGallery->save($this->data)) {
                    $this->flash(sprintf(__('%s saved.', true), 'Exhibitgallery'), array('action' => 'index'));
                } else {
                }
            }
            $exhibits = $this->ExhibitGallery->Exhibit->find('list');
            $galleries = $this->ExhibitGallery->Gallery->find('list');
            $this->set(compact('exhibits', 'galleries'));
    }

    function edit($id = null) {
            if (!$id && empty($this->data)) {
                $this->flash(sprintf(__('Invalid %s', true), 'exhibit gallery'), array('action' => 'index'));
            }
            if (!empty($this->data)) {
                if ($this->ExhibitGallery->save($this->data)) {
                        $this->flash(sprintf(__('The %s has been saved.', true), 'exhibit gallery'), array('action' => 'index'));
                } else {
                }
            }
            if (empty($this->data)) {
                    $this->data = $this->ExhibitGallery->read(null, $id);
            }
            $exhibits = $this->ExhibitGallery->Exhibit->find('list');
            $galleries = $this->ExhibitGallery->Gallery->find('list');
            $this->set(compact('exhibits', 'galleries'));
    }

    function delete($id = null) {
            if (!$id) {
                    $this->flash(sprintf(__('Invalid %s', true), 'exhibit gallery'), array('action' => 'index'));
            }
            if ($this->ExhibitGallery->delete($id)) {
                    $this->flash(sprintf(__('%s deleted', true), 'Exhibit gallery'), array('action' => 'index'));
            }
            $this->flash(sprintf(__('%s was not deleted', true), 'Exhibit gallery'), array('action' => 'index'));
            $this->redirect(array('action' => 'index'));
    }
}
?>