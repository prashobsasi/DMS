<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="DMS Admin Panel" />
<meta name="author" content="" />

<link rel="icon" href="<?php echo asset_url();?>images/favicon.png">

<title>DMS | Login</title>

<link rel="stylesheet" href="<?php echo asset_url();?>js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-core.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-theme.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-forms.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/skins/yellow.css">

	<script src="<?php echo asset_url();?>js/jquery-1.11.3.min.js"></script>

	



</head>
<body class="page-body login-page login-form-fall">


	<div class="login-container">
		<div class="login-header login-caret">
											
			<div class="login-content">
				
				<a href="index.html" class="logo">
					<img src="<?php echo asset_url();?>images/logo@2x.png" width="200"  alt="" />
				</a>
				
				<!--<p class="description">Dear user, log in to access the admin area!</p>-->



				<!-- progress bar indicator -->

			</div>



		</div>

		<div class="login-form">
			<div class="login-content">
				
				
				<form method="post" role="form" id="loginForm" action="<?php echo base_url();?>Main/login_validation">

					<h5 style="font-weight:bold; color: red">
					<?php
						echo $this->session->flashdata("error");
					?>
					</h5>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="entypo-user"></i>
							</div>
							<input type="text" class="form-control" name="username"
								autofocus="autofocus" id="username" placeholder="Username"
								autocomplete="off" />
						</div>
						<span style="font-weight:bold;color: red"><?php echo form_error('username')?></span>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="entypo-key"></i>
							</div>
							<input type="password" class="form-control" name="password"
								id="password" placeholder="Password" autocomplete="off" />
						</div>
						<span style="font-weight:bold;color: red "><?php echo form_error('password')?></span>
					</div>
					<div class="pull-left">
						<input type="checkbox" name="remember-me" id="remember-me">
						<label for="remember-me">Remember me</label>
					</div>

					

					<div class="clearfix"></div>
					<br />
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block btn-login">
							<i class="entypo-login"></i> Sign In
						</button>
					</div>
				</form>
			</div>
		</div>

		<div class="modal fade container" id="modalForgottenPassword">
			<!-- model Dialog -->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label style="color: black;">Email Address</label> <input
								id="txtEmail" class="form-control" placeholder="Email Address" />
						</div>
						<label class="error-msg" style="color: red;"></label>

					</div>

					<div class="modal-footer">
						
						<button class="btn btn-info" data-dismiss="modal">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>

		<div class="modal fade container" id="modalStatus">
			<!-- model Dialog -->
			<div class="modal-dialog">
				<div class="modal-content"
					style="background: url(http://mahindradsqi.com/media/content_admin/img/Background-Vector.jpg);">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="divStatus">
						<label style="color: black; font-weight: bold;">&nbsp;
							Password Reset Link has been send to the given mail address</label>
					</div>
					<div class="modal-footer">
						<button class="btn btn-info" data-dismiss="modal">OK</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
	</div>

	<script src="<?php echo asset_url();?>js/gsap/TweenMax.min.js"></script>
	<script src="<?php echo asset_url();?>js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?php echo asset_url();?>js/bootstrap.js"></script>
	<script src="<?php echo asset_url();?>js/joinable.js"></script>
	<script src="<?php echo asset_url();?>js/resizeable.js"></script>
	<script src="<?php echo asset_url();?>js/neon-api.js"></script>
	<script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
	<script src="<?php echo asset_url();?>js/neon-login.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo asset_url();?>js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="<?php echo asset_url();?>js/neon-demo.js"></script>

</body>
</html>