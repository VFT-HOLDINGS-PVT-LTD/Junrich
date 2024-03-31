<?php
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
                    $OutRecords = $dt_out_Records['dt_out_Records'][0]->AttDate;//

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
}
?>