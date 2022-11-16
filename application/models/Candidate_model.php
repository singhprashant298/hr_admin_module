<?php 

class Candidate_model extends CI_Model {

    protected $User_table_name = "candidate_details";

    /**
     * Insert User Data in Database
     * @param: {array} userData
     */
    public function insert_candidate($userData) {
        return $this->db->insert('candidate_details', $userData);
    }

    /**
     * Check User Login in Database
     * @param: {array} userData
     */
  

    function getByValuesBy($table, $col, $val)
	{
		$this->db->where($col, $val);
		$query = $this->db->get($table);
		//	echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return "No Data";
		}
	}

    public function update_record($id, $table, $edit_data, $field)
	{
		$this->db->cache_delete_all();
		$this->db->where($field, $id);
	    //echo $this->db->last_query();
		return $this->db->update($table, $edit_data);
	}

    

}
