<?php

class Author_types extends CI_Model{
	function __construct()
    {
        parent::__construct();
    }
	public function get_All()
    {
        $this->db->select('id,name');
        $this->db->from('author_types');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
}
?>
