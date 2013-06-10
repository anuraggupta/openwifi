	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner" style="vertical-align:bottom;">
        <div class="container">          
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><?php echo anchor("home/loginarea","Home");?></li>
              <li class="active" ><a href="#">Clients</a></li>
              <li><?php echo anchor("hotspots","Hotspots");?></li>
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

		<h1>Client Management</h1>
		<ul class="breadcrumb">
			<li><?php echo anchor("home/loginarea","Home");?> <span class="divider">/</span></li>
			<li class="active">Clients</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info disabled">View Clients</button>
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/clients/createClient'">Create Clients</button>
		</div>
		
		<div class="clearfix"><br></div>
		
		<div class="alert alert-success fade" style="display: none;">
			great
			<a href="#" class="close" data-dismiss="alert">&times;</a>
		</div>
		<div class="alert alert-error fade" style="display: none;">
			adcfasdcasca
			<a href="#" class="close" data-dismiss="alert">&times;</a>
		</div>
		
		<div class="well">
			<table class="table table-striped table-hover">
			  <thead>
			    <tr>
			      <th>S. No.</th>
			      <th>Client Name</th>
			      <th>Contact Number</th>
			      <th>Email</th>
			      <th>Default Hotspot URL</th>
			      <th>Comments</th>
			      <th>Update Options</th>
			    </tr>
			  </thead>
			  <tbody>
			    <?php
			    $i=1;
			    if(isset($records)) : foreach($records as $row) : ?>
			    	<tr>
			    		<td><?php echo $i; ?></td>
			    		<td><?php echo $row->cname; ?></td>
			    		<td><?php echo $row->contact; ?></td>
			    		<td><?php echo $row->email; ?></td>
			    		<td><?php echo $row->defurl; ?></td>
			    		<td><?php echo $row->comments; ?></td>
			    		<td>
			    			<i class="icon-remove" id="<?php echo $row->id ?>" onclick="funcDelete('<?php echo $row->id ?>', '<?php echo $row->cname ?>')"></i> &nbsp;&nbsp;&nbsp;&nbsp;
			    			<i class="icon-edit" id="<?php echo $row->id ?>" onclick="editPop('<?php echo $row->id; ?>', '<?php echo $row->cname; ?>', '<?php echo $row->contact; ?>', '<?php echo $row->email; ?>', '<?php echo $row->defurl; ?>', '<?php echo $row->comments; ?>');"></i>
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
			<h3>Update Client</h3>
		</div>  
		<div class="modal-body">  
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-updateclient');
				$input_att = array('class' => 'input-xlarge');
				$textarea_att = array('rows' => '7','id' => 'comments', 'placeholder' => 'Comments', 'name' => 'comments');
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit_form', 'content' => 'Add Client', 'value' => 'true', 'onclick'=>'form_sub();', 'name' => 'submit_form');
				
				echo form_open('', $form_att);
			?>
				<div>
					<div class="control-group">
					    <label class="control-label" for="clientName">Client Name</label>
					    <div class="controls">
					    	<?php	$cname = array('placeholder'=> 'Client Name', 'name'=>'clientName', 'id'=>'clientName');
					    			echo form_input($input_att + $cname ); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="clientContact">Contact Number</label>
					    <div class="controls">
					    	<?php	$contactno = array('placeholder'=> 'Contact Number', 'name'=>'clientContact', 'id'=>'clientContact');
					    			echo form_input($input_att+$contactno); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="clientEmail">Email Address</label>
					    <div class="controls">
					    	<?php	$cemail = array('placeholder'=> 'Email Address', 'name'=>'clientEmail', 'id'=>'clientEmail');
					    			echo form_input($input_att+$cemail); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="clientURL">Default Hotspot URL</label>
					    <div class="controls">
					    	<?php	$cdefurl = array('placeholder'=> 'Default Hotspot URL', 'name'=>'clientURL', 'id'=>'clientURL');
					    			echo form_input($input_att+$cdefurl); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="comments">Comments</label>
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
			Are you sure you want to delete <strang style="color: #A70000;" id="clientname"></strang>.
		</div>  
		<div class="modal-footer">
			<a href="#" class="btn btn-info" id="deleterecord" data-dismiss="modal">Delete</a>
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
    
	<script type="text/javascript">
		function editPop(theid, cname, ccontact, cemail, cdefurl, com) {
		     $("#update-btn").attr('onclick', 'form_sub_update('+theid+')');
		     $("#clientName").val(cname);
		     $("#clientContact").val(ccontact);
		     $("#clientEmail").val(cemail);
		     $("#clientURL").val(cdefurl);
		     $("#comments").val(com);
		     $('#editPop').modal('show');
		};
		
		function funcDelete(theid, cname) {
			$("#clientname").text(cname);
			$("#deleterecord").attr('onclick','location.href="<?php echo site_url();?>/clients/delete/'+theid+'>"');
			$('#deletePop').modal('show');
		}
		
		
		function form_sub_update(theid) {

			var form_data = {
				clientId: theid,
				clientName: $('#clientName').val(),
				clientContact: $('#clientContact').val(),
				clientEmail: $('#clientEmail').val(),
				clientURL: $('#clientURL').val(),
				comments: $('#comments').val(),
				ajax: '1'		
			};
			
			var request = $.ajax({
				url: "<?php echo site_url('clients/update'); ?>",
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
	</script>