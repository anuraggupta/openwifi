<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner" style="vertical-align:bottom;">
        <div class="container">          
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><?php echo anchor("home/loginarea","Home");?></li>
              <li><?php echo anchor("clients","Clients");?></li>
              <li><?php echo anchor("hotspots","Hotspots");?></li>
              <li class="active"><?php echo anchor("plans","Plans");?></li>
              <li><?php echo anchor("campaigns","Campaigns");?></li>
              <li><?php echo anchor("vouchers","Vouchers");?></li>
              <li><?php echo anchor("analytics","Analytics");?></li>
              <li><?php echo anchor("home/logout","Logout");?></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container" id="content_main">

		<h1>Plans Management</h1>
		<ul class="breadcrumb">
			<li><?php echo anchor("home/loginarea","Home");?> <span class="divider">/</span></li>
			<li><?php echo anchor("plans","Plans");?> <span class="divider">/</span></li>
			<li class="active">Create Plans</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/plans'">View Plans</button>
		  <button class="btn btn-info disabled">Create Plans</button>
		</div>
		
		<div class="clearfix"><br></div>
		
		<div class="well">
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-createplan');
				$input_att = array('class' => 'input-xlarge');
				$drop_att = 'class="dropdwn"';
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit_form', 'content' => 'Add Plan', 'value' => 'true', 'onclick'=>'form_sub();', 'name' => 'submit_form');
				
				echo form_open('', $form_att);
			?>
				<h3 class="form-signin-heading">Create Plan</h3>
				<div class="span4">
					<div class="control-group">
					    <label class="control-label" for="clientName">Plan Name</label>
					    <div class="controls">
					    	<?php	$pname = array('placeholder'=> 'Plan Name', 'name'=>'planName', 'id'=>'planName');
					    			echo form_input($input_att + $pname ); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="planType">Plan Type</label>
					    <div class="controls">
					    	<?php	$ptype =  'id="planType"';
					    			$types = array(
									                  'time' => 'Time Based',
									                  'packet' => 'Packet Based',
									                );
					    			echo form_dropdown('planType', $types, 'time', $ptype); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="planAmount">Type Amount</label>
					    <div class="controls">
					    	<?php	$pamount = array('placeholder'=> 'Type Amount', 'name'=>'planAmount', 'id'=>'planAmount');
					    			echo form_input($input_att+$pamount); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="planPrice">Plan Pricing</label>
					    <div class="controls">
					    	<?php	$pprice = array('placeholder'=> 'Plan Pricing', 'name'=>'planPrice', 'id'=>'planPrice');
					    			echo form_input($input_att+$pprice); ?>
						</div>
					</div>
					<div class="control-group">
	    				<div class="controls">
	    					<?php echo form_button($submit_att);?>
	    				</div>
					</div>
				</div>
				<div class="span5 offset1">
					<div class="control-group">
					    <label class="control-label" for="planDown">Download Bandwidth</label>
					    <div class="controls">
					    	<?php	$pdown = 'id="planDown"';
					    			$down = array(
									                  '128000'  => '128 KBps',
									                  '256000'  => '256 KBps',
									                  '512000'  => '512 KBps',
									                  '1024000'  => '1 MBps',
									                  '2048000'  => '2 MBps',
									                  '3072000'  => '3 MBps',
									                  '4096000'  => '4 MBps',
									                );
					    			echo form_dropdown('planDown', $down, '512000', $pdown); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="planUp">Upload Bandwidth</label>
					    <div class="controls">
					    	<?php	$pup = 'id="planUp"';
					    			$up = array(
									                  '128000'  => '128 KBps',
									                  '256000'  => '256 KBps',
									                  '512000'  => '512 KBps',
									                  '1024000'  => '1 MBps',
									                  '2048000'  => '2 MBps',
									                  '3072000'  => '3 MBps',
									                  '4096000'  => '4 MBps',
									                );
					    			echo form_dropdown('planUp', $up, '512000', $pup); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="planTimeout">Idle Timeout</label>
					    <div class="controls">
					    	<?php	$ptime = 'id="planTimeout"';
					    			$timeout = array(
									                  '0'  => 'No Limit',
									                  '1'  => '1 Min',
									                  '2'  => '2 Mins',
									                  '5'  => '5 Mins',
									                  '10'  => '10 Mins',
									                  '15'  => '15 Mins',
									                );
					    			echo form_dropdown('planTimeout', $timeout, 'No Limit', $ptime); ?>
						</div>
					</div>
					<?php
						echo form_close();
					?>
				</div>
				<div class="clearfix"></div>
		</div>

    </div> <!-- /container -->
    
    <div id="addedPop" class="modal hide fade in" style="display: none; ">  
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Great!</h3>
		</div>  
		<div class="modal-body">
			Plan has been added successfully.
		</div>  
		<div class="modal-footer">
			<a href="#" class="btn btn-success" data-dismiss="modal">Close</a>
		</div>
	</div>
	
	<div id="notaddedPop" class="modal hide fade in" style="display: none; ">  
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Oops!</h3>
		</div>  
		<div class="modal-body">
			Something went wrong, please try again.
		</div>  
		<div class="modal-footer">
			<a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
		</div> 
	</div>
    
	<script type="text/javascript">
		function form_sub() {
			
			var form_data = {
				planName: $('#planName').val(),
				planType: $("#planType").val(),
				planAmount: $("#planAmount").val(),
			    planPrice: $("#planPrice").val(),
			    planDown: $("#planDown").val(),
			    planUp: $("#planUp").val(),
			    planTimeout: $("#planTimeout").val(),
				ajax: '1'		
			};
			
			var request = $.ajax({
				url: "<?php echo site_url('/plans/create'); ?>",
				type: 'POST',
				data: form_data,
			});
			request.success(function(msg) {
				$('#addedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 2000);
				document.getElementById("form-createplan").reset();
			});
    		request.fail(function(msg) {
    			$('#notaddedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 2000);
				document.getElementById("form-createplan").reset();
    		});
			
			return false;
		};
	</script>