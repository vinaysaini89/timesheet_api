<html class="no-js"><!--<![endif]-->
<head>
 <?php 
    if($this->lib_user->isLoggedIn())
    {
        redirect('/');
    }
  ?>
	<meta charset="utf-8">
	<title>Employee Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/custom.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	
</head>
<style type="text/css">
	.error{
		color: red;
	}
</style>

<script>
function inputValidate() {
    var e1 = document.getElementsByName("emp_id")[0];
    var e2 = document.getElementsByName("password")[0];
    var emp_id =  e1.options[e1.selectedIndex].value;
    if(emp_id == 0)
    {
    	alert("Employee id is required");
    	return false;
    }

    if(e2.value == "")
    {
    	alert("Password is required");
    	return false;	
    }


    
}
</script>

<body>
	<div class="top-border"></div>
	<table class="center">
		<tbody><tr>
			<td style="text-align: center; vertical-align: middle;">
				<img src="<?php echo base_url();?>assets/img/jindagi.png" alt="Clicks" title="Clicks">

				<div class="candidate-login">
					Employee Login
				</div>
				<div class="error"><?php echo $this->session->flashdata('error');?></div>
				<form method="POST" action="login" name="frmLogon"  onsubmit="return inputValidate()" >
					<table class="form-table">
						<tbody><tr>
							<td>
								Emp ID
							</td>
							<td>
								<select name="emp_id">
									<option value="0">Select Employee</option>
									<?php foreach ($emp as $key => $value) { ?>
										<option value="<?php echo $value['id'] ?>">
										<?php echo ucwords($value['first_name'].' '.$value['last_name'].'-'.$value['id']);?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Password
							</td>
							<td>
								<input type="password" name="password" value="">
							</td>
						</tr>
					</tbody></table>
					
					
					<button type="submit" >Login</button>
					
				</form>
				
			</td>
		</tr>
	</tbody></table>

</body></html>