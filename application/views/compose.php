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

	<title>DMS | Compose</title>

	<link rel="stylesheet" href="<?php echo asset_url();?>js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-core.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-theme.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-forms.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/skins/yellow.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/custom/multiselect.css">


	<script src="<?php echo asset_url();?>js/jquery-1.11.3.min.js"></script>
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

			$('#inwardTo').multiselect({
      allSelectedText: 'All',
      maxHeight: 200,
      includeSelectAllOption: true

		});

		CKEDITOR.replace( 'remarksEditor' );
    })



		function getDocuments(){

			var docTypeId=$("#dbDocType").val();
			if(docTypeId=="-1"){
				$(".custom_document").addClass('hide');
				$(".custom_document").removeClass('show');
				alert("Please select Document Type");
				return;
			}
			$(".custom_document").addClass('show');
			$(".custom_document").removeClass('hide');
			$.ajax({
        					url : "<?php echo base_url(); ?>compose/getDocumentByDocType",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"id" : docTypeId,
        					},
        					success : function(docs) {
							
								console.log(docs['documents']);

								arrayLength=docs['documents'].length;

								var options="<option value='-1'>--- Select Document ---</option>";

								for(i=0;i<arrayLength;i++){
									console.log(docs['documents'][i].doc);

									options += "<option value="+docs['documents'][i].doc_Url+">"+docs['documents'][i].doc+"</option>";
								}

        						$("#dbDoc").html(options);

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
        					}
    				});	

		}

		function showDocument(){
			var doc_url=$("#dbDoc").val();

			if(doc_url=='-1'){
				$(".custom_remark").addClass('hide');
				$(".custom_remark").removeClass('show');
				alert("Please select Document");
				return;
			}

			$(".custom_remark").addClass('show');
			$(".custom_remark").removeClass('hide');
			var output = document.getElementById('output_pdf');
 				output.src = "<?php echo uploads_url();?>docs/"+doc_url;


		}
		


		function activateFrwdBtn(){

			if(document.getElementById("principal").checked==true ||document.getElementById("hod").checked==true){
				$("#forward").prop('disabled', false);
				var textarea="<textarea  autofocus='autofocus' id='remarksEditor' name='remarksEditor' autocomplete='off' cols=50 rows=5 placeholder='Remarks'></textarea>";
				$("#remarkText").html(textarea);
				CKEDITOR.replace( 'remarksEditor' );
			}else{
				$("#forward").prop('disabled', true);
				$("#remarkText").html('')
			}
		}

		function onSelect(){
			$('#selectEmployeeModal').modal('show');
			//$('.mdb-select').materialSelect();
		}

		var file_name = "";
		var base64String = "";

		function getBase64String(event){

			var reader = new FileReader();

			file_name=event.target.files[0].name;

			reader.onload = function()
			{
 				var img = reader.result;

 				
 				var output = document.getElementById('output_pdf');
 				output.src = reader.result;

 				var block = img.split(";");
			 	base64String = block[1].split(",")[1]; 
			 	
			 	//console.log(base64String);	
			}

  			reader.readAsDataURL(event.target.files[0]); 
		}

		function forwardTo(){

			$(".error-msg").html("");
			var f=0;

			var docTypeId=$('#dbDocType').val();
			var documentId=$('#dbDoc').val();
			var fromId=$("#hiddenEmpId").val();
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

			if(documentId=="-1"){
				f=1;
				$(".error-msg").html("Please Selecte a Document");
			}

			if(docTypeId=="-1"){
				f=1;
				$(".error-msg").html("Please Selecte a Document Type");
			}

			console.log(docTypeId +"-"+ documentId +"-"+ fromId +"-"+ remarks);
			if(f==0)
			{
				var form_data = new FormData();  
				form_data.append('docTypeId', docTypeId);
				form_data.append('documentId', documentId);
				form_data.append('fromId', fromId);
				form_data.append('remarks', remarks);
				form_data.append('forIds', forIds); 
				$(".error-msg").html("Forwarding...");
				$.ajax({
        			url : "<?php echo base_url(); ?>compose/forwardTo",
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



		function forward(){
			var f=0;

			//var hp=$("#ptext").text();

			//alert(hp);

			//<input id="hiddenId" name="hiddenId" type="hidden" value="<?php //echo $this->session->userdata('empId');?>">	

			var file=$('#pdf_file').val();
			var fromId=$("#hiddenId").val();
			var remarks=CKEDITOR.instances.remarksEditor.getData();
			var forIds=$('#inwardTo').val();
			var hod="";
			var princi="";
			var forId= "";


			
			//console.log(forIds);

			
			if(remarks==""){
				f=1;
				//alert('remark');
				$(".error-msg").html("Please Enter Remarks");
			}

			if(forIds==null){
				f=1;
				//alert('forIds');
				$(".error-msg").html("Please Select Employee");
			}

			if(file==""){
				f=1;
				//alert('file');
				$(".error-msg").html("Please Selecte a File");
			}

			var file_data = $('#pdf_file').prop('files')[0]; 
		
			console.log(fromId +"-"+ forIds +"-"+ file_name);
			if(f==0)
			{
				var form_data = new FormData();  
				form_data.append('fromId', fromId);
				form_data.append('forIds', forIds);
				form_data.append('filename', file_name);
				form_data.append('remarks', remarks);
				form_data.append('file', file_data); 
				$(".error-msg").html("Forwarding...");
				$.ajax({
        			url : "<?php echo base_url(); ?>compose/forward",
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

		function saveTo(){

			$(".error-msg").html("");
			var f=0;

			var docTypeId=$('#dbDocType').val();
			var documentId=$('#dbDoc').val();
			var fromId=$("#hiddenEmpId").val();
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

			if(documentId=="-1"){
				f=1;
				$(".error-msg").html("Please Selecte a Document");
			}

			if(docTypeId=="-1"){
				f=1;
				$(".error-msg").html("Please Selecte a Document Type");
			}

			console.log(docTypeId +"-"+ documentId +"-"+ fromId +"-"+ remarks);
			if(f==0)
			{
				var form_data = new FormData();  
				form_data.append('docTypeId', docTypeId);
				form_data.append('documentId', documentId);
				form_data.append('fromId', fromId);
				form_data.append('remarks', remarks);
				form_data.append('forIds', forIds); 
				$(".error-msg").html("Forwarding...");
				$.ajax({
        			url : "<?php echo base_url(); ?>compose/saveTo",
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

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<?php include 'side_bar.php';?>

	<div class="main-content">
				
		<?php include 'top_bar.php';?>
		
		<hr />
		
		
		<div class="well">
					<h1>Compose</h1>
		</div>
		
		<hr />
		<div class="row">
			
			<form class="form-horizontal" name="sendForm" id="form1"  enctype='multipart/form-data' method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">Doucument Type</label>
					<div class="col-sm-5">
						<select name="docType" id="dbDocType" class="form-control" 
								autofocus="autofocus" 
								autocomplete="off" onchange="getDocuments()">
						<option value="-1">--- Select Document Type ---</option>
						<?php foreach ($doc_types as $doc_type) { ?>
							<option value="<?php echo $doc_type->id;?>"><?php echo $doc_type->name;?></option>
						<?php } ?>
					</select>

					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label hide custom_document">Doucument</label>
					<div class="col-sm-5">
						<select name="doc" id="dbDoc" class="form-control hide custom_document" 
								autofocus="autofocus" 
								autocomplete="off" onchange="showDocument()">
						<option value="-1">--- Select Document ---</option>
					</select>
						
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
					<label class="col-sm-3 control-label hide custom_remark">Remarks</label>
					<div class="col-sm-5 hide custom_remark">
							<textarea autofocus='autofocus' id='remarksEditor' name='remarksEditor' autocomplete='off' cols=50 rows=5 placeholder='Remarks'></textarea>
					</div>
				</div>

				<div class="form-group">
					
					<label class='error-msg col-sm-3 control-label' style='color: red;'></label>
					<div class="col-sm-5 control-label">
						<input class="btn btn-info" style="width:90px" type="button" id="save" name="save" value="SAVE" class="btnLogin" onclick="saveTo()"> 
							<input class="btn btn-success" style="width:90px" type="button" id="forward" name="forward" value="FORWARD" onclick="forwardTo()" class="btnLogin">
					</div>
				</div>
			</form>
				<input id="hiddenEmpId" name="hiddenEmpId" type="hidden" value="<?php echo $this->session->userdata('empId');?>">	
				<hr/>
				<div>
				<embed  id="output_pdf" type="application/pdf" height="600px" width="100%" class="responsive">
				</div>
		</div>
	</hr>
		<?php include 'footer.php';?>
		
	</div>

				<!-- <center>
					<table> -->
					<!-- <tr><td>Choose file:</td><td><input class="form-control" type="file" id="pdf_file" name="pdf_file" accept="application/pdf" onchange="getBase64String(event)" ></td><td><input id="hiddenPdfId" name="hiddenId" type="hidden" value=""></td></tr> -->
<!-- 
					<tr><td><label class="hide">blank</label></td><td></td><td></td></tr>
					<tr><td><label>Doucument Type</label></td>
						<td><select name="docType" id="dbDocType" class="form-control" 
								autofocus="autofocus" 
								autocomplete="off" onchange="getDocuments()">
						<option value="-1">--- Select Document Type ---</option>
						<?php foreach ($doc_types as $doc_type) { ?>
							<option value="<?php echo $doc_type->id;?>"><?php echo $doc_type->name;?></option>
						<?php } ?>
					</select></td>
					<td></td>
					</tr>
					<tr><td><label class="hide">blank</label></td><td></td><td></td></tr>
					<tr><td><label class="hide custom_document">Doucument</label></td>
						<td><select name="doc" id="dbDoc" class="form-control hide custom_document" 
								autofocus="autofocus" 
								autocomplete="off" onchange="showDocument()">
						<option value="-1">--- Select Document ---</option>
					</select></td>
					<td></td>
					</tr>
					<tr><td><label class="hide">blank</label></td><td></td><td></td></tr>
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

 							</select> -->


 							<!-- <select id="inwardTo" multiple="multiple">

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
 					<!-- </td>
 					<td></td></tr>

 						
 					<tr><td><label class="hide">blank</label></td><td></td><td></td></tr>
					
					<tr><td></td><td class="hide custom_remark" id="remarkText"><textarea autofocus='autofocus' id='remarksEditor' name='remarksEditor' autocomplete='off' cols=50 rows=5 placeholder='Remarks'></textarea></td><td></td></tr>

					<tr><td><label class="hide">blank</label></td><td></td><td></td></tr>

					<tr><td></td><td><label class='error-msg' style='color: red;'></label></td><td></td></tr>

					<tr><td><label class="hide">blank</label></td><td></td><td></td></tr> -->

					<!-- <tr><td></td><td align="center"><input class="btn btn-info" type="button" id="save" name="save" value="SAVE" class="btnLogin" onclick="">  <input class="btn btn-success" type="button" id="forward" name="forward" value="FORWARD" onclick="forwardTo()" class="btnLogin"></td><td></td>
					</tr>					
				</table> -->
				<!-- <input id="hiddenId" name="hiddenId" type="hidden" value="<?php echo $this->session->userdata('empId');?>">	
				<hr/>
				<div>
				<embed  id="output_pdf" type="application/pdf" height="600px" width="100%" class="responsive">
				</div> -->
				<!-- </center> -->
			<!-- </form>	 -->	
		<!-- 	</div>	
		</div>

	
			
		<!-- Footer -->

		<!-- <?php include 'footer.php';?>
		
	</div>
			
	</div>  -->




	<link rel="stylesheet" href="<?php echo asset_url();?>js/datatables/datatables.css">

	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2.css">	

	<script src="<?php echo asset_url();?>js/gsap/TweenMax.min.js"></script>
	<script src="<?php echo asset_url();?>js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
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