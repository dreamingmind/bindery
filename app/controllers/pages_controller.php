<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.com)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Output
 */
/**
 * Pages Controller
 * 
 * @package       bindery
 * @subpackage    bindery.Output
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';

/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array('Content');

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
            $this->layout = 'HomePage';
            $this->css[] = 'home';
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
                $records = $this->Content->find('all',array(
                    'fields'=>array('id'),
                    'recursive'=>0,
                    'conditions'=>array('slug LIKE' => '%home%'),
                    'order' => array('Content.modified DESC')
                ));
//                debug($records);die;
                $target = rand(0, count($records)-1);
        $this->set('recentNews',  $this->Content->recentNews(1));
        $this->set('recentExhibits',$this->Content->recentExhibits(1));
                $record = $this->Content->find('all',array(
                        'contain'=>array(
                            'Image'
                        ),
                        'conditions' => array('Content.id' => $records[$target]['Content']['id']))
                    );
                $this->set('record',$record);
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
}
