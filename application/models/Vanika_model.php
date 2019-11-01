<?php
class Vanika_model extends CI_Model {

    //-- insert function
	public function insert($data,$table){
        $this->db->insert($table,$data);        
        return $this->db->insert_id();
    }

    //-- edit function
    function edit_option($action, $no, $table){
        $this->db->where('no',$no);
        $this->db->update($table,$action);
        return;
    } 

    //-- update function
    function update($action, $no, $table){
        $this->db->where('no',$no);
        $this->db->update($table,$action);
        return;
    } 

    //-- delete function
    function delete($no,$table){
        $this->db->delete($table, array('no' => $no));
        return;
    }

    //-- select function
    function select($table){
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    //-- select by id
    function select_option($id,$table){
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

    //-- get single user info
    function get_single_user_info($no){
        $this->db->select('ul.*');
        $this->db->from('userlist ul');
        $this->db->where('ul.no',$no);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    //-- get all users
    function get_all_user(){
        $this->db->select('ul.*');
        $this->db->from('userlist ul');
        $this->db->order_by('ul.no','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    //-- get all users text
    function get_all_text(){
        $this->db->select('ut.*');
        $this->db->from('usertext ut');
        $this->db->order_by('ut.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    //-- get Answered or Not users text
    function get_all_text_bystatus($status){
        $this->db->select('ut.*');
        $this->db->from('usertext ut');
        $this->db->where('status',$status);
        $this->db->order_by('ut.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
    //-- get all command
    function get_all_command(){
        $this->db->select('c.*');
        $this->db->from('command c');
        $this->db->order_by('c.no','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}

    public function check_command($command){
        $this->db->select('*');
        $this->db->from('command');
        $this->db->where('command', $command); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }
	
    //-- get single command info
    function get_single_command_info($no){
        $this->db->select('c.*');
        $this->db->from('command c');
        $this->db->where('c.no',$no);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    //-- get Command high low
    function get_command_high_low(){
        $this->db->select('c.*');
        $this->db->from('command c');
        $this->db->order_by('c.count','DESC');
        $this->db->limit(7);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    //-- count userlist, usertext, usertext answered and unanswered, commands
    function get_user_total(){
        $this->db->select('*');
        $this->db->select('count(*) as total');
        // USERLIST
        $this->db->select('(SELECT count(userlist.no)
                            FROM userlist 
                            ) AS total_userbot',TRUE);
        // USERTEXT
        $this->db->select('(SELECT count(usertext.id)
                            FROM usertext 
                            ) AS total_text',TRUE);
        // USERTEXT YES
        $this->db->select('(SELECT count(usertext.id)
                            FROM usertext
                            WHERE (usertext.status = "yes")
                            ) AS total_text_yes',TRUE);
        // USERTEXT NO
        $this->db->select('(SELECT count(usertext.id)
                            FROM usertext
                            WHERE (usertext.status = "no")
                            ) AS total_text_no',TRUE);
        // COMMAND LIST
        $this->db->select('(SELECT count(command.no)
                            FROM command
                            ) AS total_command',TRUE);
                            
                
        $this->db->from('user');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }
}
