<?php $this->load->view('common/header'); ?>
    <div class="page-content">
    	<div class="row">
    	<div class="col-md-2">
    		<?php $this->load->view('common/sidebar'); ?>
		  </div>
		  <div class="col-md-10">
		  	<div class="row">
  				
  				<div class="col-md-12">
  					<div class="content-box-large">
		  				<div class="panel-heading">
		  				<div class="row">
							<div class="col-md-7">
							<style type="text/css">
								table.information td{
									border-top: none !important;
								}
							</style>
									<table class="table information">
											<tr>
												<td><b>Employee ID:</b></td><td><input type="text" value="<?php echo $emp['employee_id'] ?>" readonly /></td>
												<td><b>Employee Name:</b></td><td><input type="text" value="<?php echo ucwords($emp['first_name'].' '.$emp['last_name']) ?>" readonly /></td>
											</tr>

											<tr>
												<td><b>Department:</b></td><td><input type="text" value="IT" readonly /></td>
												<td><b>Month:</b></td><td><input type="text" value="May-2017" readonly /></td>
											</tr>

											<tr>
												<td><b>Manager:</b></td><td><input type="text" value="Shantnu" readonly /></td>
												<td><b>Project:</b></td><td><input type="text" value="Dealplexus" readonly /></td>
											</tr>
									</table>
							</div>
							</div>
						</div>
		  				<div class="panel-body">
		  					<table class="table table-striped">
				              <thead>
				                <tr>
				                  <th>Date</th>
				                  <th>Start Time</th>
				                  <th>End Time</th>
				                  <th>Regular Hours</th>
				                  <th>Overtime Hours</th>
				                  <th>Total Hours</th>
				                </tr>
				              </thead>
				              <tbody>
				              <?php foreach ($data as $key => $value) { 

				              		$login_date =  	date('Y-m-d', strtotime($value['login_date']));
				              		$start_time = 	date('H:i', strtotime($value['start_time']));
				              		$end_time =  	date('H:i', strtotime($value['end_time']));
				              		$regular_hours = date("H:i",strtotime($value['regular_hours']));
				              		$overtime_hours = date("H:i",strtotime($value['overtime_hours']));
				              		$current_time = new DateTime();
				              		$s_time = new DateTime($value['start_time']);
				              		
				              		$total_hours = "";
				              		if($value['end_time'] == 0)
				              		{
				              			$interval = $current_time->diff($s_time);
				              			$total_hours = $interval->format('%H:%I');	
				              		}
				              		else
				              		{
				              			$e_time = new DateTime($value['end_time']);
				              			$interval = $e_time->diff($s_time);

				              			$total_hours = $interval->format('%H:%I');
				              		}
				              		
				              		$time1 = new DateTime($total_hours);
									$time2 = new DateTime($regular_hours);
									

									if($time1 > $time2){

										$interval = $time1->diff($time2);
									   	$overtime_hours =  $interval->format('%H:%I');
									}

				              	?>
				              	
				                <tr>
				                  <td><?php echo $login_date; ?></td>
				                  <td><?php echo $start_time; ?></td>
				                  <td><?php echo $end_time ; ?></td>
				                  <td><?php echo $regular_hours; ?></td>
				                  <td><?php echo $overtime_hours;?></td>
				                  <td><?php echo $total_hours; ?></td>
				                </tr>
				               <?php } ?>
				              </tbody>
				            </table>
		  				</div>
		  			</div>
  				</div>
  			</div>
		</div>
    </div>
<?php $this->load->view('common/footer'); ?>
   