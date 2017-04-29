<?php
// This function checks for email injection. Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// Load form field data into variables.
$nameErr = $emailErr = $messageErr = "";
$name = $email_address = $message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = true;
	} else {
		$name = test_input($_POST["name"]);
	}
	if (empty($_POST["email_address"])) {
		$emailErr = true;
	} else if (isInjected($email_address)) {
		$emailErr = true;
	} else {
		$email_address = test_input($_POST["name"]);
	}
	if (empty($_POST["message"])) {
		$messageErr = true;
	} else {
		$message = test_input($_POST["name"]);
	}
	send_email($name, $email, $message);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function send_email($name, $email, $message) {
	mail( "soulesjms@gmail.com", "Testing message", $message, "From: $email_address");
	$thankyou = "Thank you for your message.";
}

?>
