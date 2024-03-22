<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_Request extends CI_Controller {

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
        $currentUser = $this->session->userdata('login_user');
        $Emp = $currentUser[0]->EmpNo;
        $data['title'] = "Leave Apply | HRM System";
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_leave'] = $this->Db_model->getfilteredData("SELECT 
                                                                        lv_typ.Lv_T_ID,
                                                                        lv_typ.leave_name,
                                                                        lv_al.Balance
                                                                    FROM
                                                                        tbl_leave_allocation lv_al
                                                                        right join
                                                                        tbl_leave_types lv_typ on lv_al.Lv_T_ID = lv_typ.Lv_T_ID
                                                                        where EmpNo='$Emp'
                                                                    ");



        $data['data_leave_sum'] = $this->Db_model->getfilteredData("SELECT 
                                                                    le.LV_ID,
                                                                    le.EmpNo,
                                                                    em.Emp_Full_Name,
                                                                    lt.leave_name,
                                                                    le.Apply_Date,
                                                                    le.month,
                                                                    le.Year,
                                                                    Is_Cancel,
                                                                    Is_Approve,
                                                                    le.Is_pending,
																	le.Is_Approve,
                                                                    le.Leave_Date,
                                                                    le.Reason,
                                                                    le.Leave_Count
                                                                FROM
                                                                    tbl_leave_entry le
                                                                        INNER JOIN
                                                                    tbl_empmaster em ON em.EmpNo = le.EmpNo
                                                                        INNER JOIN
                                                                    tbl_leave_types lt ON lt.Lv_T_ID = le.Lv_T_ID where le.EmpNo = '$Emp'
                                                                ");


        $this->load->view('Leave_Transaction/Leave_Request/index', $data);
    }

    /*
     * Check Leave Balance
     */

    public function check_Leave() {


        $cat = $this->input->post('cmb_cat2');

        $query = $this->Db_model->getfilteredData("select Used, Balance from tbl_leave_allocation where EmpNo='" . $cat . "' ");

        $query;
    }

    /*
     * Dependent Dropdown
     */

    public function dropdown() {

        $cat = $this->input->post('cmb_cat');

        if ($cat == "Employee") {
            $query = $this->Db_model->get_dropdown();
            echo '<option value="" default>-- Select --</option>';
            foreach ($query->result() as $row) {

                echo "<option value='" . $row->EmpNo . "'>" . $row->Emp_Full_Name . "</option>";
            }
        }
    }

    /*
     * Insert Leave Data
     */

    public function insert_data() {


        date_default_timezone_set('Asia/Colombo');
        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');

        /*
         * Leave Type Full Fay or Half Day
         */
        $leave_type = $this->input->post('cmb_leave_type');
        $reason = $this->input->post('txt_reason');
        $orderdate = $this->input->post('txt_from_date');
        $from_date = $this->input->post('txt_from_date');
        $to_date = $this->input->post('txt_to_date');
        $Day_type = $this->input->post('cmb_day');

        $orderdate = explode('/', $orderdate);
        $year = $orderdate[0];
        $month = $orderdate[1];

        $Emp = $this->input->post('txt_employee');



        $d1 = new DateTime($from_date);
        $d2 = new DateTime($to_date);

        /*
         * Get selected days count
         */
        $interval = $d2->diff($d1)->days;
        $DaysInc = $d2->diff($d1)->days;
        ++$DaysInc;



        /*
         * Check If Selected Employee have Allocated Leave in Leave Allocation Table
         */
        $IsAllocate = $this->Db_model->getfilteredData("select count(EmpNo) as IsAllocate from tbl_leave_allocation where EmpNo=$Emp ");


        $EmpG = $this->Db_model->getfilteredData("select Grp_ID from tbl_empmaster where EmpNo = $Emp ");
//        var_dump($EmpG);  
        $grpID = $EmpG[0]->Grp_ID;
        $Sup_Data = $this->Db_model->getfilteredData("select Sup_ID from tbl_emp_group where Grp_ID =$grpID; ");

        $Sup_ID = $Sup_Data[0]->Sup_ID;

//        var_dump($Sup_ID);die;

        $IsBalance = $this->Db_model->getfilteredData("select count(Balance) as Balance from tbl_leave_allocation where EmpNo= $Emp and Lv_T_ID=$leave_type and Balance >=$DaysInc");

        /*
         * Get Individual Roster ID in Selected Date
         */
        $Roster_ID_S = $this->Db_model->getfilteredData("select count(ID_Roster) as ShftCount from tbl_individual_roster where FDate between '$from_date' and '$to_date' and EmpNo=$Emp");


//        var_dump($Roster_ID_S);
//        die;

        if ($IsAllocate[0]->IsAllocate == 0) {
            $this->session->set_flashdata('error_message', 'Employee does not have Allocated Leaves');
        } if ($IsBalance[0]->Balance == 0) {
            $this->session->set_flashdata('error_message', 'Employee Required Leave Balanve Not Enough');
        } else {


            for ($x = 0; $x <= $interval; $x++) {


                /*
                 * Get Individual Roster ID in Selected Date
                 */
                $Roster_ID = $this->Db_model->getfilteredData("select ID_Roster from tbl_individual_roster where EmpNo ='$Emp' and Fdate = '$from_date' ");




                $data = array(
                    array(
                        'EmpNo' => $Emp,
                        'Lv_T_ID' => $leave_type,
                        'Leave_Count' => $Day_type,
                        'Leave_Date' => $from_date,
                        'Apply_Date' => $timestamp,
                        'Year' => $year,
                        'Month' => $month,
                        'Sup_AD_APP' => $Sup_ID,
                        'Is_Sup_AD_APP' => 0,
                        'Reason' => $reason,
                        'Trans_time' => $timestamp,
                        'Is_pending' => 1
//                        'ID_Roster' => $Roster_ID[0]->ID_Roster
                ));

                $HasR = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_leave_entry where EmpNo = '$Emp' and Leave_Date = '$from_date' ");

                if ($HasR[0]->HasRow >= 1) {
                    $this->session->set_flashdata('error_message', 'Already Leave added these days');
                } else {
                    /*
                     * Insert Leave Data to leave entry table
                     */
                    $this->db->insert_batch('tbl_leave_entry', $data);



                    /*
                     * Get Leave Balance and Used by Employee No | Year | Leave Type
                     */

//                    var_dump($leave_type);

                    $Balance_Usd = $this->Db_model->getfilteredData("select Balance,Used,Lv_T_ID from tbl_leave_allocation where EmpNo=$Emp and Year=$year and Lv_T_ID=$leave_type ");
//                    var_dump($Balance_Usd);die;
                    $Balance = $Balance_Usd[0]->Balance - $Day_type;



                    $Used = $Balance_Usd[0]->Used + $Day_type;
                    $Lv_T_ID = $Balance_Usd[0]->Lv_T_ID;

                    $data_arr = array("Balance" => $Balance, "Used" => $Used);

//                    var_dump($data_arr);die;

                    $whereArray = array("EmpNo" => $Emp, "Lv_T_ID" => $Lv_T_ID);
                    $result = $this->Db_model->updateData("tbl_leave_allocation", $data_arr, $whereArray);




                    /*
                     * Insert to Notification table
                     */
                    $dataArray = array(
                        'Notification' => "Employee " . " " . $Emp . " Leave Request",
                        'Path' => "<?php echo base_url(); ?>Leave_Transaction/Leave_Approve/",
                        'Is_Display' => 1
                    );


                    $result = $this->Db_model->insertData("tbl_notifications", $dataArray);

                    $this->session->set_flashdata('success_message', 'New Leave Request has been send successfully');
                }


                ++$from_date;
            }
        }

        redirect('/Leave_Transaction/Leave_Request/');
    }

}
