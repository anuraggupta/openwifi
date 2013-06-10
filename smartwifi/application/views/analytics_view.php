<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner" style="vertical-align:bottom;">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><?php echo anchor("Clients/clients","Clients");?></li>
              <li><?php echo anchor("Hotspots/hotspots","Hotspots");?></li>
              <li><?php echo anchor("Plans/plans","Plans");?></li>
              <li><?php echo anchor("Campaigns/campaigns","Campaigns");?></li>
              <li><?php echo anchor("Vouchers/vouchers","Vouchers");?></li>
              <li class="active" ><a href="#">Analytics</a></li>
              <li><a href="logout">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container" id="content_main">

      <h1>Analytics</h1>
		<ul class="breadcrumb">
			<li><?php echo anchor("home/loginarea","Home");?> <span class="divider">/</span></li>
			<li class="active">Analytics</li>
		</ul>
		
		<div class="clearfix"><br></div>
		
		<div class="well">
			<?php
				$form_att = array('class' => 'form-horizontal', 'id' => 'form-analytics');
				$input_att = array('class' => 'input-xlarge');
				$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'submit_form', 'content' => '', 'value' => 'true', 'onclick'=>'form_sub();', 'name' => 'submit_form');
				
				echo form_open('', $form_att);
			?>
				<h3 class="form-signin-heading">Analytics</h3>
				<div class="span4">
					<div class="control-group">
					    <label class="control-label" for="analyticsClient">Select Client</label>
					    <div class="controls">
					    	<?php	$aclient =  'id="analyticsClient" onchange="clientSelected();"';
									$aclientlist = array();
									$aclientlist = $aclient_rec;
					    			echo form_dropdown('analyticsClient', $aclientlist, '', $aclient); ?>
						</div>
					</div>
					<div class="control-group" id="campSel">
					    
					</div>
					<?php
						echo form_close();
					?>
				</div>				
				<div class="clearfix"></div>
		</div>
		
		<div id="analytics_list"></div>
		

    </div> <!-- /container -->
    
<script type="text/javascript">
		
		function clientSelected() {
			
			var form_data = {
				selectedClient: $('#analyticsClient').val(),
				ajax: '1'
			};
			
			var request = $.ajax({
				url: "<?php echo site_url('analyticsGetClients'); ?>",
				type: 'POST',
				data: form_data,
				dataType: 'json',
			});
			request.complete(function(acamp_rec) {
				
				$insert_op = "";
				
				var i=0;
				
				$.each(acamp_rec.records, function(i,v){
					var uname = "'"+acamp_rec.records[i].cname+"'";
					
				});
				
				$('#campSel').html('<label class="control-label" for="analyticsCamp">Select Campaign</label><div class="controls"><select id="analyticsCamp" onchange="campSelected();">'+insert_op+'</select>');
					
				);
			});
    		request.fail(function(msg) {
    			$('#notaddedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 2000);
    		});
		};
		
		function campSelected() {
			
			var form_data = {
				selectedCamp: $('#analyticsCamp').val(),
				ajax: '1'
			};
			
			var request = $.ajax({
				url: "<?php echo site_url('analyticsClient'); ?>",
				type: 'POST',
				data: form_data,
			});
			request.complete(function(acamp_rec) {
				
				$insert_tab = "";
				
				for(var i = 0, i< acamp_rec.length, i++) {
					insert_tab +="<td>"+acamp_rec[i]+"</td>";
				}
				
				$('#campSel').html('<div class="well"><table class="table table-striped table-hover"><thead><tr><th>Vouchers Created</th><th>Impressions</th><th>Login Attempts</th><th>Successfull Logins</th><th>Failed Logins</th><th>Vouchers Used</th></tr></thead><tbody><tr>'+insert_tab+'</tr></tbody></table></div>');
					
				);
			});
    		request.fail(function(msg) {
    			$('#notaddedPop').modal('show');
				window.setTimeout(function() {$('#addedPop').modal('hide');}, 2000);
    		});
		};
		
		
	</script>