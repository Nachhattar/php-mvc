<?php

class Author_media extends CI_Model{
	function __construct()
    {
        parent::__construct();
    }
    public function insertData($data,$id=null)
	{
		if($id)
		{
			$this->db->where('id', $id);
			$this->db->update('author_media', $data);
			return $id;
		}
		else
		{
			$this->db->insert('author_media', $data);
			$id=$this->db->insert_id();
			return $id;
		}
	}
}
?>
