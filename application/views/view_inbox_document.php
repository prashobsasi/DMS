<?php include 'redirect_login.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="<?php echo asset_url();?>images/favicon.png">

	<title>DMS | View Document</title>
	<!-- <link rel="stylesheet" href="<?php echo asset_url();?>css/datepicker.css"> -->
	<link rel="stylesheet" href="<?php echo asset_url();?>css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-core.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-theme.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-forms.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/skins/yellow.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/custom/multiselect.css">


	<script src="<?php echo asset_url();?>js/jquery-1.11.3.min.js"></script>

	<link rel="stylesheet" href="<?php echo asset_url();?>js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<script src="<?php echo asset_url();?>js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>

<!-- 	<script src="<?php echo asset_url();?>js/datepicker.js"></script>  -->
	<script src="<?php echo asset_url();?>js/ckeditor/ckeditor.js"></script>
	<link rel="stylesheet" href="<?php echo asset_url();?>css/bootstrap-multiselect.css">

	<!--[if lt IE 9]><script src="<?php echo asset_url();?>js/ie8-responsive-file-warning.js"></script><![endif]-->
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">



		$(document).ready(function() {
			var responsiveHelper = undefined;
			var breakpointDefinition = {
			tablet : 1024,
			phone : 480
			};
			dtInbox = $('#dtInbox');

			dtInbox.dataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"bStateSave": true
			});
			// Initalize Select Dropdown after DataTables is created
			dtInbox.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
				minimumResultsForSearch: -1
			});

			$('#inwardTo').multiselect({
      			allSelectedText: 'All',
      			maxHeight: 200,
      			includeSelectAllOption: true

		});

		/*$("#txtFromDate").datepicker();
		$("#txtToDate").datepicker();*/

		CKEDITOR.replace( 'remarksEditor' );

		

		});

		function filter() {
		dtInbox.fnClearTable();
		
		if ($('#dbdateserch').val() != "CUSTOM") {
			$(".custom_date").addClass('hide');
			$(".custom_date").removeClass('show');
			$('#divDatePickers').css('display', 'none');
			$("#txtFromDate").val("");
			$("#txtToDate").val("");
		} else {
			$(".custom_date").addClass('show');
			$(".custom_date").removeClass('hide');
			$('#divDatePickers').css('display', 'initial');
			//onDateChange();
			return;
		}
	}

	function onDateChange() {
		if ($("#txtFromDate").val() == "" || $("#txtToDate").val() == "") {
			return;
		}
		var fromdate = new Date($('#txtFromDate').val());
  		fromYear = fromdate.getFullYear();
  		//alert(year);
  		if(fromYear<1900 || fromYear > 3000){
  			//alert('invalid');
  			return;
  		}
		var todate = new Date($('#txtToDate').val());
  		toYear = todate.getFullYear();
  		//alert(year);
  		if(toYear<1900 || toYear > 3000){
  			//alert('invalid');
  			return;
  		}
		dtInbox.fnClearTable();
		
	}



		function forwardView(doc_Id,fromId){

			
			var button="<button type='button' class='btn btn-success' onclick='forward("+doc_Id+","+fromId+")'>Forward</button> <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
			$("#ft").html(button);

			$.ajax({
        					url : "<?php echo base_url(); ?>compose/getDocument",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"id" : doc_Id,
        					},
        					success : function(doc) {

        						var output1 = document.getElementById('output_pdf1');
 								output1.src = "<?php echo uploads_url();?>docs/"+doc;

 								$('#docInModal').modal('show');

        						

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
        					}
    					});	
		}


		function file(doc_Id,rem_Id,obj){

			inRow = $(obj).closest('tr');

			$.ajax({
        					url : "<?php echo base_url(); ?>compose/getDocument",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"id" : doc_Id,
        						"r_Id": rem_Id
        					},
        					success : function(doc) {

        						inRow.removeAttr("style");
        						var output = document.getElementById('output_pdf');


 								output.src = "<?php echo uploads_url();?>docs/"+doc;

 								$('#docModal').modal('show');

        						

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
        					}
    					});

			


			
		}

		function forwardFrom(doc_Id){

			$(".error-msg").html("");
			var f=0;

			
			var documentId=doc_Id;
			var remarks=CKEDITOR.instances.remarksEditor.getData();
			var forIds=$('#inwardTo').val();
			
			if(forIds==null){
				f=1;
				$(".error-msg").html("Please Select Employee");
			}

			if(remarks==""){
				f=1;
				$(".error-msg").html("Please Enter Remarks");
			}

			console.log(documentId +"-"+ remarks);
			if(f==0)
			{
				var form_data = new FormData();  
				form_data.append('documentId', documentId);
				form_data.append('remarks', remarks);
				form_data.append('forIds', forIds); 
				$(".error-msg").html("Forwarding...");
				$.ajax({
        			url : "<?php echo base_url(); ?>viewInboxDocument/forwardFrom",
        			type : "POST",
        			dataType : "text",
        			cache: false,
			        contentType: false,
			        processData: false,
        			data : form_data,
        			success : function(status) {
						$(".error-msg").html("");
        				alert(status);
        				location.reload();
        			},
        			error : function (jqXHR, textStatus, errorThrown) {
        						$(".error-msg").html("");
            					console.log(textStatus);
            					$(".error-msg").html("Forwarding Failed,Please Contact Admin");
        			}
    			});
    		}
			
		}

		function saveFrom(doc_Id){

			$(".error-msg").html("");
			var f=0;

			
			var documentId=doc_Id;
			var remarks=CKEDITOR.instances.remarksEditor.getData();
			var forIds=$('#inwardTo').val();
			
			if(forIds==null){
				f=1;
				$(".error-msg").html("Please Select Employee");
			}

			if(remarks==""){
				f=1;
				$(".error-msg").html("Please Enter Remarks");
			}

			console.log(documentId +"-"+ remarks);
			if(f==0)
			{
				var form_data = new FormData();  
				form_data.append('documentId', documentId);
				form_data.append('remarks', remarks);
				form_data.append('forIds', forIds); 
				$(".error-msg").html("Forwarding...");
				$.ajax({
        			url : "<?php echo base_url(); ?>viewInboxDocument/saveFrom",
        			type : "POST",
        			dataType : "text",
        			cache: false,
			        contentType: false,
			        processData: false,
        			data : form_data,
        			success : function(status) {
						$(".error-msg").html("");
        				alert(status);
        				location.reload();
        			},
        			error : function (jqXHR, textStatus, errorThrown) {
        						$(".error-msg").html("");
            					console.log(textStatus);
            					$(".error-msg").html("Forwarding Failed,Please Contact Admin");
        			}
    			});
    		}
			
		}
	

	</script>


</head>
<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<?php include 'side_bar.php';?>

	<div class="main-content">
				
		<?php include 'top_bar.php';?>
		
		<hr />	
		<div class="well">
					<h1>View Document</h1>
		</div>
		
		<hr />
			<div class="row">
				<!-- Profile Info and Notifications -->
				

					<form class="form-horizontal" name="forwardForm" id="forwardForm"  enctype='multipart/form-data' method="post">

						<div class="form-group">
						<embed  src="<?php echo uploads_url();?>docs/<?php echo $viewDocument->doc_url;?>" type="application/pdf" height="600px" width="100%" class="responsive">
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Previous Remarks :- </label>
							<div class="col-sm-5">
								<label class="col-sm-1" control-label"><?php echo $viewDocument->emp_name;?>:</label>
								<label class="col-sm-2" control-label"><?php $text=str_ireplace('<p>','',$viewDocument->remarks);
									$text=str_ireplace('</p>','',$text);    echo $text;?></label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Inward To</label>
							<div class="col-sm-5">
								<select id="inwardTo" multiple="multiple" class="form-control">

									<?php
										$emp_Id = $this->session->userdata('empId');

										foreach ($employees as $employee) 
										{ 
													
											if($employee->emp_id!=$emp_Id && $employee->emp_id!='admin')
											{
									?>
												<option value="<?php echo $employee->emp_id;?>"><?php echo $employee->emp_name;?></option>

									<?php 	
											} 
										}
									?>

		 							</select>

							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Remarks</label>
							<div class="col-sm-5">
									<textarea autofocus='autofocus' id='remarksEditor' name='remarksEditor' autocomplete='off' cols=50 rows=5 placeholder='Remarks'></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class='error-msg col-sm-3 control-label' style='color: red;'></label>
							<div class="col-sm-5 control-label">
								<input class="btn btn-info" style="width:90px" type="button" id="save" name="save" value="SAVE" class="btnLogin" onclick="saveFrom(<?php echo $viewDocument->doc_id;?>)"> 
									<input class="btn btn-success" style="width:90px" type="button" id="forward" name="forward" value="FORWARD" onclick="forwardFrom(<?php echo $viewDocument->doc_id;?>)" class="btnLogin">
							</div>
						</div>
					</form>
				
			</div>
		<hr/>
		
		<!-- Footer -->

		<?php include 'footer.php';?>
		
	</div>
			
</div>



<div class="modal fade" id="docModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Document</strong></h4>
        </div>
        <form name="deptForm" id="deptForm"  enctype='multipart/form-data' method="post">
        	<div class="modal-body">
         		 <embed  id="output_pdf" type="application/pdf" height="500px" width="100%" class="responsive">
        	</div>
        	<div class="modal-footer">
          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	</div>
        </form>

      </div>
      
    </div>
</div>

<div class="modal fade" id="docInModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Document Inward</strong></h4>
        </div>
        <form name="deptForm" id="deptForm"  enctype='multipart/form-data' method="post">
        	<div class="modal-body">
         		 <embed  id="output_pdf1" type="application/pdf" height="500px" width="100%" class="responsive">
         		 
         		 	<table>
					
					<tr><td><label></label></td><td></td><td></td></tr>

 					<tr><td>Inward To</td>
 						<td>


 							<select id="inwardTo" multiple="multiple">

							<?php
								$emp_Id = $this->session->userdata('empId');

								foreach ($employees as $employee) 
								{ 
											
									if($employee->emp_id!=$emp_Id && $employee->emp_id!='admin')
									{
							?>
										<option value="<?php echo $employee->emp_id;?>"><?php echo $employee->emp_name;?></option>

							<?php 	
									} 
								}
							?>

 							</select>
 						<!-- 	<select id="inwardTo" multiple="multiple">

 								<?php foreach ($privileges as $privilege) 
								{ 
											
									if($privilege->associative_professor==1 || $privilege->assistant_professor==1)
									{

						?>
										<option value="Principal">Principal</option>
									
										<option value="HOD">HOD</option>
						<?php
									}else if($privilege->hod==1){
						?>
								<option value="Principal">Principal</option>
							
							<?php
								$dept_Id = $this->session->userdata('deptId');
								$desig_Id = $this->session->userdata('desigId');

								foreach ($employees as $employee) 
								{ 
											
									if($employee->department==$dept_Id && $employee->designation!=$desig_Id)
									{
							?>
								<option value="<?php echo $employee->emp_id;?>"><?php echo $employee->emp_name;?></option>

							<?php 	
									} 
								}
							?>
						<?php
								}
								else{
									echo "<label class='error-msg' style='color: red;'>No Privileges Given.Please Contact Admin</label>";
								}
							}
						?>
 							</select> -->
 						</td>
 						<td></td></tr>

 						

 						<tr><td><label></label></td><td></td><td></td></tr>
					
						<tr><td></td><td><textarea  autofocus='autofocus' id='remarksEditor' name='remarksEditor' autocomplete='off' cols=50 rows=5 placeholder='Remarks'></textarea></td><td></td></tr>

					<tr><td><label></label></td><td></td><td></td></tr>

					<tr><td></td><td><label class='error-msg' style='color: red;'></label></td><td></td></tr>

					<tr><td><label></label></td><td></td><td></td></tr>


				</table>
        	</div>

        	<div class="modal-footer">
        	<div id="ft">
        		
          	</div>
        	</div>
        </form>

      </div>
      
    </div>
</div>	
	
	
	
	


	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="<?php echo asset_url();?>js/datatables/datatables.css">

	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2.css">
	

	<!-- Bottom scripts (common) -->
	<script src="<?php echo asset_url();?>js/gsap/TweenMax.min.js"></script>
	
	<script src="<?php echo asset_url();?>js/joinable.js"></script>
	<script src="<?php echo asset_url();?>js/resizeable.js"></script>
	<script src="<?php echo asset_url();?>js/neon-api.js"></script>
	<script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
	<script src="<?php echo asset_url();?>js/neon-login.js"></script>


	<script src="<?php echo asset_url();?>js/datatables/datatables.js"></script>
	<script src="<?php echo asset_url();?>js/select2/select2.min.js"></script>
	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo asset_url();?>js/neon-custom.js"></script>


	<script src="<?php echo asset_url();?>js/custom/multiselect.js"></script>
	<script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>

	<script src="<?php echo asset_url();?>js/bootstrap-multiselect.js"></script>

	
	
	<!-- Demo Settings -->
	<script src="<?php echo asset_url();?>js/neon-demo.js"></script>


</body>
</html>