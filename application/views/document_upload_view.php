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

	<title>DMS | Document Type</title>

	<link rel="stylesheet" href="<?php echo asset_url();?>js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-core.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-theme.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-forms.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/skins/yellow.css">

	<script src="<?php echo asset_url();?>js/jquery-1.11.3.min.js"></script>

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
			dtDocumentUpload = $('#dtDocumentUpload');

			dtDocumentUpload.dataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"bStateSave": true
			});


			
			// Initalize Select Dropdown after DataTables is created
			dtDocumentUpload.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
				minimumResultsForSearch: -1
			});
		});

		
		function addDocumentUpload(){

			
			$('.error-msg').html('');
			/*document.getElementById("name").value="";
			document.getElementById("deptHiddenId").value="";*/

			$('#docTypeModal').modal('show');
		}

		function setFileName(){

			var documentTypeId=$('#dbDocType').val();

			if(documentTypeId=="-1"){
				alert("Select Document Type");
				return;
			}

			$.ajax({
        			url : "<?php echo base_url(); ?>document_upload/getFileName",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : documentTypeId},
        			success : function(filename) {
        					$('#filename').val(filename);

        			},
        			error : function (jqXHR, textStatus, errorThrown){
            				alert(errorThrown);
        			}
    			});

			


		}

		var file_name = "";
		var base64String = "";
		var file_extention="";

		function getBase64String(event){

			var reader = new FileReader();

			file_name=event.target.files[0].name;

			file_extention=file_name.split('.').pop();

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

		function editDocumentUpload(id,obj){

			$('.error-msg').html('');
	    	departmentRow = $(obj).closest('tr');

			$.ajax({
        			url : "<?php echo base_url(); ?>department/edit",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(data) {

        				var departments=JSON.stringify(data);

        				var dept_name="";

        				var dept_Id="";

        			

        				for (i=0; i < data.departments.length; i++){

        					dept_name=data.departments[i].dept_name;
        					dept_Id=data.departments[i].dept_Id;

						}

						document.getElementById("name").value=dept_name;
						
						document.getElementById("deptHiddenId").value=dept_Id;

						$('#docTypeModal').modal('show');

        			},
        			error : function (jqXHR, textStatus, errorThrown){
            				alert("error");
        			}
    			});

			

		}

		function deleteDocumentUpload(id,obj){


			$.ajax({
        			url : "<?php echo base_url(); ?>department/delete",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(status) {

						if(status){
					// delete row from data table
							var row = $(obj).closest('tr');
							dtDocumentUpload.fnDeleteRow(row[0]);	
						}else{
							alert("failed");
						}
						

        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            				alert("errorThrown");
        			}
    			});

			


	    }

		function saveDocumentUpload(){

			var f=0;


			var employee_id = document.getElementById("empHiddenId").value;
			var file=$('#pdf_file').val();
			var file_name_ext=$('#filename').val()+"."+file_extention;
			var doc_type_id=$('#dbDocType').val();

			if(file==""){
				f=1;
				$(".error-msg").html("Please Selecte a File");
			}

			var file_data = $('#pdf_file').prop('files')[0]; 
		
			if(f==0)
			{
				var form_data = new FormData();  
				form_data.append('emp_id', employee_id);
				form_data.append('doc_type_id', doc_type_id);
				form_data.append('filename', file_name_ext);
				form_data.append('file', file_data); 
				$(".error-msg").html("saving...");
				$.ajax({
        			url : "<?php echo base_url(); ?>document_upload/save",
        			type : "POST",
        			dataType : "text",
        			cache: false,
			        contentType: false,
			        processData: false,
        			data : form_data,
        			success : function(data) {

        				var documents=JSON.parse(data);
		//var documents=JSON.stringify(data);
        				$('#docTypeModal').modal('hide');
        				dtDocumentUpload.fnAddData([file_name_ext,getDateTime(documents.crated_date),documents.doc_type,""]);
        			},
        			error : function (jqXHR, textStatus, errorThrown) {
        						$(".error-msg").html("");
            					console.log(textStatus);
            					$(".error-msg").html("Forwarding Failed,Please Contact Admin");
        			}
    			});
    		}
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
			if(minutes<10){
				minutes="0"+minutes;
			}
			if(hours<10){
				hours="0"+hours;
			}
			if(seconds<10){
				seconds="0"+seconds;
			}
			var timeString = "" + ((hours > 12) ? hours - 12 : hours);
			timeString += ((minutes < 10) ? ":0" : ":") + minutes;
		//timeString += ((seconds < 10) ? ":0" : ":") + seconds;
			timeString += (hours >= 12) ? " PM" : " AM";
			return dateString + " " + timeString;
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
					<h1>DOCUMENT UPLOAD</h1>
		</div>
		
		<hr />
		
		<div class="row col-xs-12">
				<div class="pull-right">
					<button type="button" class="btn btn-success" onclick="addDocumentUpload()">Add Document Upload</button>
				</div>
		</div>
		<div class="clearfix"></div>
		<hr />

		<div class="row">
			<table class="table table-bordered datatable" id="dtDocumentUpload">
				<thead>
					<tr>
						<th>File Name</th>
						<th>Uploaded On</th>
						<th>File Type</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					 <?php foreach ($documents as $document) { 


					 			$doc_type_name="";
					 			foreach ($doc_types as $doc_type) {

					 				if($document->doc_type==$doc_type->id){
					 					$doc_type_name=$doc_type->name;
					 				}


					 			}

					 		$sec = strtotime($document->created_date); 
  
       						$date = date("d-m-Y h:i A", $sec); 

       						$up_date=$date;


					 ?>
						<tr>
							<td><?php echo $document->doc;?></td>
							<td><?php echo $up_date;?></td>
							<td><?php echo $doc_type_name;?></td>
							<td></td>
						</tr>
						<?php } ?> 
						
				</tbody>
			</table>
		
		</div>
		

		
		
		
		
		<!-- Footer -->

		<?php include 'footer.php';?>
		
	</div>
			
</div>



<div class="modal fade" id="docTypeModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Document Upload</strong></h4>
        </div>
        <form name="docTypeForm" id="docTypeForm"  enctype='multipart/form-data' method="post">
        	<div class="modal-body">

        		<label>Doucument Type</label>
					<select name="docType" id="dbDocType" class="form-control" 
								autofocus="autofocus" 
								autocomplete="off" onchange="setFileName()">
						<option value="-1">--- Select Document Type ---</option>
						<?php foreach ($doc_types as $doc_type) { ?>
							<option value="<?php echo $doc_type->id;?>"><?php echo $doc_type->name;?></option>
						<?php } ?>
					</select>
					<br>
				<label>File Name</label>
         		 <input type="text" class="form-control" name="filename"
								autofocus="autofocus" id="filename"
								autocomplete="off" placeholder="File Name" disabled/>
					<br>
					<input class="form-control" type="file" id="pdf_file" name="pdf_file" accept="application/pdf" onchange="getBase64String(event)" ><input id="hiddenPdfId" name="hiddenId" type="hidden" value="">
				

				<embed  id="output_pdf" type="application/pdf" height="500px" width="100%" class="responsive">
				<input id="empHiddenId" name="empHiddenId" type="hidden" value=<?php echo $this->session->userdata('empId'); ?>>
				<label class="error-msg" style="color: red;"></label>
        	</div>
        	<div class="modal-footer">

        	<button type="button" class="btn btn-success" onclick="saveDocumentUpload()">Save</button>
          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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


	<script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>
	
	<!-- Demo Settings -->
	<script src="<?php echo asset_url();?>js/neon-demo.js"></script>


</body>
</html>