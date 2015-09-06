<?php
class Page {

	private $each_disNum;
	private $count;
	private $current_page;
	private $each_dispage;
	private $page_link;
	private $page_nums;
	private $type;
	public function __construct(){}
	
	public function pageSheet($each_disNum, $count, $current_page, $each_dispage, $page_link, $type){
		$this->each_disNum = intval($each_disNum);
	}


    public function currentPage () {


    }


}



$page = new Page();

$page->pageSheet();












