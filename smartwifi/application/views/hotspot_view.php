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
			<li class="active">Hotspots</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info disabled">View Hotspots</button>
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/hotspots/createHotspot'">Create Hotspot</button>
		</div>
		
		<div class="clearfix"><br></div>
		
		<div class="well">
			<table class="table table-striped table-hover">
			  <thead>
			    <tr>
			      <th>S. No.</th>
			      <th>Hotspot Name</th>
			      <th>Assigned Campaign</th>
			      <th>Assigned Client</th>
			      <th>Router</th>
			      <th>Outlet Name</th>
			      <th>Outlet Address</th>
			      <th>Hotspot Location</th>
			      <th>Default URL</th>
			      <th>Mac Address</th>
			      <th>3G Operator</th>
			      <th>3G Number</th>
			      <th>Unique id</th>
			      <th>Update Options</th>
			    </tr>
			  </thead>
			  <tbody>
			    <?php
			    $i=1;
			    if(isset($records)) : foreach($records as $row) : ?>
			    	<tr>
			    		<td><?php echo $i; ?></td>
			    		<td><?php echo $row->hname; ?></td>
			    		<td><?php echo $row->hcampaign; ?></td>
			    		<td><?php echo $row->assigned; ?></td>
			    		<td><?php echo $row->router; ?></td>
			    		<td><?php echo $row->outlet; ?></td>
			    		<td><?php echo $row->add; ?></td>
			    		<td><?php echo $row->location; ?></td>
			    		<td><?php echo $row->hdefurl; ?></td>
			    		<td><?php echo $row->macadd; ?></td>
			    		<td><?php echo $row->operator; ?></td>
			    		<td><?php echo $row->inumber; ?></td>
			    		<td><?php echo $row->uniqueid; ?></td>
			    		<td>
			    			<i class="icon-remove" id="<?php echo $row->id ?>" onclick="funcDelete('<?php echo $row->id ?>', '<?php echo $row->hname ?>')"></i> &nbsp;&nbsp;&nbsp;&nbsp;
			    			<i class="icon-edit editPop" id="<?php echo $row->id ?>" onclick="editPop('<?php echo $row->id; ?>', '<?php echo $row->hname; ?>', '<?php echo $row->router; ?>', '<?php echo $row->outlet; ?>', '<?php echo $row->add; ?>', '<?php echo $row->location; ?>', '<?php echo $row->hdefurl; ?>', '<?php echo $row->macadd; ?>', '<?php echo $row->operator; ?>', '<?php echo $row->inumber; ?>' );"></i>
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
    
    <div id="editPop" class="modal hide fade in" style="display: none;">
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Update Hotspot</h3>
		</div>  
		<div class="modal-body">  
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-updatehotspot');
				$input_att = array('class' => 'input-xlarge');
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit', 'value' => 'Add Hotspot', 'onclick'=>'form_sub();','name' => 'submit',);
				
				echo form_open('', $form_att);
			?>
				<div>
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
		</div>  
		<div class="modal-footer">  
			<a id="update-btn" class="btn btn-info">Update Client</a>  
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>  
	</div>
    
    <div id="deletePop" class="modal hide fade in" style="display: none; ">  
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Just making sure!</h3>
		</div>  
		<div class="modal-body">
			Are you sure you want to delete <strang style="color: #A70000;" id="hotspotname"></strang>.
		</div>  
		<div class="modal-footer">
			<a href="#" class="btn btn-info" id="deleterecord" data-dismiss="modal">Delete</a>
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
    
	<script type="text/javascript">
		
		function funcDelete(theid, hname) {
			$("#hotspotname").text(hname);
			$("#deleterecord").attr('onclick','location.href="<?php echo site_url();?>/hotspots/delete/'+theid+'>"');
			$('#deletePop').modal('show');
		}
	
		function editPop(theid, hname, router, outlet, add, location, defurl, mac, operator, inumber ) {
		     $("#update-btn").attr('onclick', 'form_sub_update('+theid+')');
		     $("#hotspotName").val(hname);
		     $('#hotspotRouter').val(router);
		     $("#hotspotOutlet").val(outlet);
		     $("#hotspotAdd").val(add);
		     $("#hotspotLoc").val(location);
		     $("#hotspotURL").val(defurl);
		     $("#hotspotMac").val(mac);
		     $("#hotspotOperator").val(operator);
		     $("#hotspotInumber").val(inumber);
		     
		     $('#editPop').modal('show');
		};
		
		function form_sub_update(theid) {

			var form_data = {
				hotspotId: theid,
				hotspotName: $('#hotspotName').val(),
				hotspotRouter: $('#hotspotRouter').val(),
				hotspotOutlet: $('#hotspotOutlet').val(),
				hotspotAdd: $('#hotspotAdd').val(),
				hotspotLoc: $("#hotspotLoc").val(),
		     	hotspotURL: $("#hotspotURL").val(),
		     	hotspotMac: $("#hotspotMac").val(),
		     	hotspotOperator: $("#hotspotOperator").val(),
		     	hotspotInumber: $("#hotspotInumber").val(),
				ajax: '1'
			};
			
			var request = $.ajax({
				url: "<?php echo site_url('/hotspots/update'); ?>",
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