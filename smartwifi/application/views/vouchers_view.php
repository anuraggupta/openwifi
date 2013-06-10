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
			<li class="active">Vouchers</li>
		</ul>
		
		<div class="btn-group">
		  <button class="btn btn-info disabled">View Vouchers</button>
		  <button class="btn btn-info" onclick="location.href='<?php echo site_url();?>/vouchers/createVouchers'">Create Vouchers</button>
		</div>
		
		<div class="clearfix"><br></div>
		
		<div class="well">
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-getvouchers');
				$input_att = array('class' => 'input-xlarge');
				
				echo form_open('', $form_att);
			?>
				<h3 class="form-signin-heading">Vouchers</h3>
				<div class="span4">
					<div class="control-group">
					    <label class="control-label" for="voucherCamp">Select Campaign</label>
					    <div class="controls">
					    	<?php	$camps =  'id="voucherCamp" onchange="campSelected()"';
									$camplist = array(' ');
									$camplist += $camp_rec;
					    			echo form_dropdown('voucherCamp', $camplist, '', $camps); ?>
						</div>
					</div>
					<?php
						echo form_close();
					?>
				</div>
				<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		<div id="vouchers_list"></div>

    </div> <!-- /container -->
	
	<div id="deletePop" class="modal hide fade in" style="display: none; ">  
		<div class="modal-header">  
			<a class="close" data-dismiss="modal">×</a>  
			<h3>Just making sure!</h3>
		</div>  
		<div class="modal-body">
			Are you sure you want to delete <strang style="color: #A70000;" id="vouchername"></strang>.
		</div>  
		<div class="modal-footer">
			<a href="#" class="btn btn-info" id="deleterecord" data-dismiss="modal">Delete</a>
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
    
	<script type="text/javascript">
		
		function funcDelete(vname) {
			$("#vouchername").text(vname);
			vname = "'"+vname+"'";
			$("#deleterecord").attr('onclick','delVoucher('+vname+')');
			$('#deletePop').modal('show');
		};
		
		function delVoucher(voname) {
			location.href="<?php echo site_url();?>/vouchers/delete/"+voname+"";
		}
		
		
		function campSelected() {
			
			var form_data = {
				selectedCamp: $('#voucherCamp').val(),
				ajax: '1'
			};
			
			var request = $.ajax({
				url: "<?php echo site_url('vouchers/getCampVouchers'); ?>",
				type: 'POST',
				data: form_data,
				dataType: 'json',
			});
			request.success(function(vouchers_rec) {
				
				var insert_tab = "";
				var i=0;
				
				$.each(vouchers_rec.records, function(i,v){
					var uname = "'"+vouchers_rec.records[i].username+"'";
					insert_tab +="<tr>";
				    insert_tab +="<td>";
				    insert_tab +=i+1;
				    insert_tab +="</td>";
					insert_tab +="<td>"+vouchers_rec.records[i].username+"</td>";
					insert_tab +="<td>"+vouchers_rec.records[i].password+"</td>";
					insert_tab +="<td>"+vouchers_rec.records[i].time_used+"</td>";
					insert_tab +="<td>"+vouchers_rec.records[i].time_remain+"</td>";
					insert_tab +="<td>"+vouchers_rec.records[i].packet_used+"</td>";
					insert_tab +="<td>"+vouchers_rec.records[i].packet_remain+"</td>";
					insert_tab +='<td><i class="icon-remove" id="'+vouchers_rec.records[i].username+'" onclick="funcDelete('+uname+')"></i>&nbsp;&nbsp;&nbsp;&nbsp;';
					insert_tab +="</tr>";
				});
				
				$('#vouchers_list').html('<div class="well"><table class="table table-striped table-hover"><thead><tr><th>S. No.</th><th>Username</th><th>Password</th><th>Time Used</th><th>Time Remaining</th><th>Packet Used</th><th>Packet Remaining</th><th>Update Options</th></tr></thead><tbody>'+insert_tab+'</tbody></table></div>');
				
			});
    		request.fail(function(msg) {
    			alert("Fail: "+msg);
    			$('#notaddedPop').modal('show');
				window.setTimeout(function() {$('#notaddedPop').modal('hide');}, 3000);
    		});
		};

	</script>