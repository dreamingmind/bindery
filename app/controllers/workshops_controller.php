<?php
class WorkshopsController extends AppController {

	var $name = 'Workshops';
        /**
         * @var string $result_ImagePath picks the size of image in search result blocks
         */

        
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('upcoming');
        }
        
        function upcoming(){
//        debug($this->params);die;
            $this->set('upcoming', $this->Workshop->workshops_upcoming);
            $this->set('potential',  $this->Workshop->workshops_potential);
            $this->set('now', $this->Workshop->workshops_now);
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
                'Collection'=>array(
                    'fields'=>array('Collection.id','Collection.category_id','Collection.slug','Collection.heading')
                ),
                'Workshop'=>array(
                    'fields'=>array('Workshop.id','Workshop.content','Workshop.heading','Workshop.slug'),
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
//        $article = $this->findWorkshopTarget($conditions);
////        findBlogTarget() has proper blog array
//        $this->set('most_recent',$article);
//===================================
        // get the pname
        // and expand the url to full nest-length if necessary
        $url = preg_replace(
            array(
                '/[\/]?page:[0-9]+/',
                '/[\/]?id:[0-9]+/'
            ), '', $this->params['url']['url']);
        $target = explode('/', $url);
        // extract the last non-page/non-id bit off the url as pname
        $this->params['pname'] = $target[count($target)-1];
//        debug($this->params);
//                debug($url);
//                                debug($target);
        if(count($target)==2){
            // found possible shortcut URL like
            // /art/so-different
            // if it is, we'll construct the true path and redirect
            
            // first get the tree path to the current pname
            $nav = $this->Navigator->find('all',array(
                'conditions'=>array(
                    'Navline.route'=>  $this->params['pname']
                )
            ));
            $nav = $this->Navigator->getpath($nav[0]['Navigator']['id'],null,'1');

            // then if it is longer that the current path, 
            // then it was a shortcut. build and redirect
            if(count($target) < count($nav)){
                $path = '';
                foreach($nav as $node){
                    $path .= DS.$node['Navline']['route'];
                }
                $this->redirect($path);
            }
        }
        
        // we now have a full url and a pname
        // get a paginated filmstrip and an beauty shot
        $conditions = array(
            'Collection.category_id'=>$this->Workshop->ContentCollection->Collection->Category->categoryNI['workshop'],
            'ContentCollection.publish'=>1,'Workshop.slug'=>$this->params['pname']);
        
        debug($this->findWorkshopTarget($conditions));die;

        if(empty($this->viewVars['filmStrip'])){
            // didn't find any Content records for pname
            // scrap the thumbnailPage layout
            $this->layout = 'noThumbnailPage';
            // and get some links for nested art inside this node
            // so we can make a landing page with links
            $nav = $this->Navigator->find('all',array(
                'conditions'=>array(
                    'Navline.route'=>  $this->params['pname']
                )
            ));
            
            // since we don't have a beauty-shot gallery, lets
            // plumb the menu-nest and show some deep links
            $nav = $this->Navigator->children($nav[0]['Navigator']['id'], false, null, null, null, 1, 1);
            $deepLinks = array();
            if(!empty($nav)){
                // found nested nodes, look for Content for them
                foreach($nav as $node){
                    $slug = $node['Navline']['route'];
                    $content = $this->Content->ContentCollection->nodeMemeber($node['Navline']['route']);
                    if($content){
                        $deepLinks[] = $content;
                    }
                }
                // should have some Content now for art/edition link construction
                // if there are a lot, get 3 random ones for output
                if(count($deepLinks)>3){
                    shuffle($deepLinks);
                    $chunk = array_chunk($deepLinks, 3);
                    $deepLinks = $chunk[0];
                }
            }
            $this->set('deepLinks',$deepLinks);
            
            //@todo TODO ================================ TODO
            // and finally, see if we have any LIKE %pname% blog articles to offer as reprints
        }
        
        // searh should be fixed to maintain its own default array
        // now we've either got a beauty shot and paginated filmstrip
        // or a set of representative projects from deeper levels
        // of this pname menu-nest

        $details = array();
        $count = 0;
        foreach($this->viewVars['neighbors'] as $detail){
            if($detail['detail'] > 0){
                $details[$count] = $this->Content->ContentCollection->pullArticleLink($detail['detail']);
            }
        }
        $this->set('details',$details);
        
        // This makes the page header
        $this->set('collection', $this->Content->ContentCollection->Collection->find('first',array(
            'conditions'=> array(
                'Collection.category_id' => $this->categoryNI['art'],
                'Collection.slug' => $this->params['pname']
            ),
            'recursive' => -1
        )));
        
        $searchResults = $this->Content->siteSearch(array(
//            'Content.heading' => $this->viewVars['collection']['Collection']['heading']
            'Content.heading' => 'Art & Editions'
        ));
        $this->set('searchResults', isset($searchResults['dispatch'])?$searchResults['dispatch']:'');
        
        // do the data pulls for any sub_collections use ContentCollection.id
//        debug($this->Content->ContentCollection->pullArticleLink(546));

    }

}
?>