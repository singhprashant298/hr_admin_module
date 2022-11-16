<?php 

class User_model extends CI_Model {

    protected $User_table_name = "user";

    /**
     * Insert User Data in Database
     * @param: {array} userData
     */
    public function insert_user($userData) {
        return $this->db->insert('user', $userData);
    }

    /**
     * Check User Login in Database
     * @param: {array} userData
     */
    public function check_login($userData) {

        /**
         * First Check Email is Exists in Database
         */
        $query = $this->db->get_where($this->User_table_name, array('email' => $userData['email']));
        if ($this->db->affected_rows() > 0) {

            $password = $query->row('password');

            /**
             * Check Password Hash 
             */
            if (password_verify($userData['password'], $password) === TRUE) {

                /**
                 * Password and Email Address Valid
                 */
                return [
                    'status' => TRUE,
                    'data' => $query->row(),
                ];

            } else {
                return ['status' => FALSE,'data' => FALSE];
            }

        } else {
            return ['status' => FALSE,'data' => FALSE];
        }
    }

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

}
