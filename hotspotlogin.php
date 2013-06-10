<?php


$uamsecret = "uamsecret";

# 0: Login attempt (if all mandatory authentication parameters are set)
$login_mandatory_params = array('chal', 'uamip', 'uamport', 'username', 'password');
$login_params = array_intersect(array_keys($_GET), $login_mandatory_params);
if (!array_diff($login_mandatory_params, $login_params)) attempt_login();
# 1: Not logged in yet
if ($_GET['res'] == 'notyet') display_notyet();
# 2: Login failed
if ($_GET['res'] == 'failed') display_failed();
# 1: Login successful
if ($_GET['res'] == 'success') display_success();
# 3: Logged out (TODO: Display a timeout message, and options)
if ($_GET['res'] == 'logoff') display_logoff();
if ($_GET['res'] == 'timeout') display_logoff(); // timeout 'res' is not native
# 4: Tried to login while already logged in
if ($_GET['res'] == 'already') display_already();
#12: Success popup (this 'res' is not native)
if ($_GET['res'] == 'success_popup') display_success_popup();

function attempt_login() {
    global $uamsecret, $userpassword;
    
    echo "<h4>Logging in...</h4>";

    $hexchal = pack ("H32", $_GET['chal']);
    $newchal = $uamsecret ? pack("H*", md5($hexchal . $uamsecret)) : $hexchal;

    $response = md5("\0" . $_GET['password'] . $newchal);
    
    $newpwd = pack("a32", $_GET['password']);
    $pappassword = implode ('', unpack("H32", ($newpwd ^ $newchal)));
    
    if ((isset ($uamsecret)) && isset($userpassword)) {
        print implode('', array(
            '<meta http-equiv="refresh" content="0;url=',
            'http://', $_GET['uamip'], ':', $_GET['uamport'], '/',
            'logon?username=', $_GET['username'], '&password=', $pappassword, '">'
        ));
    } else {
        print implode('', array(
            '<meta http-equiv="refresh" content="0;url=',
            'http://', $_GET['uamip'], ':', $_GET['uamport'], '/',
            'logon?username=', $_GET['username'], '&response=', $response,
            '&userurl=', $_GET['userurl'], '">'
        ));
    }
};

function display_notyet() {
	global $header_content, $display_form, $msg, $body_cont, $display_login_form , $username, $password;
	
	$body_cont =' ';
	
	$msg = implode('', array(
        '<style>th {test-align:right}</style>',
        '<form name="form1" method="get" action="">',
            '<input type="hidden" name="chal" value="', $_GET['challenge'], '">',
            '<input type="hidden" name="uamip" value="', $_GET['uamip'], '">',
            '<input type="hidden" name="uamport" value="', $_GET['uamport'], '">',
            '<input type="hidden" name="userurl" value="', $_GET['userurl'], '">',
			'<input type="hidden" class="username" id="username" name="username" >',
			'<input type="hidden" class="password" id="password" name="password" value="Citibank-Ambi-5" >',
            '<input type="submit" value="Login" id="login_to_hspot" style="display:none;">',
        '</form>'
    ));
	
	$header_content = ' ';
	
	$display_login_form = '<form class="form-signin">
				<h4>Get free WiFi  access for 15 mins.</h4>
				<input type="text" id="inputPassword" class="inputPassword" placeholder="Password">
				<label class="checkbox">
					<input type="checkbox" id="inputTerms" checked><a href="#terms" data-toggle="modal">I Agree to Terms of Use</a>
				</label>
				<label class="checkbox">
					<input type="checkbox" checked> I wish to get contacted with latest Citibank Offers and Services.
				</label>
				<button type="button" class="btn" onClick="sub_form()">Get Free Wifi</button>
			</form>';
	
	$display_form = '<a href="#loginHspot" class="btn btn-small btn-primary" role="button" data-toggle="modal">Connect to WiFi</a>';
}

function display_failed() {
// TODO: remove this unused $result (for cleaning step before refactoring)
//    global $result;
//    $result = 2;
    // TODO: Simply echo message + login form again
    $display_form = '<h1>Login failed :(</h1>';
    print implode('', array(
        '<a href="http://', $_GET['uamip'], ':', $_GET['uamport'], '/prelogin', "?userurl={$_GET['userurl']}", '">',
            'Please try again',
        '</a>'
    ));
}

function display_success() {
    global $result;   
    $result = 1;
    //
    global $title, $headline, $bodytext;
    $loginpath = $_SERVER['PHP_SELF'];
    $title = 'Login successfull';
    $headline = 'Login successfull';
    $bodytext =  'You should use this page to log out when you are finished.';
    $bodytext .= '<h2><a href="http://' . $_GET['uamip'] . ':' . $_GET['uamport'] . '/logoff">Logout</a></h2>';
    print_header();
    print_body();
}

function display_success_popup() {
    global $result;
    $result = 12;   
    // TODO: Merge this with 'display_success' logic
    global $title, $headline, $bodytext;
    $title = 'Login successfull';
    $headline = 'Login successfull';
    $bodytext =  'You should use this page to log out when you are finished. Closing this page would log you out.';
    $bodytext .= '<h2><a href="http://' . $_GET['uamip'] . ':' . $_GET['uamport'] . '/logoff">Logout</a></h2>';
    print_header();
    print_body();
}

function display_logoff() {
// TODO: remove this unused $result (for cleaning step before refactoring)
//    global $result;
//    $result = 3; 
    $display_form = '<h1>Logged out</h1>';
    print implode('', array(
        '<a href="http://', $_GET['uamip'], ':', $_GET['uamport'], '/prelogin', '">',
        '    Login',
        '</a>'
    ));
}

function display_already() {
// TODO: remove this unused $result (for cleaning step before refactoring)
//    global $result;
//    $result = 4;
    $display_form = '<h1>Already logged in</h1>';
    print implode('', array(
        '<a href="http://', $_GET['uamip'], ':', $_GET['uamport'], '/logoff', '">',
        '    Login',
        '</a>'
    ));
}


# HTML rendering functions (kind of)
function print_header() {
    // TODO:
    // Removed features to re-enable:
    // - Username field autofocus.
    // - Popup window focus management (dunno what it did).
    // NOT removed feature, to ENSURE KEEPING:
    // - If popup opening fails somehow, the main page is not redirected to $userurl.
    global $title;
    global $header_content;
	
    $loginpath = $_SERVER['PHP_SELF'];
    $uamip = $_GET['uamip'];
    $uamport = $_GET['uamport'];
    
    $header_content = "
            <SCRIPT LANGUAGE=\"JavaScript\">
            var starttime = new Date();
            var startclock = starttime.getTime();
            var mytimeleft = 0;
            
            function doTime() {
                // TODO: Use Date object operation to compute time differences
                window.setTimeout( \"doTime()\", 1000 );
                t = new Date();
                time = Math.round((t.getTime() - starttime.getTime())/1000);
                if (mytimeleft) {
                    time = mytimeleft - time;
                    // time expired
                    if (time <= 0) {
                         window.location = \"$loginpath?res=timeout&uamip=$uamip&uamport=$uamport\";
                    }
                }
                if (time < 0) time = 0;
                hours = (time - (time % 3600)) / 3600;
                time = time - (hours * 3600);
                mins = (time - (time % 60)) / 60;
                secs = time - (mins * 60);
                if (hours < 10) hours = \"0\" + hours;
                if (mins < 10) mins = \"0\" + mins;
                if (secs < 10) secs = \"0\" + secs;
                title = \"Online time: \" + hours + \":\" + mins + \":\" + secs;
                if (mytimeleft) {
                    title = \"Remaining time: \" + hours + \":\" + mins + \":\" + secs;
                }
                if (document.all || document.getElementById) {
                    document.title = title;
                } else {
                    self.status = title;
                }
            }
        
            function popUp(URL) {
                if (self.name != \"chillispot_popup\") {
                    chillispot_popup = window.open(URL, 'chillispot_popup', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=600');
                }
            }
            
            function doOnLoad(result, URL, userurl, timeleft) {
                if (timeleft) {
                    mytimeleft = timeleft;
                }
                if (result == 1) {
                    if (self.name == \"chillispot_popup\") doTime();
                    else chillispot_popup = window.open(URL, 'chillispot_popup', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=600');
                }
                if ((result == 12) && (self.name == \"chillispot_popup\")) {
                    doTime();
                    if (userurl) opener.location = userurl;
                    else if (opener.home) opener.home();
                    else opener.location = \"http://www.google.com\";
                }
            }
            </script>
    ";
}

function print_body() {
    global $headline, $bodytext, $result;
	global $body_cont, $display_form;

    $loginpath = $_SERVER['PHP_SELF'];    
    $uamip = $_GET['uamip'];
    $uamport = $_GET['uamport'];
    $userurl = $_GET['userurl'];
    $timeleft = $_GET['timeleft'];
    
   $body_cont= "
        onLoad=\"javascript:doOnLoad($result, '$loginpath?res=success_popup&uamip=$uamip&uamport=$uamport&userurl=$userurl&timeleft=$timeleft','$userurl', '$timeleft')\"";
		
       $display_form = "<h1 style=\"text-align: center;\">$headline</h1>
        <center>$bodytext</center><br>
    ";
}

mysql_close();

?>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Citibank Offers</title>
        <script src="assets/js/jquery.js"></script>
		<script src="assets/js/bootstrap.js"></script>
        <link href="assets/css/bootstrap.css" rel="stylesheet">
   		<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    	<link href="assets/css/style.css" rel="stylesheet"> 
        
        <!-- CarouFredSell -->
		<script type="text/javascript" src="assets/js/jquery.carouFredSel-6.1.0-packed.js"></script>
		<script type="text/javascript" src="assets/js/helper-plugins/jquery.mousewheel.min.js"></script>
		<script type="text/javascript" src="assets/js/helper-plugins/jquery.touchSwipe.min.js"></script>
        
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          	<script src="assets/js/html5shiv.js"></script>
        <![endif]-->
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <?php echo $header_content; ?>
        
    </head>
    <body <?php echo $body_cont; ?> >
    	<div class="container">
        	<div class="logo">
            	<h4>Great Offers by</h4><img src="assets/img/citi/citilogo.png" width="">
            </div>
        <div class="list_carousel7 responsive" >
								<ul id="foo7">
									<li><div class="thumb"><img src="assets/img/citi/offerlogos/nirulas.jpg" alt="organic">
											<h5><span class="dark"><b>Nirulas Potpourri</b></span><br/><span class="light">Save 15%  on food & Non alcohlic beverages </span></h5></div></li>
											
									<li><div class="thumb"><img src="assets/img/citi/offerlogos/sbarro.jpg" alt="orange">
											<h5><span class="dark"><b>Sbarro</b></span><br/><span class="light">Save 15% on total bill amount.</span></h5></div></li>
											
									<li><div class="thumb"><img src="assets/img/citi/offerlogos/phd.jpg" alt="sociality">
											<h5><span class="dark"><b>PHD</b></span><br/><span class="light">Save 20 % on a minimum bill amount of Rs. 500/-</span></h5></div></li>
											
									<li><div class="thumb"><img src="assets/img/citi/offerlogos/cafedelhiheights.jpg" alt="organic">
											<h5><span class="dark"><b>Cafe Delhi Heights</b></span><br/><span class="light">Save 15%  on food.</span></h5></div></li>
											
									<li><div class="thumb"><img src="assets/img/citi/offerlogos/samsung.jpg" alt="pixel">
											<h5><span class="dark"><b>Samsung</b></span><br/><span class="light">Get a Reebok Watch worth Rs 2599 on minimum purchase of Rs 10,000/-<p>*Offer is not applicable on mobile phones</p></span></h5></div></li>
											
									<li><div class="thumb"><img src="assets/img/citi/offerlogos/sawasdee.jpg" alt="golf">
											<h5><span class="dark"><br/><b>Sawasdee</b></span><br/><span class="light">Save 15% on spa and slimming services.</span></h5></div></li>


								</ul>
								<div class="clearfix"></div>
							</div>
            <div class="apply">
            	<a href="#apply" class="btn btn-small btn-primary" role="button" data-toggle="modal">Apply for Citibank Card</a>
            </div>
        	<div class="apply">
            	<?php echo $display_form; ?>
        	</div>
        
        </div>
        <?php echo $msg; ?>
    </body>
</html>

<div id="apply" class="modal hide fade in" style="display: none; ">  
    <div class="modal-header">  
        <a class="close" data-dismiss="modal">×</a>  
        <h3>Apply for Citibank Debit/Credit Card</h3>
    </div> 
    <div class="modal-body">
        <form class="form-signin">
            <input type="text" id="inputAName" placeholder="Your Name">
            <input type="text" id="inputAPhone" placeholder="Your Phone">
            <label class="checkbox">
                <input type="checkbox" id="inputContacted" checked>I wish to get contacted with latest Citibank Offers and Services.
            </label>
            </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick="apply_form()" data-dismiss="modal">Send</button>
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>

<div id="loginHspot" class="modal hide fade in" style="display: none; ">  
    <div class="modal-header">  
        <a class="close" data-dismiss="modal">×</a>  
        <h3>Fill details to Connect to WiFi</h3>
    </div> 
    <div class="modal-body">
    	<h4 style="color: #09F;">SMS "SMARTWIFI" to 56263 to get password.</h4>
        <?php echo $display_login_form; ?>
    </div>
</div>

<div id="sent" class="modal hide fade in" style="display: none; ">  
    <div class="modal-header">  
        <a class="close" data-dismiss="modal">×</a>  
        <h3>Great</h3>
    </div> 
    <div class="modal-body">
    	<h4 style="color: #09F;">Information sent.</h4>
    </div>
</div>


<script type="text/javascript">
function sub_form() {
		if($('.inputPassword').val()!='') {
			if($('#inputTerms').is(':checked')) {
				var myuser = document.getElementById('username');
				var mypass = document.getElementById('password');
				myuser.value = $('.inputPassword').val();
				$('#login_to_hspot').trigger('click');
			}
			else {
				alert("Please agree to Terms of Use");
			}
		}
		else {
			alert("Please fill the details.");
		}
		
};

function apply_form() {
	var applyName = document.getElementById('inputAName');
	var applyPhone = document.getElementById('inputAPhone');
	
	var testName=/^[a-zA-Z,\s]+$/.test(applyName.value);
	var testPhone = /^\d{8,12}$/.test(applyPhone.value);
	
	
	if(applyName.value!='' && applyPhone!='' && testName==true && testPhone==true) {
			if($('#inputContacted').is(':checked')) {
				var form_data = {
					uName: applyName.value,
					uPhone: applyPhone.value,
					ajx: '1'
				};
				
				var request = $.ajax({
					url: "http://smartwifi.in/citibank_login/saveapplydata.php",
					type: 'POST',
					data: form_data,
				});
				request.success(function(msg) {
					$('#sent').modal('show');
					window.setTimeout(function(){$('#sent').modal('hide');},2000);
				});
				request.fail(function(msg) {
					alert("Problem encountered. Please refresh the page and try again.");
				});
			}
			else {
				alert("Please tick 'I wish to get contacted.'");
			}
		}
		else {
			alert("Please fill the details.");
		}
}


$(document).ready(function() {

		$('#foo7').carouFredSel({
		auto: true,
		responsive: true,
		prev: {
			button: "#prev7",
			key: "left"
		},
		next: {
			button: "#next7",
			key: "right"
		},
		pagination: "#pager7",
		swipe: true,
		mousewheel: true,
		width: '100%',
		scroll: 1,
		items: {
		width: 280,
		//	height: '30%',	//	optionally resize item-height
		visible: {
				min: 1,
				max: 6
			}
		}
		
	});

});

</script>




<div id="terms" class="modal hide fade in" style="display: none; ">  
    <div class="modal-header">  
        <a class="close" data-dismiss="modal">×</a>  
        <h3>Terms of Use</h3>
    </div> 
    <div class="modal-body" style="max-height:300px;">
        <ol class="terms">
                	<li>These Terms supersede all earlier versions. YOU UNDERSTAND AND ACKNOWLEDGE THAT THIS AGREEMENT INCLUDES A BINDING ARBITRATION CLAUSE (SECTION 22), A CLASS ACTION WAIVER (SECTION 23), AND A JURY TRIAL WAIVER (SECTION 24) AND YOUR USE OF THIS SERVICE IS CONTINGENT ON YOUR ACCEPTANCE OF THESE CLAUSES. You acknowledge that neither the retail or hospitality establishment nor any employee of SmartWiFi or any other agent is authorized to make any representation or warranty (other than as described in the Agreement or our current materials) with respect to the Agreement, the Service or to waive or modify any terms or provisions of the Agreement.</li>
                    <li>Acceptance of Agreement by Use/Modifications. BY YOUR ELECTRONIC ACCEPTANCE OF THESE TERMS OR BY YOUR USE OF THE SERVICE YOU ARE ACCEPTING THE TERMS, CONDITIONS AND PRACTICES DESCRIBED IN THESE TERMS. IF YOU DO NOT AGREE TO THESE TERMS, PLEASE DO NOT USE THE SERVICE AND EXIT IMMEDIATELY. EXCEPT TO THE EXTENT PROHIBITED BY LAW, WE RESERVE THE RIGHT TO MODIFY OR AMEND THESE TERMS FROM TIME TO TIME WITHOUT NOTICE. YOUR CONTINUED USE OF THE SERVICE FOLLOWING THE POSTING OF CHANGES TO THESE TERMS CONSTITUTES YOUR ACCEPTANCE OF THOSE CHANGES. UNLESS WE PROVIDE YOU WITH SPECIFIC NOTICE, NO CHANGES TO OUR TERMS WILL APPLY RETROACTIVELY. Your electronic acceptance of the Agreement shall have the same force and effect as if you had actually signed the Agreement.</li>
                    <li>WiFi Compatible Device. You must have a WiFi compatible device, e.g. a computer with a wireless card, a WiFi enabled smartphone, etc., ("Device") in order to access and use the Service. You are responsible for obtaining a Device. You are not required to obtain this Device from Smartwifi. You are responsible for ensuring that your Device is compatible with the Service. Availability and performance of the Service is subject to all memory, storage and other limitations in the Device.</li>
                    <li>Service Availability. The Service is only available at designated SmartWiFi HotSpot locations. The Service is available to your Device only when it is within the operating range of our system. Smartwifi HotSpot locations are subject to change at any time without notice. Actual Service coverage, speeds, locations and quality may vary. The Service is subject to unavailability, including emergencies, third party service failures, transmission, equipment or network problems or limitations, interference, signal strength, and maintenance and repair, and may be interrupted, refused, limited or curtailed. We are not responsible for data, messages or pages lost, not delivered, delayed or misdirected because of interruptions or performance issues with the Service or communications services or networks (e.g., T-1 lines or the Internet). We may impose usage or Service limits, suspend Service, or block certain kinds of usage in our sole discretion to protect users, our network or our business. Network speed is an estimate and is no indication of the speed at which your Device or the Service sends or receives data. Actual network speed will vary based on Device configuration, compression, distance, network congestion, interference and other factors. The accuracy and timeliness of data received is not guaranteed; delays or omissions may occur. We may, but do not have to, change or improve the Service.</li>
                    <li>Use of Service. You are receiving a single user account solely for your use of the Service through one Device per login session. You agree not to resell or attempt to resell any aspect of the Service, whether for profit or otherwise, share your IP address or ISP Internet connection with anyone, access the Service simultaneously through multiple units or to authorize any other individual or entity to use the Service. You agree that sharing the Service with another party breaches the Agreement and may constitute fraud or theft, for which we reserve all rights and remedies. You have no proprietary or ownership rights to a specific IP or other address, log-in name, or password that you use on the Service. We may change your address, log-in name or password at any time. We will assign you an IP address each time you access the Service, and it will vary. You shall not program any other IP address into your Device. If applicable, you may not assign your log-in name, password or IP address to any other person or Device. You agree that we may access your Device and information stored on it (such as drivers, software, etc.) to troubleshoot issues related to the Device or network; enable, operate and update the Service and software; investigate activity that may be in violation of the Agreement; or to comply with law.</li>
                    <li>Unacceptable Use. You agree not to use or attempt to use the Service or the SmartWiFi network for any fraudulent, unlawful, harassing or abusive purpose, or so as to damage or cause risk to our business, reputation, employees, subscribers, facilities, or to any person. Improper uses include, but are not limited to: (a) violating any applicable law or regulation; (b) posting or transmitting content you do not have the right to post or transmit; (c) posting or transmitting content that infringes a third party's trademark, patent, trade secret, copyright, publicity, privacy, or other right; (d) posting or transmitting content that is unlawful, untrue, stalking, harassing, libelous, defamatory, abusive, tortious, threatening, obscene, hateful, abusive, harmful or otherwise objectionable as determined in our sole discretion; (e) attempting to intercept, collect or store data about third parties without their knowledge or consent; (f) deleting, tampering with or revising any material posted by any other person or entity; (g) accessing, tampering with or using non-public areas of the Service, SmartWiFi's computer systems and network or any SmartWiFi website; (h) attempting to probe, scan or test the vulnerability of a system or network or to breach security or authentication measures; (i) attempting to access or search the Service, the SmartWiFi network or any SmartWiFi website with any engine, software, tool, agent, device or mechanism other than the software and/or search agents provided by us or other generally available third party web browser; (j) sending or attempting to send unsolicited messages, including without limitation, promotions or advertisements for products or services, "spam", "chain mail" or "junk mail"; (k) using or attempting to use the Service, the SmartWiFi network or any SmartWiFi website to send altered, deceptive or false source-identifying information; (l) attempting to decipher, decompile, disassemble or reverse engineer any of the software comprising or in any way making up a part of the Service, the SmartWiFi network or any SmartWiFi website or attempting to bypass any measures we may use to prevent or restrict access to the Service; (m) interfering or attempting to interfere with the access of any user, host or network, including without limitation, sending a "virus" to the Service, the SmartWiFi network or any SmartWiFi website, overloading, "flooding," "spamming," "crashing," or "mailbombing" the Service, the SmartWiFi network or any SmartWiFi website; (n) impersonating or misrepresenting your affiliation with any person or entity; (o) using the Service to make fraudulent offers to sell or buy products, items, or services or to advance any type of financial scam such as "pyramid schemes", "Ponzi schemes", unregistered sales of securities, and securities fraud; or (p) excessively high volume data transfers or bandwidth consumption, hosting of a web server, internet relay chat server or any other server, using any robot, spider, scraper or other similar means through the Service, and any other non-traditional end user activities.</li>
                    <li>SmartWiFi Rights and Remedies. If we suspect violations of any of these Terms, we may: (i) institute legal action, (ii) immediately, without prior notice to you, terminate your access to the Service, and (iii) cooperate with law enforcement authorities in investigating or bringing legal proceedings against violators. You agree to reasonably cooperate with us in investigating suspected violations. SmartWiFi reserves the right to install, implement, manage and/or operate one or more software, monitor or other solutions designed to assist us in identifying and/or tracking activities that we consider to be illegal or violations of these Terms, including but not limited to any of the activities described in Section 5. We may, but are not obligated to, in our sole discretion, and without notice, remove, block, filter or restrict by any means any materials or information (including but not limited to emails) that we consider to be actual or potential violations of the restrictions set forth in these Terms, including but not limited to those activities described in Section 5 and any other activities that may subject SmartWiFi or its customers to harm or liability. SmartWiFi disclaims any and all liability for any failure on its part to prevent such materials or information from being transmitted over the Service and/or into your Device. </li>
                    <li>Content Disclaimer: Cautions and Restrictions. We do not control, nor are we responsible or liable for, data, content, services, or products (including software) that you access, download, receive or buy via the Service. The Internet may provide access to content you consider harmful to minors, or otherwise offensive or inappropriate. We are not responsible for blocking your access to such content. We may, but do not have to, block information, transmissions or access to certain information, services, products or domains to protect us, our network, the public or our users. Therefore, messages and other content may be deleted before delivery. The Internet contains unedited materials, some of which may be offensive to you. We are not a publisher of third party content accessed through the Service and are not responsible for the content, accuracy, timeliness or delivery of any opinions, advice, statements, messages, services, graphics, data or any other information provided to or by third parties as accessible through the Service. You are responsible for paying all fees and charges of third party vendors whose sites, products or services you access, buy or use via the Service. If you choose to use the Service to access web sites, services or content, or purchase products from third parties, your personal information may be available to the third-party provider. How third parties handle and use your personal information related to their sites and services is governed by their security, privacy and other policies (if any) and not ours. We have no responsibility for third party provider policies, or their compliance with them. If you elect to download into your Device or otherwise enable any software, including any "client" designed to facilitate your access of the Service, you shall be solely responsible for, and shall be deemed to have reviewed and, to the extent applicable, acknowledged, accepted or waived, any disclosures, notices or options otherwise made available to you for viewing as part of the log-in process for the Service. </li>
                    <li>Termination of Service. The Agreement begins on the date the Service is first used or is otherwise deemed to have been accepted as provided in Section 1 above and will continue until terminated by you or us in the manner provided in the Agreement. If you breach these Terms, we may suspend or terminate your Service immediately without prior notice (except to the extent prohibited by law). Our remedies hereunder are not exclusive but are in addition to all other remedies provided by law.</li>
                    <li>Your Account. You understand that you may need to create an account to use this Service. In consideration of your use of the Service, you will: (a) provide true, accurate, current and complete information about yourself and your business as prompted by the Service registration form (such information being the "Registration Data") and (b) maintain and promptly update the Registration Data to keep it true, accurate, current and complete. If you provide any information that is untrue, inaccurate, not current or incomplete, or SmartWiFi has reasonable grounds to suspect that such information is untrue, inaccurate, not current or incomplete, SmartWiFi has the right to suspend or terminate your account and refuse any and all current or future use of the Service. You are entirely responsible for the security and confidentiality of your password and account. Furthermore, you are entirely responsible for any and all activities that occur under your account. You agree to immediately notify us of any unauthorized use of your account or any other breach of security of which you become aware. You are responsible for taking precautions and providing security measures best suited for your situation and intended use of the Services. We have the right to provide user billing, account, Content or use records, and related information under certain circumstances (such as in response to legal responsibility, lawful process, orders, subpoenas, or warrants, or to protect our rights, customers or business). Please note that anyone able to provide your personally identifiable information will be able access your account so you should take reasonable steps to protect this information.</li>
                    <li>Disclaimer of Warranties. THE SERVICE IS PROVIDED ON AN "AS IS" AND "WITH ALL FAULTS" BASIS, AND WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, WARRANTIES OF TITLE, MERCHANTABILITY, NON-INFRINGEMENT, OR FITNESS FOR A PARTICULAR PURPOSE WHICH ARE EXPRESSLY DISCLAIMED. YOU ASSUME ALL RESPONSIBILITY AND RISK FOR USE OF THE SERVICE. WE DO NOT AUTHORIZE ANYONE TO MAKE A WARRANTY OF ANY KIND ON OUR BEHALF AND YOU SHOULD NOT RELY ON ANY SUCH STATEMENT. NEITHER WE NOR OUR OFFICERS, DIRECTORS, EMPLOYEES, MANAGERS, AGENTS, DEALERS, SUPPLIERS, PARENTS, SUBSIDIARIES OR AFFILIATES ("SmartWiFi AFFILIATES") WARRANT THAT THE INFORMATION, PRODUCTS, PROCESSES, AND/OR SERVICES AVAILABLE THROUGH THE SERVICE WILL BE UNINTERRUPTED, ALWAYS AVAILABLE, ACCURATE, COMPLETE, USEFUL, FUNCTIONAL OR ERROR FREE. IF APPLICABLE STATE LAW DOES NOT ALLOW THE DISCLAIMER OF CERTAIN IMPLIED WARRANTIES, THE RELEVANT PORTIONS OF THE ABOVE EXCLUSION MAY NOT APPLY TO YOU. </li>
                    <li>Limitation of Liability. EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF DAMAGES, WE WILL NOT BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY DAMAGES ARISING FROM USE OF THE SERVICE, INCLUDING WITHOUT LIMITATION: PUNITIVE, EXEMPLARY, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES, LOSS OF PRIVACY OR SECURITY DAMAGES; PERSONAL INJURY OR PROPERTY DAMAGES; OR ANY DAMAGES WHATSOEVER RESULTING FROM INTERRUPTION OR FAILURE OF SERVICE, LOST PROFITS, LOSS OF BUSINESS, LOSS OF DATA, LOSS DUE TO UNAUTHORIZED ACCESS OR DUE TO VIRUSES OR OTHER HARMFUL COMPONENTS, COST OF REPLACEMENT PRODUCTS AND SERVICES, THE INABILITY TO USE THE SERVICE, THE CONTENT OF ANY DATA TRANSMISSION, COMMUNICATION OR MESSAGE TRANSMITTED TO OR RECEIVED BY YOUR DEVICE, ACCESS TO THE WORLD WIDE WEB, THE INTERCEPTION OR LOSS OF ANY DATA OR TRANSMISSION, OR LOSSES RESULTING FROM ANY GOODS OR SERVICES PURCHASED OR MESSAGES OR DATA RECEIVED OR TRANSACTIONS ENTERED INTO THROUGH THE SERVICE. SOME STATES DO NOT ALLOW THE EXCLUSION OR LIMITATION OF INCIDENTAL OR CONSEQUENTIAL DAMAGES, OR OTHER MODIFICATIONS OF OR LIMITATIONS TO CERTAIN REMEDIES, SO THE ABOVE EXCLUSION OR LIMITATION MAY NOT APPLY TO YOU, IN WHOLE OR IN PART. </li>
                    <li>THE MAXIMUM AGGREGATE LIABILITY OF SmartWiFi TO YOU, AND THE EXCLUSIVE REMEDY AVAILABLE IN CONNECTION WITH THE AGREEMENT FOR ANY AND ALL DAMAGES, INJURY, LOSSES ARISING FROM ANY AND ALL CLAIMS AND/OR CAUSES OF ACTION RELATED TO THE SERVICE OR DEVICE, SHALL BE TO RECOVER THE GREATER OF ANY AMOUNTS PAID TO SmartWiFi OR TWENTY FIVE DOLLARS ($25.00). THE EXISTENCE OF MULTIPLE CLAIMS OR SUITS UNDER OR RELATED TO THE AGREEMENT WILL NOT ENLARGE OR EXTEND THE LIMITATION OF MONEY DAMAGES. </li>
                    <li>THE FOREGOING LIMITATIONS OF LIABILITY SHALL ALSO APPLY TO ANY VENUE PARTNER WHERE THE SERVICE IS USED. EXCEPT TO THE EXTENT PROHIBITED BY LAW, ALL CLAIMS MUST BE BROUGHT WITHIN 2 YEARS OF THE DATE THE CLAIM ARISES.</li>
                    <li> Force Majeure. Neither Company nor you shall be responsible for damages or for delays or failures in performance caused in whole or in part from acts or occurrences beyond their reasonable control, including, without limitation: fire, lightning, explosion, power surge or failure, water, acts of God, war, revolution, civil commotion or acts of civil or military authorities or public enemies: any law, order, regulation, ordinance, or requirement of any government or legal body or any representative of any such government or legal body; equipment or facility failure, network problems, interference, lack of coverage or network capacity, or labor unrest, including without limitation, strikes, slowdowns, picketing, or boycotts; inability to secure raw materials, transportation facilities, fuel or energy shortages, or acts or omissions of other common carriers.</li>
                    <li>Indemnification. You agree to defend, indemnify and hold us, any underlying carrier or network provider, any venue providing the Service and any SmartWiFi Affiliates harmless from and against any and all claims, demands, actions, liabilities, costs or damages arising out of your use of the Service or a Device or your violation of the Agreement. You further agree to pay our reasonable attorneys' and expert witnesses' fees and costs arising from any actions or claims hereunder and those incurred in establishing the applicability of this section. </li>
                    <li>Release. In the event that you have a dispute with any person or entity through your use of the Service or you have a dispute with the venue where you are accessing this Service, you release SmartWiFi (and our officers, directors, agents, subsidiaries, joint ventures and employees) from claims, demands and damages (actual and consequential) of every kind and nature, known and unknown, suspected and unsuspected, disclosed and undisclosed, arising out of or in any way connected with such disputes.</li>
                    <li>Privacy and Security. Wireless systems use radio channels to transmit voice and data communications over a complex network. Privacy cannot be guaranteed, and we are not liable to you or any other party for any lack of privacy you experience while using the Service. If you use the Service in a public location, you understand that others may be able to see and observe your use of the Service. We have the right, but not the obligation to monitor, intercept and disclose any transmissions over or using our facilities, and to provide account or use records, and related information under certain circumstances (for example, in response to lawful process, orders, subpoenas, or warrants, or other information, in good faith reliance on legal process, if required by law or to protect our rights, business, network, customers or property). Please consult the SmartWiFi Privacy Policy posted on our website at www.SmartWiFi.com/terms-policy/privacy-policy.html for additional information on the use and disclosure of information. In the event of a conflict between the SmartWiFi Privacy Policy and these Terms, these Terms will govern. You acknowledge that the Service is inherently not secure and that wireless communications can be intercepted by equipment and software designed for that purpose. Notwithstanding efforts to enhance security with respect to the Service, we cannot guarantee the effectiveness of these efforts and will not be liable to you or any other party for any lack of security that may result from your use of the Service. You acknowledge that you are responsible for taking such precautions and providing such security measures best suited for your situation and intended use of the Service. We strongly encourage and support certain customer-provided security solutions, such as virtual private networks, encryption and personal firewalls, but do not provide these to our users and are not responsible for their effectiveness. </li>
                    <li>Assignment. We may assign in whole or in part our rights or duties under the Agreement without prior notice to you and upon such assignment we shall be released from all liability hereunder. You may assign the Agreement only with our prior written consent. Subject to this restriction, the Agreement shall inure to the benefit of and be binding upon the heirs successors, subcontractors, and assigns of the respective parties. </li>
                    <li>Severability. All terms and provisions of these Terms are independent of each other. If any term or provision of these Terms is held to be inapplicable or unenforceable, then: (a) such term or provision shall be construed, as nearly as possible, to reflect the intentions of the parties with the other provisions remaining in full force and effect, (b) the Agreement will not fail its essential purpose and (c) the balance of the terms and provisions shall remain unaffected and in full force and effect, unless our obligations hereunder are materially impaired, in which event we reserve the right to terminate the Agreement. </li>
                    <li>Entire Agreement/Miscellaneous. The Agreement represents the final and entire agreement between you and us regarding the Service. Electronic images of the Agreement will be considered originals. A printed version of these Terms of Use will be admissible in judicial and administrative proceedings based upon or relating to these Terms of Use to the same extent and subject to the same conditions as other business documents and records originally generated and maintained in printed form. You acknowledge that you have not relied on any other representations not specifically included in the Agreement. If we don't enforce our rights under any of the provisions of the Agreement, we may still require strict compliance in the future. You represent that you are of legal age and have the legal capacity to enter into the Agreement. If you are contracting on behalf of a company, you represent that you are authorized to enter into the Agreement and agree to be personally liable for all accounts if you are not so authorized. </li>
                    <li>Survival. The following provisions, and any other provisions which may reasonably be construed as surviving, and the rights and obligations of the parties thereunder, shall survive any termination of the Agreement for any reason: Sections 1, 6, and 8-25. </li>
                    <li>Other Agreements or Warranties. Other SmartWiFi services (such as cable television service, voice or data telecommunication services) or products come with separate written terms or conditions, and warranties that govern their use or purchase. Please see those other agreements or warranties for your rights and duties regarding their use, if applicable. </li>
                    <li>Choice of Law/Venue. Any claim relating to, and the use of, this Service and the materials contained herein is governed by the laws of the state of California. You consent to the exclusive jurisdiction of the state and federal courts located in the state in which you use the Service. </li>
                    <li>Binding Arbitration. PLEASE READ THIS SECTION CAREFULLY. IT REQUIRES RESOLUTION OF DISPUTES THROUGH ARBITRATION INSTEAD OF COURT TRIALS AND CLASS ACTIONS. ARBITRATION IS FINAL AND BINDING AND SUBJECT TO ONLY VERY LIMITED REVIEW BY A COURT.  THIS SECTION IS INTENDED TO BE INTERPRETED BROADLY TO ENCOMPASS ALL DISPUTES OR CLAIMS ARISING OUT OF OUR RELATIONSHIP.   YOU AND SmartWiFi AGREE THAT ANY CLAIM, DISPUTE, OR CONTROVERSY (WHETHER BASED IN CONTRACT, TORT, STATUTE, FRAUD, MISREPRESENTATION OR ANY OTHER LEGAL THEORY), RELATING TO OR ARISING OUT OF YOUR RELATIONSHIP WITH SmartWiFi, IRRESPECTIVE OF WHETHER ARISING  PRIOR TO OR AFTER THIS OR ANY OTHER AGREEMENT, INCLUDING CLAIMS, DISPUTES, OR CONTROVERSIES ARISING UNDER FEDERAL, STATE, OR LOCAL STATUTE, ORDINANCE, OR REGULATION, OR AS RELATES TO THIS AGREEMENT INCLUDING ANY OF ITS COMPONENTS, THE SERVICES OR EQUIPMENT PROVIDED BY SmartWiFi OR ANY ORAL OR WRITTEN STATEMENTS, ADVERTISEMENTS, REPRESENTATIONS OR PROMOTIONS RELATING TO THIS AGREEMENT OR TO THE SERVICES OR EQUIPMENT (COLLECTIVELY, "CLAIM") SHALL BE RESOLVED THROUGH BINDING ARBITRATION UNDER THE FEDERAL ARBITRATION ACT, EXCEPT THAT SmartWiFi MAY CHOOSE TO PURSUE CLAIMS IN COURT IF THE CLAIMS RELATE SOLELY TO THE COLLECTION OF ANY DEBTS YOU OWE US.   All arbitration shall be initiated and conducted in accordance with the Commercial Arbitration Rules and Mediation Procedures of the American Arbitration Association ("AAA").  The AAA shall appoint the arbitrator.  The party initiating arbitration shall give notice to the other party by mailing a copy of the request for arbitration to the other party at the addresses on the Service Order.   Arbitration must be initiated by You within one (1) year of the date of the occurrence of the event or facts giving rise to the dispute (except for billing disputes which must be initiated within thirty (30) days).  You waive any claim not filed in accordance with the previous sentence.  All parties to the arbitration must be individually named and there shall be no right or authority for any claims to be arbitrated or otherwise tried on a class action or consolidated basis or through a representative.  The arbitrator may not consolidate proceedings or more than one person's claims, and may not otherwise preside over any form of a representative or class proceeding.  An arbitrator may not award relief in excess of or contrary to what this Agreement provides or award punitive damages or any other damages aside from the prevailing party's actual damages, except that the arbitrator may award on an individual basis damages required by statute and may order injunctive or applicable declaratory relief. Arbitration of claims will be conducted in such forum and pursuant to such laws and rules related to commercial arbitration in the state where you used the service that are in effect on the date of the notice to arbitrate. </li>
                    <li>CLASS ACTION WAIVER. WHETHER IN COURT, SMALL CLAIMS COURT, OR ARBITRATION, YOU AND WE MAY ONLY BRING CLAIMS AGAINST EACH OTHER IN AN INDIVIDUAL CAPACITY AND NOT AS A CLASS REPRESENTATIVE OR A CLASS MEMBER IN A CLASS OR REPRESENTATIVE ACTION. IF A COURT OR ARBITRATOR DETERMINES IN A CLAIM BETWEEN YOU AND US THAT YOUR WAIVER OF ANY ABILITY TO PARTICIPATE IN CLASS OR REPRESENTATIVE ACTIONS IS UNENFORCEABLE UNDER APPLICABLE LAW, THE ARBITRATION AGREEMENT WILL NOT APPLY, AND YOU AND WE AGREE THAT SUCH CLAIMS WILL BE RESOLVED BY A COURT OF APPROPRIATE JURISDICTION, OTHER THAN A SMALL CLAIMS COURT. </li>
                    <li>JURY TRIAL WAIVER. WHETHER ANY CLAIM IS IN ARBITRATION OR IN COURT, YOU AND WE WAIVE ANY RIGHT TO JURY TRIAL INVOLVING ANY CLAIMS OR DISPUTES BETWEEN YOU AND US.</li>
                </ol>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>
