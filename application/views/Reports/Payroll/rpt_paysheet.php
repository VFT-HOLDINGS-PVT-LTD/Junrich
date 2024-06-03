<?php

$date = date("Y/m/d");

$data_month;

//var_dump($data_c[0]->id);die;
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Paysheet_Month_' . $data_month . '.pdf');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . '', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


$PDF_HEADER_TITLE = $data_cmp[0]->Company_Name;
$PDF_HEADER_LOGO_WIDTH = '0';
$PDF_HEADER_LOGO = '';
$PDF_HEADER_STRING = '';


// set default header data
$pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE . '', $PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------    
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.



$pdf->SetMargins(5, 14, 15, 0, true);
$pdf->AddPage('L', 'LEGAL');
//$pdf->SetMargins(0, 0, 0, true);
// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.0, 'depth_h' => 0.0, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
$html = '
            <h6 style="margin-left:0px; text-align:center; ">PAY SHEET </h6>
            <div style="font-size: 11px; float: left; border-bottom: solid #000 1px;">Year : ' . $data_year . ' &nbsp;  Month : ' . date('F', mktime(0, 0, 0, $data_month)) . '</div></font><br>
            <table cellpadding="3">
                <thead style="border-bottom: #000 solid 1px;">
                    <tr style="border-bottom: 1px solid black; font-weight:bold"> 
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black; width:60px;">EMP NO</th>                      
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black; width:100px;">NAME</th>                       
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:50px;">BASIC SALARY</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:40px;">BR</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:50px;">TOTAL FOR EPF</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:60px;">OT 15</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:60px;">FIXED</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:55px;">PROD INC I</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:50px;">PROD INC II</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:40px;">SPC.ALL</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:55px;border-TOP: 1px solid black;">GROSS PAY</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:55px;border-TOP: 1px solid black;">EPF 8%</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:60px;border-TOP: 1px solid black;">ADV.PAID</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:55px;border-TOP: 1px solid black;">OTHER</th>                       
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:70px;border-TOP: 1px solid black;">P.A.Y.E</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:70px;border-TOP: 1px solid black;">WELFAIR</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:50px;border-TOP: 1px solid black;">TOTAL DEDUCTION</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:50px;border-TOP: 1px solid black;">NET SALARY</th>                        
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:50px;border-TOP: 1px solid black;">EPF 12%</th>
                        <th style="font-size:8px;border-bottom: 1px dashed  black;width:50px;border-TOP: 1px solid black;">BALANCE</th>                                                                                                                                                                                                            
                    </tr>
                    <tr style="border-bottom: 1px solid black; font-weight:bold"> 
                        <th style="font-size:8px; width:60px;"></th>                      
                        <th style="font-size:8px; width:100px;"></th>                      
                        <th style="font-size:8px;width:50px;">SAL ARREAS</th>
                        <th style="font-size:8px;width:40px;">NO PAY</th>
                        <th style="font-size:8px;width:50px;">SUNDAY OT</th>
                        <th style="font-size:8px;width:60px;">OT 20</th>
                        <th style="font-size:8px;width:60px;">ATTBON</th>
                        <th style="font-size:8px;width:55px;">SPC INC</th>
                        <th style="font-size:8px;width:50px;">OTHER ALLOW</th>
                        <th style="font-size:8px;width:40px;"></th>
                        <th style="font-size:8px;width:55px;"></th>
                        <th style="font-size:8px;width:55px;"></th>
                        <th style="font-size:8px;width:60px;">FEST ADV</th>
                        <th style="font-size:8px;width:55px;">UNIFORM</th>                      
                        <th style="font-size:8px;width:70px;">STAMP</th>
                        <th style="font-size:8px;width:70px;">LOAN</th>
                        <th style="font-size:8px;width:50px;"></th>
                        <th style="font-size:8px;width:50px;">STAMP</th>                       
                        <th style="font-size:8px;width:50px;">ETF 3%</th>
                        <th style="font-size:8px;width:50px;"></th>                                                                                                                                                                                                                      
                    </tr>
                </thead>
             <tbody>';

foreach ($data_set as $data) {


    $html .= ' <tr>
    <th style="font-size:8px;border-bottom: 1px dashed black;border-TOP: 1px solid black; width:60px;">' . $data->EmpNo . '</th>                      
    <th style="font-size:8px;border-bottom: 1px dashed black;border-TOP: 1px solid black; width:100px;">' . $data->Emp_Full_Name . '</th>                       
    <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:50px;">' . number_format($data->Basic_sal, 2, '.', ',')  . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:40px;">' . number_format($data->Br_pay, 2, '.', ',')  . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:50px;">' . number_format($data->Total_F_Epf, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:60px;">' . number_format($data->Normal_OT_Pay, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:60px;">' . number_format($data->Fixed, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:55px;">' . number_format($data->Prod_inc1, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:50px;">' . number_format($data->Prod_inc2, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;border-TOP: 1px solid black;width:40px;">' . number_format($data->spc_all, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:55px;border-TOP: 1px solid black;">' .  number_format($data->Gross_pay, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:55px;border-TOP: 1px solid black;">' . number_format($data->EPF_Worker_Amount, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:60px;border-TOP: 1px solid black;">' . number_format($data->Salary_advance, 2, '.', ',')  . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:55px;border-TOP: 1px solid black;">' . number_format($data->Deductions, 2, '.', ',') . '</th>                       
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:70px;border-TOP: 1px solid black;">' . number_format($data->Payee_amount, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:70px;border-TOP: 1px solid black;">' . number_format($data->Wellfare, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:50px;border-TOP: 1px solid black;">' . number_format($data->tot_deduction, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:50px;border-TOP: 1px solid black;">' . number_format($data->D_Salary, 2, '.', ',') . '</th>                        
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:50px;border-TOP: 1px solid black;">' . number_format($data->EPF_Employee_Amount, 2, '.', ',') . '</th>
    <th style="font-size:8px;border-bottom: 1px dashed  black;width:50px;border-TOP: 1px solid black;">' . number_format($data->Net_salary, 2, '.', ',') . '</th>                                                     
                </tr>
                <tr>
                        <td  style="font-size:8px;  width:60px;"></td>                       
                        <td style="font-size:8px;width:100px;"></td>                          
                        <td style="font-size:8px;width:50px;">' . number_format(0, 2, '.', ',')  . '</td>
                        <td style="font-size:8px;width:40px;">' . number_format($data->no_pay_deduction, 2, '.', ',') . '</td>
                        <td style="font-size:8px;width:50px;">' . number_format($data->Double_OT_Pay, 2, '.', ',')  . '</td>
                        <td style="font-size:8px;width:60px;">' . number_format($data->Double_OT_Pay, 2, '.', ',') . '</td>
                        <td style="font-size:8px;width:60px;">' . number_format($data->Att_Allowance, 2, '.', ',') . '</td>
                        <td style="font-size:8px;width:55px;">' . number_format($data->Spc_inc1, 2, '.', ',') . '</td>
                        <td style="font-size:8px;width:50px;">' . number_format($data->Allowances, 2, '.', ',') . '</td>
                        <td style="font-size:8px;width:40px;"></td>
                        <td style="font-size:8px;width:55px;"></td>
                        <td style="font-size:8px;width:55px;"></td>
                        <td style="font-size:8px;width:60px;">' . number_format($data->Festivel_Advance, 2, '.', ',') . '</td>
                        <td style="font-size:8px;width:55px;">' . number_format(0, 2, '.', ',')  . '</td>                           
                        <td style="font-size:8px;width:70px;">' . number_format(0, 2, '.', ',') . '</td>                               
                        <td style="font-size:8px;width:70px;">' . number_format($data->Loan_Instalment, 2, '.', ',') . '</td>                       
                        <td style="font-size:8px;width:50px;"></td>
                        <td style="font-size:8px;width:50px;">' . number_format(0, 2, '.', ',') . '</td>
                        <td style="font-size:8px;width:50px;">' . number_format($data->ETF_Amount, 2, '.', ',') . '</td>
                        <td style="font-size:8px;width:50px;"></td>                        
                                                                              
                </tr>';
}
$html .= '</tbody>
                  
          </table>
        <br>




';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------    
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Paysheet_Month_' . $data_month . '.pdf', 'I');

//============================================================+
    // END OF FILE
    //============================================================+
