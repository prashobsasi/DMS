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

	<title>DMS | Inwards</title>
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

				var selectOption = $('#dbdateserch').val();
				
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
					onDateChange();
					return;
				}
				dtInbox.fnClearTable();
				$.ajax({
        					url : "<?php echo base_url(); ?>inbox/filterInbox",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"filterBy" : selectOption,
        					},
        					success : function(documentRemarks) {
        						
        						

        						if(documentRemarks.length!=0)
        						{
        							console.log(documentRemarks);
        							addRowsToTable(documentRemarks);
        						}else{
        							dtInbox.fnClearTable();
        						}

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
        					}
		    		});	
	}

	function addRowsToTable(documentRemarks) {
			dtInbox.fnClearTable();

			rows="";

			$.each(documentRemarks, function(index, doc) {

		

					doc_name=doc.doc_name;
					recOn=getDateTime(doc.time_stamp);
					recFrom=doc.recFrom;
					remarks=doc.remark;
					r_id=doc.r_Id;
					status=doc.status;
					button="<a type='button' class='btn btn-primary' style='width: 105px;' href='<?php echo base_url();?>/viewInboxDocument?r_id="+r_id+"'>View</a>";

					//dtInbox.fnAddData([doc_name,recOn,recFrom,remarks,button]);

        			if(status==0)
        			{
        				rows+="<tr id='trow' style='background-color: #ffb3b3'><td>"+doc_name+"</td><td>"+recOn+"</td><td>"+recFrom+"</td><td>"+remarks+"</td><td>"+button+"</td></tr>"	
        			}else{
        				rows+="<tr id='trow'><td>"+doc_name+"</td><td>"+recOn+"</td><td>"+recFrom+"</td><td>"+remarks+"</td><td>"+button+"</td></tr>"

        			}
        			
        			
								

			});

			//alert(rows);

			$('#tbodyInbox').html(rows);
		}

	function getDateTime(date1) {
			var date = new Date(date1);
		/* var monthNames = [ "January", "February", "March", "April", "May",
				"June", "July", "August", "September", "October", "November",
				"December" ]; */
			var day = date.getDate();
			var monthIndex = date.getMonth() + 1;
			var year = date.getFullYear();
		//var dateString = day + ", " + monthNames[monthIndex] + ", " + year;
			var dateString = day + "-" + monthIndex + "-" + year;

			var hours = date.getHours();
			var minutes = date.getMinutes();
			var seconds = date.getSeconds();

			var timeString = "" + ((hours > 12) ? hours - 12 : hours);
			timeString += ((minutes < 10) ? ":0" : ":") + minutes;
		//timeString += ((seconds < 10) ? ":0" : ":") + seconds;
			timeString += (hours >= 12) ? " PM" : " AM";
			return dateString + " " + timeString;
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

		fromDate=$("#txtFromDate").val();
		toDate=$("#txtToDate").val();

		$.ajax({
        					url : "<?php echo base_url(); ?>inbox/filterCustomInbox",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"fromdate" : fromDate,
        						"todate" 	: toDate,
        					},
        					success : function(documentRemarks) {

        						if(documentRemarks.length!=0)
        						{
        							console.log(documentRemarks);
        							addRowsToTable(documentRemarks);
        						}else{
        							dtInbox.fnClearTable();
        						}

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
        					}
		    		});	
		
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

		function forward(doc_Id){

			//var remarks=$("#remarks").val();
			var remarks=CKEDITOR.instances.remarksEditor.getData();
			var forIds=$('#inwardTo').val();

			//alert(forIds);

			var form_data = new FormData();  
				form_data.append('docId', doc_Id);
				form_data.append('forIds', forIds);
				form_data.append('remarks', remarks);
				$(".error-msg").html("Forwarding...");
			$.ajax({
        					url : "<?php echo base_url(); ?>compose/forwardInbox",
        					type : "POST",
        					dataType : "text",
        					cache: false,
			        		contentType: false,
			       			processData: false,
        					data : form_data,
        					success : function(doc) {
        						$(".error-msg").html("");
        						alert(doc);
        						location.reload();

        						

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
        					}
    					});

			


			
		}
	

	</script>


</head>
<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<?php include 'side_bar.php';?>

	<div class="main-content">
				
		<?php include 'top_bar.php';?>
		
		<hr />	
		<div class="well">
					<h1>Inwards</h1>
		</div>
		
		<hr />
					<div class="row">
				<!-- Profile Info and Notifications -->
				<div class="col-md-12 col-sm-12 clearfix">
					<form role="form" class="form-horizontal form-groups-bordered">
						<div class="form-group">
							<div class="col-sm-3">
								<select class="form-control" id="dbdateserch"
									onchange="filter()">
									<option value="ALL">ALL</option>
									<option value="TODAY">TODAY</option>
									<option value="YESTERDAY">YESTERDAY</option>
									<option value="WTD">WTD</option>
									<option value="MTD">MTD</option>
									<option value="CUSTOM">CUSTOM</option>
								</select>
							</div>
							<div class="col-sm-3 hide custom_date">
								<div class="input-group">
									<input type="date" class="form-control" id="txtFromDate"
										onchange="onDateChange()" placeholder="Select From Date"
										style="background-color: #fff;"/>
									<div class="input-group-addon">
										<a href="#"><i class="entypo-calendar"></i></a>
									</div>
								</div>
							</div>
							<div class="col-sm-3 hide custom_date">
								<div class="input-group">
									<input onchange="onDateChange()" type="date"
										class="form-control" id="txtToDate"
										placeholder="Select To Date" style="background-color: #fff;"
										 />
									<div class="input-group-addon">
										<a href="#"><i class="entypo-calendar"></i></a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
		<hr/>
		
			<table class="table table-bordered datatable" id="dtInbox">
				<thead>
					<tr>
						<th>Document Name</th>
						<th>Recieved On</th>
						<th>Recieved From</th>
						<th>Remarks</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody id="tbodyInbox">
					<?php 

					if (is_array($document_remarks) || is_object($document_remarks))
					{
						foreach ($document_remarks as $doc) { 

								$r_id=$doc->r_Id;
								$docId=$doc->doc_Id;
								$status=$doc->status;
								$doc_name="";
								$doc_url="";
								$recFrom="";
								$emp_Id="";
								$toId="";
								$remarks=$doc->remark;
								$data['documents'] = $this->compose_model->get__document_name($docId);
								foreach ($data['documents']  as $document) {
								$doc_name=$document->doc;
								}
								$data['employees'] = $this->employee_model->get_employee_name($doc->from_Id);
								foreach ($data['employees']  as $employee) {
									$recFrom=$employee->emp_name;
									$emp_Id=$employee->emp_id;
									$toId=$employee->e_id;
								}

							$sec = strtotime($doc->time_stamp); 
  
       						$date = date("d-m-Y h:i A", $sec); 
  
    
							$recOn=$date;

							$empId=$this->session->userdata('empId');
							$fromId=$this->session->userdata('employeeId');

							if($empId!=$emp_Id)

							{
								if ($status=="0") {
									# code...
								
						?>
						<tr id="trow" style="background-color: #ffb3b3">
						<?php
								}else{
						?>
						<tr id="trow">
						<?php  } ?>
							<td><?php echo $doc_name;?></td>
							<td><?php echo $recOn;?></td>
							<td><?php echo $recFrom;?></td>
							<td><?php echo $remarks;?></td>
							<td><a type="button" class="btn btn-primary" style="width: 105px;" href="<?php echo base_url();?>viewInboxDocument?r_id=<?php echo $r_id;?>">View</a></td>
						</tr>
					<?php 
							}
						}
					} 
					?>
				</tbody>
			</table>
	
		

		
		
		
		
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