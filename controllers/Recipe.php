<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Recipe extends CI_Controller {
	public function __construct()
    {
        parent::__construct();        
		$this->load->helper('url');
		$this->load->model('authors');
		$this->load->model('articles');
		$this->load->model('article_types');
		$this->load->model('media');
		$this->load->model('article_media');
		$this->load->model('site_index');
		$this->load->model('subcategories');
		$this->load->model('article_status');
	}
	public function index()
	{
		$data=array();			
		$data['articles']=$this->articles->get_All_articles('RECIPE');
		foreach($data['articles'] as $article)
		{
			$article->authorName=$this->authors->get_NameBy_id($article->author_id)->name;			
		}
		$data['subview'] = $this->load->view('recipe/manage', $data, TRUE);
		$this->load->view('main_layout', $data);
	}
	public function add($id=null)
	{
		$data=array();
		if(isset($_POST['title']))
		{
			$rowData=array();
			$rowData['title']=$_POST['title'];
			$rowData['slug']=$_POST['slug'];
			$rowData['article_type_id']=$_POST['article_type_id'];
			$rowData['author_id']=$_POST['author_id'];
			if(!$id)
				$rowData['date_created']=date("Y-m-d");
			$rowData['date_published']=date("Y-m-d",strtotime($_POST['date_published']));
			$rowData['content']=$_POST['content'];
			$rowData['status_id']=$_POST['status_id'];			
			$rowData['meta_title']=$_POST['meta_title'];
			$rowData['meta_description']=$_POST['meta_description'];
			$rowData['meta_keywords']=$_POST['meta_keywords'];
			$rowData['og_title']=$_POST['og_title'];
			$rowData['og_description']=$_POST['og_description'];
			$rowData['twitter_title']=$_POST['twitter_title'];
			$rowData['twitter_description']=$_POST['twitter_description'];
			//$rowData['cat_id']=$_POST['category_id'];
			$rowData['subcategory_id']=$_POST['subcategory_id'];
			$articleId=$this->articles->insertData($rowData,$id);
			if($articleId)
			{
				if($id)
				{
					$data['message']='The Recipe is updated';				
				}
				else
				{
					$data['message']='The Recipe is added';
				}
				$data['type']='success';
			}
			else
			{
				$data['message']='Changes could not be made due to some error';	
				$data['type']='error';
			}
			$imageData=array();
			$articleMediaData=array();
			$slugData=array();
			//upload media
			if(isset($_FILES['main_media']))
			{
				$imgpath=IMAGE_URL.$_FILES['main_media']['name'];
				if(move_uploaded_file($_FILES['main_media']['tmp_name'],$imgpath))
				{
					$filename=$_FILES['main_media']['name'];
					$filenameArr=explode(".",$filename);					
					$imageData['name']=$filenameArr[0];
					$imageData['filename']=$_FILES['main_media']['name'];
					$imageData['type']='image';
					
					//add media to Media table
					$mediaId=$this->media->insertData($imageData);
					//add media link to articleMedia table
					$articleMediaData['article_id']=$articleId;
					$articleMediaData['media_id']=$mediaId;
					$articleMediaData['type']='main';
					$this->article_media->insertData($articleMediaData);
				}
			}
			if(isset($_FILES['preview_media']))
			{
				$imgpath1=IMAGE_URL.$_FILES['preview_media']['name'];
				if(move_uploaded_file($_FILES['preview_media']['tmp_name'],$imgpath1))
				{
					$filename=$_FILES['preview_media']['name'];
					$filenameArr=explode(".",$filename);					
					$imageData['name']=$filenameArr[0];
					$imageData['filename']=$_FILES['preview_media']['name'];
					$imageData['type']='image';
					
					//add media to Media table
					$mediaId=$this->media->insertData($imageData);
					//add media link to article_media table
					$articleMediaData['article_id']=$articleId;
					$articleMediaData['media_id']=$mediaId;
					$articleMediaData['type']='preview';
					$this->article_media->insertData($articleMediaData);
				}
			}
			if(isset($_FILES['thumbnail_media']))
			{
				$imgpath1=IMAGE_UPLOAD_URL.$_FILES['thumbnail_media']['name'];
				if(move_uploaded_file($_FILES['thumbnail_media']['tmp_name'],$imgpath1))
				{
					$filename=$_FILES['thumbnail_media']['name'];
					$filenameArr=explode(".",$filename);					
					$imageData['name']=$filenameArr[0];
					$imageData['filename']=$_FILES['thumbnail_media']['name'];
					$imageData['type']='image';
					
					//add media to Media table
					$mediaId=$this->media->insertData($imageData);
					//add media link to article_media table
					$articleMediaData['article_id']=$articleId;
					$articleMediaData['media_id']=$mediaId;
					$articleMediaData['type']='thumbnail';
					$this->article_media->insertData($articleMediaData);
				}
			}
			set_message($data['type'], $data['message']);
			if(!$id)
			{
				//add slug to site_index
				$siteIndexData['slug']=$rowData['slug'];
				$siteIndexData['type']='article';
				$this->site_index->insertData($siteIndexData);
				redirect('recipe');
			}
			if(isset($_POST['close']))
			{
				redirect('recipe');
			}
		}
		$data['articleTypes']=$this->article_types->get_All();
		$data['authors']=$this->authors->get_All_IdName();
		$data['category']=$this->articles->get_All_category();
		$data['article_status']=$this->article_status->get_All();
		if($id)
		{
			//Edit Article
			$data['title']='Edit Receipe';
			$data['buttonTitle']='Save Changes';
			$data['articleData']=$this->articles->get_by_id($id);	
			//get the parent category
			$data['catId']=$this->subcategories->getCatID($data['articleData']->subcategory_id);
			//load all the subcategories for this cat id
			$data['subCatIdArr']=$this->subcategories->getallSubCat($data['catId']);
		}
		else
		{
			//Add Article
			$data['buttonTitle']='Add Receipe';
			$data['title']='Add Receipe';
		}
		$data['subview'] = $this->load->view('recipe/add', $data, TRUE);
		$this->load->view('main_layout', $data);
	}
	public function delete($id)
	{
		$result=$this->articles->delete($id);
		if($result==1)
		{
			$data['message']='The Recipe is deleted';				
			$data['type']='success';
		}
		else
		{
			$data['message']=$result;				
			$data['type']='error';
		}
		set_message($data['type'], $data['message']);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>
