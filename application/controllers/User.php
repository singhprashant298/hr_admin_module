<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
    }

    /**
     * User Registration
     */
    public function registration()
    {
        $this->form_validation->set_rules('username', 'Username', 'required'); // Unique Field

        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[user.email]', [
            'is_unique' => 'The %s already exists. Please use a different email',
        ]); // // Unique Field

        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "User Registration";
            $this->load->view('_Layout/home/header.php', $data); // Header File
            $this->load->view("user/registration");
            $this->load->view('_Layout/home/footer.php'); // Footer File
        }
        else
        {   
            $insert_data = array(
                'name' => $this->input->post('username', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
                'role' => $this->input->post('role', TRUE),
                'created_date' => date('Y-m-d H:i:s')
            );

            /**
             * Load User Model
             */
            $this->load->model('User_model', 'UserModel');
            $result = $this->UserModel->insert_user($insert_data);

            if ($result == TRUE) {

                $this->session->set_flashdata('success_flashData', 'You have registered successfully.');
                redirect('User/registration');

            } else {

                $this->session->set_flashdata('error_flashData', 'Invalid Registration.');
                redirect('User/registration');

            }
        }
    }


    public function add_candidate()
    {
        $this->form_validation->set_rules('candidate_name', 'Username', 'required'); // Unique Field       
        $this->form_validation->set_rules('exp', 'Experince', 'required');
        $this->form_validation->set_rules('ctc', 'CTC', 'required');
        $this->form_validation->set_rules('expected_ctc', 'Expected CTC', 'required');
        $this->form_validation->set_rules('Designation', 'User File', 'required');

		
        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "Add Candidate";
            $this->load->view('_Layout/home/header.php', $data); // Header File
            $this->load->view("user/addcandidate");
            $this->load->view('_Layout/home/footer.php'); // Footer File
        }
        else
        {
            $directoryName = "./uploads";
                /* Check if the directory already exists. */
                if(!is_dir($directoryName)){
                    /* Directory does not exist, so lets create it. */
                    mkdir($directoryName, 0755, true);
            }
            $config['upload_path'] = "./uploads";
            $config['allowed_types'] = "text/plain|text/csv|csv|xls|xlsx|pdf";
            $config['max_size'] = '50000';
            $this->load->library('upload', $config);    
            if (!$this->upload->do_upload('userfile')) {
                $error['erroruserfile'] =  $this->upload->display_errors();
                $data['page_title'] = "Add Candidate";
                $this->load->view('_Layout/home/header.php', $data); // Header File
                $this->load->view('user/addcandidate', $error);
                $this->load->view('_Layout/home/footer.php'); // Footer File
    
            } else{
                $file_data = $this->upload->data();
                $file_path =  $file_data['file_name'];
   
            $insert_data = array(
                'candidate_name' => $this->input->post('candidate_name', TRUE),
                'exp' => $this->input->post('exp', TRUE),
                'ctc' => $this->input->post('ctc', TRUE),
                'expected_ctc' => $this->input->post('expected_ctc', TRUE),
                'Designation' => $this->input->post('Designation', TRUE),
                'resume_name'=>$file_path,
                'user_id'=>$this->session->userdata('USER_ID'),
                'created_date' => date('Y-m-d H:i:s')
             );
           
            /**
             * Load User Model
             */
            $this->load->model('Candidate_model', 'CandidateModel');
            $result = $this->CandidateModel->insert_candidate($insert_data);

            if ($result == TRUE) {

                $this->session->set_flashdata('success_flashData', 'You have Added  successfully Candidate.');
                redirect('User/panel');

            } else {

                $this->session->set_flashdata('error_flashData', 'Invalid Registration.');
                redirect('User/registration');

             }
          }
        }
    }

    /**
     * User Login
     */
	public function login()
	{
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "User Login";
            $this->load->view('_Layout/home/header.php', $data); // Header File
            $this->load->view("user/login");
            $this->load->view('_Layout/home/footer.php'); // Footer File
        }
        else
        {
            $login_data = array(
                'email' => $this->input->post('email', TRUE),
                'password' => $this->input->post('password', TRUE),
            );

            /**
             * Load User Model
             */
            $this->load->model('User_model', 'UserModel');
            $result = $this->UserModel->check_login($login_data);

            if (!empty($result['status']) && $result['status'] === TRUE) {

                /**
                 * Create Session
                 * -----------------
                 * First Load Session Library
                 */
                $session_array = array(
                    'USER_ID'  => $result['data']->id,
                    'USERNAME'  => $result['data']->name,
                    'USER_EMAIL' => $result['data']->email,
                    'Role'  => $result['data']->role,
                );
                
                $this->session->set_userdata($session_array);
                if($result['data']->role=='HR'){
                  $this->session->set_flashdata('success_flashData', 'Login Success');
                  redirect('User/Panel');
                }else{
                    $this->session->set_flashdata('success_flashData', 'Login Success');
                    redirect('User/TLPanel');  
                }

            } else {

                $this->session->set_flashdata('error_flashData', 'Invalid Email/Password.');
                redirect('User/login');
            }
        }
    }
    
    /**
     * User Logout
     */
    public function logout() {

        /**
         * Remove Session Data
         */
        $remove_sessions = array('USER_ID', 'USERNAME','USER_EMAIL','IS_ACTIVE', 'USER_NAME');
        $this->session->unset_userdata($remove_sessions);

        redirect('User/login');
    }

    /**
     * User Panel
     */
    public function panel() {

        if (empty($this->session->userdata('USER_ID'))) {
            redirect('user/login');
        }

        $user_id=$this->session->userdata('USER_ID');
        $this->load->model('User_model', 'UserModel');

        $result['data'] = $this->UserModel->getByValuesBy('candidate_details','user_id',$user_id);

        $result['TLData'] = $this->UserModel->getByValuesBy('user','role','TL');



        $data['page_title'] = "Welcome to User Panel";
        $this->load->view('_Layout/home/header.php', $data); // Header File

        $this->load->view("user/panel",$result);
        $this->load->view('_Layout/home/footer.php'); // Footer File
        

    }

    public function TLpanel() {

        if (empty($this->session->userdata('USER_ID'))) {
            redirect('user/login');
        }

        $user_id=$this->session->userdata('USER_ID');

        $result['USERNAME']=$this->session->userdata('USERNAME');

        
        $this->load->model('User_model', 'UserModel');

        $result['data'] = $this->UserModel->getByValuesBy('candidate_details','tl_id',$user_id);

        


        $data['page_title'] = "Welcome to TL Panel";
        $this->load->view('_Layout/home/header.php', $data); // Header File

        $this->load->view("user/tlpanel",$result);
        $this->load->view('_Layout/home/footer.php'); // Footer File
        

    }

    public function showcandiate() {

        if (empty($this->session->userdata('USER_ID'))) {
            redirect('user/login');
        }

        $data['page_title'] = "Welcome to Candidate Panel";
        $this->load->view('_Layout/home/header.php', $data); // Header File
        $this->load->view("user/addcandidate");
        $this->load->view('_Layout/home/footer.php'); // Footer File
    }

   function saveasigntl(){

     $save_data = array(
        'tl_id' => $this->input->post('tl_id', TRUE),
     );
     $candidate_id = $this->input->post('candidate_id', TRUE);
     $this->load->model('Candidate_model', 'CandidateModel');
     $result = $this->CandidateModel->update_record($candidate_id,'candidate_details',$save_data,'id');
     echo "true";
    }

    function saveremark(){

        $save_data = array(
           'feedback' => $this->input->post('feedback', TRUE),
           'status' => $this->input->post('status', TRUE),
        );
        $candidate_id = $this->input->post('candidate_id', TRUE);
        $this->load->model('Candidate_model', 'CandidateModel');
        $result = $this->CandidateModel->update_record($candidate_id,'candidate_details',$save_data,'id');
        echo "true";
    }

    function getCandidateDetails(){

       
        $candidate_id = $this->input->post('candidate_id', TRUE);
        $this->load->model('User_model', 'UserModel');
        $data = $this->UserModel->getByValuesBy('candidate_details','id',$candidate_id);
        echo json_encode($data);

       }
}