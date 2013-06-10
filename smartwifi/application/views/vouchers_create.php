<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner" style="vertical-align:bottom;">
        <div class="container">          
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><?php echo anchor("home/loginarea","Home");?></li>
              <li><?php echo anchor("clients","Clients");?></li>
              <li><?php echo anchor("hotspots","Hotspots");?></li>
              <li><?php echo anchor("plans","Plans");?></li>
              <li><?php echo anchor("campaigns","Campaigns");?></li>
              <li class="active"><?php echo anchor("vouchers","Vouchers");?></li>
              <li><?php echo anchor("analytics","Analytics");?></li>
              <li><?php echo anchor("home/logout","Logout");?></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container" id="content_main">

		<h1>Voucher Management</h1>
		<ul class="breadcrumb">
			<li><?php echo anchor("home/loginarea","Home");?> <span class="divider">/</span></li>
			<li><?php echo anchor("vouchers","Vouchers");?> <span class="divider">/</span></li>
			<li class="active">Create Vouchers</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/vouchers'">View Vouchers</button>
		  <button class="btn btn-info disabled">Create Vouchers</button>
		</div>
		
		<div class="clearfix"><br></div>
		
		<div class="well">
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-createvouchers');
				$input_att = array('class' => 'input-small');
				$textarea_att = array('rows' => '7','id' => 'comments', 'placeholder' => 'Comments', 'name' => 'comments');
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit_form', 'content' => 'Add Vouchers', 'value' => 'true', 'onclick'=>'form_sub();', 'name' => 'submit_form');
				
				echo form_open('', $form_att);
			?>
				<h3 class="form-signin-heading">Create Vouchers</h3>
				<div class="span4">
					<div class="control-group">
					    <label class="control-label" for="voucherCamp">Select Campaign</label>
					    <div class="controls">
					    	<?php	$vouchercamp =  'id="voucherCamp"';
									$camplist = array();
									$camplist = $camp_rec;
					    			echo form_dropdown('voucherCamp', $camplist, '', $vouchercamp); ?>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="voucherQty">Voucher Quantity</label>
					    <div class="controls">
					    	<?php	$voucherqty = array('placeholder'=> 'Quantity', 'name'=>'voucherQty', 'id'=>'voucherQty');
					    			echo form_input($input_att+$voucherqty); ?>
						</div>
					</div>
					<div class="control-group">
	    				<div class="controls">
	    					<?php echo form_button($submit_att);?>
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
			Vouchers has been created successfully.
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
				voucherCamp: $('#voucherCamp').val(),
				voucherQty: $('#voucherQty').val(),
				ajx: '1'
			};
			
			var request = $.ajax({
				url: "<?php echo site_url('/vouchers/create'); ?>",
				type: 'POST',
				data: form_data,
				dataType: "json"
			});
			request.success(function(msg) {
				$('#addedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 3000);
				document.getElementById("form-createvouchers").reset();
			});
    		request.fail(function(msg) {
    			$('#notaddedPop').modal('show');
				window.setTimeout(function() {$('#notaddedPop').modal('hide');}, 3000);
				document.getElementById("form-createvouchers").reset();
    		});
			
			return false;
		};
	</script>