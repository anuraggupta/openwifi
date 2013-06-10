<?php

// Create connection
mysql_connect("198.100.45.191",root,ebffb4499fa6cd78);
@mysql_select_db(smartwifi) or die( "Unable to select database");

$query="SELECT * FROM voucher_list WHERE time_used IS NULL AND campaign='Citibank-Ambi-5'";
$result=mysql_query($query);
 
$username= mysql_result($result,0,"username");
$password= mysql_result($result,0,"password");


$uamsecret = "uamsecret";

$uagent = $_SERVER['HTTP_USER_AGENT'];


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
			'<input type="hidden" name="username" value="', $username,'">',
			'<input type="hidden" name="password" value="', $password,'">',
            '<input type="submit" value="Login" id="login_to_hspot" style="display:none;">',
        '</form>'
    ));
	
	$header_content = ' ';
	
	$display_login_form = '
			<form class="form-signin">
				<button type="button" class="login_button" onClick="sub_form()">OK</button>
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
        <title>BB Z10</title>
        <script src="assets/js/jquery.js"></script>
    	<link href="assets/css/style.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php echo $header_content; ?>

    </head>
    <body <?php echo $body_cont; ?> >
    	<div class="container">
			<?php echo $display_login_form; ?>
            <p class="terms_line">By clicking on OK, you agree to <a href="terms.html">TERMS OF USE</a></p>
        </div>
        <?php echo $msg; ?>
    </body>
</html>




<script type="text/javascript">
function sub_form() {
		
		var form_data = {
					uAgent: '<?php echo $uagent ?>',
					ajx: '1'
				};
				
		var request = $.ajax({
			url: "http://smartwifi.in/bbz10_login/savedata.php",
			type: 'POST',
			data: form_data,
		});
		request.success(function(msg) {
			$('#login_to_hspot').trigger('click');
		});
		request.fail(function(msg) {
			alert("Problem encountered. Please refresh the page and try again.");
		});
};

</script>