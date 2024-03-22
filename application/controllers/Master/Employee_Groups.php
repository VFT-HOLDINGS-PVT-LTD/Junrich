<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Groups extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }
        /*
         * Load Database model
         */
        $this->load->model('Db_model', '', TRUE);
    }

    /*
     * Index page in Departmrnt
     */

    public function index() {

        $data['title'] = "Employee Groups | HRM System";
        $data['data_set'] = $this->Db_model->getData('Grp_ID,EmpGroupName,GracePeriod,NosLeaveForMonth,MaxSLS,Allow1stSession,Allow2ndSession,OTPattern', 'tbl_emp_group');
        $data['data_ot'] = $this->Db_model->getData('OTCode,OTName', 'tbl_ot_pattern_hd');
        $data['emp_sup'] = $this->Db_model->getfilteredData("select EmpNo,Emp_Full_Name from tbl_empmaster where Status=1");
        $this->load->view('Master/Employee_Groups/index', $data);
    }

    /*
     * Insert Departmrnt
     */

    public function insert_data() {

        $FSt = $this->input->post('chk_1st');
        if ($FSt == null) {
            $FSt = 0;
        } elseif ($FSt == 'on') {
            $FSt = 1;
        }

        $Snd = $this->input->post('chk_2nd');
        if ($Snd == null) {
            $Snd = 0;
        } elseif ($Snd == 'on') {
            $Snd = 1;
        }

        $data = array(
            'EmpGroupName' => $this->input->post('txt_group_name'),
            'GracePeriod' => $this->input->post('txt_grace_p'),
            'NosLeaveForMonth' => $this->input->post('txt_sl_per_mth'),
            'MaxSLS' => $this->input->post('txt_max_l_size'),
            'Allow1stSession' => $FSt,
            'Allow2ndSession' => $Snd,
            'OTPattern' => $this->input->post('cmb_ot_pattern')
        );

        $result = $this->Db_model->insertData("tbl_emp_group", $data);


        if ($result) {
            $condition = 1;
        } else {
            
        }

        $info[] = array('a' => $condition);
        echo json_encode($info);
    }

    /*
     * Get Department data
     */

    public function get_details() {
        $id = $this->input->post('id');

        $whereArray = array('Grp_ID' => $id);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('Grp_ID,user_level_name', 'tbl_emp_group');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ID = $this->input->post("id", TRUE);
        $UL = $this->input->post("user_level_name", TRUE);


        $data = array("user_level_name" => $UL);
        $whereArr = array("Grp_ID" => $ID);
        $result = $this->Db_model->updateData("tbl_emp_group", $data, $whereArr);
        redirect(base_url() . "Master/User_Levels");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_emp_group";
        $where = 'Grp_ID';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

}
