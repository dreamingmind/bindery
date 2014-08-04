<?php

class WorkshopsController extends AppController {

    var $name = 'Workshops';

    /**
     * @var string $result_ImagePath picks the size of image in search result blocks
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('upcoming');
        $this->Auth->allow('detail');
        $this->css[] = 'workshop';
    }

    function beforeRender() {
        parent::beforeRender();
    }

    function upcoming() {
//        debug($this->request->params);die;
//            $this->set('result_imagePath');
        $this->Workshop->workshopsFeatured();
        $this->removeFeaturedDuplicate();
        $key=array_keys($this->Workshop->workshops_featured);
        $this->set('feature', $this->Workshop->workshops_featured[$key[0]]);
        $this->set('upcoming', $this->Workshop->workshops_upcoming);
        $this->set('potential', $this->Workshop->workshops_potential);
        $this->set('now', $this->Workshop->workshops_now);
        //unset the fetured element from the appropriate returned data
        $this->layout = 'noThumbnailPage';
    }
    
    function removeFeaturedDuplicate() {
        if (isset($this->Workshop->workshops_featured['source'])){
            $source=$this->Workshop->workshops_featured['source'];
            unset($this->Workshop->workshops_featured['source']);
//            debug(array_keys($this->Workshop->workshops_featured));
            $key=array_keys($this->Workshop->workshops_featured);
//            debug($key[0]);debug($source);
            switch ($source){
                case "workshops_now":
                    unset($this->Workshop->workshops_now[$key[0]]);
                break;
                case "workshops_potential":                    
                    unset($this->Workshop->workshops_potential[$key[0]]);
                break;
                case "workshops upcoming":
                    unset($this->Workshop->workshops_upcoming[$key[0]]);
                break;
            }
        }
        
    }

    function index() {
        $this->Workshop->recursive = 0;
        $this->set('workshops', $this->paginate('Workshop'));
        debug($this->viewVars['workshops']);
        die;
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid workshop'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('workshop', $this->Workshop->read(null, $id));
    }

    function add() {
        if (!empty($this->request->data)) {
            $this->Workshop->create();
            if ($this->Workshop->save($this->request->data)) {
                $this->Session->setFlash(__('The workshop has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The workshop could not be saved. Please, try again.'));
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__('Invalid workshop'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Workshop->save($this->request->data)) {
                $this->Session->setFlash(__('The workshop has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The workshop could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Workshop->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for workshop'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Workshop->delete($id)) {
            $this->Session->setFlash(__('Workshop deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Workshop was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    function detail() {
//        
        $this->layout = 'noThumbnailPage';
        $this->expandShortUrl();
        //test if pname has content or is a collection
        //If No content
        //Search for 
        $collection = $this->Workshop->find('first', array(
            'fields' => array(
                'Workshop.id'
            ),
            'contain' => false,
            'conditions' => array(
                'Workshop.slug' => $this->request->params['pname'],
               'Workshop.category_id' => $this->Workshop->Category->categoryNI['workshop']
            )
                ));
        $article = $this->Workshop->ContentCollection->findWorkshopTarget(array('Content.slug' => $this->request->params['pname'], 'Workshop.category_id' => $this->Workshop->Category->categoryNI['workshop']));
        $this->set('feature', $this->Workshop->workshops_all[$article[0]['Workshop']['id']]);
        $this->set('upcoming', $this->Workshop->workshops_upcoming);
        $this->set('delete', array_shift($article));
        $this->set('article', $article);
    }
/**
 * Ajax editing form for workshops
 * 
 * This function borrowed from contents_controller (was edit_dispatch)
 * 
 * @param int $id
 */
    function edit_workshop($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__('Invalid content'));
        }
        if (!empty($this->request->data)) {
            $this->request->params = unserialize($this->request->data['params']);
            $this->passedArgs = unserialize($this->request->data['passedArgs']);
            $message = ($this->Workshop->ContentCollection->Content->saveAll($this->request->data['Content'])) ? 'Content records saved' : 'Content record save failed';
            $message .= ($this->Workshop->ContentCollection->Content->Image->saveAll($this->request->data['Image'])) ? "<br />Image records saved" : "<br />Image record save failed";
            $this->Session->setFlash($message);
            $this->redirect('/' . $this->request->params['url']['url'] . '/#');
        }
        if (empty($this->request->data)) {
            $this->layout = 'ajax';
            $packet = $this->Workshop->ContentCollection->Content->find('all', array(
                'contain' => array(
                    'Image',
                    'ContentCollection' => array(
                        'Collection' => array( //changed from 'Collection' to 'Workshop'
                            'Category'
                        )
                    )
                ),
                'conditions' => array('Content.id' => $id)
                    ));
            $record[0]['Content'][$packet[0]['Content']['id']] = $packet[0]['Content'];
            $record[0]['Image'][$packet[0]['Content']['id']] = $packet[0]['Image'];
            $this->set('linkNumber', $packet[0]['Content']['id']);
            $this->set('packet', $record);
//        // now pull unpublished images. Those are potential
//        // inline images.
            $iiLinks = $this->unpubImageLinks($_POST['collection'][0], $_POST['slug']);
            $this->set('iiLinks', $iiLinks);
        }
//        $this->Session->setFlash('a test message');
    }
/*
 * Test
 * 
 */

    function test(){
        if(isset($this->request->data)){
            debug($this->request->data);
        }
    }   

    function edit_session($slug){
    $this->layout = 'noThumbnailPage';
    $article = $this->Workshop->ContentCollection->findWorkshopTarget(array('Content.slug' => $slug, 'Workshop.category_id' => $this->Workshop->Category->categoryNI['workshop']));
    $this->set('feature', $this->Workshop->workshops_all[$article[0]['Workshop']['id']]);

    }
    
}
?>