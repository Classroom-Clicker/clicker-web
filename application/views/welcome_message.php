<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}

	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<div id="body">
		<div>
			<h1> Testing curl </h1>
			<?php
			$wArray = makeRequestArray();
			var_dump($wArray);


			$wCurl = new Curl();
			// BEGIN IN DEBUG ONLY !!!
			$wCurl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
			// END IN DEBUG ONLY !!!

			$wCurl->get('https://clicker.dev/api/v1/users/1', $wArray);

			if ($wCurl->error) {
	    		echo "Error :".$wCurl->error_code;
			}
			else {
				echo "<h2>Successfull request!</h2>";
				echo $wCurl->response->id."<br>";
				echo $wCurl->response->firstname."<br>";
				echo $wCurl->response->lastname."<br>";
				echo $wCurl->response->email."<br>";
			}
		?>
		</div>
		<div>
			<h1> Testing CAS </h1>
		<?php
		
		phpCAS::client(CAS_VERSION_2_0, 'websso.wwu.edu', 443, '/cas');
		//at the moment add the following line and comment out the two after that
		phpCAS::setCasServerCACert("application/config/CA_CAS_FILE.pem");
		phpCAS::forceAuthentication();
		if (isset($_REQUEST['logout'])) {
			phpCAS::logoutWithRedirectService("http://clicker.dev/web/");
		}
		?>
		<div>
			<h2>Successfull Authentication!</h2>
			<p>The user's login is <strong><?php echo phpCAS::getUser(); ?></strong></p>
			<p>The phpCAS version is <strong><?php echo phpCAS::getVersion(); ?></strong></p>
			<p><a href="?logout=">Logout</a></p>
		</div>

		</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>
