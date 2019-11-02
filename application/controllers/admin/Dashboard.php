<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_login_user();
        $this->load->model('vanika_model');
    }

    
    public function index()
    {
        $data = array();
        $data['page_title'] = 'Dashboard';
        $data['count'] = $this->vanika_model->get_user_total();
        $data['users'] = $this->vanika_model->get_command_high_low();

        $dayQuery = $this->db->query("SELECT month, SUM(usr) as userlist, SUM(txt) as usertext
		FROM
		(
			SELECT MONTH(t.dateadd) AS monthnum, MONTHNAME(t.dateadd) AS Month, 1 AS usr, 0 AS txt
			FROM userlist t
			WHERE YEAR(t.dateadd) = YEAR(CURRENT_TIMESTAMP) 
			  AND MONTH(t.dateadd) < 12 
		
			UNION ALL
		
			SELECT MONTH(t.createdate) AS monthnum, MONTHNAME(t.createdate) AS Month, 0 AS usr, 1 AS txt
			FROM usertext t
			WHERE YEAR(t.createdate) = YEAR(CURRENT_TIMESTAMP) 
			  AND MONTH(t.createdate) < 12
		) q
		GROUP BY monthnum, month
		ORDER BY MONTH(STR_TO_DATE(month, '%M'))");
        
        $record = $dayQuery->result();
        $data['day_wise'] = json_encode($record);

        $data['main_content'] = $this->load->view('admin/home', $data, true);
        $this->load->view('admin/index', $data);
    }

    /**
     * backup database
     *
     * @param string $fileName nama file tidak dengan extension
     * @return void
     */
    public function backup($fileName='db_backup_')
    {
        $extension = ".zip";
        $fileName .= date("d_m_Y").$extension;
        $this->load->dbutil();
        $backup =& $this->dbutil->backup();
        $this->load->helper('file');
        write_file(FCPATH.'/downloads/'.$fileName, $backup);
        $this->load->helper('download');
        force_download($fileName, $backup);
    }
}
