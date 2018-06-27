<?php

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Progress Report');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, Progress Report, test, guide');

// set default header data
$pdf->SetHeaderData('', '', "Ramkabir", '');
$pdf->setPrintHeader(false);
// set header and footer fonts
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
// ---------------------------------------------------------
// set font
$pdf->SetFont('dejavusans', '', 10);


//$pdf->AddPage('L', 'A4');
//$pdf->Cell(0, 0, '', 0, 0, 'C');
// add a page
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
// create some HTML content
//$html = $data_html_header;
//echo $html;
/* --------------------------------------------------------------------------------------------------------------------------------- */
$htmll = "";
$pdf->AddPage();
$next_year = array(1, 2, 3, 4, 5);

$selected = "selected";
$whole_month = array(6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec", 1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May");

$img_url = NODP;
if (isset($student["std_profileurl"]) && $student["std_profileurl"] != '') {
    $img_url = ASSETURL . 'std_data/' . $student["std_profileurl"];
} else {
    $img_url = ASSETURL . 'std_data/no-image.png';
}

$html = <<<EOF
<style>
    table.main {
        color: #003300;
        font-family: helvetica;
        font-size: 12px;
        border-left: 3px solid black;
        border-right: 3px solid black;
        border-top: 3px solid black;
        border-bottom: 3px solid black;
        
        padding:10px;
    }
        table.sub {
        color: #003300;
        font-family: helvetica;
        font-size: 12px;
        border-left: 3px solid black;
        border-right: 3px solid black;
        border-top: 3px solid black;
        border-bottom: 3px solid black;
        padding:10px;
    }
    table.sub tr > td
    {
        background-color: #ffffee;
        border: 2px solid black;
    }
  table.main tr > td{
        border: 2px solid black;
        background-color: #ffffee;
    }
    th
    {
        border: 2px solid black;
        font-weight:bold;
    }
    div 
    {
        font-weight:bold;
    }
</style>
<div style="text-align:center;"><center><h1>Ramkabir</h1></center></div>
    <h3>Student Details</h3>
<table class="sub">
        <tbody>
            <tr>
                <th>First Name</th>
                <td class="uppercase"> $student[std_firstname]</td>
                <td>$student[std_middlename]</td>
                <td>$student[std_lastname]</td>
                <td rowspan="3"><img src="$img_url" class="img-responsive" alt="profile-image" style="height: 150px;width: 200px;object-fit: cover;"></td>
            </tr>
            <tr>
                <th>Rollno</th>
                <td>$student[std_rollno]</td>
                <th>Mobile</th>
                <td >$student[std_phone]</td>
            </tr>
        <tr >
            <th>Faculty</th>
            <td>$student[std_faculty]</td>
            <th>Standard</th>
            <td>$student[std_standard]</td>
        </tr>
        </tbody>
    </table>   
       

 <br>
    <h3>Exam Reports</h3>
    <table border="1" class="main" style="text-align:center;">
        <thead>
            <tr role="row">
                <th>
                    Exam date
                </th>
                <th>
                    Attendents
                </th>
                <th>
                    Subject
                </th>
                <th>
                    Chapter
                </th>
                <th>
                    Total Marks
                </th>
                <th>
                    Obtain Marks
                </th>

                
            </tr>
        </thead>
        <tbody>
EOF;

$percentage = 0;
$total_obtain = 0;
$all_total = 0;

$table = "Result";
$orderby = "result_id";
foreach ($std_exam_data as $val) {
    $where = array(
        "std_id" => $student["std_id"],
        "exam_id" => $val['exam_id']
    );
    $std_result_data = $this->common_px_mdl->get_orderby($table, $orderby, $where);
    $obt_marks = ( $std_result_data ) ? $std_result_data[0]['result_added_marks'] : 0;
    if ($std_result_data && ($obt_marks != "")) {
        if ($obt_marks == "AB" || $obt_marks == "ab") {
            $obt_marks = "AB";
            $ab_ps = "Absent";
        } else {
           $ab_ps = ($obt_marks == 0) ? "Absent" : "Present";
            $total_obtain = $total_obtain + $obt_marks;
        }
        $all_total = $all_total + $val['exam_total_marks'];

        
        $bk_color = ($obt_marks == 0) ? "#ec383e" : "";
        $date_1 = date("d-m-Y", strtotime($val['exam_date']));


        $html .= <<<EOF
    <tr >
        <td style="background-color:$bk_color;">$date_1</td>
        <td style="background-color:$bk_color;color:#000;">$ab_ps</td> 
        <td style="background-color:$bk_color;">$val[exam_subject]</td>
        <td style="background-color:$bk_color;">$val[exam_chapter]</td>
        <td style="background-color:$bk_color;">$val[exam_total_marks]</td>
        <td style="background-color:$bk_color;">$obt_marks</td>    

    </tr>
EOF;
    }
}
$percentage = ($total_obtain > 0) ? (($total_obtain * 100) / $all_total) : 0;
$percentage = number_format((float) $percentage, 2, '.', '') . "%";
$html .= <<<EOF
        </tbody>
</table>
<br>
<h3>Result</h3>
<table class="main">
    <tbody>
         <tr role="row">
                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" >
                    Percentage : $percentage
                </th>
                <th class="sorting_asc" tabindex="0"  rowspan="1" colspan="1">
                    Total Marks : $all_total 
                </th>
                <th class="sorting" tabindex="0"  rowspan="1" colspan="1"  >
                    Obtain Marks : $total_obtain 
                </th>

                
            </tr>
    </tbody>
</table>
<br><br><br>
<div style="font-size:11px;">Parents Signiture:_______________, Teacher Signiture:_______________, Student Signiture:_______________</div>

EOF;

$pdf->writeHTML($html, true, false, true, false, '');
//$htmll = $data_html;
//$pdf->Cell(0, 0, $htmll, 1, 1, 'L', 1, 0);
;
//$pdf->writeHTML($htmll, true, false, true, false, '');
$pdf->lastPage();
//$pdf->AddPage();
//$htmll = $pdf_graph;
//$pdf->writeHTML($htmll, true, false, true, false, '');
//echo $pdf_graph;die;
//$html .= $data_html;


/* --------------------------------------------------------------------------------------------------------------------------------- */

$html .=' </div> 
</div>
<footer class="footer text-right">
    2017 © Planetx.
</footer>
</div>';


//echo $html;
//$html .= $data_html_footer;
// output the HTML content
//echo $html;
//$pdf->writeHTML($html, true, false, true, false, '');
// output some RTL HTML content

$pdf->Output('progress_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
