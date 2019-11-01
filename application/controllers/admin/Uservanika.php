<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uservanika extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
       $this->load->model('vanika_model');
       $this->load->model('login_model');
    }

	// -- Index UserVanika
    public function index()
    {
        $data['userlist'] = $this->vanika_model->get_all_user();
        $data['count'] = $this->vanika_model->get_user_total();
        $data['main_content'] = $this->load->view('admin/user/uservanika/uservanika_all_list', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

	// -- USERTEXT
	// -- Index Usertext
    public function usertext()
    {
        $data['usertext'] = $this->vanika_model->get_all_text();
        $data['count'] = $this->vanika_model->get_user_total();
        $data['main_content'] = $this->load->view('admin/user/uservanika/usertext', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    // Get Usertext Answered or Not
    public function usertext_status($status)
    {
        $data['usertext'] = $this->vanika_model->get_all_text_bystatus($status);
        $data['count'] = $this->vanika_model->get_user_total();
        $data['main_content'] = $this->load->view('admin/user/uservanika/usertext_status', $data, TRUE);
        $this->load->view('admin/index', $data);
	}
	
	//-- USERLIST
	// -- Index Userlist
    public function userlist()
    {
        $data['userlist'] = $this->vanika_model->get_all_user();
        $data['count'] = $this->vanika_model->get_user_total();
        $data['main_content'] = $this->load->view('admin/user/uservanika/uservanika_all_list', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- Update uservanika info
    public function update($no)
    {
		if ($this->session->userdata('role') == 'admin' || check_power(2)) {
			if ($_POST) {
				$data = array(
					'userid' => $_POST['userid'],
					'username' => $_POST['username'],
					'user_email' => $_POST['user_email'],
					'userprivilege' => $_POST['userprivilege']
				);
				$data = $this->security->xss_clean($data);
				$this->vanika_model->edit_option($data, $no, 'userlist');
				$this->session->set_flashdata('msg', 'Information Updated Successfully');
				redirect(base_url('admin/uservanika/userlist'));
			}

			$data['user'] = $this->vanika_model->get_single_user_info($no);
			$data['main_content'] = $this->load->view('admin/user/uservanika/uservanika_edit', $data, TRUE);
			$this->load->view('admin/index', $data);
		}
		else{
            redirect(base_url('admin/uservanika/userlist'));
        }     
    }

    
    //-- Change to Admin Only admin user
    public function admin($no) 
    {
		if ($this->session->userdata('role') == 'admin') {
			$data = array(
				'userprivilege' => "admin"
			);
			$data = $this->security->xss_clean($data);
			$this->vanika_model->update($data, $no,'userlist');
			$this->session->set_flashdata('msg', 'User active Successfully');
			redirect(base_url('admin/uservanika/userlist'));
		}
		else{
            redirect(base_url('admin/uservanika/userlist'));
        }     
    }

    //-- Change to User Only admin user
    public function user($no) 
    {
		if ($this->session->userdata('role') == 'admin') {
			$data = array(
				'userprivilege' => "user"
			);
			$data = $this->security->xss_clean($data);
			$this->vanika_model->update($data, $no,'userlist');
			$this->session->set_flashdata('msg', 'User deactive Successfully');
			redirect(base_url('admin/uservanika/userlist'));
		}
		else{
            redirect(base_url('admin/uservanika/userlist'));
        }
    }

    //-- Delete User Only admin user
    public function delete($no)
    {
		if ($this->session->userdata('role') == 'admin' || check_power(3)) {
			$this->vanika_model->delete($no,'userlist'); 
			$this->session->set_flashdata('msg', 'User deleted Successfully');
			redirect(base_url('admin/uservanika/userlist'));
		}
		else{
            redirect(base_url('admin/uservanika/userlist'));
        }
	}
	
	//-- COMMANDS
	// -- Index Userlist
    public function command()
    {
        $data['usercommand'] = $this->vanika_model->get_all_command();
        $data['count'] = $this->vanika_model->get_user_total();
        $data['main_content'] = $this->load->view('admin/user/uservanika/command_list', $data, TRUE);
        $this->load->view('admin/index', $data);
	}

    //-- Add new user by admin or user with role add
    public function addcommand()
    {   
        if ($this->session->userdata('role') == 'admin' || check_power(1)) {
            if ($_POST) {
                $data = array(
                'prefix' => $_POST['prefix'],
                'command' => $_POST['command'],
                'message' => $_POST['message'],
                'create_date' => current_datetime()
            );

                $data = $this->security->xss_clean($data);
            
                //-- check duplicate email
                $command = $this->vanika_model->check_command($_POST['command']);

                if (empty($command)) {
                    $user_id = $this->vanika_model->insert($data, 'command');
                    $this->session->set_flashdata('msg', 'Command added Successfully');
                    redirect(base_url('admin/uservanika/command'));
                } else {
                    $this->session->set_flashdata('error_msg', 'Command already exist, try another command');
                    redirect(base_url('admin/uservanika/addcommand'));
                }
            }
            $data['page_title'] = 'Command Add';
            $data['main_content'] = $this->load->view('admin/user/uservanika/command_add', $data, TRUE);
            $this->load->view('admin/index', $data);
        }
        else{
            redirect(base_url('admin/uservanika/command'));
        }
    }

   //-- Update user command info
   public function update_command($no)
   {
	   if ($this->session->userdata('role') == 'admin' || check_power(2)) {
		   if ($_POST) {
			   $data = array(
				   'prefix' => $_POST['prefix'],
				   'message' => $_POST['message'],
				   'command' => $_POST['command']
			   );
			   $data = $this->security->xss_clean($data);
			   $this->vanika_model->edit_option($data, $no, 'command');
			   $this->session->set_flashdata('msg', 'Information Updated Successfully');
			   redirect(base_url('admin/uservanika/command'));
		   }

		   $data['command'] = $this->vanika_model->get_single_command_info($no);
		   $data['main_content'] = $this->load->view('admin/user/uservanika/command_edit', $data, TRUE);
		   $this->load->view('admin/index', $data);
	   }
	   else{
		   redirect(base_url('admin/uservanika/command'));
	   }     
   }

	//-- Delete User Only admin user
	public function delete_command($no)
	{
		if ($this->session->userdata('role') == 'admin' || check_power(3)) {
			$this->vanika_model->delete($no,'command'); 
			$this->session->set_flashdata('msg', 'User deleted Successfully');
			redirect(base_url('admin/uservanika/command'));
		}
		else{
			redirect(base_url('admin/uservanika/command'));
		}
	}

}
