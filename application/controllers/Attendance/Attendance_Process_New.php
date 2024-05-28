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




    public function emp_attendance_process()
    {

        date_default_timezone_set('Asia/Colombo');
        /*
         * Get Employee Data
         * Emp no , EPF No, Roster Type, Roster Pattern Code, Status
         */
        //        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,RosterCode, Status  FROM  tbl_empmaster where status=1");
        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("select * from tbl_individual_roster INNER JOIN tbl_empmaster ON tbl_individual_roster.EmpNo = tbl_empmaster.EmpNo where Is_processed = 0 AND Dep_ID != 3 AND Status=1");
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
                $depId = $dtEmp['EmpData'][$x]->Dep_ID;
                $hrshdaycheck = $dtEmp['EmpData'][$x]->ShiftDay;

                $FromDate = $dtEmp['EmpData'][$x]->FDate;
                $ToDate = $dtEmp['EmpData'][$x]->TDate;
                //Check If From date less than to Date
                if ($FromDate <= $ToDate) {
                    $ApprovedExH = 0;
                    $DayStatus = "not";

                    // Get the CheckIN 
                    $dt_in_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND Status='0' ");

                    $InRecords = $dt_in_Records['dt_Records'][0]->AttDate;

                    //**** In Date
                    $InDate = $dt_in_Records['dt_Records'][0]->AttDate;
                    //**** In Time
                    $InTime = $dt_in_Records['dt_Records'][0]->INTime;
                    $InRecID = $dt_in_Records['dt_Records'][0]->EventID;
                    $InRec = 1;


                    // **************************************************************************************//
                    // tbl_individual_roster eke OFF dwas ganne 
                    $OFFDAY['OFF'] = $this->Db_model->getfilteredData("select `ShType` from tbl_individual_roster where FDate = '$FromDate'");
                    $Day = $OFFDAY['OFF'][0]->ShType;
                    

                    if ($Day != "OFF") {

                        // Get the CheckOut 
                        $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND Status='1' ");

                        //**** Out Date
                        $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        //**** Out Time
                        $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                        $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                        $OutRec = 0;
                        $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        // echo $OutDate;
                        // echo "<br/>";

                        // Out Ekak nethnm check nextday(1st nextDay)
                        if ($OutTime == null) {

                            // Use Carbon to add one day to the date
                            $newDate = date('Y-m-d', strtotime($FromDate . ' +1 day'));

                            // Get the CheckOut in the nextDay (before 8am)
                            $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$newDate' AND Status='1' AND AttTime <'09:00:00'");

                            //**** Out Date
                            $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                            //**** Out Time
                            $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                            $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                            $OutRec = 0;
                            $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;
                        } else {

                            // nextDay Ekak nethnm this day(ema dwsema) ekema rathri 12 sita ude 8 dkwa record ekak thiywda balanwa
                            $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND Status='1' AND AttTime BETWEEN '00:01:00' AND '09:00:00' ");

                            //**** Out Date
                            $OutDate1 = $dt_out_Records['dt_out_Records'][0]->AttDate;
                            //**** Out Time
                            $OutTime1 = $dt_out_Records['dt_out_Records'][0]->OutTime;
                            $OutRecID1 = $dt_out_Records['dt_out_Records'][0]->EventID;
                            $OutRec1 = 0;
                            $OutRecords1 = $dt_out_Records['dt_out_Records'][0]->AttDate;


                            // ema record ekak thiywam
                            if ($OutTime1 != null) {
                                $newDate = date('Y-m-d', strtotime($FromDate . ' +1 day'));

                                // aye ee dwse idn thwa nextDay ekak balanwa (2nd nextDay)
                                $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='$newDate' AND Status='1' AND AttTime <'09:00:00'");

                                //**** Out Date
                                $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                                //**** Out Time
                                $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                                $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                                $OutRec = 0;
                                $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;



                                if ($OutTime == null) {
                                    $OFFDAY['OFF'] = $this->Db_model->getfilteredData("select `ShType` from tbl_individual_roster where FDate = '$FromDate'");
                                    $Day = $OFFDAY['OFF'][0]->ShType;

                                    if ($Day != "OFF") {

                                        // same day ekma hws thiywda balanwa
                                        $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND Status='1' AND AttTime >'08:00:00' ");

                                        //**** Out Date
                                        $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                                        //**** Out Time
                                        $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                                        $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                                        $OutRec = 0;
                                        $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate; //

                                        if ($OutTime == null) {
                                            $DayStatus = 'MS';
                                            $Late_Status = 0;
                                            $Nopay = 0;
                                            $OutTime = "00:00:00";
                                        }
                                    }
                                }
                            } else {
                                $OFFDAY['OFF'] = $this->Db_model->getfilteredData("select `ShType` from tbl_individual_roster where FDate = '$FromDate'");
                                $Day = $OFFDAY['OFF'][0]->ShType;

                                if ($Day != "OFF") {
                                    $dt_out_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND Status='1' ");

                                    //**** Out Date
                                    $OutDate = $dt_out_Records['dt_out_Records'][0]->AttDate;
                                    //                        var_dump($OutDate);
                                    //**** Out Time
                                    $OutTime = $dt_out_Records['dt_out_Records'][0]->OutTime;
                                    $OutRecID = $dt_out_Records['dt_out_Records'][0]->EventID;
                                    $OutRec = 0;
                                    $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;
                                }
                            }
                        }


                        // var_dump($InRecords . ' ' . $InTime . ' ' . $EmpNo);
                        // echo "<br>";
                        // var_dump($OutDate . ' ' . $OutTime . ' ' . $EmpNo);
                        // echo "<br>";
                        // echo "<br>";
                        // **************************************************************************************//
                        if ($InRecords == null) {

                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='" . $FromDate . "' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1 ");
                            if (!empty($Manual)) {

                                $InDate = $Manual[0]->Att_Date;
                                //**** In Time
                                $InTime = $Manual[0]->In_Time;

                                $InRec = 1;
                            }
                        }


                        if ($InTime == $OutTime || $OutTime == null) {

                            $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='" . $FromDate . "' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1 ");
                            if (!empty($Manual)) {

                                $OutDate = $Manual[0]->Att_Date;
                                //**** In Time
                                $OutTime = $Manual[0]->In_Time;

                                $InRec = 1;
                            }
                        }

                        // if ($InTime == $OutTime) {
                        //     $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='" . $FromDate . "' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");
                        //     if (!empty($Manual)) {

                        //         $InDate = $Manual[0]->Att_Date;
                        //         //**** In Time
                        //         $InTime = $Manual[0]->In_Time;

                        //         $OutTime = $Manual[0]->Out_Time;

                        //         $InRec = 1;
                        //     }
                        // }

                        // if ($OutRecords == null) {

                        //     $Manual = $this->Db_model->getfilteredData("select * from tbl_manual_entry where Att_Date='" . $FromDate . "' and Enroll_No='$EmpNo' and Is_Admin_App_ID=1");

                        //     if (!empty($Manual)) {

                        //         $OutDate = $Manual[0]->Att_Date;
                        //         //**** In Time
                        //         $OutTime = $Manual[0]->Out_Time;

                        //         $OutRec = 1;
                        //     }
                        // }

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


                        $OT['OT'] = $this->Db_model->getfilteredData("SELECT tbl_ot_pattern_dtl.DayCode,tbl_ot_pattern_dtl.OTCode,tbl_empmaster.EmpNo,tbl_ot_pattern_dtl.OTPatternName,tbl_ot_pattern_dtl.DUEX,tbl_ot_pattern_dtl.BeforeShift,tbl_ot_pattern_dtl.MinBS,tbl_ot_pattern_dtl.AfterShift,tbl_ot_pattern_dtl.MinAS,tbl_ot_pattern_dtl.RoundUp,tbl_ot_pattern_dtl.Rate,tbl_ot_pattern_dtl.Deduct_LNC FROM tbl_ot_pattern_dtl RIGHT JOIN tbl_empmaster ON tbl_ot_pattern_dtl.OTCode = tbl_empmaster.OTCode WHERE tbl_ot_pattern_dtl.DayCode ='$Shift_Day' and tbl_empmaster.EmpNo='$EmpNo'");
                        $AfterShiftWH = 0;

                        // $Round = $OT['OT'][0]->RoundUp;
                        // $BeforeShift = $OT['OT'][0]->BeforeShift;
                        $AfterShift = $OT['OT'][0]->AfterShift;
                        $Rate = $OT['OT'][0]->Rate;
                        $DayCode = $OT['OT'][0]->DayCode;
                        // $Deduct_Lunch = $OT['OT'][0]->Deduct_LNC;
                        $MinAS = $OT['OT'][0]->MinAS;

                        $lateM = 0;
                        // $BeforeShift = 0;
                        $Late_Status = 0;
                        $NetLateM = 0;
                        $ED = 0;
                        $EDF = 0;
                        $Att_Allowance = 1;
                        $Nopay = 0;

                        // if ($InTime !== null) {
                        //     $InTime = substr($InTime, 0, 5);
                        // }
                        // **************************************************************************************//
                        if ($InTime == $OutTime || $OutTime == null || $OutTime == '') {
                            $DayStatus = 'MS';
                            $Late_Status = 0;
                            $Nopay = 0;
                            $Nopay_Hrs = 0;
                        }

                        /*
                     * If In Available & Out Missing
                     */
                        if ($InTime != '' && $InTime == $OutTime) {
                            $DayStatus = 'MS';
                            $Late_Status = 0;
                            $Nopay = 0;
                            $Nopay_Hrs = 0;
                        }

                        // If Out Available & In Missing
                        if ($OutTime != '' && $InTime == $OutTime) {
                            $DayStatus = 'MS';
                            $Late_Status = 0;
                            $Nopay = 0;
                            $Nopay_Hrs = 0;
                        }

                        // If In Available & Out Missing
                        if ($InTime != '' && $OutTime == '') {
                            $DayStatus = 'MS';
                            $Late_Status = 0;
                            $Nopay = 0;
                            $Nopay_Hrs = 0;
                        }

                        // If Out Available & In Missing
                        if ($OutTime != '' && $InTime == '') {
                            $DayStatus = 'MS';
                            $Late_Status = 0;
                            $Nopay = 0;
                            $Nopay_Hrs = 0;
                        }
                        // **************************************************************************************//

                        if ($InTime != '' && $InTime != $OutTime && $OutTime != '') {
                            $Nopay = 0;
                            $DayStatus = 'PR';
                            $Nopay_Hrs = 0;
                        }
                        // **************************************************************************************//



                        // **************************************************************************************//

                        // // IN wenna kalin OT
                        // if ($InTime != '' && $InTime != $OutTime) {
                        //     $InTimeSrt = strtotime($InTime);
                        //     $SHStartTime = strtotime($SHFT);
                        //     $iCalc = round(($SHStartTime - $InTimeSrt) / 60);

                        //     if ($iCalc >= 0) {

                        //         $BeforeShift = $iCalc;

                        //         $BeforeShift = ($BeforeShift);
                        //     }
                        //     $testBSH = floor($BeforeShift);

                        //     if ($ShiftType == 'DU') {
                        //         $Late = true;

                        //         $lateM = 0 - $iCalc - $GracePrd;
                        //         $Late_Status = 1;

                        //         if ($lateM <= 0) {
                        //             $lateM = 0;
                        //         }
                        //     }
                        //     $Nopay = 0;
                        //     $DayStatus = 'PR';
                        //     $Nopay_Hrs = 0;
                        // } else 


                        // **************************************************************************************//
                        $Nopay_Hrs = 0;
                        // Nopay
                        if ($InTime == '' && $OutTime == '' && $Day == 'DU') {
                            $DayStatus = 'AB';
                            $Nopay = 1;
                            $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);

                            // if ($DayType == 0.5) {
                            //     $Nopay = 0.5;
                            //     $Nopay_Hrs = (((strtotime($SHTT) - strtotime($SHFT))) / 60);
                            // }
                            // $Att_Allowance = 0;

                            if ($InTime == '' && $OutTime == '' && $Day == 'EX') {
                                $Nopay = 0;
                                $Nopay_Hrs = 0;
                                $DayStatus = 'EX';
                            }
                        }

                        // **************************************************************************************//
                        // Get the BreakkIN 
                        $dt_Breakin_Records['dt_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND Status='3' ");
                        $BreakInRecords = $dt_Breakin_Records['dt_Records'][0]->AttDate;
                        $BreakInDate = $dt_Breakin_Records['dt_Records'][0]->AttDate;
                        $BreakInTime = $dt_Breakin_Records['dt_Records'][0]->INTime;
                        $BreakInRecID = $dt_Breakin_Records['dt_Records'][0]->EventID;
                        $BreakInRec = 1;

                        // Get the BreakOut 
                        $dt_Breakout_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OutTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' AND Status='4' ");
                        $BreakOutDate = $dt_Breakout_Records['dt_out_Records'][0]->AttDate;
                        $BreakOutTime = $dt_Breakout_Records['dt_out_Records'][0]->OutTime;
                        $BreakOutRecID = $dt_Breakout_Records['dt_out_Records'][0]->EventID;
                        $BreakOutRec = 0;
                        $BreakOutRecords = $dt_Breakout_Records['dt_out_Records'][0]->AttDate;

                        // ShortLeave thani eka [(After)atharameda In Time ekata kalin short leave thiywam]
                        if ($BreakInTime != null && $BreakOutTime != null) {
                            $BreakInTime = $dt_Breakin_Records['dt_Records'][0]->INTime;
                            $BreakOutTime = $dt_Breakout_Records['dt_out_Records'][0]->OutTime;

                            //Late
                            $ShortLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_shortlive WHERE EmpNo = $EmpNo AND tbl_shortlive.Date = '$FromDate' ");
                            if (!empty($ShortLeave[0]->Is_Approve)) {
                                $SHFtime = $ShortLeave[0]->from_time;
                                $SHTtime = $ShortLeave[0]->to_time;

                                $BreakOutTimeSrt = strtotime($BreakOutTime);
                                $SHToTimeSrt = strtotime($SHTtime);

                                $iCalcShortLTIntv = ($BreakOutTimeSrt - $SHToTimeSrt) / 60;
                                if ($iCalcShortLTIntv <= 0) {
                                    // welawta ewilla

                                } else if ($iCalcShortLTIntv >= 0) {
                                    // welatwa ewilla ne(short leave & haffDay ektath passe late)
                                    $lateM = $iCalcHaffT + $iCalcShortLTIntv;
                                    $DayStatus = 'SL';
                                }
                            }

                            // ED
                            if (!empty($ShortLeave[0]->Is_Approve)) {
                                $SHFtime = $ShortLeave[0]->from_time;
                                $SHTtime = $ShortLeave[0]->to_time;

                                $BreakInTimeSrt = strtotime($BreakInTime);
                                $SHFromTimeSrt = strtotime($SHFtime);

                                $iCalcShortLTIntvED = ($SHFromTimeSrt - $BreakInTimeSrt) / 60;

                                if ($iCalcShortLTIntvED <= 0) {
                                    // ee welwta hari ee welwen passe hari gihinm

                                } else if ($iCalcShortLTIntvED >= 0) {
                                    // kalin gihinm
                                    // $ED = $EDF + $iCalcShortLTIntvED;
                                    $ED = $iCalcShortLTIntvED;
                                }
                            }
                        }

                        // var_dump($InDate . ' ' . $InTime . ' ' . $ED . ' ' . $DayStatus);
                        // echo "<br>";
                        // var_dump($OutDate . ' ' . $OutTime . ' ' . $EmpNo);
                        // echo "<br>";
                        // echo "<br>";
                        // **************************************************************************************//
                        $lateM = 0;
                        // Late
                        if ($InTime != '' && $InTime != $OutTime && $Day == 'DU' || $OutTime != '' && $Day == 'DU') {
                            $Late = true;

                            $SHStartTime = strtotime($SHFT);
                            $InTimeSrt = strtotime($InTime);

                            $iCalc = ($InTimeSrt - $SHStartTime) / 60;
                            $lateM = $iCalc - $GracePrd;


                            if ($lateM <= 0) {
                                $lateM = 0;
                                $Late_Status = 0;
                            } else if ($lateM >= 0) {
                                $lateM;
                                $Late_Status = 1;

                                // Morning In Time ekata kalin short leave thiywam
                                $ShortLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_shortlive WHERE EmpNo = $EmpNo AND tbl_shortlive.Date = '$FromDate' ");
                                if (!empty($ShortLeave[0]->Is_Approve)) {
                                    $SHFtime = $ShortLeave[0]->from_time;
                                    $SHTtime = $ShortLeave[0]->to_time;

                                    $InTimeSrt = strtotime($InTime);
                                    $SHToTimeSrt = strtotime($SHTtime);

                                    $iCalcShortLT = ($InTimeSrt - $SHToTimeSrt) / 60;


                                    if ($iCalcShortLT <= 0) {
                                        // welawta ewilla
                                        $lateM = 0;
                                        $Late_Status = 0;
                                    } else if ($iCalcShortLT >= 0) {
                                        // welatwa ewilla ne(short leave ektath passe late)


                                        // haffDay thiywam short Leave ekka
                                        $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");
                                        if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                                            $SHTtime = "15:00:00";

                                            $InTimeSrt = strtotime($InTime);
                                            $SHToTimeSrt = strtotime($SHTtime);

                                            $iCalcHaffT = ($InTimeSrt - $SHToTimeSrt) / 60;
                                            // echo "0";

                                            if ($iCalcHaffT <= 0) {
                                                // welawta ewilla
                                                $lateM = 0;
                                                $Late_Status = 0;
                                            } else if ($iCalcHaffT >= 0) {
                                                // welatwa ewilla ne(short leave & haffDay ektath passe late)
                                                $lateM = $iCalcHaffT;
                                                $DayStatus = 'HFD/SL';

                                                // echo "1";
                                            }
                                        } else {
                                            // welatwa ewilla ne(short leave ektath passe late /haffDay ne )
                                            $lateM = $iCalcShortLT;
                                            $DayStatus = 'SL';

                                            // echo "2";
                                        }
                                    }
                                }
                            }
                        }

                        // **************************************************************************************//
                        // haffDay thiywam
                        if ($InTime != '' && $InTime != $OutTime && $Day == 'DU' || $OutTime != '' && $InTime != $OutTime && $Day == 'DU') {
                            $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");
                            // haffDay thiywam (only) Morning
                            if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                                $SHTtime = "14:00:00";

                                $InTimeSrt = strtotime($InTime);
                                $SHToTimeSrt = strtotime($SHTtime);

                                $iCalcHaffT = ($InTimeSrt - $SHToTimeSrt) / 60;
                                // echo "0";

                                if ($iCalcHaffT <= 0) {
                                    // welawta ewilla
                                    $lateM = 0;
                                    $Late_Status = 0;
                                } else if ($iCalcHaffT >= 0) {
                                    // welatwa ewilla ne(short leave & haffDay ektath passe late)
                                    $lateM = $iCalcHaffT;
                                    $DayStatus = 'HFD';

                                    // echo "1";
                                }
                            }

                            // haffDay thiywam (only) Evening
                            if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                                $HDFTtime = "14:00:00";

                                $HDFTimeSrt = strtotime($HDFTtime);
                                $OutTimeSrt = strtotime($OutTime);

                                $iCalcHaffT = ($HDFTimeSrt - $OutTimeSrt) / 60;
                                // echo "0";

                                if ($iCalcHaffT <= 0) {
                                    // welawta ewilla
                                    $ED = 0;
                                    // $Late_Status = 0;

                                } else if ($iCalcHaffT >= 0) {
                                    // welatwa ewilla ne(short leave & haffDay ektath passe late)
                                    $ED = $iCalcHaffT;
                                    $DayStatus = 'HFD';

                                    // echo "1";
                                }
                            }
                        }



                        // **************************************************************************************//
                        //OT
                        $ApprovedExH = 0;
                        $SH_EX_OT = 0;
                        if ($OutTime != '' && $InTime != $OutTime && $InTime != '' && $Day == 'DU' && $OutTime != "00:00:00") {

                            // **************************************************************************************//
                            // Out wunma passe OT
                            $SHIFTDAY['SHIFT'] = $this->Db_model->getfilteredData("SELECT `TDate` FROM tbl_individual_roster WHERE FDate = '$FromDate'");
                            $ToDateOT = $SHIFTDAY['SHIFT'][0]->TDate;
                            // date samanam
                            if ($ToDateOT == $OutDate) {
                                if ($AfterShift == 1) {

                                    $OutTimeSrt = strtotime($OutTime);
                                    $SHEndTime = strtotime($SHTT);



                                    //*******Get Minutes
                                    $iCalcOut = (($OutTimeSrt - $SHEndTime) / 60);
                                    $icalData = $iCalcOut - 15; //windi 30kin pase OT hedenne(tbl_ot_pattern_dtl eken balanna)

                                } else if ($AfterShift == 0) {

                                    $OutTimeSrt = strtotime($OutTime);
                                    $SHEndTime = strtotime($SHTT);

                                    //*******Get Minutes
                                    $iCalcOut = (($OutTimeSrt - $SHEndTime) / 60);
                                    $icalData = $iCalcOut;
                                }
                            } else {
                                // nextDay thiywam OT hedena widiha
                                if ($AfterShift == 1) {

                                    // $SHEndTime = strtotime($SHTT);

                                    // $OutTime;

                                    // $H = explode(":",$OutTime);
                                    // $H2 = $H[0];

                                    // $OutT = $H2+24;


                                    // $OutTimeSrt = strtotime($OutT);


                                    // // $OTHHH = $OutT-$SHTT;

                                    // $iCalcOut = (($OutTimeSrt - $SHEndTime) / 60);

                                    // Define the two dates
                                    $date1 = new DateTime($SHTT);
                                    $date2 = new DateTime($OutTime);

                                    // Subtract 24 hours from $date1
                                    $date1->sub(new DateInterval('P1D')); // P1D represents a period of 1 day

                                    // Calculate the difference in minutes
                                    $interval = $date2->getTimestamp() - $date1->getTimestamp();
                                    $totalMinutes = round($interval / 60); // Convert seconds to minutes

                                    // Subtract 30 minutes
                                    $totalMinutes -= 15;

                                    // Store the result in $icalData
                                    $icalData = $totalMinutes;

                                    // echo $icalData; // Output: Updated time difference in minutes



                                    // Using codnighter
                                    // echo $timeDifference;


                                    // Using codnighter


                                    //*******Get Minutes
                                    // $iCalcOut = (($OutTimeSrt - $SHEndTime) / 60);
                                    // $icalData = $iCalcOut - $MinAS;//windi 30kin pase OT hedenne(tbl_ot_pattern_dtl eken balanna)

                                } else if ($AfterShift == 0) { //30m gap ekak nethnm
                                    // check
                                    // Define the two dates
                                    $date1 = new DateTime($SHTT);
                                    $date2 = new DateTime($OutTime);

                                    // Subtract 24 hours from $date1
                                    $date1->sub(new DateInterval('P1D')); // P1D represents a period of 1 day

                                    // Calculate the difference in minutes
                                    $interval = $date2->getTimestamp() - $date1->getTimestamp();
                                    $totalMinutes = round($interval / 60); // Convert seconds to minutes

                                    // Subtract 30 minutes
                                    $totalMinutes -= 15;

                                    // Store the result in $icalData
                                    $icalData = $totalMinutes;
                                }
                            }

                            // if ($icalData >= 0 && ) {
                            // }   

                            // Out wunma passe OT
                            if ($icalData >= 0 && $AfterShift == 1) {
                                $AfterShiftWH = $icalData;
                            }

                            // **************************************************************************************//
                            // kalin giya ewa (ED)
                            $SHIFTDAY['SHIFT'] = $this->Db_model->getfilteredData("SELECT `TDate` FROM tbl_individual_roster WHERE FDate = '$FromDate'");
                            $ToDateOT = $SHIFTDAY['SHIFT'][0]->TDate;
                            // date samanam
                            if ($ToDateOT == $OutDate) {
                                if ($Day == 'DU') {
                                    if ($OutTime < $SHTT) {
                                        $OutTimeSrt = strtotime($OutTime);
                                        $SHEndTime = strtotime($SHTT);
                                        $EDF = ($SHEndTime - $OutTimeSrt) / 60;

                                        // kalin gihhilanm haff day ekak thiynwda balanna
                                        $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");
                                        if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                                            $SHstarttime = "14:00:00";

                                            $OutTimeSrt = strtotime($OutTime);
                                            $SHstartimeSrt = strtotime($SHstarttime);

                                            $iCalcHaffED = ($SHstartimeSrt - $OutTimeSrt) / 60;

                                            if ($iCalcHaffED >= 0) {
                                                //ED thiywa
                                                $ED = $iCalcHaffED;
                                                // $ED = $EDF + $iCalcHaffED;

                                            } else if ($iCalcHaffED <= 0) {
                                                //ED nee
                                                $ED = 0;
                                            }
                                        } else {
                                            $ED = $EDF;
                                        }
                                    }

                                    // $ED = 0 - $icalData;
                                    // if ($ED <= 0) {
                                    //     $ED = 0;
                                    // }
                                }
                            }


                            // **************************************************************************************//
                            // HaffDay walata kalin gihin nethnm (ED)
                            if ($InTime != '' && $InTime != $OutTime && $Day == 'DU' || $OutTime != '' && $Day == 'DU') {

                                $HaffDayaLeave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='0.5' ");
                                if (!empty($HaffDayaLeave[0]->Is_Approve)) {
                                    $SHstarttime = "14:00:00";

                                    $OutTimeSrt = strtotime($OutTime);
                                    $SHstartimeSrt = strtotime($SHstarttime);

                                    $iCalcHaffED = ($SHstartimeSrt - $OutTimeSrt) / 60;

                                    if ($iCalcHaffED <= 0) {
                                        //ED nee

                                        $ED = 0;
                                    } else if ($iCalcHaffED >= 0) {
                                        $ED = $iCalcHaffED;
                                    }
                                }
                            }

                            // var_dump($InDate . ' ' . $InTime . ' ' . $ED . ' ' . $DayStatus);
                            // echo "<br>";
                            // var_dump($OutDate . ' ' . $OutTime . ' ' . $EmpNo);
                            // echo "<br>";
                            // echo "<br>";
                            // die;

                            // DOT
                            // if ($ShiftType == 'EX') {
                            //     $EX_OT_Gap = round(((strtotime($SHTT) - strtotime($InTime)) - 60 * 60) / 60);
                            //     $SH_EX_OT = $EX_OT_Gap - $BeforeShift + 5;
                            //     $Nopay = 0;
                            //     $Nopay_Hrs = 0;
                            // }
                        }


                        // $$$$$$$$$$$$$$$$$$$$$$$//
                        // **************************************************************************************//
                        $OFFDAY['OFF'] = $this->Db_model->getfilteredData("select `ShType` from tbl_individual_roster where FDate = '$FromDate'  ");
                        $Day = $OFFDAY['OFF'][0]->ShType;

                        if ($OutTime == "00:00:00") {
                            $DayStatus = 'MS';
                            $Late_Status = 0;
                            $Nopay = 0;
                            $OutTime = "00:00:00";
                        }



                        // $SH_EX_OT = 0;
                        // $NetLateM = 0;

                        // $ExH_OT = $BeforeShift + $AfterShiftWH;

                        // if ($NetLateM > $ExH_OT) {
                        //     $NetLateM = $NetLateM - $ExH_OT;
                        //     $ApprovedExH = 0;

                        // } else {
                        //     $ApprovedExHTemp = ($ExH_OT - $NetLateM);
                        //     $ApprovedExH = (floor(($ApprovedExHTemp) / $Round)) * $Round;

                        //     $NetLateM = 0;
                        // }

                        // if ($ApprovedExH >= 0) {

                        //     $dataArray = array(
                        //         'EmpNo' => $EmpNo,
                        //         'OTDate' => $FromDate,
                        //         'RateCode' => $Rate,
                        //         'OT_Cat' => $DayCode,
                        //         'OT_Min' => $ApprovedExH
                        //     );

                        //     //                            var_dump($dataArray);
                        //     $result = $this->Db_model->insertData("tbl_ot_d", $dataArray);
                        // }
                        if ($depId == 1 && $hrshdaycheck == 'SAT') {
                            $Alldoubleotmin = 0;
                            $AfterShiftWH = 0;
                            $DayStatus = 'OFF';
                        }

                    }
                    // die;
                    // echo $EmpNo.' '.$OutDate.' '.$OutTime .' '.$newDate;
                    // echo '<br>';



                    $Holiday = $this->Db_model->getfilteredData("select count(Hdate) as HasRow from tbl_holidays where Hdate = '$FromDate' ");
                    if ($Holiday[0]->HasRow == 1) {
                        $DayStatus = 'HD';
                        $Nopay = 0;
                        $Nopay_Hrs = 0;
                        $Att_Allowance = 0;
                    }
                    $Leave = $this->Db_model->getfilteredData("SELECT * FROM tbl_leave_entry where EmpNo = $EmpNo and Leave_Date = '$FromDate' AND Leave_Count='1' ");
                    if (!empty($Leave[0]->Is_Approve)) {
                        $Nopay = 0;
                        $DayStatus = 'LV';
                        $Nopay_Hrs = 0;
                        $Att_Allowance = 0;
                    }
                    $Alldoubleotmin = 0;
                    if ($Day == "OFF" || $Day == "EX") {
                        $Nopay = 0;
                        $OutTime = 0;
                        // $OutDate = 0;
                        $SHFT = 0;
                        $SHTT = 0;
                        $InTime = 0;
                        $ID_Roster = 0;
                        $Shift_Day = 0;
                        $Alldoubleotmin = 0;
                        $Allnomalotmin = 0;
                        $DayStatus = 'OFF';
                        $SH['SH'] = $this->Db_model->getfilteredData("select ID_roster,EmpNo,ShiftCode,ShType,ShiftDay,Day_Type,FDate,FTime,TDate,TTime,ShType,GracePrd from tbl_individual_roster where Is_processed=0 and EmpNo='$EmpNo' and FDate='$FromDate' ");
                        $Shift_Day = $SH['SH'][0]->ShiftDay;

                        //****Shift Type DU| EX
                        $ShiftType = $SH['SH'][0]->ShType;
                        //****Individual Roster ID
                        $ID_Roster = $SH['SH'][0]->ID_roster;
                        $dt_in_Records['dt_in_Records'] = $this->Db_model->getfilteredData("select min(AttTime) as INTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' and AttTime BETWEEN '06:00:00' AND '13:00:00' ");
                        $dt_in_Records['dt_out_Records'] = $this->Db_model->getfilteredData("select max(AttTime) as OUTTime,Enroll_No,AttDate,EventID from tbl_u_attendancedata where Enroll_No='$EmpNo' and AttDate='" . $FromDate . "' and AttTime BETWEEN '13:00:00' AND '23:59:59' ");
                        $InsunIN = $dt_in_Records['dt_in_Records'][0]->INTime;
                        $OutsunOUT = $dt_in_Records['dt_out_Records'][0]->OUTTime;
                        
                        if (!empty($OutsunOUT)) {
                            if (empty($InsunIN)||$InsunIN==''||$InsunIN == null) {
                                $InsunIN = '08:00:00';
                                // $DaysunOUT = date('Y-m-d', strtotime($FromDate . ' +1 day'));
                            }
                            $OutTimeSrt = strtotime($OutsunOUT);
                            $SHEndTime = strtotime($InsunIN);
                            $iCalcOut = round(($OutTimeSrt - $SHEndTime) / 60);
                            $Alldoubleotmin = $iCalcOut;
                            $DayStatus = 'EX';
                            $OutTime = $OutsunOUT;
                            $InTime = $InsunIN;
                        }
                        if ($depId == 1 && $hrshdaycheck == 'SAT') {
                            $Alldoubleotmin = 0;
                            $AfterShiftWH = 0;
                            $DayStatus = 'OFF';
                        }
                        
                    }
                    if ($depId == 1 && $Day == "OFF"  ) {
                        $Alldoubleotmin = 0;
                        $AfterShiftWH = 0;
                        $DayStatus = 'OFF';
                    }

                    // echo $FromDate;
                    // echo "<br/>";
                    // echo $ID_Roster;
                    // echo "<br/>";
                    // echo $EmpNo . "  " . $InTime . " " . $InDate;
                    // echo "<br/>";
                    // echo $EmpNo . "  " . $SHFT . " " . $SHTT;
                    // echo "<br/>";
                    // echo $EmpNo . "  " . $OutTime . " " . $OutDate;
                    // echo "<br/>";
                    // echo $DayStatus;
                    // echo "<br/>";
                    // echo $Shift_Day;
                    // echo "<br/>";
                    // echo $ID_Roster;
                    // echo "<br/>";
                    // echo $Nopay;
                    // echo "<br/>";
                    // echo "late = " . $lateM;
                    // echo "<br/>";
                    // echo "ED = " . $ED;
                    // echo "<br/>";
                    // echo "double ot" . $Alldoubleotmin;
                    // echo "<br/>";
                    // echo "ottime" . $AfterShiftWH;
                    // echo "<br/>";
                    // echo "<br/>";
                    // echo "<br/>";
                    // echo "<br/>";
                    $data_arr = array("InRec" => 1, "InDate" => $InDate, "InTime" => $InTime, "FTime" => $SHFT, "TTime" => $SHTT, "OutRec" => 1, "OutDate" => $OutDate, "OutTime" => $OutTime, "nopay" => $Nopay, "Is_processed" => 1, "DayStatus" => $DayStatus, "BeforeExH" => 0, "AfterExH" => $AfterShiftWH, "LateSt" => $Late_Status, "LateM" => $lateM, "EarlyDepMin" => $ED, "NetLateM" => $NetLateM, "ApprovedExH" => $ApprovedExH, "nopay_hrs" => $Nopay_Hrs, "Att_Allow" => $Att_Allowance, "DOT" => $Alldoubleotmin);
                    $whereArray = array("ID_roster" => $ID_Roster);
                    $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);
                    // $data_arr = array("InRec" => 1, "InDate" => $FromDate, "InTime" => $InTime, "OutRec" => 1, "OutDate" => $OutDate, "OutTime" => $OutTime, "nopay" => $Nopay, "Is_processed" => 1, "DayStatus" => $DayStatus, "AfterExH" => $AfterShiftWH, "LateSt" => $Late_Status, "LateM" => $lateM, "EarlyDepMin" => $ED, "NetLateM" => $NetLateM, "ApprovedExH" => $ApprovedExH, "nopay_hrs" => $Nopay_Hrs, "Att_Allow" => $Att_Allowance);
                    // $whereArray = array("ID_roster" => $ID_Roster);
                    // $result = $this->Db_model->updateData("tbl_individual_roster", $data_arr, $whereArray);

                }
            }
            // }
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_New');
        } else {
            $this->session->set_flashdata('success_message', 'Attendance Process successfully');
            redirect('/Attendance/Attendance_Process_New');
        }
        $this->session->set_flashdata('success_message', 'Attendance Process successfully');
        redirect('/Attendance/Attendance_Process_New');
    }
}
