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
        $this->set('upcoming', $this->Workshop->workshops_upcoming);
        $this->set('potential',  $this->Workshop->workshops_potential);
        $this->set('now', $this->Workshop->workshops_now);
        }
        
        function upcoming(){
//        debug($this->params);die;
//            $this->set('result_imagePath');
            $this->layout = 'noThumbnailPage';
        }

	function index() {
		$this->Workshop->recursive = 0;
		$this->set('workshops', $this->paginate('Workshop'));
                debug($this->viewVars['workshops']);die;
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
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Workshop->delete($id)) {
			$this->Session->setFlash(__('Workshop deleted', true));
			$this->redirect(array('action'=>'index'));
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
    function findWorkshopTarget($conditions = null){
        if($conditions == null){
            return false;
        }
        return $this->Workshop->ContentCollection->find('all',array(
            'fields'=>array(
                'ContentCollection.id', 
                'ContentCollection.content_id',
                'ContentCollection.collection_id',
                'ContentCollection.sub_slug'),
            'contain'=>array(
                'Workshop'=>array(
                    'fields'=>array('Workshop.id','Workshop.category_id','Workshop.slug','Workshop.heading')
                ),
                'Content'=>array(
                    'fields'=>array('Content.id','Content.content','Content.heading','Content.modified','Content.slug'),
//                    'conditions'=>array('Workshop.publish'=>1),
                    'Image'=>array(
                        'fields'=>array('Image.alt','Image.title','Image.img_file',
                            'Image.created', 'Image.date','Image.id')
                    )
                )
            ),
            'order'=>array(
                'ContentCollection.seq ASC',
                'ContentCollection.id ASC'
            ),
            'conditions' => $conditions
        ));        
    }

        
    function detail(){
//        
        $article = $this->findWorkshopTarget(array('Content.slug' => $this->params['pass'][0],'Workshop.category_id'=>$this->Workshop->Category->categoryNI['workshop']));
        
        
        $this->layout='noThumbnailPage';
        $this->set('feature',  $this->Workshop->workshops_all[$article[0]['Workshop']['id']]);
        $this->set('delete',array_shift($article));
        $this->set('article',$article);
//        debug($article);debug($this->Workshop->workshops_all);debug($this->Workshop->workshops_potential);die;
    }
}
?>