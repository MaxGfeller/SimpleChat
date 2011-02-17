<?php
	if($_GET['action'] == 'login') {
		setcookie('username', $_POST['username']);
		session_id($_POST['chatroom']);
		session_start();
		if($_SESSION['chatroom'] == '') {
			$_SESSION['chatroom'] = $_POST['chatroom'];
		}
	}
	if($_GET['action'] == 'write') {
		
		session_start();
		if($_SESSION['chat_array'] == '') {
			$_SESSION['chat_array'] = array();
		}
		if($_POST['text'] != '') {
			$_SESSION['chat_array'][] = htmlentities('[' . $_COOKIE['username'] . ']: ' . $_POST['text']);
		}
	}
	if($_GET['action'] == 'retr') {
		session_start();
		if(isset($_SESSION['chat_array'])) {
			foreach($_SESSION['chat_array'] as $value) {
				echo $value . '<br />';
			}
		}
		exit();
	}
?>
<html>
<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">

		<title>Simple Session Chat</title>

		<style type="text/css">
		h1 {
			color: #00FF00;
		}
		body {
			color: #00FF00;
			font-family: Courier;
		}
		input {
			color: blue;
			
		}
		#messages {
			color: blue;
			background-color: grey;
			width: 100%;
		}
		</style>
		<script type="text/javascript">
			var xmlHttpObject = false;
			if (typeof XMLHttpRequest != 'undefined') 
			{
			    xmlHttpObject = new XMLHttpRequest();
			}
			if (!xmlHttpObject) 
			{
			    try 
			    {
			        xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP");
			    }
			    catch(e) 
			    {
			        try 
			        {
			            xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP");
			        }
			        catch(e) 
			        {
			            xmlHttpObject = null;
			        }
			    }
			}
			
			function reload_messages() {
				window.setInterval("get_messages()", 2000);
			}
			
			function get_messages() {
				xmlHttpObject.open('GET', '?action=retr');
				xmlHttpObject.onreadystatechange = function() {
					//alert(xmlHttpObject.responseText);
					if(document.getElementById('messages').innerHTML != xmlHttpObject.responseText) {
						document.getElementById('messages').innerHTML = xmlHttpObject.responseText;
					}
					
				};
				xmlHttpObject.send(null);

			}
		</script>
</head>
<body bgcolor="black" onload="reload_messages()">

<?php 
	if(isset($_COOKIE['username']) || $_GET['action'] == 'login') {
?>
<h1>Chatroom "<?=$_SESSION['chatroom'] ?>"</h1>

<form name="form1" action="?action=write" method="post">
Nachricht: <input type="text" name="text" size="50" /><br />
<input type="submit" value="senden" />
</form>

<div id="messages">
<?php
	if(isset($_SESSION['chat_array'])) {
		foreach($_SESSION['chat_array'] as $value) {
			echo $value . '<br />';
		}
	}
?>
</div>
<?php
	} else {
?>
<h1>Anmeldung</h1>

<form name="form1" action="?action=login" method="post">
Username: <br />
<input type="text" name="username" size="20"><br />
Chatroom (is being created if non existant): <br />
<input type="text" name="chatroom" size="20"><br /><br />
<input type="submit" value="log in..." />
</form> 
<?php
}
?>

</body>
</html>