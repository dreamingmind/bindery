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
//        debug($this->params);die;
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
            $this->Session->setFlash(__('Invalid workshop', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('workshop', $this->Workshop->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Workshop->create();
            if ($this->Workshop->save($this->data)) {
                $this->Session->setFlash(__('The workshop has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The workshop could not be saved. Please, try again.', true));
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid workshop', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Workshop->save($this->data)) {
                $this->Session->setFlash(__('The workshop has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The workshop could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Workshop->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for workshop', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Workshop->delete($id)) {
            $this->Session->setFlash(__('Workshop deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Workshop was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Return some batch of Content records sorted by article order
     * 
     * These are pulled for ContentCollection context so there may be
     * more be a variety of results.
     * $condition can look at 
     *      ContentCollection
     *      Collection
     *      Content
     * 
     * @param array $conditions The ContentCollection conditions for the query
     * @return boolean|array A batch of Content/Image records or false
     */
    function findWorkshopTarget($conditions = null) {
        if ($conditions == null) {
            return false;
        }
        return $this->Workshop->ContentCollection->find('all', array(
                    'fields' => array(
                        'ContentCollection.id',
                        'ContentCollection.content_id',
                        'ContentCollection.collection_id',
                        'ContentCollection.sub_slug'),
                    'contain' => array(
                        'Workshop' => array(
                            'fields' => array('Workshop.id', 'Workshop.category_id', 'Workshop.slug', 'Workshop.heading')
                        ),
                        'Content' => array(
                            'fields' => array('Content.id', 'Content.content', 'Content.heading', 'Content.modified', 'Content.slug'),
//                    'conditions'=>array('Workshop.publish'=>1),
                            'Image' => array(
                                'fields' => array('Image.alt', 'Image.title', 'Image.img_file',
                                    'Image.created', 'Image.date', 'Image.id')
                            )
                        )
                    ),
                    'order' => array(
                        'ContentCollection.seq ASC',
                        'ContentCollection.id ASC'
                    ),
                    'conditions' => $conditions
                ));
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
                'Workshop.slug' => $this->params['pname'],
//                'Workshop.role' => 'workshop'
               'Workshop.category_id' => $this->Workshop->Category->categoryNI['workshop']
            )
                ));
//        debug($collection);
//        debug($this->Workshop->workshops_all[$collection[0]['Workshop']['id']]);
//        debug($this->Workshop->workshops_all);
//        debug($this->Workshop->workshops_upcoming);
//        debug($this->Workshop->workshops_now);
//        debug($this->params);
        $article = $this->findWorkshopTarget(array('Content.slug' => $this->params['pname'], 'Workshop.category_id' => $this->Workshop->Category->categoryNI['workshop']));
        $this->set('feature', $this->Workshop->workshops_all[$article[0]['Workshop']['id']]);
        $this->set('upcoming', $this->Workshop->workshops_upcoming);
        $this->set('delete', array_shift($article));
        $this->set('article', $article);
//        debug($article);debug($this->Workshop->workshops_all);debug($this->Workshop->workshops_potential);die;
    }
/**
 * Ajax editing form for workshops
 * 
 * This function borrowed from contents_controller (was edit_dispatch)
 * 
 * @param int $id
 */
    function edit_workshop($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid content', true));
        }
        if (!empty($this->data)) {
            $this->params = unserialize($this->data['params']);
            $this->passedArgs = unserialize($this->data['passedArgs']);
            $message = ($this->Workshop->ContentCollection->Content->saveAll($this->data['Content'])) ? 'Content records saved' : 'Content record save failed';
            $message .= ($this->Workshop->ContentCollection->Content->Image->saveAll($this->data['Image'])) ? "<br />Image records saved" : "<br />Image record save failed";
            $this->Session->setFlash($message);
            $this->redirect('/' . $this->params['url']['url'] . '/#');
        }
        if (empty($this->data)) {
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

}

?>