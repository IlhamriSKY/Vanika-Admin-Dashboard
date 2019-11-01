<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userweb extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
       $this->load->model('common_model');
       $this->load->model('login_model');
    }

    // -- Index Userweb
    public function index()
    {
        $data = array();
        $data['page_title'] = 'Userweb';
        $data['users'] = $this->common_model->get_all_user();
        $data['country'] = $this->common_model->select('country');
        $data['count'] = $this->common_model->get_user_total();
        $data['main_content'] = $this->load->view('admin/user/userweb/userweb_all_list', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    // -- Userweb list
    public function userlist()
    {
        $data['page_title'] = 'Userweb List';
        $data['users'] = $this->common_model->get_all_user();
        $data['country'] = $this->common_model->select('country');
        $data['count'] = $this->common_model->get_user_total();
        $data['main_content'] = $this->load->view('admin/user/userweb/userweb_all_list', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- Add new user by admin or user with role add
    public function add()
    {   
        if ($this->session->userdata('role') == 'admin' || check_power(1)) {
            if ($_POST) {
                $data = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => md5($_POST['password']),
                'mobile' => $_POST['mobile'],
                'country' => $_POST['country'],
                'status' => $_POST['status'],
                'role' => $_POST['role'],
                'created_at' => current_datetime()
            );

                $data = $this->security->xss_clean($data);
            
                //-- check duplicate email
                $email = $this->common_model->check_email($_POST['email']);

                if (empty($email)) {
                    $user_id = $this->common_model->insert($data, 'user');
            
                    if ($this->input->post('role') == "user") {
                        $actions = $this->input->post('role_action');
                        foreach ($actions as $value) {
                            $role_data = array(
                            'user_id' => $user_id,
                            'action' => $value
                        );
                            $role_data = $this->security->xss_clean($role_data);
                            $this->common_model->insert($role_data, 'user_role');
                        }
                    }
                    $this->session->set_flashdata('msg', 'User added Successfully');
                    redirect(base_url('admin/userweb/userlist'));
                } else {
                    $this->session->set_flashdata('error_msg', 'Email already exist, try another email');
                    redirect(base_url('admin/userweb/add'));
                }
            }
            $data['page_title'] = 'Userweb Add';
            $data['country'] = $this->common_model->select('country');
            $data['power'] = $this->common_model->get_all_power('user_power');
            $data['main_content'] = $this->load->view('admin/user/userweb/userweb_add', $data, TRUE);
            $this->load->view('admin/index', $data);
        }
        else{
            redirect(base_url('admin/userweb/userlist'));
        }
    }

    //-- update users info by admin or user with role edit
    public function update($id)
    {
        if ($this->session->userdata('role') == 'admin' || check_power(2)) {
            if ($id == 1) {
                $this->session->set_flashdata('error_msg', 'You cant update Admin');
                redirect(base_url('admin/userweb/userlist'));
            }
            else{
                if ($_POST) {
                    $data = array(
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'mobile' => $_POST['mobile'],
                        'country' => $_POST['country'],
                        'role' => $_POST['role']
                    );
                    $data = $this->security->xss_clean($data);

                    $powers = $this->input->post('role_action');
                    if (!empty($powers)) {
                        $this->common_model->delete_user_role($id, 'user_role');
                        foreach ($powers as $value) {
                            $role_data = array(
                                'user_id' => $id,
                                'action' => $value
                            );
                            $role_data = $this->security->xss_clean($role_data);
                            $this->common_model->insert($role_data, 'user_role');
                        }
                    }

                    $this->common_model->edit_option($data, $id, 'user');
                    $this->session->set_flashdata('msg', 'Information Updated Successfully');
                    redirect(base_url('admin/userweb/userlist'));
                }
                $data['page_title'] = 'Userweb Edit';
                $data['user'] = $this->common_model->get_single_user_info($id);
                $data['user_role'] = $this->common_model->get_user_role($id);
                $data['power'] = $this->common_model->select('user_power');
                $data['country'] = $this->common_model->select('country');
                $data['main_content'] = $this->load->view('admin/user/userweb/userweb_edit', $data, TRUE);
                $this->load->view('admin/index', $data);
            }
        }
        else{
            redirect(base_url('admin/userweb/userlist'));
        }     
    }
    
    //-- active user by admin or user with role edit
    public function active($id) 
    {
        if ($this->session->userdata('role') == 'admin' || check_power(2)){
            $data = array(
                'status' => 1
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->update($data, $id,'user');
            $this->session->set_flashdata('msg', 'User active Successfully');
            redirect(base_url('admin/userweb/userlist'));
        }
        else{
            redirect(base_url('admin/userweb/userlist'));
        }

    }

    //-- deactive user by admin or user with role edit
    public function deactive($id) 
    {
        if ($this->session->userdata('role') == 'admin' || check_power(2)){
            $data = array(
                'status' => 0
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->update($data, $id,'user');
            $this->session->set_flashdata('msg', 'User deactive Successfully');
            redirect(base_url('admin/userweb/userlist'));
        }
        else{
            redirect(base_url('admin/userweb/userlist'));
        }
    }

    //-- delete user by admin or user with role delete (cant delete admin)
    public function delete($id)
    {
        if ($this->session->userdata('role') == 'admin' || check_power(3)){
            if ($id == 1){
                $this->session->set_flashdata('error_msg', 'You cant delete Admin');
                redirect(base_url('admin/userweb/userlist'));
            }
            else{
                $this->common_model->delete($id,'user'); 
                $this->session->set_flashdata('msg', 'User deleted Successfully');
                redirect(base_url('admin/userweb/userlist'));
            }
        }
        else{
            redirect(base_url('admin/userweb/userlist'));
        }
    }

    // -- power / privilege list can open by admin only
    public function power()
    {   
        if ($this->session->userdata('role') == 'admin') {
            $data['powers'] = $this->common_model->get_all_power('user_power');
            $data['main_content'] = $this->load->view('admin/user/userweb/userweb_power', $data, TRUE);
            $this->load->view('admin/index', $data);
        }
        else{
            redirect(base_url('admin/userweb/userlist'));
        }        
    }

    //-- add user power by admin only
    public function add_power()
    {   
        if ($this->session->userdata('role') == 'admin') {
            if (isset($_POST)) {
                $data = array(
                    'name' => $_POST['name'],
                    'power_id' => $_POST['power_id']
                );
                $data = $this->security->xss_clean($data);
                
                //-- check duplicate power id
                $power = $this->common_model->check_exist_power($_POST['power_id']);
                if (empty($power)) {
                    $user_id = $this->common_model->insert($data, 'user_power');
                    $this->session->set_flashdata('msg', 'Power added Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Power id already exist, try another one');
                }
                redirect(base_url('admin/userweb/power'));
            }
        }
        else{
            redirect(base_url('admin/userweb/userlist'));
        }           
    }

    //--update user power by admin only
    public function update_power()
    {   
        if ($this->session->userdata('role') == 'admin') {
            if (isset($_POST)) {
                $data = array(
                    'name' => $_POST['name']
                );
                $data = $this->security->xss_clean($data);
                
                $this->session->set_flashdata('msg', 'Power updated Successfully');
                $user_id = $this->common_model->edit_option($data, $_POST['id'], 'user_power');
                redirect(base_url('admin/userweb/power'));
            }
        }
        else{
            redirect(base_url('admin/userweb/userlist'));
        }        
    }

    // delete user power by admin only
    public function delete_power($id)
    {
        if ($this->session->userdata('role') == 'admin') {
            $this->common_model->delete($id, 'user_power');
            $this->session->set_flashdata('msg', 'Power deleted Successfully');
            redirect(base_url('admin/userweb/power'));
        }
        else{
            redirect(base_url('admin/userweb/userlist'));
        }
    }
}
