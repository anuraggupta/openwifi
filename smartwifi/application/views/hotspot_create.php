<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner" style="vertical-align:bottom;">
        <div class="container">          
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><?php echo anchor("home/loginarea","Home");?></li>
              <li><?php echo anchor("clients","Clients");?></li>
              <li class="active"><?php echo anchor("hotspots","Hotspots");?></li>
              <li><?php echo anchor("plans","Plans");?></li>
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

		<h1>Hotspots Management</h1>
		<ul class="breadcrumb">
			<li><?php echo anchor("home/loginarea","Home");?> <span class="divider">/</span></li>
			<li><?php echo anchor("hotspots","Hotspots");?> <span class="divider">/</span></li>
			<li class="active">Create Hotspot</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/hotspots'">View Hotspots</button>
		  <button class="btn btn-info disabled">Create Hotspot</button>
		</div>
		
		<div class="clearfix"><br></div>
		
		<div class="well">
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-createhotspot');
				$input_att = array('class' => 'input-xlarge');
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit_form', 'content' => 'Add Hotspot', 'value' => 'true', 'onclick'=>'form_sub();', 'name' => 'submit_form');
				
				echo form_open('', $form_att);
			?>
				<h3 class="form-signin-heading">Create Hotspot</h3>
				<div class="span4">
					<div class="control-group">
					    <label class="control-label" for="hotspotName">Hotspot Name</label>
					    <div class="controls">
					    	<?php	$hname = array('placeholder'=> 'Hotspot Name', 'name'=>'HotspotName', 'id'=>'hotspotName');
					    			echo form_input($input_att + $hname ); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="hotspotRouter">Router</label>
					    <div class="controls">
					    	<?php	$router = array('placeholder'=> 'Router Details', 'name'=>'hotspotRouter', 'id'=>'hotspotRouter');
					    			echo form_input($input_att+$router); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="hotspotOutlet">Outlet Name</label>
					    <div class="controls">
					    	<?php	$outlet = array('placeholder'=> 'Outlet Name', 'name'=>'hotspotOutlet', 'id'=>'hotspotOutlet');
					    			echo form_input($input_att+$outlet); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="hotspotAdd">Outlet Address</label>
					    <div class="controls">
					    	<?php	$hadd = array('placeholder'=> 'Outlet Address', 'name'=>'hotspotAdd', 'id'=>'hotspotAdd');
					    			echo form_input($input_att+$hadd); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="hotspotLoc">Hotspot Location</label>
					    <div class="controls">
					    	<?php	$hloc = array('placeholder'=> 'Hotspot Location', 'name'=>'hotspotLoc', 'id'=>'hotspotLoc');
					    			echo form_input($input_att+$hloc); ?>
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
					    <label class="control-label" for="hotspotURL">Default URL</label>
					    <div class="controls">
					    	<?php	$hurl = array('placeholder'=> 'Default URL', 'name'=>'hotspotURL', 'id'=>'hotspotURL');
					    			echo form_input($input_att+$hurl); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="hotspotMac">Mac Address</label>
					    <div class="controls">
					    	<?php	$hmac = array('placeholder'=> 'Mac Address', 'name'=>'hotspotMac', 'id'=>'hotspotMac');
					    			echo form_input($input_att+$hmac); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="hotspotOperator">3G Operator</label>
					    <div class="controls">
					    	<?php	$hoperator = array('placeholder'=> '3G Operator', 'name'=>'hotspotOperator', 'id'=>'hotspotOperator');
					    			echo form_input($input_att+$hoperator); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="hotspotInumber">3G Number</label>
					    <div class="controls">
					    	<?php	$hno = array('placeholder'=> '3G Number', 'name'=>'hotspotInumber', 'id'=>'hotspotInumber');
					    			echo form_input($input_att+$hno); ?>
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
			Hotspot has been added successfully.
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
				hotspotName: $('#hotspotName').val(),
				hotspotRouter: $('#hotspotRouter').val(),
				hotspotOutlet: $('#hotspotOutlet').val(),
				hotspotAdd: $('#hotspotAdd').val(),
				hotspotLoc: $("#hotspotLoc").val(),
		     	hotspotPlan: $("#hotspotPlan").val(),
		     	hotspotAction: $("#hotspotAction").val(),
		     	hotspotURL: $("#hotspotURL").val(),
		     	hotspotMac: $("#hotspotMac").val(),
		     	hotspotOperator: $("#hotspotOperator").val(),
		     	hotspotInumber: $("#hotspotInumber").val(),
				ajax: '1'		
			};
			
			var request = $.ajax({
				url: "<?php echo site_url('hotspots/create'); ?>",
				type: 'POST',
				data: form_data
			});
			request.success(function(msg) {
				$('#addedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 3000);
				document.getElementById("form-createhotspot").reset();
			});
    		request.fail(function(msg) {
    			$('#notaddedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 3000);
				document.getElementById("form-createhotspot").reset();
    		});
			
			return false;
		};
	</script>