<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Author extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();        
		$this->load->helper('url');
		$this->load->model('authors');
		$this->load->model('media');
		$this->load->model('author_media');
		$this->load->model('site_index');
		$this->load->model('author_types');
	}
	public function index()
	{
		$data=array();			
		$data['authors']=$this->authors->get_All();
		$data['subview'] = $this->load->view('author/manage', $data, TRUE);
		$this->load->view('main_layout', $data);
	}
	public function add($id=null)
	{
		$data=array();
		
		if(isset($_POST['name']))
		{
			$rowData=array();
			$rowData['name']=$_POST['name'];
			$rowData['slug']=$_POST['slug'];
			$rowData['date_joined']=date("Y-m-d",strtotime($_POST['date_joined']));
			$rowData['content']=$_POST['content'];
			$rowData['preview_text']=$_POST['preview_text'];			
			$rowData['meta_title']=$_POST['meta_title'];
			$rowData['meta_description']=$_POST['meta_description'];
			$rowData['meta_keywords']=$_POST['meta_keywords'];
			$rowData['og_title']=$_POST['og_title'];
			$rowData['author_type_id']=$_POST['author_type_id'];	
			$rowData['og_description']=$_POST['og_description'];
			$rowData['twitter_title']=$_POST['twitter_title'];
			$rowData['twitter_description']=$_POST['twitter_description'];
			$authorId=$this->authors->insertData($rowData,$id);
			if($authorId)
			{
				if($id)
				{
					$data['message']='The Author is updated';				
				}
				else
				{
					$data['message']='The Author is added';
				}
				$data['type']='success';
			}
			else
			{
				$data['message']='Changes could not be made due to some error';	
				$data['type']='error';
			}
			
			$imageData=array();
			$authorMediaData=array();
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
					//add media link to author_media table
					$authorMediaData['author_id']=$authorId;
					$authorMediaData['media_id']=$mediaId;
					$authorMediaData['type']='main';
					$this->author_media->insertData($authorMediaData);
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
					//add media link to author_media table
					$authorMediaData['author_id']=$authorId;
					$authorMediaData['media_id']=$mediaId;
					$authorMediaData['type']='preview';
					$this->author_media->insertData($authorMediaData);
				}
			}
			if(!$id)
			{
				//add slug to site_index
				$siteIndexData['slug']=$rowData['slug'];
				$siteIndexData['type']='author';
				$this->site_index->insertData($siteIndexData);
			}
			set_message($data['type'], $data['message']);					
			redirect('author');
		}
		$data['author_types']=$this->author_types->get_All();
		if($id)
		{
			//Edit author
			$data['title']='Edit Author';
			$data['buttonTitle']='Save Changes';
			$data['authorData']=$this->authors->get_by_id($id);	
		}
		else
		{
			//Add Author
			$data['buttonTitle']='Add Author';
			$data['title']='Add Author';
		}
		
		$data['subview'] = $this->load->view('author/add', $data, TRUE);
		$this->load->view('main_layout', $data);
	}
	public function delete($id)
	{
		$result=$this->authors->delete($id);
		if($result==1)
		{
			$data['message']='The Author is deleted';				
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
