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
			<li class="active">Campaigns</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info disabled">View Campaigns</button>
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/campaigns/createCampaign'">Create Campaign</button>
		</div>
		
		<div class="clearfix"><br></div>
		
		<div class="well">
			<table class="table table-striped table-hover">
			  <thead>
			    <tr>
			      <th>S. No.</th>
			      <th>Campaign Name</th>
			      <th>Client</th>
			      <th>Campaign Details</th>
			      <th>Assigned Hotspots</th>
			      <th>Assigned Plan</th>
			      <th>Campaign Action</th>
			      <th>Campaign URL</th>
			      <th>Start Date</th>
			      <th>End Date</th>
			    </tr>
			  </thead>
			  <tbody>
			    <?php
			    $i=1;
			    if(isset($records)) : foreach($records as $row) : ?>
			    	<tr>
			    		<td><?php echo $i; ?></td>
			    		<td><?php echo $row->name; ?></td>
			    		<td><?php echo $row->client; ?></td>
			    		<td><?php echo $row->details; ?></td>
			    		<td><?php echo $row->hotspots; ?></td>
			    		<td><?php echo $row->plan; ?></td>
			    		<td><?php echo $row->action; ?></td>
			    		<td><?php echo $row->assurl; ?></td>
			    		<td><?php echo $row->startdate; ?></td>
			    		<td><?php echo $row->enddate; ?></td>
			    		<td>
			    			<i class="icon-remove" id="<?php echo $row->id ?>" onclick="funcDelete('<?php echo $row->id ?>', '<?php echo $row->name ?>')"></i> &nbsp;&nbsp;&nbsp;&nbsp;
			    			<i class="icon-edit" id="<?php echo $row->id ?>" onclick="editPop('<?php echo $row->id; ?>', '<?php echo $row->name; ?>', '<?php echo $row->client; ?>', '<?php echo $row->details; ?>', '<?php echo $row->hotspots; ?>', '<?php echo $row->plan; ?>', '<?php echo $row->action; ?>', '<?php echo $row->assurl; ?>', '<?php echo $row->startdate; ?>', '<?php echo $row->enddate; ?>');"></i>
			    		</td>
			    	</tr>
				<?php $i++; endforeach; ?>
			
				<?php else : ?>	
				<tr><td colspan="6">No records were found.</td></tr>
				<?php endif; ?>
			  </tbody>
			</table>
		</div>

    </div> <!-- /container -->
    
    <div id="editPop" class="modal hide fade in" style="display: none; ">  
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Update Campaign</h3>
		</div>  
		<div class="modal-body">  
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-createcampaign');
				$input_att = array('class' => 'input-xlarge');
				$date_att = array('class' => 'input-large');
				$textarea_att = array('rows' => '3','id' => 'campaignDetails', 'placeholder' => 'Campaign Details', 'name' => 'campaignDetails');
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit', 'value' => 'Add Campaign', 'onclick'=>'form_sub();','name' => 'submit',);
				
				echo form_open('', $form_att);
			?>
				<h3 class="form-signin-heading">Update Campaign</h3>
				<div>
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
						    			echo form_dropdown('campAction', $camptypes, 'facebookLike', $campction); ?>
							</div>
						</div>
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
		</div>  
		<div class="modal-footer">  
			<a id="update-btn" class="btn btn-info">Update Campaign</a>  
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>  
	</div>
	
	<div id="deletePop" class="modal hide fade in" style="display: none; ">  
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Just making sure!</h3>
		</div>  
		<div class="modal-body">
			Are you sure you want to delete <strang style="color: #A70000;" id="campaignname"></strang>.
		</div>  
		<div class="modal-footer">
			<a href="#" class="btn btn-info" id="deleterecord" data-dismiss="modal">Delete</a>
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
    
	<script type="text/javascript">
		function editPop(theid, name, client, details, hotspots, plan, action, assurl, startdate, enddate) {
			 
			 var hspots = new Array('');
			 hspots = hotspots.split(', ');
			 
			 var select = document.getElementById( 'campaignHotspots' );
			select.selectedIndex = -1;
			
			for ( var i = 0, l = select.options.length, op; i < l; i++ )
			{
			  op = select.options[i];
			  if ( hspots.indexOf( op.text ) != -1 )
			  {
			    op.selected = true;
			  }
			 }
			 
			
		     $("#update-btn").attr('onclick', 'form_sub_update('+theid+')');
		     $("#campaignName").val(name);
		     $("#campaignClient").val(client);
		     $("#campaignDetails").val(details);
		     $("#campaignPlan").val(plan);
		     $("#campaignAction").val(action);
		     $("#campaignURL").val(assurl);
		     $("#campaignStart").val(startdate);
		     $("#campaignEnd").val(enddate);
		     $('#editPop').modal('show');
		};
		
		function funcDelete(theid, name) {
			$("#campaignname").text(name);
			$("#deleterecord").attr('onclick','location.href="<?php echo site_url();?>/campaigns/delete/'+theid+'>"');
			$('#deletePop').modal('show');
		}
		
		
		function form_sub_update(theid) {

			var form_data = {
				campaignId: theid,
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
				url: "<?php echo site_url('/campaigns/update'); ?>",
				type: 'POST',
				data: form_data
			});
			request.success(function(msg) {
				$('#editPop').modal('hide');
				window.setTimeout('location.reload()', 1000); 
			});
    		request.fail(function(msg) {
    			window.setTimeout('location.reload()', 1000); 
    			$('#editPop').modal('hide');
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