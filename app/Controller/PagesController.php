<?php


App::uses('PagesController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Article','Story');
	
	public $components = array('Trove');

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
 
 	public function home() {
 		$stories = $this->Story->find('all');
 		foreach($stories as &$story) {
 			$story['Story']['articlelength'] = $this->Article->find('count',array('conditions'=>array('story_id'=>$story['Story']['id'])));
 		}
 		$this->set('stories',$stories);
 	}
 	
 	public function create() {
	 	
 	}
}
