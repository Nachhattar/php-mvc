<?php

class Authors extends CI_Model{
	function __construct()
    {
        parent::__construct();
    }
	public function get_All()
    {
        $this->db->select('id,name,slug,date_joined');
        $this->db->from('authors');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function get_All_IdName()
    {
        $this->db->select('id,name');
        $this->db->from('authors');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function get_by_id($id)
    {
		$this->db->select('id,name,slug,date_joined,content,preview_text,meta_title,meta_description,meta_keywords,og_title,og_description,twitter_title,twitter_description,author_type_id');
        $this->db->from('authors');
        $this->db->where('id',$id);
        $result = $this->db->get()->row();
        return $result;
	}
	public function get_NameBy_id($id)
    {
		$this->db->select('id,name');
        $this->db->from('authors');
        $this->db->where('id',$id);
        $result = $this->db->get()->row();
        return $result;
	}
	public function insertData($data,$id=null)
	{
		if($id)
		{
			$this->db->where('id', $id);
			$this->db->update('authors', $data);
			return $id;
		}
		else
		{
			$this->db->insert('authors', $data);
			$id=$this->db->insert_id();
			return $id;
		}
	}
	public function delete($id)
	{
		//check if this author has articles
		$this->db->select('id');
		$this->db->where('author_id',$id);		
		$rows=$this->db->get('articles')->num_rows();
		if($rows > 0)
		{
			$result="This author has articles so it cannot be deleted.";
		}
		else
		{
			$this->db->where('id', $id);
			$res=$this->db->delete('authors'); 
			if (!($res)) {
				$result = $this->db->_error_message();
			}
			else{
				$result = 1;
			}
		}
		return $result;
	}
	public function searchAll($keyword)
    {
		$this->db->select('*');
		$this->db->from('authors');
		$this->db->like('name', $keyword);
		$this->db->or_like('content', $keyword);
		$this->db->or_like('meta_title', $keyword);
		$query = $this->db->get()->result();
		//echo $this->db->last_query();
		return $query;
	}
}
