<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_Process extends CI_Controller {

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

        $this->load->helper('url');
        $data['title'] = "Payroll Process | HRM SYSTEM";
        $data['data_emp'] = $this->Db_model->getData('EmpNo,Emp_Full_Name', 'tbl_empmaster');
        $this->load->view('Payroll/Payroll_process/index', $data);
    }

    /*
     * Payroll Process
     */

    public function emp_payroll_process() {
//die;
        date_default_timezone_set('Asia/Colombo');
        $year = date("Y");
        $month = $this->input->post('cmb_month');

        $date = date_create();
        $timestamp = date_format($date, 'Y-m-d H:i:s');

        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,EMP_ST_ID,Enroll_No, EPFNO,Dep_ID,Des_ID,RosterCode, Status  FROM  tbl_empmaster where status=1 and Active_process=1");
//        $dtEmp['EmpData'] = $this->Db_model->getfilteredData("SELECT EmpNo,Enroll_No, EPFNO,Dep_ID,Des_ID,RosterCode, Status  FROM  tbl_empmaster where EmpNo=3316");
        //For loop for All active employees 
        for ($x = 0; $x < count($dtEmp['EmpData']); $x++) {



            $EmpNo = $dtEmp['EmpData'][$x]->EmpNo;
            $EpfNo = $dtEmp['EmpData'][$x]->EPFNO;
            $Dep_ID = $dtEmp['EmpData'][$x]->Dep_ID;
            $Des_ID = $dtEmp['EmpData'][$x]->Des_ID;

            $Emp_ST = $dtEmp['EmpData'][$x]->EMP_ST_ID;


            $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_salary where EmpNo=$EmpNo and month=$month and year=$year");

//            var_dump($HasRow);die;
            //IF Salary records have in Salary table update salary records into salary table

            if ($HasRow[0]->HasRow > 0) {

//            var_dump($dtEmp['EmpData']);die;
                //Get Employee Basic Salary | Incentive
                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO, Is_EPF,Dep_ID, Des_ID,Basic_Salary,Fixed_Allowance,Incentive from tbl_empmaster where EmpNo=$EmpNo");
                $BasicSal = $SalData[0]->Basic_Salary;
                $Incentive = $SalData[0]->Incentive;
                $Fixed_Allowance = $SalData[0]->Fixed_Allowance;
                $Is_EPF = $SalData[0]->Is_EPF;


                //Get Nopay days in Individual Roster table
                $Nopay = $this->Db_model->getfilteredData("select sum(nopay) as nopay, sum(nopay_hrs) nopay_hrs,sum(Att_Allow) as Att_Allow from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and EXTRACT(YEAR FROM FDate)=$year");
                $NopayDays = $Nopay[0]->nopay;
                $Nopay_Hrs = $Nopay[0]->nopay_hrs;

                var_dump($NopayDays . '------------');

                if ($NopayDays == 0) {
                    $NopayDays = 0;
                    $Att_Allowance = 1000;
//                    die;
                }



                $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);


                var_dump($days . $Nopay[0]->Att_Allow);

                $Att_Allowance = 0;
                if ($Nopay[0]->Att_Allow == $days) {
                    $Att_Allowance = 1000;
                }



                //Calculate Nopay deduction
                $NopayRate = ($BasicSal + $Fixed_Allowance) / 30;


                if ($Emp_ST == 2) {
                    $NopayRate = ($BasicSal + $Fixed_Allowance) / 25;
                }

                echo $Emp_ST . "______" . $NopayRate;
//                die;



                $Nopay_Deduction = $NopayRate * $NopayDays;



                var_dump($Nopay_Deduction . 'no pay days' . $NopayDays);

                //Get Variable Allowances details
                $Allowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_varialble_allowance where EmpNo=$EmpNo and Month=$month and Year=$year");

                //Get Variable Deductions details
                $Deductions = $this->Db_model->getfilteredData("select Ded_ID,Amount from tbl_variable_deduction where EmpNo=$EmpNo and Month=$month and Year=$year");

                //Get Salary Advance details
                $Sal_Advance = $this->Db_model->getfilteredData("select Amount from tbl_salary_advance where Is_Approve=1 and EmpNo=$EmpNo and month=$month and year = $year");

                $Fest_Advance = $this->Db_model->getfilteredData("SELECT Amount from tbl_festivel_advance where EmpNo=$EmpNo and Month=$month and Year = $year");

                if ($Fest_Advance == null) {
                    $Festivel_Advance = 0;
                } else {
                    $Festivel_Advance = $Fest_Advance[0]->Amount;
                }

                //Get loan details
                $Loan = $this->Db_model->getfilteredData("select Loan_ID,Loan_amount,Month_Installment,FullAmount,Paid_Amount from tbl_loans where Is_Settled=0 and EmpNo=$EmpNo");



                /*
                 * Loan Details
                 */

                if (empty($Loan[0]->Loan_ID)) {
                    $LoanID = 0;
                } else {
                    $LoanID = $Loan[0]->Loan_ID;
                }


                if (empty($Loan[0]->Month_Installment)) {
                    $LoanMonth = 0;
                } else {
                    $LoanMonth = $Loan[0]->Month_Installment;
                }

                /*
                 * Salary Advance Details
                 */


                if (empty($Sal_Advance[0]->Amount)) {
                    $Sal_advance = 0;
                } else {
                    $Sal_advance = $Sal_Advance[0]->Amount;
                }

                /*
                 * Allowance Details
                 */


                if (empty($Allowances[0]->Alw_ID)) {
                    $Allowance_ID_1 = 0;
                } else {
                    $Allowance_ID_1 = $Allowances[0]->Alw_ID;
                }

                if (empty($Allowances[0]->Amount)) {
                    $Allowance_1 = 0;
                } else {
                    $Allowance_1 = $Allowances[0]->Amount;
                }

                if (empty($Allowances[1]->Alw_ID)) {
                    $Allowance_ID_2 = 0;
                } else {
                    $Allowance_ID_2 = $Allowances[1]->Alw_ID;
                }

                if (empty($Allowances[1]->Amount)) {
                    $Allowance_2 = 0;
                } else {
                    $Allowance_2 = $Allowances[1]->Amount;
                }

                if (empty($Allowances[2]->Alw_ID)) {
                    $Allowance_ID_3 = 0;
                } else {
                    $Allowance_ID_3 = $Allowances[2]->Alw_ID;
                }

                if (empty($Allowances[2]->Amount)) {
                    $Allowance_3 = 0;
                } else {
                    $Allowance_3 = $Allowances[2]->Amount;
                }

                /*
                 * Deduction Details
                 */

                if (empty($Deductions[0]->Ded_ID)) {
                    $Deduction_ID_1 = 0;
                } else {
                    $Deduction_ID_1 = $Deductions[0]->Ded_ID;
                }

                if (empty($Deductions[0]->Amount)) {
                    $Deduction_1 = 0;
                } else {
                    $Deduction_1 = $Deductions[0]->Amount;
                }

                if (empty($Deductions[1]->Ded_ID)) {
                    $Deduction_ID_2 = 0;
                } else {
                    $Deduction_ID_2 = $Deductions[1]->Ded_ID;
                }

                if (empty($Deductions[1]->Amount)) {
                    $Deduction_2 = 0;
                } else {
                    $Deduction_2 = $Deductions[1]->Amount;
                }

                if (empty($Deductions[2]->Ded_ID)) {
                    $Deduction_ID_3 = 0;
                } else {
                    $Deduction_ID_3 = $Deductions[2]->Ded_ID;
                }

                if (empty($Deductions[2]->Amount)) {
                    $Deduction_3 = 0;
                } else {
                    $Deduction_3 = $Deductions[2]->Amount;
                }





                //Get Overtime details
//                $Overtime = $this->Db_model->getfilteredData("select sum(ApprovedExH) as OT from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");
                //---------Normal OT Calculation
//                $Overtime = $this->Db_model->getfilteredData("select sum(OT_Min) as N_OT from tbl_ot_d where EmpNo='$EmpNo' and RateCode = 1.5 and EXTRACT(MONTH FROM OTDate)=$month and  EXTRACT(YEAR FROM OTDate) =$year");
//
//                $N_OT_Hours = $Overtime[0]->N_OT;

                $Overtime_DB = $this->Db_model->getfilteredData("select sum(OT_Min) as D_OT from tbl_ot_d where EmpNo='$EmpNo' and RateCode = 2 and EXTRACT(MONTH FROM OTDate)=$month and  EXTRACT(YEAR FROM OTDate) =$year");
                $Overtime = $this->Db_model->getfilteredData("select sum(OT_Min) as N_OT from tbl_ot_d where EmpNo='$EmpNo' and RateCode = 1.5 and EXTRACT(MONTH FROM OTDate)=$month and  EXTRACT(YEAR FROM OTDate) =$year");

                $N_OT_Hours = $Overtime[0]->N_OT;

                $D_OT_Hours = $Overtime_DB[0]->D_OT;

                $OT_Rate = ((($BasicSal + $Fixed_Allowance) / 240) * 1.5);
                $N_OT_Amount = $OT_Rate * ($N_OT_Hours / 60);

//                var_dump($D_OT_Hours . '_Emp' . $EmpNo);

                $OT_Rate_2 = ((($BasicSal + $Fixed_Allowance) / 240) * 2);
                $D_OT_Amount = $OT_Rate_2 * ($D_OT_Hours / 60);




//                if (!empty($NopayDays)) {
//
//                    $Incentive = $Incentive - (($Incentive / 30) * $NopayDays);
//                }
                //*** Get Late Minutes
                $Late_Min = $this->Db_model->getfilteredData("select sum(LateM) as LateMin from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");

                //*** Late Min
                if (empty($Late_Min[0]->LateMin)) {
                    $Late_Min = 0;
                } else {
                    $Late_Min = $Late_Min[0]->LateMin;
                }

                //240 = 30*8
                $Late_rate = (($BasicSal / 240) ) / 60;
                //** Late Amount
//                $Late_Amount = $Late_rate * $Late_Min;
//                Kangara Holdigs
                $Late_Amount = 0;


                //All Allowances
                $Allowances = $Allowance_1 + $Allowance_2 + $Allowance_3;
//                var_dump($Allowances);
//                die;
                //Calculate Gross salary
                $Gross_sal = ($BasicSal + $Fixed_Allowance + $Incentive);

                //Calculate EPF Employee
                $EPF_Worker = (8 / 100) * ($BasicSal + $Fixed_Allowance);

                //Calculate EPF Employer
                $EPF_Employer = (12 / 100) * ($BasicSal + $Fixed_Allowance);

                //Calculate ETF Employee
                $ETF = (3 / 100) * ($BasicSal + $Fixed_Allowance);

                //Calculate Total Deductions
                $Tot_deductions = $EPF_Worker + $Sal_advance + $Festivel_Advance + $Deduction_1 + $Deduction_2 + $Deduction_3 + $LoanMonth + $Late_Amount + $Nopay_Deduction;

                //Calculate Net Salary
                $netSal = ($Gross_sal + $N_OT_Amount + $D_OT_Amount + $Att_Allowance + $Allowances) - $Tot_deductions;




                $D_Salary = $Gross_sal - $Tot_deductions;


//---------------------  only kangara holdings
                if ($BasicSal >= 50000) {

                    $N_OT_Hours = 0;
                    $N_OT_Amount = 0;
                    $D_OT_Hours = 0;
                    $D_OT_Amount = 0;
                }


                if ($Is_EPF == 0) {
                    $EPF_Worker = 0;
                    $EPF_Employer = 0;
                    $ETF = 0;
                }

//---------------------  only kangara holdings




                $data = array(
                    'EmpNo' => $EmpNo,
                    'EPFNO' => $EpfNo,
                    'Basic_sal' => $BasicSal,
                    'Incentive' => $Incentive,
                    'Dep_ID' => $Dep_ID,
                    'Des_ID' => $Des_ID,
                    'No_Pay_days' => $NopayDays,
                    'No_Pay_Hrs' => $Nopay_Hrs,
                    'no_pay_deduction' => $Nopay_Deduction,
                    'EPF_Worker_Rate' => 8,
                    'EPF_Worker_Amount' => $EPF_Worker,
                    'EPF_Employee_Rate' => 12,
                    'EPF_Employee_Amount' => $EPF_Employer,
                    'ETF_Rate' => 3,
                    'ETF_Amount' => $ETF,
                    'Loan_Instalment' => $LoanMonth,
                    'Salary_advance' => $Sal_advance,
                    'Festivel_Advance' => $Festivel_Advance,
                    'Late_min' => 0,
//                    'Late_min' => $Late_Min,
                    'Late_deduction' => 0,
//                    'Late_deduction' => $Late_Amount,
                    'Alw_ID_1' => $Allowance_ID_1,
                    'Allowance_1' => $Allowance_1,
                    'Alw_ID_2' => $Allowance_ID_2,
                    'Allowance_2' => $Allowance_2,
                    'Alw_ID_3' => $Allowance_ID_3,
                    'Allowance_3' => $Allowance_3,
                    'Att_Allowance' => $Att_Allowance,
                    'Normal_OT_Hrs' => ($N_OT_Hours / 60),
                    'Normal_OT_Pay' => $N_OT_Amount,
                    'Double_OT_Hrs' => ($D_OT_Hours / 60),
                    'Double_OT_Pay' => $D_OT_Amount,
                    'Ded_ID_1' => $Deduction_ID_1,
                    'Deduct_1' => $Deduction_1,
                    'Ded_ID_2' => $Deduction_ID_2,
                    'Deduct_2' => $Deduction_2,
                    'Ded_ID_3' => $Deduction_ID_3,
                    'Deduct_3' => $Deduction_3,
//                    'Wellfare' => 200,
                    'tot_deduction' => $Tot_deductions,
                    'Gross_sal' => $Gross_sal,
                    'D_Salary' => $D_Salary,
                    'Net_salary' => $netSal);


                //***** Update Salary Table
                $whereArray = array("EmpNo" => $EmpNo, 'Month' => $month, 'Year' => $year);
                $result = $this->Db_model->updateData("tbl_salary", $data, $whereArray);


                /*
                 * Loan Amount
                 */
                if (empty($Loan[0]->Paid_Amount)) {
                    $PaidAmount = 0;
                } else {
                    $PaidAmount = $Loan[0]->Paid_Amount;
                }

                if (empty($Loan[0]->FullAmount)) {
                    $Full_Amount = 0;
                } else {
                    $Full_Amount = $Loan[0]->FullAmount;
                }





                //****** Loan Amount deduction process
                $PaidAmount_to = $PaidAmount + $LoanMonth;
                $BalanceAmount = $Full_Amount - $PaidAmount_to;

                If ($BalanceAmount == 0) {
                    $Is_Settele = 1;
                } else {
                    $Is_Settele = 0;
                }


                $data_loan = array(
                    'EmpNo' => $EmpNo,
                    'Paid_Amount' => $PaidAmount_to,
                    'Balance_amount' => $BalanceAmount,
                    'Is_Settled' => $Is_Settele,
                );



                $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_loan_trans where EmpNo=$EmpNo and month=$month and year=$year");


                if ($LoanMonth == 0) {
                    
                } {
                    $dataArray = array(
                        'Year' => $year,
                        'EmpNo' => $EmpNo,
                        'Month' => $month,
                        'Amount_month' => $LoanMonth,
                        'Loan_ID' => $LoanID,
                        'Time_Trans' => $timestamp,
                    );

                    $this->Db_model->insertData("tbl_loan_trans", $dataArray);
                }




                $HasRow = $this->Db_model->getfilteredData("select count(EmpNo) as HasRow from tbl_loan_trans where EmpNo=$EmpNo and month=$month and year=$year ");

                if ($HasRow[0]->HasRow) {
                    
                } else {
                    $whereArray_loan = array("EmpNo" => $EmpNo);
                    $result = $this->Db_model->updateData("tbl_loans", $data_loan, $whereArray_loan);
                }


//die;
                //*******Else Salary records haven't in Salary table insert salary records into salary table
            } else {


                $SalData = $this->Db_model->getfilteredData("select EmpNo,EPFNO,Is_EPF, Dep_ID, Des_ID,Basic_Salary,Fixed_Allowance,Incentive from tbl_empmaster where EmpNo=$EmpNo");
                $BasicSal = $SalData[0]->Basic_Salary;
                $Incentive = $SalData[0]->Incentive;
                $Fixed_Allowance = $SalData[0]->Fixed_Allowance;
                $Is_EPF = $SalData[0]->Is_EPF;

                //**** Get Nopay days
                $Nopay = $this->Db_model->getfilteredData("select sum(nopay) as nopay, sum(nopay_hrs) nopay_hrs,sum(Att_Allow) as Att_Allow from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and EXTRACT(YEAR FROM FDate)=$year");
                $NopayDays = $Nopay[0]->nopay;

                var_dump($NopayDays);


                if ($NopayDays == 0) {
                    $NopayDays = 0;
                    $Att_Allowance = 1000;
//                    die;
                }



                $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);


                var_dump($days . $Nopay[0]->Att_Allow);

                $Att_Allowance = 0;
                if ($Nopay[0]->Att_Allow == $days) {
                    $Att_Allowance = 1000;
                }


                if ($NopayDays == null) {
                    $NopayDays = 0;
                }



                //**** Calculate no pay amount
                $NopayRate = ($BasicSal + $Incentive) / 30;
                $Nopay_Deduction = $NopayRate * $NopayDays;


              


                //**** Get Allowance Details
                $Allowances = $this->Db_model->getfilteredData("select Alw_ID, Amount from tbl_varialble_allowance where EmpNo=$EmpNo and Month=$month and Year=$year");

                //**** Get deduction Details
                $Deductions = $this->Db_model->getfilteredData("select Ded_ID,Amount from tbl_variable_deduction where EmpNo=$EmpNo and Month=$month and Year=$year");

                //**** Get salary advance
                $Sal_Advance = $this->Db_model->getfilteredData("select Amount from tbl_salary_advance where Is_Approve=1 and EmpNo=$EmpNo and month=$month and year = $year");

                $Fest_Advance = $this->Db_model->getfilteredData("SELECT Amount from tbl_festivel_advance where EmpNo=$EmpNo and Month=$month and Year = $year");

                if ($Fest_Advance == null) {
                    $Festivel_Advance = 0;
                } else {
                    $Festivel_Advance = $Fest_Advance[0]->Amount;
                }

                //**** Get loan Details
                $Loan = $this->Db_model->getfilteredData("select Loan_ID,Loan_amount,Month_Installment,FullAmount,Paid_Amount from tbl_loans where Is_Settled=0 and EmpNo=$EmpNo");



                /*
                 * Loan Details
                 */

                if (empty($Loan[0]->Loan_ID)) {
                    $LoanID = 0;
                } else {
                    $LoanID = $Loan[0]->Loan_ID;
                }


                if (empty($Loan[0]->Month_Installment)) {
                    $LoanMonth = 0;
                } else {
                    $LoanMonth = $Loan[0]->Month_Installment;
                }

                /*
                 * Salary Advance Details
                 */


                if (empty($Sal_Advance[0]->Amount)) {
                    $Sal_advance = 0;
                } else {
                    $Sal_advance = $Sal_Advance[0]->Amount;
                }

                /*
                 * Allowance Details
                 */


                if (empty($Allowances[0]->Alw_ID)) {
                    $Allowance_ID_1 = 0;
                } else {
                    $Allowance_ID_1 = $Allowances[0]->Alw_ID;
                }

                if (empty($Allowances[0]->Amount)) {
                    $Allowance_1 = 0;
                } else {
                    $Allowance_1 = $Allowances[0]->Amount;
                }

                if (empty($Allowances[1]->Alw_ID)) {
                    $Allowance_ID_2 = 0;
                } else {
                    $Allowance_ID_2 = $Allowances[1]->Alw_ID;
                }

                if (empty($Allowances[1]->Amount)) {
                    $Allowance_2 = 0;
                } else {
                    $Allowance_2 = $Allowances[1]->Amount;
                }

                if (empty($Allowances[2]->Alw_ID)) {
                    $Allowance_ID_3 = 0;
                } else {
                    $Allowance_ID_3 = $Allowances[2]->Alw_ID;
                }

                if (empty($Allowances[2]->Amount)) {
                    $Allowance_3 = 0;
                } else {
                    $Allowance_3 = $Allowances[2]->Amount;
                }

                /*
                 * Deduction Details
                 */

                if (empty($Deductions[0]->Ded_ID)) {
                    $Deduction_ID_1 = 0;
                } else {
                    $Deduction_ID_1 = $Deductions[0]->Ded_ID;
                }

                if (empty($Deductions[0]->Amount)) {
                    $Deduction_1 = 0;
                } else {
                    $Deduction_1 = $Deductions[0]->Amount;
                }

                if (empty($Deductions[1]->Ded_ID)) {
                    $Deduction_ID_2 = 0;
                } else {
                    $Deduction_ID_2 = $Deductions[1]->Ded_ID;
                }

                if (empty($Deductions[1]->Amount)) {
                    $Deduction_2 = 0;
                } else {
                    $Deduction_2 = $Deductions[1]->Amount;
                }

                if (empty($Deductions[2]->Ded_ID)) {
                    $Deduction_ID_3 = 0;
                } else {
                    $Deduction_ID_3 = $Deductions[2]->Ded_ID;
                }

                if (empty($Deductions[2]->Amount)) {
                    $Deduction_3 = 0;
                } else {
                    $Deduction_3 = $Deductions[2]->Amount;
                }

                //Get Overtime details
                $Overtime_DB = $this->Db_model->getfilteredData("select sum(OT_Min) as D_OT from tbl_ot_d where EmpNo='$EmpNo' and RateCode = 2 and EXTRACT(MONTH FROM OTDate)=$month and  EXTRACT(YEAR FROM OTDate) =$year");
                $Overtime = $this->Db_model->getfilteredData("select sum(OT_Min) as N_OT from tbl_ot_d where EmpNo='$EmpNo' and RateCode = 1.5 and EXTRACT(MONTH FROM OTDate)=$month and  EXTRACT(YEAR FROM OTDate) =$year");

                $N_OT_Hours = $Overtime[0]->N_OT;

                $D_OT_Hours = $Overtime_DB[0]->D_OT;

                $OT_Rate = ((($BasicSal + $Fixed_Allowance) / 240) * 1.5);
                $N_OT_Amount = $OT_Rate * ($N_OT_Hours / 60);

                var_dump($D_OT_Hours . '_Emp' . $EmpNo);

                $OT_Rate_2 = ((($BasicSal + $Fixed_Allowance) / 240) * 2);
                $D_OT_Amount = $OT_Rate_2 * ($D_OT_Hours / 60);


                //*** Get Late Minutes
                $Late_Min = $this->Db_model->getfilteredData("select sum(LateM) as LateMin from tbl_individual_roster where EmpNo=$EmpNo and EXTRACT(MONTH FROM FDate)=$month and RYear=$year");

                //*** Late Min

                if (empty($Late_Min[0]->LateMin)) {
                    $Late_Min = 0;
                } else {
                    $Late_Min = $Late_Min[0]->LateMin;
                }


                $Late_rate = (($BasicSal / 240) ) / 60;
                //** Late Amount
//                $Late_Amount = $Late_rate * $Late_Min;
//                 Kangara Holdigs
                $Late_Amount = 0;




                //All Allowances
                $Allowances = $Allowance_1 + $Allowance_2 + $Allowance_3;
//                var_dump($Allowances);
//                die;
                //Calculate Gross salary
                $Gross_sal = ($BasicSal + $Fixed_Allowance + $Incentive);

                //Calculate EPF Employee
                $EPF_Worker = (8 / 100) * ($BasicSal + $Fixed_Allowance);

                //Calculate EPF Employer
                $EPF_Employer = (12 / 100) * ($BasicSal + $Fixed_Allowance);

                //Calculate ETF Employee
                $ETF = (3 / 100) * ($BasicSal + $Fixed_Allowance);

                //Calculate Total Deductions
                $Tot_deductions = $EPF_Worker + $Sal_advance + $Festivel_Advance + $Deduction_1 + $Deduction_2 + $Deduction_3 + $LoanMonth + $Late_Amount + $Nopay_Deduction;

                //Calculate Net Salary
                $netSal = ($Gross_sal + $N_OT_Amount + $D_OT_Amount + $Att_Allowance + $Allowances) - $Tot_deductions;




                $D_Salary = $Gross_sal - $Tot_deductions;




//---------------------  only kangara holdings

                if ($BasicSal >= 50000) {

                    $N_OT_Hours = 0;
                    $N_OT_Amount = 0;
                    $D_OT_Hours = 0;
                    $D_OT_Amount = 0;
                }

                if ($Is_EPF == 0) {
                    $EPF_Worker = 0;
                    $EPF_Employer = 0;
                    $ETF = 0;

                }
//---------------------  only kangara holdings


                $data = array(
                    array(
                        'EmpNo' => $EmpNo,
                        'EPFNO' => $EpfNo,
                        'Month' => $month,
                        'Year' => $year,
                        'Basic_sal' => $BasicSal,
                        'Incentive' => $Incentive,
                        'Dep_ID' => $Dep_ID,
                        'Des_ID' => $Des_ID,
                        'No_Pay_days' => $NopayDays,
                        'no_pay_deduction' => $Nopay_Deduction,
                        'EPF_Worker_Rate' => 8,
                        'EPF_Worker_Amount' => $EPF_Worker,
                        'EPF_Employee_Rate' => 12,
                        'EPF_Employee_Amount' => $EPF_Employer,
                        'ETF_Rate' => 3,
                        'ETF_Amount' => $ETF,
                        'Loan_Instalment' => $LoanMonth,
                        'Salary_advance' => $Sal_advance,
//                        'Late_min' => $Late_Min,
//                        'Late_deduction' => $Late_Amount,
                        'Late_min' => 0,
                        'Late_deduction' => 0,
                        'Alw_ID_1' => $Allowance_ID_1,
                        'Allowance_1' => $Allowance_1,
                        'Alw_ID_2' => $Allowance_ID_2,
                        'Allowance_2' => $Allowance_2,
                        'Alw_ID_3' => $Allowance_ID_3,
                        'Allowance_3' => $Allowance_3,
                        'Normal_OT_Hrs' => ($N_OT_Hours / 60),
                        'Normal_OT_Pay' => $N_OT_Amount,
                        'Double_OT_Hrs' => ($D_OT_Hours / 60),
                        'Double_OT_Pay' => $D_OT_Amount,
                        'Ded_ID_1' => $Deduction_ID_1,
                        'Deduct_1' => $Deduction_1,
                        'Ded_ID_2' => $Deduction_ID_2,
                        'Deduct_2' => $Deduction_2,
                        'Ded_ID_3' => $Deduction_ID_3,
                        'Deduct_3' => $Deduction_3,
                        'tot_deduction' => $Tot_deductions,
                        'Gross_sal' => $Gross_sal,
                        'D_Salary' => $D_Salary,
                        'Net_salary' => $netSal
                ));



                $this->db->insert_batch('tbl_salary', $data);

                if (empty($Loan[0]->Paid_Amount)) {
                    $PaidAmount = 0;
                } else {
                    $PaidAmount = $Loan[0]->Paid_Amount;
                }


                $PaidAmount_to = $PaidAmount + $LoanMonth;


                if (empty($Loan[0]->FullAmount)) {
                    $Full_Amount = 0;
                } else {
                    $Full_Amount = $Loan[0]->FullAmount;
                }



                $BalanceAmount = $Full_Amount - $PaidAmount_to;

                If ($BalanceAmount == 0) {
                    $Is_Settele = 1;
                } else {
                    $Is_Settele = 0;
                }


                $data_loan = array(
                    'EmpNo' => $EmpNo,
                    'Paid_Amount' => $PaidAmount_to,
                    'Balance_amount' => $BalanceAmount,
                    'Is_Settled' => $Is_Settele,
                );


                $whereArray_loan = array("EmpNo" => $EmpNo);
                $result = $this->Db_model->updateData("tbl_loans", $data_loan, $whereArray_loan);


                $this->session->set_flashdata('success_message', 'Allovance added successfully');
            }
        }
//        die;

        $this->session->set_flashdata('success_message', 'Payroll Process successfully');
        redirect(base_url() . 'Pay/Payroll_Process');
    }

}
