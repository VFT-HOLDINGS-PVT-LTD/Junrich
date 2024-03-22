<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OT_Pattern extends CI_Controller {

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
     * Index page
     */

    public function index() {

        $data['title'] = "OT Pattern | HRM System";
        $data['data_set_shift'] = $this->Db_model->getData('ShiftCode,ShiftName', 'tbl_shifts');
        $data['data_set'] = $this->Db_model->getData('ShiftCode,ShiftName,FromTime,ToTime,NextDay,DayType,FHDSessionEndTime,SHDSessionStartTime,ShiftGap', 'tbl_shifts');
        $this->load->view('Master/OT_Pattern/index', $data);
    }

    /*
     * Insert Data
     */

    public function insert_Data() {

        $dataset = json_decode($_POST['hdntext']);


        foreach ($dataset as $dataitems) {
            $shiftarray = array(
                "OTPatternCode" => $this->input->post('txtOT_Code'),
                'OTPatternName' => $this->input->post('txtOT_Name'),
                'DayCode' => $dataitems->Day,
                'DUEX' => $dataitems->Type,
                'BeforeShift' => $dataitems->chkBSH,
                'MinBS' => $dataitems->MinTw,
                'AfterShift' => $dataitems->ChkASH,
                'MinAS' => $dataitems->ASH_MinTw,
                'RoundUp' => $dataitems->RoundUp,
            );




            $this->Db_model->insertData('tbl_ot_pattern_dtl', $shiftarray);
        }
    }

    /*
     * Get data
     */

    public function get_details() {
        $ShiftCode = $this->input->post('ShiftCode');

        $whereArray = array('ShiftCode' => $ShiftCode);

        $this->Db_model->setWhere($whereArray);
        $dataObject = $this->Db_model->getData('ShiftCode,ShiftName,FromTime,ToTime,ShiftGap', 'tbl_shifts');

        $array = (array) $dataObject;
        echo json_encode($array);
    }

    /*
     * Edit Data
     */

    public function edit() {
        $ShiftCode = $this->input->post("ShiftCode", TRUE);
        $ShiftName = $this->input->post("ShiftName", TRUE);
        $FromTime = $this->input->post("FromTime", TRUE);
        $ToTime = $this->input->post("ToTime", TRUE);
        $ShiftGap = $this->input->post("ShiftGap", TRUE);



        $data = array("ShiftName" => $ShiftName, "FromTime" => $FromTime, "ToTime" => $ToTime, "ShiftGap" => $ShiftGap,);
        $whereArr = array("ShiftCode" => $ShiftCode);
        $result = $this->Db_model->updateData("tbl_shifts", $data, $whereArr);
        redirect(base_url() . "Master/Shifts");
    }

    /*
     * Delete Data
     */

    public function ajax_delete($id) {
        $table = "tbl_shifts";
        $where = 'ShiftCode';
        $this->Db_model->delete_by_id($id, $where, $table);
        echo json_encode(array("status" => TRUE));
    }

    /*
     * Get Bank account number
     */

    function get_data() {
        $state = $this->input->post('cmb_bank');
        $query = $this->Db_model->get_bank_info();
        echo '<option value="" default>-- Select --</option>';
        foreach ($query->result() as $row) {

            echo "<option value='" . $row->Acc_no . "'>" . $row->Acc_no . "</option>";
        }
    }

    /*
     * Get last cheque number according to bank account number
     */

    function get_data_chq() {
        $state = $this->input->post('cmb_acc_no');
        $query = $this->Db_model->get_chqno_info();

        foreach ($query->result() as $row) {
//                 echo "< value='".$row->lc_no."'>".$row->lc_no."";

            echo $row->lc_no;
        }
    }

    public function getShiftData() {
        $shiftcode = $this->input->post("shiftCode");
        $string = "SELECT FromTime,ToTime FROM tbl_shifts WHERE ShiftCode='$shiftcode'";
        $shfitData = $this->Db_model->getfilteredData($string);

        echo json_encode($shfitData);
    }

}
