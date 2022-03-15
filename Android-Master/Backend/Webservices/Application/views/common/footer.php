<!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright <?php echo date("Y"); ?>. All right reserved.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- main wrapper start -->
    <!-- jquery latest version -->
    <script src="<?php echo base_url(); ?>skins/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url(); ?>skins/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/jquery.slicknav.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/additional-methods.min.js"></script>
    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <!-- start amcharts -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <!-- all line chart activation -->
    <script src="<?php echo base_url(); ?>skins/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="<?php echo base_url(); ?>skins/js/pie-chart.js"></script>
    <!-- all bar chart -->
    <script src="<?php echo base_url(); ?>skins/js/bar-chart.js"></script>
    <!-- all map chart -->
    <script src="<?php echo base_url(); ?>skins/js/maps.js"></script>

    <!-- Start datatable js -->
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script> -->










    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>



    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <!-- others plugins -->
    <script src="<?php echo base_url(); ?>skins/js/plugins.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/scripts.js"></script>
    <script type="text/javascript">

        jQuery(document).ready(function($){
            $.validator.addMethod('filesize', function (value, element, param) {
              return this.optional(element) || (element.files[0].size <= param)
            });
            jQuery('#user_import').validate({
              rules: {
                  file: {
                    required: true,
                    extension: "xlsx,xls",

                  },
              },
              messages:{
                file:{
                  extension: "Only XLSX, XLS format accepted ",
                  required : "Please upload a file"
                },
              },
              submitHandler: function(form) { 
                jQuery('button[type="submit"]').attr("disabled", true);
               // jQuery('button[type="button"]').attr("disabled", true);
                jQuery('#preloader').show();
                form.submit();
              }
            });
            $('#category').multiselect({
                nonSelectedText: 'Choose Category',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                onDropdownHidden: function (event) {
                   var selected1 = [];
                   $('#category option:selected').each(function() {
                       selected1.push($(this).val());
                   });
                   $.ajax({
                    url: "<?php echo base_url().'nonprofit/checkcategory'; ?>",
                    method : "POST",
                    data: "categoryid="+selected1,
                    dataType: "json",
                    success: function(result){
                        jQuery('#subcategory').html('');
                        jQuery('#subcategory').append('<option value="">Choose Category</option>');
                        var i = result.data.length; while(i--){
                        $("#subcategory").append('<option value="'+result.data[i].i2D_D_NTEE_1_CODE+'">'+result.data[i].i2D_D_NTEE_1_NAME+'</option>');
                       }
                       $('#subcategory').multiselect('rebuild');
                    }
                  });
                }
            });
             $('#subcategory').multiselect({
                nonSelectedText: 'Choose Category',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                  onDropdownHidden: function (event) {
                   var selected1 = [];
                   $('#category option:selected').each(function() {
                       selected1.push($(this).val());
                   });
                   var selected2 = [];
                   $('#subcategory option:selected').each(function() {
                       selected2.push($(this).val());
                   });
                   $.ajax({
                    url: "<?php echo base_url().'nonprofit/checkmulticategory'; ?>",
                    method : "POST",
                    data: "categoryid="+selected1+"&subcategoryid="+selected2,
                    dataType: "json",
                    success: function(result){
                        jQuery('#child_category').html('');
                        jQuery('#child_category').append('<option value="">Choose Category</option>');
                        var i = result.data.length; while(i--){
                        $("#child_category").append('<option value="'+result.data[i].i2D_D_NTEE_1_CODE+'">'+result.data[i].i2D_D_NTEE_1_NAME+'</option>');
                       }
                       $('#child_category').multiselect('rebuild');
                    }
                  });
                }
             });
        });
    </script>
</body>

</html>
