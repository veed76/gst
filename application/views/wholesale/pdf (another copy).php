<?php

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Wholesale Bill');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, Wholesale Bill, test, guide');

// set default header data
$pdf->SetHeaderData('', '', WEBSITE_NAME , '');
$pdf->setPrintHeader(false);
// set header and footer fonts
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
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
if($print_value == 1)
{
    $print_value='<font class="pdf_print text-bold cursor_pointer decoration-color">Original</font> &nbsp;&nbsp;&nbsp; <font class="pdf_print text-bold cursor_pointer decoration-color" style="text-decoration: line-through;">Duplicate</font>';
}else
{
    $print_value='<font class="pdf_print text-bold cursor_pointer decoration-color" style="text-decoration: line-through;">Original</font> &nbsp;&nbsp;&nbsp; <font class="pdf_print text-bold cursor_pointer decoration-color" >Duplicate</font>';
}
$pdf->AddPage('P','A4');
/*$img_url = NODP;
if (isset($student["std_profileurl"]) && $student["std_profileurl"] != '') {
    $img_url = ASSETURL . 'std_data/' . $student["std_profileurl"];
} else {
    $img_url = ASSETURL . 'std_data/no-image.png';
}*/
$date = date("d-m-Y",strtotime($wholesale_data["wholesale_generatedt"]));
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
        padding:5px;
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
    .text-capitalize_1
    {
        text-transform: capitalize !important;
    }
    .cursor_pointer
    {
        cursor:pointer !important;
    }

    .text-align-left
    {
        text-align: left !important;
    }
    .text-align-center
    {
        text-align: center !important;
    }
    .text-bold
    {
        font-weight:bolder; 
    }
</style>
<table class="main">
    <tbody>
        <tr >
            <td colspan="5"  class="text-align-center text-bold"> 
                <h1 style="text-transform: capitalize;">$company_data[company_name] </h1> 
                <h4 style="text-transform: capitalize;">$company_data[company_address]</h4>
            </td>
        </tr>
        <tr >
            <td colspan="6" class="text-align-center text-bold" style="text-transform: capitalize;">$tags[setting_value_1]</td>
        </tr>
        <tr>
            <td class="text-align-left text-bold">Name :</td>
            <td class="text-align-left" style="width:45%;text-transform: Capitalize;" colspan="2">$wholesale_data[wholesale_name]</td>
            
            <td align="center" style="width:35%;" rowspan="3">
                <table>
                    <tr>
                        <td class="text-align-center text-bold" colspan="2">TAX INVOICE</td>
                    </tr>
                    <tr>
                        <td class="text-align-center" colspan="2">
                                $print_value
                        </td>
                    </tr>
                    <tr>
                        <td class="text-align-center text-bold">Invoice No :</td>
                        <td>$wholesale_data[wholesale_invoice_number]</td>
                    </tr>
                    <tr>
                        <td class="text-align-center text-bold">Date :&nbsp;</td>
                        <td>
                            $date
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="text-bold">Address :</td>
            <td colspan="2" class="text-capitalize_1">$wholesale_data[wholesale_address]
            </td>
            
        </tr>
        <tr >
            <td class="text-bold">State Code : </td>
            <td >$state[state_code] - $state[state_name]</td>
            <td class="text-bold">Gst No : $wholesale_data[wholesale_gst_number]</td>
            
        </tr>
    </tbody>
</table>
EOF;
$html .= <<<EOF
<table class="main">           
    <tr role="row">
        <th>
            Sr. No.
        </th>
        <th>
            Description
        </th>
        <th>
            HSN Code
        </th>
        <th>
            Weight
        </th>
        <th>
            Rate
        </th>
        <th>
            Amount
        </th>                               
    </tr>
<tbody>
EOF;
$i=0;
$total_weight = 0;
    foreach($description_data as $key => $val)
    {
        $total_amount = abs($val["description_weight"] * $val["description_rate"]);
        $total_amount_1=number_format ( $total_amount , 2 , "." , "," );
        $rate = number_format ( $val["description_rate"], 2 , "." , "," );
        ++$i;
        $html .= <<<EOF
        <tr>
            <td > $i </td>
            <td class="text-capitalize">$val[description_particular]</td>  
            <td >$val[description_hsn_code] </td>  
            <td >$val[description_weight]</td>  
            <td >$rate</td>  
            <td >$total_amount_1</td>  
        </tr>
EOF;
    $total_weight = $total_weight + $val["description_weight"];
    $total_amount_grand = $total_amount_grand + $total_amount;
    }
    
    $cgst = ($total_amount_grand * $wholesale_data["wholesale_cgst"]) /100;
    
    $sgst = ($total_amount_grand * $wholesale_data["wholesale_sgst"]) /100;
    $cgst_sgst = $cgst + $sgst;
    $cgst_sgst=number_format ( $cgst_sgst , 2 , "." , "," );
    $full_total = $total_amount_grand + $cgst_sgst;
    $full_total = number_format ( $full_total , 2 , "." , "," );
    $cgst = number_format ( $cgst , 2 , "." , "," );
    $sgst = number_format ( $sgst , 2 , "." , "," );
    $total_amount_grand = number_format ( $total_amount_grand , 2 , "." , "," );
$html .=<<<EOF
<tr>
    <th colspan="2"> </th>
    <th colspan=""> Total </th>
    <th colspan="2"> $total_weight</th>
    <th >$total_amount_grand</th>
</tr>
<tr>
    <td colspan="3"> </td>
    <td class="text-bold" colspan="2"> Sub Total </td>
    <td colspan="">$total_amount_grand </td>
</tr>
<tr>
    <td colspan="3"> </td>
    <td class="text-bold" colspan="2"> Add : CGST @$wholesale_data[wholesale_cgst]% Amount : </td>
    <td > $cgst </td>
</tr>
<tr>
    <td colspan="3"> </td>
    <td class="text-bold" colspan="2"> Add : SGST @$wholesale_data[wholesale_sgst]% Amount : </td>
    <td > $sgst </td>
</tr>
<tr>
    <td colspan="3"> </td>
    <td class="text-bold" colspan="2"> Total GST Tax Amount : </td>
    <td > $cgst_sgst </td>
</tr>
<tr>
    <td colspan="3"> </td>
    <td class="text-bold" colspan="2"> Total : </td>
    <td >$full_total </td>
</tr>
</tbody>
</table>
<table class="main">
<tbody>
<tr>
    <td class="text-bold"> Customer's Signature : </td>
    <td > vishal </td>
    <td colspan="2" ></td>
    <td colspan="2"> For Shree Mahakali J </td>
</tr>
 <tr>
    <td colspan="6" class="text-align-center text-bold"> <h5>This Is A Computerised Generated Invoice</h5> </td>
</tr>
<tr>
    <td colspan="2" class="text-bold"> Contibuted By Mshine Technologies Tele :   </td>
    <td colspan="2"> +91-9624736996 </td>
    <td colspan="2"> Surat-Ahmedabad-Vadodara </td>
</tr>
</tbody>
</table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('bill.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
