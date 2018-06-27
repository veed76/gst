
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-10">
        <h4 class="page-title">Review Bill</h4>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url() . 'wholesale/'; ?>">Wholesale</a>
            </li>
            <li class="active">
                View
            </li>
        </ol>
    </div>
    <!-- <div class="col-sm-2" style="line-height: 80px;"><button class="btn btn-primary" id="gen_pdf_btn"> Generate PDF </button></div> -->
</div>

<?php
$company_date = date("d/m/Y",strtotime($company_data["company_registrationdt"]));
?>
<div class="row view_wholesale_bill">
            <div class="col-md-12">
        <div class="card-box table-responsive font-times-roman" id="content_pdf">

                    <table class="table">
                        <tbody>
                        	<tr >
                        		<th colspan="6" class="text-align-center"> 
                        			<h1 class="text-capitalize"> <?= $company_data["company_name"]; ?> </h1> 
                        			<h6 class="text-capitalize font-times-roman"><?= $company_data["company_address"]; ?></h6>
                        		</th>
                        	</tr>
                        	<tr >
					            <th colspan="5" class="text-align-center border-top-dashed text-bold" style="text-transform: capitalize;">GSTIN NO: <?= $company_data["company_gstin"]; ?> DATED: <?= $company_date; ?></th>
					        </tr>
                            <tr >
                                <th colspan="6" class="text-align-center font-times-roman text-capitalize" ><?= $tags["setting_value_1"]; ?></th>
                            </tr>
                            <tr>
                                <th class="text-align-left">Name :</th>
                                <td colspan="3" class="text-align-left text-capitalize"><?= $customer["customer_firstname"] ." ".$customer["customer_middlename"]." ".$customer["customer_lastname"]; ?></td>
                                
                                <td align="center" rowspan="4">
                                	<table class="child-table">
                                		<tr>
                                			<th class="text-align-center text-italic text-underline font-times-roman" colspan="2">TAX INVOICE</th>
                                		</tr>
                                		<tr>
                                			<th class="text-align-center" colspan="2">
                                				<?php
                                					$attr= array(
									                    "class" => "form-horizontal m-t-20 ",
									                    "id" => $html_form_id,
									                    "method" => "post",
									                    "novalidate" =>""
									                );
									                echo form_open_multipart($html_action,$attr);
                                				?>
                                					<input type="hidden" name="print_value" id="pdf_input"/>
	                                				<font class="pdf_print cursor_pointer decoration-color" data-source="1">Original</font> &nbsp; 
	                                				<font class="pdf_print cursor_pointer decoration-color" data-source="2">Duplicate</font>
	                                			<?php  form_close(); ?>
                                			</th>
                                		</tr>
                                		<tr>
                                			<th class="text-align-center" style="width:30%;">Invoice No :</th>
                                			<td><?= $wholesale_data["wholesale_invoice_number"]; ?></td>
                                		</tr>
                                		<tr>
                                			<th class="text-align-center">Date :&nbsp;</th>
                                			<td><?php 
                                				echo date("d/m/Y",strtotime($wholesale_data["wholesale_generatedt"]));
                                				?>
                                				</td>
                                		</tr>
                                	</table>
                                </td>
                            </tr>
                            <tr>
                                <th>Address :</th>
                                <td colspan="3" class="text-capitalize">
                                	<?= $customer["customer_address"]; ?>
                                </td>
                            </tr>
                             <tr>
					            <th class="text-bold">Mobile No :</th>
					            <td colspan="2" class=""><?= $customer["customer_mobile"] ?>
					            </td>
					        </tr>
                            <tr >
                                <th>State Code : </th>
                                <td ><?= $state["state_code"]." - ".$state["state_name"]; ?></td>
                                <th>Gst No : </th>
                                <td ><?= $customer["customer_gstin_number"]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                   
                    <table class="table">
				        
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
				                <th class="text-align-right">
				                    Amount
				                </th>				                
				            </tr>
				        
				        <tbody>
				        <?php
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
						        $class_padding = (!$desc)?"padding-bottom:20px !important;":"";
				        ?>
				        	<tr >
						        <td style="<?= $class_padding;  ?>"> <?= $counter; ?> </td>
						        <td class="text-capitalize"> <?=  $val["description_particular"]; ?> </td>  
						        <td > <?=  $val["description_hsn_code"]; ?> </td>  
						        <td > <?=  $val["description_weight"]; ?> </td>  
						        <td > <?=  $rate; ?> </td>  
						        <td class="text-align-right"> <?=  $total_amount_1; ?> </td>  
						    </tr>
						    	
						<?php  
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
							$cgst_sgst=number_format( $cgst_sgst , 2 , "." , "," );
							$full_total = number_format ( $full_total , 2 , "." , "," );
							$cgst = number_format ( $cgst , 2 , "." , "," );
							$sgst = number_format ( $sgst , 2 , "." , "," );
							$igst = number_format ( $igst , 2 , "." , "," );
							$total_amount_grand = number_format ( $total_amount_grand , 2 , "." , "," );
						?>
						    <tr>
						    	<td colspan="2"> </td>
						        <th colspan=""> Total </th>
						        <th colspan="2"> <?= $total_weight; ?> </th>
						        <th class="text-align-right">  <?= $total_amount_grand; ?> </th>
						    </tr>
						    <tr>
						    	<td colspan="3"> </td>
						    	<th colspan="2"> Sub Total </th>
						    	<td class="text-align-right"> <?= $total_amount_grand; ?> </td>
						    	
						    </tr>
						    <tr>
						    	<td colspan="3"> </td>
						    	<th colspan="2"> Add : CGST @<?=$cgst_per; ?>% Amount : </th>
							    <td class="text-align-right" > <?= $cgst; ?> </td>
						    </tr>
						    <tr>
						    	<td colspan="3"> </td>
						    	<th colspan="2"> Add : SGST @<?=$sgst_per; ?>% Amount : </th>
							    <td class="text-align-right" > <?= $sgst; ?> </td>
						    </tr>
						    <tr class="">
							    <td colspan="3"> </td>
							    <th class="text-bold td_left_border" colspan="2"> Add : IGST @<?=$igst_per; ?>% Amount : </th>
							    <td class="text-align-right" > <?= $igst; ?> </td>
							</tr>
						    <tr>
						    	<td colspan="3"> </td>
						    	<th colspan="2"> Total GST Tax Amount : </th>
						    	<td class="text-align-right"> <?= $cgst_sgst; ?> </td>
						    </tr>
						    <tr>
						    	<td colspan="3"> </td>
						    	<th colspan="2"> Total : </th>
						    	<td class="text-align-right"> <?= $full_total; ?> </td>
						    </tr>
						    <th class="text-bold" colspan="3"><br><br><br><br><br> Customer's Signature :  </th>    
    <th colspan="3"class="text-align-right"><br><br><br><br><br> For <?= $company_data["company_name"]; ?> </th>
						    </tbody>
						    </table>
						    <table class="table">
						    <tbody>
						    
						     <tr>
							    <td colspan="3" class="text-align-center text-bold"> <h6>This Is A Computerised Generated Invoice</h6> </td>
							</tr>
						    <tr>
							    <td colspan="3" class="text-bold text-size-11"> Contibuted By Mshine Technologies Surat Tele : +91-9624736996 </td>
							    <!-- <td > Surat-Ahmedabad-Vadodara </td> -->
							</tr>
						</tbody>
					</table>

                </div>
            <div class="">

            </div> 
            <div id="editor_pdf"></div>
            </div> 
</div>
