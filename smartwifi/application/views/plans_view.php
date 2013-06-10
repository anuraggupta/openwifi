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
			<li class="active">Plans</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info disabled">View Plans</button>
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/plans/createPlan'">Create Plans</button>
		</div>
		
		<div class="clearfix"><br></div>
		
		<div class="well">
			<table class="table table-striped table-hover">
			  <thead>
			    <tr>
			      <th>S. No.</th>
			      <th>Plan Name</th>
			      <th>Plan Type</th>
			      <th>Type Amount</th>
			      <th>Plan Pricing</th>
			      <th>Download Bandwidth</th>
			      <th>Upload  Bandwidth</th>
			      <th>Idle Timeout</th>
			      <th>Update Options</th>
			    </tr>
			  </thead>
			  <tbody>
			    <?php
			    $i=1;
			    if(isset($records)) : foreach($records as $row) : ?>
			    	<tr>
			    		<td><?php echo $i; ?></td>
			    		<td><?php echo $row->name; ?></td>
			    		<td><?php echo $row->type; ?></td>
			    		<td><?php echo $row->amount; ?></td>
			    		<td><?php echo $row->price; ?></td>
			    		<td><?php echo $row->bw_download; ?></td>
			    		<td><?php echo $row->bw_upload; ?></td>
			    		<td><?php echo $row->IdleTimeout; ?></td>
			    		<td>
			    			<i class="icon-remove" id="<?php echo $row->id ?>" onclick="funcDelete('<?php echo $row->id ?>', '<?php echo $row->name ?>')"></i> &nbsp;&nbsp;&nbsp;&nbsp;
			    			<i class="icon-edit" id="<?php echo $row->id ?>" onclick="editPop('<?php echo $row->id; ?>', '<?php echo $row->name; ?>', '<?php echo $row->type; ?>', '<?php echo $row->amount; ?>', '<?php echo $row->price; ?>', '<?php echo $row->bw_download; ?>', '<?php echo $row->bw_upload; ?>', '<?php echo $row->IdleTimeout; ?>');"></i>
			    		</td>
			    	</tr>
				<?php $i++; endforeach; ?>
			
				<?php else : ?>	
				<tr><td colspan="6">No records were returned.</td></tr>
				<?php endif; ?>
			  </tbody>
			</table>
		</div>

    </div> <!-- /container -->
    
    <div id="editPop" class="modal hide fade in" style="display: none; ">  
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Update Plan</h3>
		</div>  
		<div class="modal-body">  
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-createclient');
				$input_att = array('class' => 'input-xlarge');
				$textarea_att = array('rows' => '7','id' => 'comments', 'placeholder' => 'Comments', 'name' => 'comments');
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit', 'value' => 'Add Client', 'onclick'=>'form_sub();','name' => 'submit',);
				
				echo form_open('', $form_att);
			?>
			<div>
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
		</div>  
		<div class="modal-footer">  
			<a id="update-btn" class="btn btn-info">Update Plan</a>  
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>  
	</div>
	
	<div id="deletePop" class="modal hide fade in" style="display: none; ">  
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Just making sure!</h3>
		</div>  
		<div class="modal-body">
			Are you sure you want to delete <strang style="color: #A70000;" id="planname"></strang>.
		</div>  
		<div class="modal-footer">
			<a href="#" class="btn btn-info" id="deleterecord" data-dismiss="modal">Delete</a>
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
    
	<script type="text/javascript">
		function editPop(theid, name, type, amount, price, bw_download, bw_upload, IdleTimeout) {
		     $("#update-btn").attr('onclick', 'form_sub_update('+theid+')');
		     $("#planName").val(name);
		     $("#planType").val(type);
		     $("#planAmount").val(amount);
		     $("#planPrice").val(price);
		     $("#planDown").val(bw_download);
		     $("#planUp").val(bw_upload);
		     $("#planTimeout").val(IdleTimeout);
		     $('#editPop').modal('show');
		};
		
		function funcDelete(theid, name) {
			$("#planname").text(name);
			$("#deleterecord").attr('onclick','location.href="<?php echo site_url();?>/plans/delete/'+theid+'>"');
			$('#deletePop').modal('show');
		}
		
		
		function form_sub_update(theid) {

			var form_data = {
				planId: theid,
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
				url: "<?php echo site_url('/plans/update'); ?>",
				type: 'POST',
				data: form_data
			});
			request.done(function(msg) {
				$('#editPop').modal('hide');
				window.setTimeout('location.reload()', 1000); 
			});
    		request.fail(function(msg) {
    			window.setTimeout('location.reload()', 1000); 
    			$('#editPop').modal('hide');
    		});
			
			return false;
		};
	</script>