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

	<title>DMS | Employee</title>

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
			dtEmployee = $('#dtEmployee');

			dtEmployee.dataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"bStateSave": true
			});


			
			// Initalize Select Dropdown after DataTables is created
			dtEmployee.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
				minimumResultsForSearch: -1
			});
		});




		
		function addEmployee(id,obj){

			$('#modHead').html("Employee Registration");
			$('.error-msg').html('');
			$(".emperr-msg").html("");
			$(".emailerr-msg").html("");
			$(".phoneerr-msg").html("");
			$(".usernameerr-msg").html("");

			$("#employeeId").prop('disabled', false);
        	$("#employeeName").prop('disabled', false);
        	$("#dob").prop('disabled', false);
        	$("#doj").prop('disabled', false);
        	$("#departmentModal").prop('disabled', false);
        	$("#designationModal").prop('disabled', false);
        	$("#username").prop('disabled', false);
        	$("#password").prop('disabled', false);
        	$("#image").prop('disabled', false);
        	$("#confirmpassword").prop('disabled', false);

			$("#employeeId").val("");
        	$("#employeeName").val("");
        	$("#dob").val("");
        	$("#doj").val("");
        	$("#departmentModal").val("-1");
        	$("#designationModal").val("-1");
        	$("#image").val("");
        	$("#phone").val("");
        	$("#address").val("");
        	$("#email").val("");
        	$("#username").val("");
        	$("#password").val("");
        	$("#confirmpassword").val("");
        	$("#empHiddenId").val("");


			$('#employeeModal').modal('show');
		}

		function editEmployee(id,obj){




			$('#modHead').html("Edit");
			$('.error-msg').html('');
			$(".emailerr-msg").html("");
			$(".phoneerr-msg").html("");

	    	employeeRow = $(obj).closest('tr');

			$.ajax({
        			url : "<?php echo base_url(); ?>employee/edit",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(employee) {

        					$("#employeeId").prop('disabled', true);
        					$("#employeeName").prop('disabled', true);
        					$("#dob").prop('disabled', true);
        					$("#doj").prop('disabled', true);
        					$("#departmentModal").prop('disabled', true);
        					$("#designationModal").prop('disabled', true);
        					$("#image").prop('disabled', true);
        					$("#username").prop('disabled', true);
        					$("#password").prop('disabled', true);
        					$("#confirmpassword").prop('disabled', true);


        					$("#employeeId").val(employee.employeeId);
        					$("#employeeName").val(employee.empname);
        					$("#dob").val(employee.dob);
        					$("#doj").val(employee.doj);
        					$("#departmentModal").val(employee.department);
        					$("#designationModal").val(employee.designation);
        					$("#phone").val(employee.phone);
        					$("#address").val(employee.address);
        					$("#email").val(employee.email);
        					$("#username").val(employee.uname);
        					$("#password").val(employee.password);
        					$("#confirmpassword").val(employee.password);
        					$("#empHiddenId").val(id);
        					
							$('#employeeModal').modal('show');

        			},
        			error : function (jqXHR, textStatus, errorThrown){
            				alert(errorThrown);
        			}
    			});

			

		}

		function viewEmployee(id){

			var rows = "";
			var employeeId=id;
		
		
			var imageHtml="";
			$('#viewRows').html("");

			$.ajax({
        			url : "<?php echo base_url(); ?>employee/view",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(employee) {

						//var employee=JSON.stringify(data);

	        				if (employee.image != null) {
								imageHtml = '<img height="100px" width="100px"  src="data:image/jpeg;base64,'
								+ employee.image
								+ '"/>';
							} else {
								imageHtml = "No Image";
							}

							rows += "<tr><td rowspan='3'>" +  imageHtml
								+ "</td><tr><td>Id</td><td>"+employee.employeeId+"</td></tr><tr><td>Name</td><td>"+employee.empname+"</td></tr><tr><td>Email</td><td colspan='2'>"+employee.email+"</td></tr><tr><td>Username</td><td colspan='2'>"+employee.uname+"</td></tr><tr><td>Date Of Birth</td><td colspan='2'>"+getDateTime(employee.dob) +"</td></tr><tr><td>Department</td><td colspan='2'>"+employee.department+"</td></tr><tr><td>Designation</td><td colspan='2'>"+employee.designation+"</td></tr><tr><td>Date Of Joining</td><td colspan='2'>"+getDateTime(employee.doj) +"</td></tr><tr><td>Phone Number</td><td colspan='2'>"+employee.phone+"</td></tr><tr><td>Address</td><td colspan='2'>"+employee.address+"</td></tr>";
						


        				

        				$('#viewRow').html(rows);
        				$('#viewEmployeeModal').modal('show');
        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            				alert(errorThrown);
        			}
    			});


			
		}

		function deleteEmployee(id,obj){


			$.ajax({
        			url : "<?php echo base_url(); ?>employee/delete",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(status) {

						if(status){
					// delete row from data table
							var emprow = $(obj).closest('tr');
							dtEmployee.fnDeleteRow(emprow[0]);	
						}else{
							alert("failed");
						}
						

        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            				alert("errorThrown");
        			}
    			});

			


	    }

	    function filterDepartment(){

	    	var departmentId =$("#dbDepartments").val();
			var designationId = $("#dbDesignations").val();

			console.log('Dept Id= '+departmentId);
			console.log('Desig Id=' +designationId);

	    	$.ajax({
        			url : "<?php echo base_url(); ?>employee/filterEmployee",
        			type : "POST",
        			dataType : "json",
        			data : {
        				"departmentId" : departmentId,
						"designationId" : designationId

        			},
        			success : function(employees) {
						
        				console.log(employees);

        				dtEmployee.fnClearTable();
						addRowsToTable(employees);
        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            					console.log(errorThrown);
        			}
    			});
		
	    }

	    function filterDesignation(){

	    	var departmentId =$("#dbDepartments").val();
			var designationId = $("#dbDesignations").val();

			console.log('Dept Id= '+departmentId);
			console.log('Desig Id=' +designationId);


	    	$.ajax({
        			url : "<?php echo base_url(); ?>employee/filterEmployee",
        			type : "POST",
        			dataType : "json",
        			data : {
        				"departmentId" : departmentId,
						"designationId" : designationId
        			},
        			success : function(employees) {
						
        				console.log(employees);

        				dtEmployee.fnClearTable();
						addRowsToTable(employees);
        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            					console.log(errorThrown);
        			}
    			});
		
	    }


	    function addRowsToTable(employees) {


			$.each(employees, function(index, employee) {

		

					e_Id=employee.e_Id;
        			emp_Id=employee.employeeId;
        			emp_name=employee.empname;
        			emp_email=employee.email;

        			console.log(employee);
	
        			dtEmployee.fnAddData([emp_Id,emp_name,emp_email,"<button type='button' class='btn btn-primary' style='width: 105px;'' onclick='viewEmployee("+e_Id+")'>View</button> <button type='button' class='btn btn-blue' style='width: 105px;'' onclick='editEmployee("+e_Id+",this)'>Edit</button> <button type='button' class='btn btn-danger' style='width: 105px;'' onclick='deleteEmployee("+e_Id+",this)'>Delete</button> <button type='button' class='btn btn-info' style='width: 105px;'' onclick='editPrivilege("+e_Id+",this)'>Edit Privilege</button>"]);
								

			});
		}

		function editPrivilege(id,obj){

			
			$.ajax({
        			url : "<?php echo base_url(); ?>employee/editPrivilege",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(privilege) {

        					$("#directors").prop('checked', false);
        					$("#officestaff").prop('checked', false);
        					$("#reception").prop('checked', false);
        					$("#principal").prop('checked', false);
        					$("#hod").prop('checked', false);
        					$("#associative_professor").prop('checked', false);
        					$("#assistant_professor").prop('checked', false);
        					$("#trade_instructor").prop('checked', false);

        					console.log(privilege);

        					if(privilege.directors==1)
        						$("#directors").prop('checked', true);
        						
        					if(privilege.officestaff==1)
        						$("#officestaff").prop('checked', true);
        
        					if(privilege.reception==1)
        						$("#reception").prop('checked', true);
        						
        					if(privilege.principal==1)
        						$("#principal").prop('checked', true);
        						
        					if(privilege.hod==1)
        						$("#hod").prop('checked', true);
        					
        					if(privilege.associative_professor==1)
        						$("#associative_professor").prop('checked', true);
        						
        					if(privilege.assistant_professor==1)
        						$("#assistant_professor").prop('checked', true);
        						
        					if(privilege.trade_instructor==1)
        						$("#trade_instructor").prop('checked', true);
        					

        					$("#emHiddenId").val(id);

							$('#viewPrivilegeModal').modal('show');
        			},
        			error : function (jqXHR, textStatus, errorThrown){
            				alert(errorThrown);
        			}
    			});


			
		}

		function savePrivileges(){



				var principal=0;
				var hod=0;
				var directors=0;
				var reception=0;
				var associative_professor=0;
				var assistant_professor=0;
				var officestaff=0;
				var trade_instructor=0;

				var id = $("#emHiddenId").val();

				if(document.getElementById("principal").checked==true){
						principal=1;
				}

				if(document.getElementById("hod").checked==true){
						hod=1;
				}

				if(document.getElementById("directors").checked==true){
						directors=1;
				}

				if(document.getElementById("reception").checked==true){
						reception=1;

				}

				if(document.getElementById("associative_professor").checked==true){
						associative_professor=1;

				}

				if(document.getElementById("assistant_professor").checked==true){
						assistant_professor=1;

				}

				if(document.getElementById("officestaff").checked==true){
						officestaff=1;

				}

				if(document.getElementById("trade_instructor").checked==true){
						trade_instructor=1;

				}
				console.log(principal+"-"+hod+"-"+directors+"-"+reception+"-"+associative_professor+"-"+assistant_professor+"-"+officestaff+"-"+trade_instructor);

				$.ajax({
        			url : "<?php echo base_url(); ?>employee/savePrivilege",
        			type : "POST",
        			dataType : "json",
        			data : {
        				"id" : id,
        				"principal" : principal,
						"hod" : hod,
						"directors" : directors,
						"reception" : reception,
						"associative_professor" : associative_professor,
						"assistant_professor" : assistant_professor,
						"officestaff" : officestaff,
						"trade_instructor" : trade_instructor
        			},
        			success : function(status) {
						
        				if(status){
        					$('#viewPrivilegeModal').modal('hide');
        				}
        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            					console.log(errorThrown);
        			}
    			});

		}
		
		
		function getBase64String(event){

			var reader = new FileReader();
			reader.onload = function()
			{
 				var img = reader.result;
 				$("#imageDiv").html("<img src="+img+" width=100px>");

 				var block = img.split(";");
			 	base64String = block[1].split(",")[1]; 
			 	
			 	console.log(base64String);	
			}

  			reader.readAsDataURL(event.target.files[0]); 
		}


		function saveEmployee(){

				var f=0;

				
				var empId=$("#employeeId").val();
        		var empname=$("#employeeName").val();
        		var dob=$("#dob").val();
        		var doj=$("#doj").val();
        		var department=$("#departmentModal").val();
        		var designation=$("#designationModal").val();
        		var image=$("#image").val();
        		
        		var phone=$("#phone").val();
        		var address=$("#address").val();
        		var email=$("#email").val();
        		var username=$("#username").val();
        		var password=$("#password").val();
        		var confirmpassword=$("#confirmpassword").val();
        		var e_id=	$("#empHiddenId").val();

        		var emailRegExp =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        		var phoneRegExp = /^\d{10}$/;
        					

				if(confirmpassword==""){
					f=1;
					$(".error-msg").html("Please Enter  Confirm Password");
				}else if(password!=confirmpassword){
					f=1;
					$(".error-msg").html("Password Mismatch");
				}
				if(password==""){
					f=1;
					$(".error-msg").html("Please Enter Password");
				}
				if(username==""){
					f=1;
					$(".error-msg").html("Please Enter Username");
				}
				if(email==""){
					f=1;
					$(".error-msg").html("Please Enter Email");
				}else if(emailRegExp.test(email)!=true){
					f=1;
					$(".error-msg").html("Please Enter Valid Email");
				}
				if(address==""){
					f=1;
					$(".error-msg").html("Please Enter Address");
				}
				if(phone==""){
					f=1;
					$(".error-msg").html("Please Enter Phone");
				}else if(phoneRegExp.test(phone)!=true){
					f=1;
					$(".error-msg").html("Please Enter Valid Phone Number");
				}
				if(e_id=="")
				{
					if(image==""){

						f=1;
						$(".error-msg").html("Please Choose Image");
					}
				}
				if(designation=="-1"){
					f=1;
					$(".error-msg").html("Please Enter Designation");
				}
				if(department=="-1"){
					f=1;
					$(".error-msg").html("Please Enter Department");
				}
				if(doj==""){
					f=1;
					$(".error-msg").html("Please Enter Date of Joining");
				}
				if(dob==""){
					f=1;
					$(".error-msg").html("Please Enter Date Of Birth");
				}
				if(empname==""){
					f=1;
					$(".error-msg").html("Please Enter Employee Name");
				}
				if(empId==""){
					f=1;
					$(".error-msg").html("Please Enter Employee Id");
				}
				
				if (f==0) {

					if (e_id!="") {

						$.ajax({
        					url : "<?php echo base_url(); ?>employee/update",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"id" : e_id,
        						"phone" : phone,
        						"address": address,
        						"email" : email,
        					},
        					success : function(data) {

        						employeeRow.find("td").eq(0).text(empId);
        						employeeRow.find("td").eq(1).text(empname);
        						employeeRow.find("td").eq(2).text(email);

								$('#employeeModal').modal('hide');

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					$('#employeeModal').modal('show');
        					}
    					});
						
					}else{

						$.ajax({
        					url : "<?php echo base_url(); ?>employee/insert",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"employeeId" : empId,
        						"empname" : empname,
        						"dob" : dob,
        						"doj" : doj,
        						"department" : department,
        						"designation" : designation,
        						"image" : base64String,
        						"phone" : phone,
        						"address": address,
        						"email" : email,
        						"username" : username,
        						"password" : password
        					},
        					success : function(employee) {


        						//var employee=JSON.stringify(data);

        						 console.log(employee);
     
        							
        							e_Id=employee['e_Id'];
        							emp_Id=employee['employeeId'];
        							emp_name=employee['empname'];
        							emp_email=employee['email'];
	
        							dtEmployee.fnAddData([emp_Id,emp_name,emp_email,"<button type='button' class='btn btn-primary' style='width: 105px;'' onclick='viewEmployee("+e_Id+",this)'>View</button> <button type='button' class='btn btn-blue' style='width: 105px;'' onclick='editEmployee("+e_Id+",this)'>Edit</button> <button type='button' class='btn btn-danger' style='width: 105px;'' onclick='deleteEmployee("+e_Id+",this)'>Delete</button> <button type='button' class='btn btn-info' style='width: 105px;'' onclick='editPrivilege("+e_Id+",this)'>Edit Privilege</button>"]);
								

								$('#employeeModal').modal('hide');
								

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
		                		$("#employeeModal").show();
		                		alert(errorThrown);
		            		}
    					});

						//$('#departmentModal').modal('hide');
					}
					
				}
		}

		


		function getDateTime(date) {
			var date = new Date(date);
		 monthNames = [ "January", "February", "March", "April", "May",
				"June", "July", "August", "September", "October", "November",
				"December" ]; 
			var day = date.getDate();
		
			var monthIndex = date.getMonth() ;

			
			var year = date.getFullYear();
			var dateString = day + ", " + monthNames[monthIndex] + ", " + year;
			//var dateString = day + "/" + monthIndex + "/" + year;

			return dateString;
		}

		function empId_exist(){

			var empId=$("#employeeId").val();

			if(empId!="")
			{
				$.ajax({
        					url : "<?php echo base_url(); ?>employee/chekEmployeeId",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"id" : empId,
        					},
        					success : function(status) {

        						if(status){
        							f=1;
        							$(".emperr-msg").html("Employee Id Already Exists");	
        						}else{
        							f=0;
        							$(".emperr-msg").html("");
        						}

        						

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
        					}
    					});
			}
		}

		function empEmail_exist(){

        	var email=$("#email").val();

			if(email!="")
			{
				$.ajax({
        					url : "<?php echo base_url(); ?>employee/chekEmployeeEmail",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"email" : email,
        					},
        					success : function(status) {

        						if(status){
        							f=1;
        							$(".emailerr-msg").html("Email Address Already Exists");	
        						}else{
        							f=0;
        							$(".emailerr-msg").html("");
        						}

        						

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
        					}
    					});
			}
		}

		function empPhone_exist(){

			
			var phone=$("#phone").val();
        		
			if(phone!="")
			{
				$.ajax({
        					url : "<?php echo base_url(); ?>employee/chekEmployeePhone",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"phone" : phone,
        					},
        					success : function(status) {

        						if(status){
        							f=1;
        							$(".phoneerr-msg").html("Phone Number Already Exists");	
        						}else{
        							f=0;
        							$(".phoneerr-msg").html("");
        						}

        						

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
        					}
    					});
			}
		}

		function empUsername_exist(){

			
        	var username=$("#username").val();

			if(username!="")
			{
				$.ajax({
        					url : "<?php echo base_url(); ?>employee/chekEmployeeUsername",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"username" : username,
        					},
        					success : function(status) {

        						if(status){
        							f=1;
        							$(".usernameerr-msg").html("Username Already Exists");	
        						}else{
        							f=0;
        							$(".usernameerr-msg").html("");
        						}

        						

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					
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
					<h1>EMPLOYEE</h1>
				</div>
		
		<hr />
		
		<div class="row col-xs-12">

				<div class="form-group">
					<div class="col-sm-3">
						<select name="department" id="dbDepartments" class="form-control" onchange="filterDepartment()">
								<option value="-1">--- Select Department ---</option>
							<?php foreach ($departments as $department) { ?>
								<option value="<?php echo $department->dept_Id;?>"><?php echo $department->dept_name;?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-3">
						<select name="desig" id="dbDesignations" class="form-control" onchange="filterDesignation()">
								<option value="-1">--- Select Designation ---</option>
							<?php foreach ($designations as $designation) { ?>
								<option value="<?php echo $designation->desig_id;?>"><?php echo $designation->desig_name;?></option>
							<?php } ?>
						</select>
					</div>

				</div>


				<div class="pull-right">
					<button type="button" class="btn btn-success" onclick="addEmployee()">Add Employee</button>
				</div>
		</div>
		<div class="clearfix"></div>
		<hr />

		<div class="row">
			<table class="table table-bordered datatable" id="dtEmployee">
				<thead>
					<tr>
						<th>Employee Id</th>
						<th>Employee Name</th>
						<th>Email</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($employees as $employee) 
						{ 
							if($employee->emp_name!='admin')
							{
					?>
						<tr>
							<td><?php echo $employee->emp_id;?></td>
							<td><?php echo $employee->emp_name;?></td>
							<td><?php echo $employee->email;?></td>
							<td><button type="button" class="btn btn-primary" style="width: 105px;" onclick="viewEmployee(<?php echo $employee->e_id;?>,this)">View</button>
								<button type="button" class="btn btn-blue" style="width: 105px;" onclick="editEmployee(<?php echo $employee->e_id; ?>,this)">Edit</button>
								<button type="button" class="btn btn-danger" style="width: 105px;" onclick="deleteEmployee(<?php echo $employee->e_id; ?>,this)">Delete</button>
								<button type="button" class="btn btn-info" style="width: 105px;" onclick="editPrivilege(<?php echo $employee->e_id; ?>,this)">Edit Privilege</button>
								<label id="hiddenId" hidden ><?php echo $employee->emp_id; ?></label>
							</td>
						</tr>
					<?php 	}
						} 
					?>
				</tbody>
			</table>
		
		</div>
		
		
		
		
		<!-- Footer -->

		<?php include 'footer.php';?>
		
	</div>
			
</div>

<div class="modal fade" id="employeeModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong id="modHead"></strong></h4>
        </div>
        <form name="regForm" id="form1"  enctype='multipart/form-data' method="post">
        	<div class="modal-body">
       
        			<label>Employee Id</label>
					<input type="text" name="employeeId" class="form-control" 
								autofocus="autofocus" id="employeeId" onchange="empId_exist()" 
								autocomplete="off" />
					<label class="emperr-msg" style="color: red;"></label>
					<br>
					<label>Employee Name</label>
					<input type="text" name="employeeName" class="form-control" 
								autofocus="autofocus" id="employeeName"
								autocomplete="off" />
					<br>
					<label>Date Of Birth</label>
					<input type="date" name="dob" class="form-control" 
								autofocus="autofocus" id="dob"
								autocomplete="off" >
					<br>
					<label>Date Of Joining</label>
					<input type="date" name="doj" class="form-control" 
								autofocus="autofocus" id="doj"
								autocomplete="off">
					<br>
					<label>Department</label>
					<select name="department" id="departmentModal" class="form-control" 
								autofocus="autofocus"
								autocomplete="off">
						<option value="-1">--- Select Department ---</option>
						<?php foreach ($departments as $department) { ?>
							<option value="<?php echo $department->dept_Id;?>"><?php echo $department->dept_name;?></option>
						<?php } ?>
					</select>
					<br>
					<label>Designation</label>
					<select name="desig" id="designationModal" class="form-control" 
								autofocus="autofocus" 
								autocomplete="off">
						<option value="-1">--- Select Designation ---</option>
						<?php foreach ($designations as $designation) { ?>
							<option value="<?php echo $designation->desig_id;?>"><?php echo $designation->desig_name;?></option>
						<?php } ?>
					</select>
					<br>
					<label>Image</label>
					<input type="file" name="image"  accept="image/jpeg" class="form-control" 
								onchange="getBase64String(event)" autofocus="autofocus" id="image"
								autocomplete="off"/>
					<br>
					<div id="imageDiv">
					</div>
					<br>
					<label>Phone Number</label>
					<input type="text" name="phone" class="form-control" 
								autofocus="autofocus" id="phone"
								autocomplete="off" onchange="empPhone_exist()">
					<label class="phoneerr-msg" style="color: red;"></label>
					<br>
					<label>Address</label>
					<textarea name="address" class="form-control" 
								autofocus="autofocus" id="address"
								autocomplete="off" > </textarea>
					<br>
					<label>Email Address</label>
					<input typeinput type="email" name="email" class="form-control" 
								autofocus="autofocus" id="email"
								autocomplete="off" onchange="empEmail_exist()">
					<label class="emailerr-msg" style="color: red;"></label>
					<br>
					<label>Username</label>
					<input type="text" name="username" class="form-control" 
								autofocus="autofocus" id="username"
								autocomplete="off" onchange="empUsername_exist()">
					<label class="usernameerr-msg" style="color: red;"></label>
					<br>
					<label>Password</label>
					<input type="password" name="password" class="form-control" 
								autofocus="autofocus" id="password"
								autocomplete="off">
					<br>
					<label>Confirm Password</label>
					<input type="password" name="confirmpassword" class="form-control" 
								autofocus="autofocus" id="confirmpassword"
								autocomplete="off" />
         			<input id="empHiddenId" name="empHiddenId" type="hidden" value="">
         			<br><br>
					<label class="error-msg" style="color: red;"></label>
        	</div>
        	<div class="modal-footer">

        	<button type="button" class="btn btn-success" id="saveEmp" onclick="saveEmployee()">Save</button>
          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	</div>
        </form>

      </div>
      
    </div>
</div>


<div class="modal fade" id="viewEmployeeModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>View</strong></h4>
        </div>
        
        	<div class="modal-body">

        		<div class="modal-body">
							<table class="table table-striped table-bordered ">
								<tbody id="viewRow"></tbody>
							</table>
				</div>
        	</div>
        	<div class="modal-footer">

          		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	</div>

     </div>
      
    </div>
</div>	

<div class="modal fade" id="viewPrivilegeModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Privileges</strong></h4>
        </div>
        <form name="empForm" id="empForm"  enctype='multipart/form-data' method="post">
        	<div class="modal-body">
        	
        		<div class="modal-body" style="text-align: center">


        			<table class="table table-bordered datatable">
        			<tr>
						<td><input type="checkbox"  name="directors" value="directors" 
								autofocus="autofocus" id="directors"
								autocomplete="off" />
						</td>
						<td><strong>Directors</strong></td>
					</tr>
					<tr>
						<td><input type="checkbox"  name="officestaff" value="officestaff" 
								autofocus="autofocus" id="officestaff"
								autocomplete="off" />
						</td>
						<td><strong>Office Staff</strong></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="reception"  value="reception" 
								autofocus="autofocus" id="reception"
								autocomplete="off" />
						</td>
						<td><strong>Reception</strong></td>
					</tr>
        			<tr>
        				<td>
        					<input type="checkbox" name="principal" value="principal" 
								autofocus="autofocus" id="principal"
								autocomplete="off" />
						</td>
						<td><strong>Principal</strong></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="hod"  value="hod" autofocus="autofocus" id="hod" autocomplete="off" />
						</td>
						<td><strong>HOD</strong></td>
					</tr>
					<tr>
        				<td>
        					<input type="checkbox" name="associative_professor" value="associative_professor" autofocus="autofocus" id="associative_professor"
								autocomplete="off" />
						</td>
						<td><strong>Associative Professor</strong></td>
					</tr>
					<tr>
        				<td>
        					<input type="checkbox" name="assistant_professor" value="assistant_professor" 
								autofocus="autofocus" id="assistant_professor" autocomplete="off" />
						</td>
						<td><strong>Assistant Professor</strong></td>
					</tr>
					<tr>
        				<td>
        					<input type="checkbox" name="trade_instructor" value="trade_instructor" 
								autofocus="autofocus" id="trade_instructor" autocomplete="off" />
						</td>
						<td><strong>Trade Instructor</strong></td>
					</tr>
					</table>
        				
				</div>
			
        	</div>
        	<div class="modal-footer">
        		<input id="emHiddenId" name="emHiddenId" type="hidden" value="">
        		<button type="button" class="btn btn-success" id="savePri" onclick="savePrivileges()">Save</button>
          		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	</div>

     </div>
      
    </div>
</div>	

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


	<script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>
	
	<!-- Demo Settings -->
	<script src="<?php echo asset_url();?>js/neon-demo.js"></script>





</body>
</html>