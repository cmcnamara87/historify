<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ApiController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Api';

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
 
 	public function search($searchterm,$page=1,$forcerefresh=false) {
	 	$data = $this->Trove->search($searchterm,$page,$forcerefresh);
	 	header('Content-Type: application/json');
	 	echo json_encode($data);
	 	die();
 	}
 	
 	public function testgeo($location) {
	 	print_r($this->Trove->getGeo($location));
	 	die();
 	}
 	
 	public function newstory() {
	 	$data = array();
	 	$postdata = json_decode(file_get_contents('php://input'));
	 	/*if(!isset($postdata->title) || !isset($postdata->description)) {
		 	echo 'POST Fields required: name,description,slugline';
		 	die();
	 	}*/
	 	$data['name'] = $postdata->title;
	 	$data['description'] = $postdata->description;
	 	//$data['slugline'] = $postdata->slugline;
	 	$data['author'] = $postdata->author;
	 	$this->Story->create();
	 	if($this->Story->save($data)) {
	 		$story_id = $this->Story->id;
	 		foreach($postdata->items as $item) {
		 		$newitem = array();
		 		$newitem['story_id'] = $story_id;
		 		$newitem['data'] = json_encode($item);
		 		$this->Article->create();
		 		$this->Article->save($newitem);
	 		}
		 	echo $story_id;
		 	die();
	 	}
 	}
 	
 	public function stories() {
	 	$stories = $this->Story->find('all');
	 	header('Content-Type: application/json');
	 	echo json_encode($stories);
	 	die();
 	}
 	
 	public function getarticles() {
	 	$articles = $this->Article->find('all');
	 	$this->set('articles',$articles);
 	}
 	
 	public function story($story_id) {
 		$story = $this->Story->find('first',array('conditions'=>array('Story.id'=>$story_id)));
 		$story = $story['Story'];
 		$story['items'] = array();
	 	$items = $this->Article->find('all',array('conditions'=>array('story_id'=>$story_id)));
	 	foreach($items as $item) {
	 		$newitem = $item['Article'];
	 		$newitem = json_decode($newitem['data']);
		 	$story['items'][] = $newitem;
	 	}
	 	header('Content-Type: application/json');
	 	echo json_encode($story);
	 	die();
 	}
 	
 	public function articles($story_id=0) {
 		$articles = array();
	 	if($story_id>0) {
		 	$articles = $this->Article->find('all',array('conditions'=>array('story_id'=>$story_id)));
	 	} else {
		 	$articles = $this->Article->find('all');
	 	}
	 	header('Content-Type: application/json');
	 	echo json_encode($articles);
	 	die();
 	}
 	
 	public function savearticle() {
	 	$data = array();
	 	if(!isset($_POST['article_id']) || !isset($data['pdfurl'])) {
		 	echo 'POST Fields required: story_id,data';
		 	die();
	 	}
	 	$data['article_id'] = $_POST['article_id'];
	 	$data['title'] = $_POST['title'];
	 	$data['story_id'] = $_POST['story_id'];
	 	$data['heading'] = $_POST['heading'];
	 	$data['date'] = $_POST['date'];
	 	$data['snippet'] = $_POST['snippet'];
	 	$data['imageurl'] = $_POST['imageurl'];
	 	$data['fulltexturl'] = $_POST['fulltexturl'];
	 	$data['latitude'] = $_POST['latitude'];
	 	$data['longitude'] = $_POST['longitude'];
	 	$data['pdfurl'] = $_POST['pdfurl'];
	 	$this->Article->create();
	 	if($this->Article->save($data)) {
		 	echo 'done';
		 	die();
	 	}
 	}
 	
 	public function image($article_id) {
	 	$filename = $this->Trove->image($article_id);
	 	$file_extension = strtolower(substr(strrchr($filename,"."),1));
        switch ($file_extension) {
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpe": case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            default: $ctype="application/force-download";
        }
	 	header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: $ctype");
        header("Content-Transfer-Encoding: binary");
        set_time_limit(0);
        @readfile("$filename") or die("File not found.");
        die();
 	}
 	
 	public function fulltext($article_id) {
	 	$data = $this->Trove->getfulltext($article_id);
	 	header('Content-Type: application/json');
	 	echo json_encode($data);
	 	die();
 	}
 	
 	public function photos() {
	 	$photos = array();
	 	$this->set('photos',$photos);
 	}
 
	public function display() {
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
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
}
