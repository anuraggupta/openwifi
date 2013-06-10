<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner" style="vertical-align:bottom;">
        <div class="container">          
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><?php echo anchor("home/loginarea","Home");?></li>
              <li class="active"><a href="#">Clients</a></li>
              <li><?php echo anchor("hotspots","Hotspots");?></li>
              <li><?php echo anchor("plans","Plans");?></li>
              <li><?php echo anchor("campaigns","Campaigns");?></li>
              <li><?php echo anchor("vouchers","Vouchers");?></li>
              <li><?php echo anchor("analytics","Analytics");?></li>
              <li><a href="logout">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container" id="content_main">

		<h1>Client Management</h1>
		<ul class="breadcrumb">
			<li><?php echo anchor("home/loginarea","Home");?> <span class="divider">/</span></li>
			<li><?php echo anchor("clients","Clients");?> <span class="divider">/</span></li>
			<li class="active">Create Clients</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/clients'">View Clients</button>
		  <button class="btn btn-info disabled">Create Clients</button>
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
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-createclient');
				$input_att = array('class' => 'input-xlarge');
				$textarea_att = array('rows' => '7','id' => 'comments', 'placeholder' => 'Comments', 'name' => 'comments');
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit_form', 'content' => 'Add Client', 'value' => 'true', 'onclick'=>'form_sub();', 'name' => 'submit_form');
				
				echo form_open("",$form_att);
			
			?>
				<h3 class="form-signin-heading">Create Client</h3>
				<div class="span4">
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
	    				<div class="controls">
	    					<?php echo form_button($submit_att);?>
	    				</div>
					</div>
				</div>
				<div class="span5 offset1">
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
				<div class="clearfix"></div>
		</div>

    </div> <!-- /container -->
    
    <div id="addedPop" class="modal hide fade in" style="display: none; ">  
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Great!</h3>
		</div>  
		<div class="modal-body">
			Client has been added successfully.
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
				clientName: $('#clientName').val(),
				clientContact: $('#clientContact').val(),
				clientEmail: $('#clientEmail').val(),
				clientURL: $('#clientURL').val(),
				comments: $('#comments').val(),
				ajx: '1'
			};
			
			var request = $.ajax({
				url: "<?php echo site_url();?>/clients/create",
				type: 'POST',
				dataType: 'json',
				data: form_data,
			});
			request.success(function(msg) {
				$('#addedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 3000);
				document.getElementById("form-createclient").reset();
			});
    		request.fail(function(msg) {
    			$('#notaddedPop').modal('show');
    			window.setTimeout(function() {$('#notaddedPop').modal('hide');}, 3000);
    			document.getElementById("form-createclient").reset();
    		});
			
			return false;
		};
	</script>