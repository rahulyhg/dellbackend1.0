</div>

</section>

</section>
 <!-- js placed at the end of the document so the pages load faster -->
    
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.scrollTo.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.nicescroll.js'); ?>" type="text/javascript"></script>
   
    <script src="<?php echo base_url('assets/js/owl.carousel.js'); ?>" ></script>
    <script src="<?php echo base_url('assets/js/jquery.customSelect.min.js'); ?>" ></script>
	<script type="text/javascript" src="<?php echo base_url('assets/assets/data-tables/jquery.dataTables.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/assets/data-tables/DT_bootstrap.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/dynamic-table.js'); ?>"></script>
    <!--common script for all pages-->
    <script src="<?php echo base_url('assets/js/common-scripts.js'); ?>"></script>

    <!--script for this page-->
   
	<script src="<?php echo base_url('assets/js/TableTools.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/assets/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/assets/bootstrap-daterangepicker/date.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/assets/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js'); ?>"></script>
	 <!--custom switch-->
    <script src="<?php echo base_url('assets/js/bootstrap-switch.js'); ?>"></script>
    <!--custom tagsinput-->
    <script src="<?php echo base_url('assets/js/jquery.tagsinput.js'); ?>"></script>
	
	<!--script for this page-->
	<script src="<?php echo base_url('assets/js/form-component.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/select2.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/select2.min.js'); ?>" type="text/javascript"></script>
  <script>

      //owl carousel

      $(document).ready(function() {
          $("#checkbox").click(function () {
            // alert("checkbox");
            if ($("#checkbox").is(':checked')) {
                //alert("checkbox");
                $(".check").prop('checked', true);
            } else {
                $(".check").prop('checked', false);

            }
        });
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
		  $('.fpTable').dataTable();
		  
		  var datatable=$('.csvdataTable').dataTable({
			"sDom": "T<'clear'>lfrtip",
			"oTableTools": {
				"sSwfPath": "<?php echo base_url('assets/media/swf/copy_csv_xls_pdf.swf'); ?>"
			},
			"sPaginationType": "bootstrap",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			}

			
		});
		$(".myselect2").select2({
			allowClear: true
		});
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58427978-1', 'auto');
 ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>
  

</body>
</html>