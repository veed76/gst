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
    $print_value='<font class="pdf_print text-bold cursor_pointer decoration-color">Original </font>&nbsp;&nbsp;&nbsp;<font class="pdf_print text-bold cursor_pointer decoration-color" style="text-decoration: line-through;"> Duplicate</font>';
}else
{
    $print_value='<font class="pdf_print text-bold cursor_pointer decoration-color" style="text-decoration: line-through;">Original </font> &nbsp;&nbsp;&nbsp; <font class="pdf_print text-bold cursor_pointer decoration-color" > Duplicate</font>';
}
$pdf->AddPage('P','A4');
/*$img_url = NODP;
if (isset($student["std_profileurl"]) && $student["std_profileurl"] != '') {
    $img_url = ASSETURL . 'std_data/' . $student["std_profileurl"];
} else {
    $img_url = ASSETURL . 'std_data/no-image.png';
}*/
$date = date("d/m/Y",strtotime($wholesale_data["wholesale_generatedt"]));
$company_date = date("d/m/Y",strtotime($company_data["company_registrationdt"]));
$html = <<<EOF
<style>
    table.main {
        color: #003300;
        font-family: helvetica;
        font-size: 12px;
        
        
        padding:5px;
    }

  /*table.main tr > td{
        border: 2px solid black;
        background-color: #ffffee;
    }*/
    th
    {
        border-top: 1px dashed black;
        border-bottom: 1px dashed black;
        font-weight:bold;
    }
    th.border-top-dashed
    {
        border-top: 1px dashed black;
        border-bottom: none;
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
    .text-align-right
    {
        text-align: right !important;
    }
    .text-align-center
    {
        text-align: center !important;
    }
    .text-bold
    {
        font-weight:bolder; 
    }
    .text-italic 
    {
    	font-style: italic;
    }
    .text-underline
    {
    	text-decoration : underline;
    }
    td.td_left_border
    {
    	border-left: 2px solid #555;
    }
    .font-times-roman, table *
    {
    	font-family: "Times New Roman", Georgia, Serif !important;
    }
    .text-size-11
    {
        font-size:11px;
    }
    .margin-right-5
    {
        margin-right:15px !important;
    }

</style>
<table class="main font-times-roman">
    <tbody>
        <tr >
            <td colspan="5"  class="text-align-center text-bold"> 
                <h1 style="text-transform: capitalize;">$company_data[company_name] </h1> 
                <h4 class="font-times-roman" style="text-transform: capitalize;">$company_data[company_address]</h4>
            </td>
        </tr>
        <tr >
            <th colspan="5" class="text-align-center border-top-dashed text-bold" style="text-transform: capitalize;">GSTIN NO: $company_data[company_gstin] DATED: $company_date</th>
        </tr>
        <tr >
            <th colspan="5" class="text-align-center text-bold font-times-roman" style="text-transform: capitalize;">$tags[setting_value_1]</th>
        </tr>
        <tr>
            <td class="text-align-left text-bold">Name :</td>
            <td class="text-align-left" style="width:45%;text-transform: Capitalize;" colspan="2">$customer[customer_firstname] $customer[customer_middlename] $customer[customer_lastname]</td>
            
            <td align="center" style="width:35%;" rowspan="4">
                <table>
                    <tr>
                        <td class="text-align-center text-bold text-italic text-underline font-times-roman" colspan="2">TAX &nbsp;INVOICE</td>
                    </tr>

                    <tr>
                        <td class="text-align-center" colspan="2">
                                $print_value
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="text-align-center text-bold">Invoice &nbsp;No :</td>
                        <td>$wholesale_data[wholesale_invoice_number]</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
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
            <td colspan="2" class="text-capitalize_1">$customer[customer_address]
            </td>
        </tr>
        <tr>
            <td class="text-bold">Mobile No :</td>
            <td colspan="2" class="">$customer[customer_mobile]
            </td>
        </tr>
        <tr >
            <td class="text-bold">State Code : </td>
            <td >$state[state_code] - $state[state_name]</td>
            <td class="text-bold">Gst No : $customer[customer_gstin_number]</td>
            
        </tr>
    </tbody>
</table>
EOF;
$html .= <<<EOF
<table class="main">           
    <tr role="row">
        <th style="width:9%">
            Sr. No.
        </th>
        <th style="width:25%">
            Description
        </th>
        <th class="text-align-center">
            HSN Code
        </th>
        <th class="text-align-center">
            Weight
        </th>
        <th class="text-align-center">
            Rate
        </th>
        <th class="text-align-right">
            Amount
        </th>                               
    </tr>
<tbody>
EOF;
$i=0;
$total_weight = 0;
$count = 6;
    for($ii=0;$ii<$count;$ii++)
    {
    	$val= $description_data[$ii];
        $total_amount = abs($val["description_weight"] * $val["description_rate"]);
        $total_amount_1=number_format ( $total_amount , 2 , "." , "," );
        $rate = number_format ( $val["description_rate"], 2 , "." , "," );
        ++$i;
        $desc = trim($val["description_particular"]);
        $counter = ($desc)?$i:"";
        $rate = ($desc)?$rate:"";
        $total_amount_1 = ($desc)?$total_amount_1:"";
        $html .= <<<EOF
        <tr>
            <td style="width:9%" class="text-align-center"> $counter </td>
            <td style="width:25%"class="text-capitalize">$val[description_particular]</td>  
            <td class="text-align-center">$val[description_hsn_code] </td>  
            <td class="text-align-center">$val[description_weight]</td>  
            <td class="text-align-center">$rate</td>  
            <td class="text-align-right">$total_amount_1</td>  
        </tr>
EOF;
        $total_weight = $total_weight + $val["description_weight"];
        $total_amount_grand = $total_amount_grand + $total_amount;
    }
    
    
   

    $customer_state_code = $state["state_code"];
    $company_state_code = $company_data["company_state"];
    if($company_state_code === $customer_state_code)
    {
        $cgst = ($total_amount_grand * $wholesale_data["wholesale_cgst"]) /100;
        $sgst = ($total_amount_grand * $wholesale_data["wholesale_sgst"]) /100;

        $cgst_sgst = $cgst + $sgst;
        $cgst_per = trim($wholesale_data["wholesale_cgst"]);
        $cgst_per = (!empty($cgst_per))?$cgst_per:"0.00";

        $sgst_per = trim($wholesale_data["wholesale_sgst"]);
        $sgst_per = (!empty($sgst_per))?$sgst_per:"0.00";

        $igst_per ="0.00";
        $igst = 0;
    }else
    {
        $igst = ($total_amount_grand * $wholesale_data["wholesale_igst"]) /100;
        $cgst_sgst=$igst;
        $igst_per = trim($wholesale_data["wholesale_igst"]);
        $igst_per = (!empty($igst_per))?$igst_per:"0.00";
        $cgst_per = $sgst_per = "0.00";
        $cgst = $sgst = 0;
    }
   
    $full_total = $total_amount_grand + $cgst_sgst;
    $cgst_sgst=number_format ( $cgst_sgst , 2 , "." , "," );
    $full_total = number_format ( $full_total , 2 , "." , "," );
    $cgst = number_format ( $cgst , 2 , "." , "," );
    $sgst = number_format ( $sgst , 2 , "." , "," );
    $igst = number_format ( $igst , 2 , "." , "," );
    $total_amount_grand = number_format ( $total_amount_grand , 2 , "." , "," );
    
$html .=<<<EOF
<tr>
    <th > </th>
    <th > </th> 
    <th class="text-align-center"> Total </th>
    <th class="text-align-center"> $total_weight</th>
 	<th > </th>
    <th class="text-align-right">$total_amount_grand</th>
</tr>
<tr class="">
    <td colspan="3"> </td>
    <td class="text-bold td_left_border" colspan="2"> Sub Total </td>
    <td class="text-align-right">$total_amount_grand </td>
</tr>
<tr class="">
    <td colspan="3"> </td>
    <td class="text-bold td_left_border" colspan="2"> Add : CGST @$cgst_per% Amount : </td>
    <td class="text-align-right" > $cgst </td>
</tr>
<tr class="">
    <td colspan="3"> </td>
    <td class="text-bold td_left_border" colspan="2"> Add : SGST @$sgst_per% Amount : </td>
    <td class="text-align-right" > $sgst </td>
</tr>
<tr class="">
    <td colspan="3"> </td>
    <td class="text-bold td_left_border" colspan="2"> Add : IGST @$igst_per% Amount : </td>
    <td class="text-align-right" > $igst </td>
</tr>
<tr class="">
    <td colspan="3"> </td>
    <td class="text-bold td_left_border" colspan="2"> Total GST Tax Amount : </td>
    <td class="text-align-right" > $cgst_sgst </td>
</tr>
<tr class="">
    <td colspan="3"> </td>
    <td class="text-bold td_left_border" colspan="2"> Total : </td>
    <td class="text-align-right">$full_total </td>
</tr>
<tr >
    <th class="text-bold" colspan="3"><br><br><br><br><br> Customer's Signature :  </th>    
    <th colspan="3"class="text-align-right"><br><br><br><br><br> For $company_data[company_name] </th>
</tr>

</tbody>
</table>

<table class="main">
<tbody>

 <tr class="">
    <td colspan="2" class="text-align-center text-bold"> <h5>This Is A Computerised Generated Invoice</h5></td>
</tr>
<tr>
    <td colspan="2" class="text-bold text-size-11"> Contibuted By Mshine Technologies Surat Tele : +91-9624736996 </td>
    <!-- <td > Surat-Ahmedabad-Vadodara </td> -->
</tr>
</tbody>
</table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('bill.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
