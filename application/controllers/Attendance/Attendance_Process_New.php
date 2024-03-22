<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_Process_New extends CI_Controller
{

    public function __construct()
    {
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

    public function index()
    {

        $data['title'] = "Attendance Process | HRM System";
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_shift'] = $this->Db_model->getData('ShiftCode,ShiftName', 'tbl_shifts');
        $data['data_roster'] = $this->Db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');



        $data['sh_employees'] = $this->Db_model->getfilteredData("SELECT 
                                                                    tbl_empmaster.EmpNo
                                                                FROM
                                                                    tbl_empmaster
                                                                        LEFT JOIN
                                                                    tbl_individual_roster ON tbl_individual_roster.EmpNo = tbl_empmaster.EmpNo
                                                                    where tbl_individual_roster.EmpNo is null AND tbl_empmaster.status=1 and Active_process=1");


        $this->load->view('Attendance/Attendance_Process/index', $data);
    }

    public function re_process()
    {
        $data['title'] = "Attendance Process | HRM System";
        $data['data_set'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $data['data_shift'] = $this->Db_model->getData('ShiftCode,ShiftName', 'tbl_shifts');
        $data['data_roster'] = $this->Db_model->getData('RosterCode,RosterName', 'tbl_rosterpatternweeklyhd');



        $data['sh_employees'] = $this->Db_model->getfilteredData("SELECT 
                                                                    tbl_empmaster.EmpNo
                                                                FROM
                                                                    tbl_empmaster
                                                                        LEFT JOIN
                                                                    tbl_individual_roster ON tbl_individual_roster.EmpNo = tbl_empmaster.EmpNo
                                                                    where tbl_individual_roster.EmpNo is null AND tbl_empmaster.status=1 and Active_process=1");


        $this->load->view('Attendance/Attendance_REProcess/index', $data);
    }

    /*
     * Insert Data
     */

    public function emp_attendance_re_process()
    {


        $from_date = $this->input->post('txt_from_date');
        $to_date = $this->input->post('txt_to_date');

        date_default_timezone_set('Asia/Colombo');
        /*
         * Get Employee Data
         * Emp no , EPF No, Roster Type, Roster Pattern Code, Status
         */
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where status=1");
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("select EmpNo from tbl_individual_roster where Is_processed = 1 group by EmpNo");
        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("select EmpNo from tbl_individual_roster where FDate between '$from_date' and '$to_date' group by FDate");
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where EmpNo=3316");
        //        echo "<pre>";
        //        echo 'count--------------------------';
        //        var_dump(($dtEmp['EmpData']));
        //        var_dump(count($dtEmp['EmpData']));
        //        echo "<pre>";
        //        die;
        //        $DayStatus = 'AB';
        //        $lateM=0;
        $AfterShift = 0;
        //        var_dump($dtEmp);die;
        if (!empty($dtEmp['EmpData'])) {


            //echo "<pre>";  var_dump($dtEmp); echo "<pre>";die;
            /*
             * For Loop untill all employee and where employee status = 1
             */
            for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {
                $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;
                //                echo $x . 'Line_____________________77' . $EmpNo;
                //                $EnrollNO = $dtEmp['EmpData'][$x]->Enroll_No;
                //                $EpfNO = $dtEmp['EmpData'][$x]->EPFNO;
                //                $roster = $dtEmp['EmpData'][$x]->RosterCode;
                //            echo $EmpNo . "<br>";
                /*
                 * Get Process From Date and To date(To day is currunt date)
                 */
                //                $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FDate, Max(FDate) as ToDate  FROM tbl_individual_roster where Is_processed=1 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");
                $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FDate, Max(FDate) as ToDate  FROM tbl_individual_roster where EmpNo='$EmpNo' GROUP BY EmpNo");
                //            echo "<pre>";     var_dump($dtRs);echo "<pre>"; die;
                //            if (!empty($dtRs['dt'])) {
                //var_dump($dtRs);
                //Last Shift Allocated Date
                //                $FDate = date("Y-m-d", strtotime("+1 day", strtotime($dtRs['dt'][0]->FDate)));
                $FDate = $dtRs['dt'][0]->FDate;
                //Current Date
                $TDate = $dtRs['dt'][0]->ToDate;
                //Check If From date less than to Date
                if ($FDate <= $TDate) {

                    //                    var_dump($FDate . '   ' . $TDate . 'ss');die;
                    //                    die;
                    $d1 = new DateTime($FDate);
                    $d2 = new DateTime($TDate);

                    $interval = $d1->diff($d2)->days;
                    //**** Attendance Process start after shift allocation
                    //                    $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=1 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");
                    $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where EmpNo='$EmpNo' GROUP BY EmpNo");
                    //
                    //                    var_dump($dtRs);
                    //                    var_dump($EmpNo);
                    //                 die;
                    $FromDate = $dtRs['dt'][0]->FromDate;
                    $ToDate = $dtRs['dt'][0]->ToDate;

                    $d1 = new DateTime($FromDate);
                    $d2 = new DateTime($ToDate);

                    //Date intervel for, loop
                    $interval2 = $d1->diff($d2)->days;
                    //                    var_dump($interval2);die;
                    $ApprovedExH = 0;

                    $FromDate = $d1->modify("-1 day");

                    $FromDate = $FromDate->format('Y-m-d');


                    // die;
                    for ($z = 0; $z <= $interval2; $z++) {


                        //                        var_dump($FromDate);die;
                        //                     die;
                        //                          echo "<pre>";     var_dump($interval2);echo "<pre>"; die;
                        //                        $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=1 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");
                        $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where EmpNo='$EmpNo' GROUP BY EmpNo");

                        //                        var_dump($dtRs);die;

                        $FromDate = $dtRs['dt'][0]->FromDate;
                        $ToDate = $dtRs['dt'][0]->ToDate;
                        //                        var_dump($dtRs); die;
                        // die;

                        $FromDate = $d1->modify("+1 day");

                        $FromDate = $FromDate->format('Y-m-d');


                        /*
                         * ******Get Employee IN Details
                         */
                        $dt_in_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$FromDate' ");

                        $InRecords = $dt_in_Records['dt_Records'][0]->AttDate;
                        //                        var_dump($InRecords);die;
                        //**** In Date
                        $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                        //**** In Time
                        $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                        $InRecID = $dt_in_Records['dt_Records'][0]->EventID;
                        $InRec = 1;
                        /*
                         * ******Get Employee OUT Details
                         */
                        $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$FromDate' ");

                        //**** Out Date
                        $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        //                        var_dump($OutDate);
                        //**** Out Time
                        $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                        $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                        $OutRec = 0;
                        $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        //                        var_dump($OutRecords);
                        //                        var_dump($InTime . 'In');
                        //                    if ($InTime == $OutTime) {
                        //                        
                        //                    }
                        //                    die;

                        if ($InRecords == null) {


                            //                            echo 'heeeeeeeeeeeeeeeeeeeee';
                            //                            var_dump($FromDate,$EmpNo);
                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");
                            //                            var_dump($Manual);
                            //                            var_dump($FromDate . 'Manual In record available');
                            //                            var_dump($Manual);die;

                            if (!empty($Manual)) {
                                //                                print_r($FromDate);
                                //                                var_dump($Manual);
                                //                        die;
                                $InDate = $Manual[0]->Att_Date;
                                //**** In Time
                                $InTime = $Manual[0]->In_Time;

                                $InRec = 1;
                            }
                        }
                        if ($InTime == $OutTime) {
                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");
                            if (!empty($Manual)) {
                                //                                print_r($FromDate);
                                //                                var_dump($Manual);
                                //                        die;
                                $InDate = $Manual[0]->Att_Date;
                                //**** In Time
                                $InTime = $Manual[0]->In_Time;

                                $OutTime = $Manual[0]->Out_Time;

                                $InRec = 1;
                            }
                        }
                        //var_dump($Manual);die;
                        //                        var_dump($dt_out_Records);
                        //
                        //                        die;
                        //
                        //                        if ($FromDate = "2023-07-05") {
                        //                            echo 'find______2023-07-nooooo';
                        ////                            die;
                        //                        }
                        if ($OutRecords == null) {

                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='$FromDate' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");



                            //                            var_dump($Manual);
                            //                            die;
                            if (!empty($Manual)) {
                                //                                print_r($FromDate);
                                //                                var_dump($Manual);
                                //                        die;

                                $OutDate = $Manual[0]->Att_Date;
                                //**** In Time
                                $OutTime = $Manual[0]->Out_Time;

                                $OutRec = 1;
                            }
                        }
                        //                        
                        //die;
                        //                        var_dump('Innnnsdsds  ' . $InTime . 'OUT Time' . $OutTime);

                        /*
                         * ***** Get Shift Code
                         */
                        //                        var_dump($EmpNo.$FromDate);die;
                        $SH['SH'] = $this->Db_model->getfilteredData("select ID_roster,EmpNo,ShiftCode,ShType,ShiftDay,Day_Type,FDate,FTime,TDate,TTime,ShType,GracePrd from tbl_individual_roster where EmpNo='$EmpNo' && FDate='$FromDate'");

                        //                        var_dump($FromDate);die;

                        $SH_Code = $SH['SH'][0]->ShiftCode;
                        $Shift_Day = $SH['SH'][0]->ShiftDay;
                        //****Shift Type DU| EX
                        $ShiftType = $SH['SH'][0]->ShType;
                        //****Individual Roster ID
                        $ID_Roster = $SH['SH'][0]->ID_roster;

                        //****Shift from time
                        $SHFT = $SH['SH'][0]->FTime;
                        //****Shift to time
                        $SHTT = $SH['SH'][0]->TTime;
                        //****Day Type Full day or Half day (1)or 0.5
                        $DayType = $SH['SH'][0]->Day_Type;

                        $GracePrd = $SH['SH'][0]->GracePrd;

                        //                        var_dump('-----------Roster-------------' . '' . $ID_Roster . '----------------------Roster');
                        //                        var_dump($ShiftType);
                        //                        var_dump($Shift_Day . $ShiftType . $EmpNo);
                        //die;
                        /*
                         * Get OT Pattern Details
                         */
                        $OT['OT'] = $this->Db_model->getfilteredData("SELECT tbl_ot_pattern_dtl.DayCode,tbl_ot_pattern_dtl.OTCode,tbl_empmaster.EmpNo,tbl_ot_pattern_dtl.OTPatternName,tbl_ot_pattern_dtl.DUEX,tbl_ot_pattern_dtl.BeforeShift,tbl_ot_pattern_dtl.MinBS,tbl_ot_pattern_dtl.AfterShift,tbl_ot_pattern_dtl.MinAS,tbl_ot_pattern_dtl.RoundUp,tbl_ot_pattern_dtl.Rate,tbl_ot_pattern_dtl.Deduct_LNC FROM tbl_ot_pattern_dtl RIGHT JOIN tbl_empmaster ON tbl_ot_pattern_dtl.OTCode = tbl_empmaster.OTCode WHERE tbl_ot_pattern_dtl.DayCode ='$Shift_Day' and tbl_ot_pattern_dtl.DUEX='$ShiftType'");
                        $AfterShiftWH = 0;
                        //                        var_dump($OT);die;

                        $Round = 1;
                        $BeforeShift = 2;
                        $AfterShift = 3;
                        $Rate = 4;
                        $DayCode = 5;
                        $Deduct_Lunch = 6;


                        //                          echo "<pre>";     var_dump($Round,$BeforeShift,$AfterShift,$Rate,$DayCode,$Deduct_Lunch);echo "<pre>"; die;
                        //                        var_dump($OT);
                        $lateM = 0;
                        $BeforeShift = 0;
                        $Late_Status = 0;
                        $NetLateM = 0;
                        $ED = 0;
                        $Att_Allowance = 1;
                        //                        var_dump($OT);
                        //                        var_dump($InTime . 'Intime');

                        if ($InTime !== null) {
                            $InTime = substr($InTime, 0, 5);
                        }
                        //                        $InTime = substr($InTime, 0, 5);
                        if ($InTime == $OutTime) {
                            $DayStatus = 'MS';

                            //                                die;
                        }
                        /*
                         * If In Available & In Out Missing
                         */
                        if ($InTime != '' && $InTime == $OutTime) {
                            $DayStatus = 'MS';
                            $Late_Status = 0;
                            $Nopay = 0;


                            $Nopay_Hrs = 0;
                        }
                        if ($InTime != '' && $InTime != $OutTime) {
                            $InTimeSrt = strtotime($InTime);

                            //                            echo 'IN and Out Both available';


                            //                            var_dump($SHFT);
                            $SHStartTime = strtotime($SHFT);

                            //                            echo "<pre>";
                            //                            var_dump($InTime . $SHFT . 'InTime Sh time');
                            //                            echo "<pre>";
                            $iCalc = round(($SHStartTime - $InTimeSrt) / 60);

                            //                            echo "<pre>";
                            //                            var_dump($iCalc);
                            //                            echo "<pre>";
                            //                            var_dump($iCalc . 'iCalc');
                            //                            die;
                            //                            (FLOOR(@AcceptedBeforeEarlyMinutes / @RoundUP) * @RoundUP);


                            if ($iCalc >= 0) {

                                $BeforeShift = $iCalc;

                                $BeforeShift = ($BeforeShift);

                                //                                $BeforeShift = ((floor(($BeforeShift + $GracePrd) / $Round)) * $Round);
                            }
                            $testBSH = floor($BeforeShift);


                            //                            var_dump($testBSH . 'Before shift');
                            //                            die;

                            if ($ShiftType == 'DU') {
                                $Late = true;

                                $lateM = 0 - $iCalc - $GracePrd;
                                $Late_Status = 1;

                                if ($lateM <= 0) {
                                    $lateM = 0;
                                }
                            }
                            $Nopay = 0;
                            $DayStatus = 'PR';
                            $Nopay_Hrs = 0;
                        } else if ($InTime == '' && $OutTime == '') {
                            $DayStatus = 'AB';
                            $Nopay = 1;
                            //                            $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT)) - 60 * 60) / 60);
                            $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);
                            if ($DayType == 0.5) {
                                $Nopay = 0.5;
                                $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);
                            }
                            //                            var_dump($Nopay_Hrs . '----------------------------' . $SHTT . '---' . $SHFT);
                            $Att_Allowance = 0;

                            if ($InTime == '' && $OutTime == '' && $ShiftType == 'EX') {
                                $Nopay = 0;
                                $Nopay_Hrs = 0;
                                $DayStatus = 'EX';
                            }
                        }

                        $ApprovedExH = 0;
                        //                        echo "<pre>";
                        //                        var_dump($ApprovedExH);
                        //                        echo "<pre>";
                        //                        
                        //                    if ($OutTime != '') {
                        if ($OutTime != '' && $InTime != $OutTime) {
                            //                            var_dump($OutTime . '_Out Time' . $SHTT . '_Shift End Time -------------------------');
                            $OutTimeSrt = strtotime($OutTime);
                            $SHEndTime = strtotime($SHTT);

                            //                            var_dump('Innnn' . $InTime . 'OUTttt' . $OutTime . 'Shift Out' . $SHTT . 'Shift End Time');
                            //Get Hours
                            //$iCalc1= round(round(($OutTime1 - $SHEndTime1) / 60)/60);
                            //*******Get Minutes
                            $iCalcOut = round(($OutTimeSrt - $SHEndTime) / 60);
                            //                            var_dump($iCalcOut . 'icalc-----------------------------------------');
                            //                            die;
                            //                            var_dump('$EX_OT_Gap..............' . '.............$BeforeShift............' . $BeforeShift);
                            //                            var_dump('icalc----------------' . $iCalcOut);
                            //                            var_dump($Deduct_Lunch . '-------------------');
                            if ($iCalcOut >= 0 && $AfterShift == 1) {
                                $AfterShiftWH = $iCalcOut;

                                //                                var_dump('asfter--------------' . $AfterShift);
                                //----------------Do not delete if need re use ------------------------------If need deduct Lunch----------------------------------------------------------
                                //                                if ($Deduct_Lunch >= 0) {
                                //                                    $AfterShift = $iCalcOut - 60;
                                //                                }
                                //----------------------------------------------If need deduct Lunch----------------------------------------------------------                             
                            }

                            $SH_EX_OT = 0;
                            if ($ShiftType == 'DU') {
                                $ED = 0 - $iCalcOut;
                                if ($ED <= 0) {
                                    $ED = 0;
                                }
                            }
                            if ($ShiftType == 'EX') {
                                $EX_OT_Gap = round(((strtotime($SHTT) - strtotime($InTime)) - 60 * 60) / 60);
                                $SH_EX_OT = $EX_OT_Gap - $BeforeShift + 5;
                                $Nopay = 0;
                                $Nopay_Hrs = 0;

                                //                                var_dump($Nopay . '---------------');
                            }
                        }


                        $SH_EX_OT = 0;
                        //                        var_dump($ShiftType . $ED);
                        //                            die;
                        //                        var_dump($AfterShift);
                        //                        $DayStatus = 'PR';
                        //                        var_dump($EmpNo . ' ' . $FromDate);
                        //                        var_dump('Round Eco' . $Round . 'Round Eco');
                        //                        var_dump($BeforeShift . 'BF' . $AfterShift . 'AF' . $SH_EX_OT . ' -EX OT-' . $Round . '-Round' . '---------------------');
                        $NetLateM = $lateM + $ED;
                        // $NetLateM = 0;

                        //                        $ApprovedExH = (floor(($BeforeShift + $AfterShift + $SH_EX_OT) / $Round)) * $Round;
                        $ExH_OT = $BeforeShift + $AfterShiftWH;
                        //                        $ApprovedExH = (floor(($BeforeShift + $AfterShiftWH) / $Round)) * $Round;
                        //                        var_dump($BeforeShift . '$BeforeShift................' . $AfterShift . '$AfterShift.........................' . $SH_EX_OT . '$SH_EX_OT...............................' . $Round . '$Round.................');
                        //                        var_dump($ApprovedExH . '$ApprovedExH......................');
                        //                        die;
                        //                        if ($Round != 0) {
                        //                            $ApprovedExH = (floor(($BeforeShift + $AfterShift + $SH_EX_OT) / $Round)) * $Round;
                        //                        } else {
                        //                            // Handle the case when $Round is zero (e.g., assign a default value or show an error message)
                        //                            // Example:
                        //                            $ApprovedExH = 0; // Assigning zero as a default value
                        //                            // or
                        //                            echo "Error: Division by zero encountered.";
                        //                        }
                        //                        $ApprovedExH = ((floor(($BeforeShift + $AfterShift + $SH_EX_OT) / $Round)) * $Round);
                        //                        
                        //                            $ApprovedExH = (((($BeforeShift + $AfterShift) / $Round)) * $Round);
                        //                        var_dump($ApprovedExH);



                        if ($NetLateM > $ExH_OT) {

                            //                            echo 'yes late wedi'. '<br>';
                            //                            echo '$NetLateM---------' . $NetLateM . '$ExH_OT------------' . $ExH_OT. '<br>';


                            $NetLateM = $NetLateM - $ExH_OT;

                            //                            echo '$NetLateM-----------' . $NetLateM. '<br>';

                            $ApprovedExH = 0;
                        } else {
                            $ApprovedExHTemp = ($ExH_OT - $NetLateM);
                            $ApprovedExH = (floor(($ApprovedExHTemp) / $Round)) * $Round;

                            //                            echo 'appppproved ---- '. $ApprovedExH. '<br>';

                            $NetLateM = 0;
                        }




                        //                        if ($ExH_OT <= $NetLateM) {
                        //                            $ApprovedExH = $ApprovedExH - $NetLateM;
                        //                            if ($ApprovedExH <= 0) {
                        //                                $ApprovedExH = 0;
                        //                            }
                        //                        }
                        //                        $NetLateM = 0;
                        //                        if ($ExH_OT > $NetLateM) {
                        //                            echo 'Yes OT wedi'. '<br>';
                        //                            echo $ExH_OT . '$ExH_OT$ExH_OT$ExH_OT$ExH_OT----------' . $NetLateM . '-----------$NetLateM$NetLateM$NetLateM$NetLateM';
                        //                            echo 'page 462-----------goooooooooooooooooooooooooooooooooooooodddddddddddddddddddddddddddddddddddddddddddddddd' . $ApprovedExHTemp;
                        //                            var_dump($ApprovedExH.'sdsdsdsdsdsdsdsdaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
                        //                            die;
                        //                        }
                        //                        echo 'before submit app-----'. $ApprovedExH. '<br>';
                        //                        die;

                        if ($ApprovedExH >= 0) {

                            $dataArray = array(
                                'EmpNo' => $EmpNo,
                                'OTDate' => $FromDate,
                                'RateCode' => $Rate,
                                'OT_Cat' => $DayCode,
                                'OT_Min' => $ApprovedExH
                            );

                            //                            var_dump($dataArray);
                            $whereArray = array("EmpNo" => $ID_Roster, "OTDate" => $FromDate);
                            $result = $this->Db_model->updateData("tbl_ot_d", $dataArray, $whereArray);
                        }


                        $Holiday = $this->Db_model->getfilteredData("select count(Hdate) as HasRow from tbl_holidays where Hdate = '$FromDate' ");
                        if ($Holiday[0]->HasRow == 1) {
                            $DayStatus = 'HD';
                            $Nopay = 0;
                            $Nopay_Hrs = 0;
                            $Att_Allowance = 0;
                        }
                        $Leave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' ");
                        //                        $isLeave = $Leave[0]->Is_Approve;
                        if (!empty($Leave[0]->Is_Approve)) {
                            //                            var_dump($isLeave);
                            $Nopay = 0;
                            $DayStatus = 'LV';
                            $Nopay_Hrs = 0;
                            $Att_Allowance = 0;
                        }
                        //                        echo $FromDate;
                        //                        echo $OutTime;
                        //                        echo $Nopay . 'No Pay';
                        //                        if ($FromDate == "2023-07-05") {
                        //                            echo $OutTime . 'yyyyyyyyyyyyyyyyyyyy' . $InTime . $ID_Roster . $Nopay;
                        ////                            die;
                        //                        }
                        //                        die;
                        $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $FromDate, "OutTime" => $OutTime, "nopay" => $Nopay, "Is_processed" => 1, "DayStatus" => $DayStatus, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShiftWH, "LateSt" => $Late_Status, "LateM" => $lateM, "EarlyDepMin" => $ED, "NetLateM" => $NetLateM, "ApprovedExH" => $ApprovedExH, "nopay_hrs" => $Nopay_Hrs, "Att_Allow" => $Att_Allowance);
                        $whereArray = array("ID_roster" => $ID_Roster);
                        //                         $whereArray = array("EmpNo" => $FromDate, "EmpNo" => $EmpNo ,""=> $DayStatus);
                        $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                        //                        var_dump($data_arr);
                        //                        var_dump('last Die');
                    }
                }
            }
            //            die;
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_New/re_process');
        } else {
            //            die;
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_New/re_process');
        }
        //        die;
        $this->session->set_flashdata('success_message', 'Attendance Process successfully');
        redirect('/Attendance/Attendance_Process_New/re_process');
    }



    public function emp_attendance_process()
    {

        date_default_timezone_set('Asia/Colombo');
        /*
         * Get Employee Data
         * Emp no , EPF No, Roster Type, Roster Pattern Code, Status
         */
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where status=1");
        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("select * from tbl_individual_roster where Is_processed = 0 ");
        // $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where EmpNo=3316");
        // echo "<pre>";
        // echo 'count--------------------------';
        // var_dump(($dtEmp['EmpData']));
        // var_dump(count($dtEmp['EmpData']));
        // echo "<pre>";
     
        $AfterShift = 0;
       
        if (!empty($dtEmp['EmpData'])) {

            
            for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {
                $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;

                /*
                 * Get Process From Date and To date(To day is currunt date)
                 */
                // $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT * FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");
              
                //Last Shift Allocated Date
                // $FDate = date("Y-m-d", strtotime("+1 day", strtotime($dtRs['dt'][0]->FDate)));
                $FromDate = $dtEmp['EmpData'][$x]->FDate;

                // echo $FDate.' '.$FromDate;
                // echo "Test";
                // echo '<br>';
                //Current Date
                $ToDate = $dtEmp['EmpData'][$x]->TDate;
                //Check If From date less than to Date

              

                if ($FromDate <= $ToDate) {

                    // $d1 = new DateTime($FromDate);
                    // $d2 = new DateTime($ToDate);

                    // $interval = $d1->diff($d2)->days;

                    
                    //**** Attendance Process start after shift allocation
                    // $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");

                    // $FromDate = $dtRs['dt'][0]->FromDate;
                    // $ToDate = $dtRs['dt'][0]->ToDate;

                    
                  
                    // $d1 = new DateTime($FromDate);
                    // $d2 = new DateTime($ToDate);

                    //Date intervel for, loop
                    // $interval2 = $d1->diff($d2)->days;
                    $ApprovedExH = 0;
                    // die;
                    // for ($z = 0; $z <= $interval; $z++) {

                        // $currentDate = date('Y-m-d', strtotime($FDate . ' + ' . $z . ' days'));
                        

                        // $dtRs['dt'] = $this->Db_model->getfilteredData("SELECT  Min(FDate) AS FromDate, Max(TDate) as ToDate  FROM tbl_individual_roster where Is_processed=0 GROUP BY EmpNo HAVING  EmpNo='$EmpNo'");


                        // $FromDate = $dtRs['dt'][0]->FromDate;
                        // $ToDate = $dtRs['dt'][0]->ToDate;

                        // echo $FromDate.' '. $EmpNo;
                        // echo $dtRs['dt'][0]->FromDate.' '.$EmpNo;
                        // // echo json_encode( $dtRs['dt']);
                        // echo '<br>';
                        // echo '<br>';



                         /*
                        * ******Get Employee IN Details
                        */
                        $dt_in_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='".$FromDate."' AND Status='0'  ");

                        $InRecords = $dt_in_Records['dt_Records'][0]->AttDate;

                        //**** In Date
                        $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                        //**** In Time
                        $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                        // $InRecID = $dt_in_Records['dt_Records'][0]->EventID;
                        $InRec = 1;


                        /*
                        * ******Get Employee OUT Details
                        */
                        $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='".$FromDate."' AND Status='1' ");

                        //**** Out Date
                        $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        //                        var_dump($OutDate);
                        //**** Out Time
                        $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                        // $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                        $OutRec = 0;
                        $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;

                        // ****************************************************** */

                        

                            //   ****************************************************** */
                        //       $dt_in_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='".$FromDate."' AND verify_type='0' ");

                        //       $InRecords = $dt_in_Records['dt_Records'][0]->AttDate;
                        //       //                        var_dump($dt_in_Records);
                        //       //**** In Date
                        //       $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                        //       //**** In Time
                        //       $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                        //       $InRecID = $dt_in_Records['dt_Records'][0]->EventID;
                        //       $InRec = 1;

                        // $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='".$FromDate."' AND verify_type='1' AND AttTime >'05:00:00' ");

                        // //**** Out Date
                        // $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        // //                        var_dump($OutDate);
                        // //**** Out Time
                        // $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                        // $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                        // $OutRec = 0;
                        // $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;

                        // echo $EmpNo.' '. $OutDate.' '.  $OutTime;
                        // echo '---------------------<br>';

                        // echo json_encode($dt_out_Records);
                        // echo "<br>";

                        // if ($OutTime == null) {
                        // echo "OK"   ;                     
                        // }else{
                        //     echo "error";
                        // }

                        // if ($OutTime == null) {
                        //     // check nextday
                        //     // Use Carbon to add one day to the date
                        //     $newDate = date('Y-m-d', strtotime($FromDate . ' +1 day'));
                        
                        //     /*
                        //     * ******Get Employee OUT Details
                        //     */
                        //     $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$newDate' AND verify_type='1'");

                        //     //**** Out Date
                        //     $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        //     //                        var_dump($OutDate);
                        //     //**** Out Time
                        //     $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                        //     $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                        //     $OutRec = 0;
                        //     $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;

                          
                        // }
                        // // echo $EmpNo.' '.$OutDate.' '.$OutTime .' '.$newDate;
                        // // echo '<br>';
                        

                        if ($InRecords == null) {

                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='".$FromDate."' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");
                            if (!empty($Manual)) {
                                
                                $InDate = $Manual[0]->Att_Date;
                                //**** In Time
                                $InTime = $Manual[0]->In_Time;

                                $InRec = 1;
                            }
                        }
                        if ($InTime == $OutTime) {
                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='".$FromDate."' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");
                            if (!empty($Manual)) {
           
                                $InDate = $Manual[0]->Att_Date;
                                //**** In Time
                                $InTime = $Manual[0]->In_Time;

                                $OutTime = $Manual[0]->Out_Time;

                                $InRec = 1;
                            }
                        }

                        if ($OutRecords == null) {

                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='".$FromDate."' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");

                            if (!empty($Manual)) {

                                $OutDate = $Manual[0]->Att_Date;
                                //**** In Time
                                $OutTime = $Manual[0]->Out_Time;

                                $OutRec = 1;
                            }
                        }

                        /*
                        * ***** Get Shift Code
                        */
                        $SH['SH'] = $this->Db_model->getfilteredData("select ID_roster,EmpNo,ShiftCode,ShType,ShiftDay,Day_Type,FDate,FTime,TDate,TTime,ShType,GracePrd from tbl_individual_roster where Is_processed=0 and EmpNo='$EmpNo' and FDate='$FromDate'");
                        $SH_Code = $SH['SH'][0]->ShiftCode;
                        $Shift_Day = $SH['SH'][0]->ShiftDay;
                        //****Shift Type DU| EX
                        $ShiftType = $SH['SH'][0]->ShType;
                        //****Individual Roster ID
                        $ID_Roster = $SH['SH'][0]->ID_roster;
                        //****Shift from time
                        $SHFT = $SH['SH'][0]->FTime;
                        //****Shift to time
                        $SHTT = $SH['SH'][0]->TTime;

                        //****Day Type Full day or Half day (1)or 0.5
                        $DayType = $SH['SH'][0]->Day_Type;

                        $GracePrd = $SH['SH'][0]->GracePrd;

                        /*
                        * Get OT Pattern Details
                        */
                        $OT['OT'] = $this->Db_model->getfilteredData("SELECT tbl_ot_pattern_dtl.DayCode,tbl_ot_pattern_dtl.OTCode,tbl_empmaster.EmpNo,tbl_ot_pattern_dtl.OTPatternName,tbl_ot_pattern_dtl.DUEX,tbl_ot_pattern_dtl.BeforeShift,tbl_ot_pattern_dtl.MinBS,tbl_ot_pattern_dtl.AfterShift,tbl_ot_pattern_dtl.MinAS,tbl_ot_pattern_dtl.RoundUp,tbl_ot_pattern_dtl.Rate,tbl_ot_pattern_dtl.Deduct_LNC FROM tbl_ot_pattern_dtl RIGHT JOIN tbl_empmaster ON tbl_ot_pattern_dtl.OTCode = tbl_empmaster.OTCode WHERE tbl_ot_pattern_dtl.DayCode ='$Shift_Day' and tbl_ot_pattern_dtl.DUEX='$ShiftType' AND tbl_empmaster.EmpNo='$EmpNo'");
                        $AfterShiftWH = 0;

                        $Round = $OT['OT'][0]->RoundUp;
                        $BeforeShift = $OT['OT'][0]->BeforeShift;
                        $AfterShift = $OT['OT'][0]->AfterShift;
                        $MinAS = $OT['OT'][0]->MinAS;
                        $Rate = $OT['OT'][0]->Rate;
                        $DayCode = $OT['OT'][0]->DayCode;
                        $Deduct_Lunch = $OT['OT'][0]->Deduct_LNC;

                        $lateM = 0;
                        $BeforeShift = 0;
                        $Late_Status = 0;
                        $NetLateM = 0;
                        $ED = 0;
                        $Att_Allowance = 1;
                        $Nopay = 0;

                        // if ($InTime !== null) {
                        //     $InTime = substr($InTime, 0, 5);
                        // }
                        if ($InTime == $OutTime) {
                            $DayStatus = 'MS';
                        }

                        /*
                        * If In Available & In Out Missing
                        */
                        if ($InTime != '' && $InTime == $OutTime) {
                            $DayStatus = 'MS';
                            $Late_Status = 0;
                            $Nopay = 0;


                            $Nopay_Hrs = 0;
                        }

                        // IN wenna kalin OT
                        if ($InTime != '' && $InTime != $OutTime) {
                            $InTimeSrt = strtotime($InTime);
                            $SHStartTime = strtotime($SHFT);
                            $iCalc = round(($SHStartTime - $InTimeSrt) / 60);
                           
                        // IN wenna kalin OT
                        if ($iCalc >= 0) {

                                $BeforeShift = $iCalc;

                                $BeforeShift = ($BeforeShift);
                            }
                            $testBSH = floor($BeforeShift);

                            // LATE thiynwada balanawa with GracePrd
                            if ($ShiftType == 'DU') {
                                $Late = true;

                                $lateM = 0 - $iCalc - $GracePrd;
                                $Late_Status = 1;

                                if ($lateM <= 0) {
                                    $lateM = 0;
                                }
                            }
                            $Nopay = 0;
                            $DayStatus = 'PR';
                            $Nopay_Hrs = 0;

                            // Nopay 
                        } else if ($InTime == '' && $OutTime == '') {
                            $DayStatus = 'AB';
                            $Nopay = 1;

                            $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);

                            // Edawsata Short Leave thiyanwam
                            if ($DayType == 0.5) {
                                $Nopay = 0.5;
                                $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);
                            }
                            $Att_Allowance = 0;

                            // Extra dawsaknam
                            if ($InTime == '' && $OutTime == '' && $ShiftType == 'EX') {
                                $Nopay = 0;
                                $Nopay_Hrs = 0;
                                $DayStatus = 'EX';
                            }
                        }

                        $ApprovedExH = 0;
                        $EX_OT_Gap = 0;

                        // Out wunma passe OT
                        if ($OutTime != '' && $InTime != $OutTime ) {
                            $OutTimeSrt = strtotime($OutTime);
                            $SHEndTime = strtotime($SHTT);

                            //*******Get Minutes
                            $iCalcOut1 = ($OutTimeSrt - $SHEndTime) / 60;
                            $iCalcOut = number_format($iCalcOut1, 2);

                            //  Out wunma passe OT Grass-p eath ekka ganna tbl eka tbl_ot_pattern_dtl
                            if ($iCalcOut >= 0 && $AfterShift == 1) {
                                $NewiCalcOut = $iCalcOut - $MinAS;
                                if ($NewiCalcOut >= 0 && $ShiftType == 'DU') {
                                    $AfterShiftWH = $NewiCalcOut;  
                                }                   
                            }

                            
                            $SH_EX_OT = 0;
                            if ($ShiftType == 'DU') {
                                $ED = 0 - $iCalcOut;
                                if ($ED <= 0) {
                                    $ED = 0;
                                }
                            }

                            // DOT
                            if ($ShiftType == 'EX' || $ShiftType == 'HD') {
                                // $EX_OT_Gap = round(((strtotime($SHTT) - strtotime($InTime)) - 60 * 60) / 60);
                                // $SH_EX_OT = $EX_OT_Gap - $BeforeShift + 5;
                               
                                // $InTime = substr($InTime, 0, 5);
                                // $OutTime = substr($OutTime, 0, 5);


                                $InTimeSrt = strtotime($InTime);
                                $OutTimeSrt = strtotime($OutTime);
    
                                //*******Get Minutes
                                $EX_OT_Gap1 = ($OutTimeSrt - $InTimeSrt) / 60;
                                $EX_OT_Gap = number_format($EX_OT_Gap1, 2);
                                $Nopay = 0;
                                $Nopay_Hrs = 0;

                                // var_dump($InTime . "STT");
                                // echo "<br>";
                                // var_dump($OutTime . "Out");
                                // echo "<br>";
                                // var_dump($EX_OT_Gap . "IN");
                                // echo "<br>";
                                // echo "<br>";

                            }
                        }

                
                        $SH_EX_OT = 0;
                        $NetLateM = 0;

                        // $ExH_OT = $BeforeShift + $AfterShiftWH;
                        $ExH_OT = $AfterShiftWH;


                        if ($NetLateM > $ExH_OT) {
                            $NetLateM = $NetLateM - $ExH_OT;
                            $ApprovedExH = 0;

                        } else {
                            $ApprovedExHTemp = ($ExH_OT - $NetLateM);
                            // $ApprovedExH = (floor(($ApprovedExHTemp) / $Round)) * $Round;
                            $ApprovedExH = $ApprovedExHTemp;

                            $NetLateM = 0;

                                // var_dump($InTime . "STT");
                                // echo "<br>";
                                // var_dump($OutTime . "Out");
                                // echo "<br>";
                                // var_dump($AfterShiftWH . "IN");
                                // echo "<br>";
                                // echo "<br>";
                        }

                        if ($ShiftType == 'OFF') {
                            $Nopay = 0;
                            $Nopay_Hrs = 0;
                            $Att_Allowance = 0;
                        }

                        if ($ApprovedExH >= 0) {

                            $dataArray = array(
                                'EmpNo' => $EmpNo,
                                'OTDate' => $FromDate,
                                'RateCode' => $Rate,
                                'OT_Cat' => $DayCode,
                                'OT_Min' => $ApprovedExH
                            );

                            //                            var_dump($dataArray);
                            $result = $this->Db_model->insertData("tbl_ot_d", $dataArray);
                        }

                        $Holiday = $this->Db_model->getfilteredData("select count(Hdate) as HasRow from tbl_holidays where Hdate = '$FromDate' ");
                        if ($Holiday[0]->HasRow == 1) {
                            $DayStatus = 'HD';
                            $Nopay = 0;
                            $Nopay_Hrs = 0;
                            $Att_Allowance = 0;
                        }
                        $Leave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' ");
                        if (!empty($Leave[0]->Is_Approve)) {
                            $Nopay = 0;
                            $DayStatus = 'LV';
                            $Nopay_Hrs = 0;
                            $Att_Allowance = 0;
                        }
                        $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $OutDate, "OutTime" => $OutTime, "nopay" => $Nopay, "Is_processed" => 1, "DayStatus" => $DayStatus, "BeforeExH" => $BeforeShift, "AfterExH" => $AfterShiftWH, "DOT" => $EX_OT_Gap, "LateSt" => $Late_Status, "LateM" => $lateM, "EarlyDepMin" => $ED, "NetLateM" => $NetLateM, "ApprovedExH" => $ApprovedExH, "nopay_hrs" => $Nopay_Hrs, "Att_Allow" => $Att_Allowance);
                        $whereArray = array("ID_roster" => $ID_Roster);
                        $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                      
                        // }
                    }
                }
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_New');

        }
        else {
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_New');

        }
        $this->session->set_flashdata('success_message', 'Attendance Process successfully');
        redirect('/Attendance/Attendance_Process_New');
    }


    
}