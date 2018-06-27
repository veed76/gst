
</div> <!-- container -->
</div> <!-- content -->
<footer class="footer text-right">
    <?php echo COPY_RIGHT; ?>
</footer>
</div>
</div>
<script>
    var resizefunc = [];
</script>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->

<script src="<?php echo THEMEURL; ?>js/jquery.min.js"></script>
<script src="<?php echo THEMEURL; ?>js/bootstrap.min.js"></script>
<script src="<?php echo THEMEURL; ?>js/detect.js"></script>
<script src="<?php echo THEMEURL; ?>js/fastclick.js"></script>
<script src="<?php echo THEMEURL; ?>js/jquery.slimscroll.js"></script>
<script src="<?php echo THEMEURL; ?>js/jquery.blockUI.js"></script>
<script src="<?php echo THEMEURL; ?>js/waves.js"></script>
<script src="<?php echo THEMEURL; ?>js/wow.min.js"></script>
<script src="<?php echo THEMEURL; ?>js/jquery.nicescroll.js"></script>
<script src="<?php echo THEMEURL; ?>js/jquery.scrollTo.min.js"></script>

<?php
$controller = $this->router->fetch_class();
switch ($controller) {
    case "gst" || "company" :
        ?>
        <script src="<?php echo THEMEURL; ?>plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/datatables/buttons.print.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/datatables/responsive.bootstrap.min.js"></script>


        <!--Form Wizard-->
        <script src="<?php echo THEMEURL; ?>plugins/jquery.steps/build/jquery.steps.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo THEMEURL; ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>

        <!--wizard initialization-->
        <script src="<?php echo THEMEURL; ?>pages/jquery.wizard-init.js" type="text/javascript"></script>
        <script src="<?php echo THEMEURL; ?>plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>                
        <script src="<?php echo THEMEURL; ?>plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>



        <script src="<?php echo THEMEURL; ?>plugins/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>
        <!--FooTable-->
        <script src="<?php echo THEMEURL; ?>plugins/footable/js/footable.all.min.js" type="text/javascript"></script>       
        <script src="<?php echo THEMEURL; ?>plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="<?php echo THEMEURL; ?>plugins/parsleyjs/dist/parsley.min.js" type="text/javascript" ></script>

        <!-- Date Picker -->
        <script src="<?php echo THEMEURL; ?>plugins/moment/moment.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo THEMEURL; ?>plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.common.min.js" type="text/javascript" ></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.js" type="text/javascript" ></script>


        <script type="text/javascript">
            jQuery('#datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true,
                format : "d-m-yyyy"
            }); 
        </script>
        <?php
        break;
}
?>    
<script src="<?php echo THEMEURL; ?>js/jquery.core.js"></script>
<script src="<?php echo THEMEURL; ?>js/jquery.app.js"></script>      

<!--  *******************************  Custom js *******************************************  -->
<!--<script src="<?php echo ASSETURL; ?>js/htmleditor/editor.js"></script>  -->
<script src="<?php echo ASSETURL; ?>js/gst-custom.js"></script>
<script src="<?php echo ASSETURL; ?>js/jspdf.min.js"></script>
        <?php $html_form_id=(empty($html_form_id)?null:$html_form_id); ?>
        <script type="text/javascript">
        var doc = new jsPDF();
            var specialElementHandlers = {
                '#editor_pdf': function (element, renderer) {
                    return true;
                }
            };

            $('#gen_pdf_btn').click(function () {
                doc.fromHTML($('#content_pdf').html(), 15, 15, {
                    'width': 170,
                        'elementHandlers': specialElementHandlers
                });
                doc.save('sample-file.pdf');
            });

        $('#datatable-dealer-tag').DataTable();
        
            var html_form_id = '<?php echo $html_form_id ?>';
            if(html_form_id)
            {
                $('#'+html_form_id).parsley();
            }
        </script>
<!-- END wrapper -->
</body>
<!-- Mirrored from coderthemes.com/ubold_1.5/light/page-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Apr 2016 06:07:07 GMT -->
</html>