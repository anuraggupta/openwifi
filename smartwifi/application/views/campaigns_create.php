<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner" style="vertical-align:bottom;">
        <div class="container">          
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="<?php echo site_url();?>/home/loginarea">Home</a></li>
              <li><a href="<?php echo site_url();?>/clients">Clients</a></li>
              <li><a href="<?php echo site_url();?>/hotspots">Hotspots</a></li>
              <li><a href="<?php echo site_url();?>/plans">Plans</a></li>
              <li class="active"><a href="<?php echo site_url();?>/campaigns">Campaigns</a></li>
              <li><a href="<?php echo site_url();?>/vouchers">Vouchers</a></li>
              <li><a href="<?php echo site_url();?>/analytics">Analytics</a></li>
              <li><a href="<?php echo site_url();?>/home/logout">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container" id="content_main">

		<h1>Campaign Management</h1>
		<ul class="breadcrumb">
			<li><?php echo anchor("home/loginarea","Home");?> <span class="divider">/</span></li>
			<li><?php echo anchor("campaigns","Campaigns");?> <span class="divider">/</span></li>
			<li class="active">Create Campaign</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/campaigns'">View Campaigns</button>
		  <button class="btn btn-info disabled">Create Campaign</button>
		</div>
		
		<div class="clearfix"><br></div>
		
		<div class="well">
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-createcampaign');
				$input_att = array('class' => 'input-xlarge');
				$date_att = array('class' => 'input-large');
				$textarea_att = array('rows' => '3','id' => 'campaignDetails', 'placeholder' => 'Campaign Details', 'name' => 'campaignDetails');
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit_form', 'content' => 'Add Campaign', 'value' => 'true', 'onclick'=>'form_sub();', 'name' => 'submit_form');
				
				echo form_open('', $form_att);
			?>
				<h3 class="form-signin-heading">Create Campaign</h3>
				<div class="span4">
					<div class="control-group">
					    <label class="control-label" for="campaignName">Campaign Name</label>
					    <div class="controls">
					    	<?php	$campname = array('placeholder'=> 'Campaign Name', 'name'=>'campaignName', 'id'=>'campaignName');
					    			echo form_input($input_att + $campname ); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="campaignClient">Select Client</label>
					    <div class="controls">
					    	<?php	$campclient =  'id="campaignClient"';
									$clientlist = array();
									$clientlist = $clients_rec;
					    			echo form_dropdown('campaignClient', $clientlist, '', $campclient); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="campaignHotspots">Assign Hotspots</label>
					    <div class="controls">
					    	<?php	$camphotspots =  'id="campaignHotspots"';
									$campselect = array('','');
									$hotspotlist = array();
									$hotspotlist = $hotspots_rec;
					    			echo form_dropdown('campaignHotspots', $hotspotlist, $campselect, $camphotspots); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="campaignPlan">Assign Plan</label>
					    <div class="controls">
					    	<?php	$campplan =  'id="campaignPlan"';
									$planlist = array();
									$planlist = $plan_rec;
					    			echo form_dropdown('campaignPlan', $planlist, '', $campplan); ?>
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
					    <label class="control-label" for="campAction">Campaign Action</label>
					    <div class="controls">
					    	<?php	$campction =  'id="campaignAction"';
					    			$camptypes = array(
									                  'facebookLike' => 'Facebook Like',
									                  'twitter' => 'Twitter Update',
									                  'quiz' => 'Quiz',
									                  'game' => 'Game',
									                  'custom' => 'Custom',
									                );
					    			echo form_dropdown('campaignAction', $camptypes, 'facebookLike', $campction); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="campaignURL">Campaign URL</label>
					    <div class="controls">
					    	<?php	$campurl = array('placeholder'=> 'Campaign URL', 'name'=>'campaignURL', 'id'=>'campaignURL');
					    			echo form_input($input_att+$campurl); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="campaignStart">Campaign Start Date</label>
					    <div class="controls">
					    	<div id="datepicker1" class="input-append">
						    	<?php	$campstart = array('name'=>'campaignStart', 'id'=>'campaignStart', 'data-format' => 'yyyy-MM-dd');
						    			echo form_input($date_att+$campstart); ?>
						    	<span class="add-on">
							      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
							      </i>
							    </span>
						    </div>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="campaignEnd">Campaign End Date</label>
					    <div class="controls">
					    	<div id="datepicker2" class="input-append">
						    	<?php	$campend = array('name'=>'campaignEnd', 'id'=>'campaignEnd', 'data-format' => 'yyyy-MM-dd');
						    			echo form_input($date_att+$campend); ?>
						    	<span class="add-on">
							      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
							      </i>
							    </span>
						    </div>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="campaignDetails">Campaign Details</label>
					    <div class="controls">
					    	<?php echo form_textarea($textarea_att); ?>
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
			Campaign has been added successfully.<br>
			<p class="start"></p><p class="end"></p>
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
				campaignName: $('#campaignName').val(),
				campaignClient: $('#campaignClient').val(),
				campaignDetails: $('#campaignDetails').val(),
				campaignHotspots: $('#campaignHotspots').val(),
				campaignPlan: $('#campaignPlan').val(),
				campaignAction: $('#campaignAction').val(),
				campaignURL: $('#campaignURL').val(),
				campaignStart: $('#campaignStart').val(),
				campaignEnd: $('#campaignEnd').val(),
				ajax: '1'		
			};
			
			var request = $.ajax({
				url: "<?php echo site_url('/campaigns/create'); ?>",
				type: 'POST',
				data: form_data
			});
			request.success(function(msg) {
				$('#addedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 3000);
				document.getElementById("form-createcampaign").reset();
			});
    		request.fail(function(msg) {
    			$('#notaddedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 3000);
				document.getElementById("form-createcampaign").reset();
    		});
			
			return false;
		};
		
		$(function() {
		    $('#datepicker1').datetimepicker({
		      pickTime: false
		    });
		    $('#datepicker2').datetimepicker({
		      pickTime: false
		    });
		  });
		
	</script>