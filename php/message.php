<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');

	$error = [];

	// get data from json post if existing or normal post incase of JS failure
	$data = isset($_POST['json']) ? $_POST['data'] : $_POST;
	$data = array_map('trim', $data); // trim all values

	// do serverside validation
	// name things
	if (!isset($data['name']) || empty($data['name']) || strlen($data['name']) <= 1) {
		$error['name'] = 'You forgot to enter your name!';
	}

	// email things
	if (!isset($data['email']) || empty($data['email'])) {
		$error['email'] = 'You forgot to enter your email address.';
	} else {
		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$error['email'] = 'Your email address seems to be invalid.';
		}
	}

	// message things
	if (!isset($data['message']) || empty($data['message'])) {
		$error['message'] = 'You forgot to enter a message.';
	} else {
		if (strlen($data['message']) < 25) {
			$error['message'] = 'Your message is to short, please send something constructive.';
		}
	}

	// if we have no errors send me the email!
	if (count($error) === 0) {
		$mailformat = vsprintf('name: %1$s\r\nemail: <a href="mailto:%2$s">%2$s</a>\r\nmessage:\r\n%3$s', $data);
		mail("jennevdmeer@impulze.net", ' idn — ' . $data['name'], $mailformat);
	}

	if (isset($_POST['json'])) {
		// send back some data
		header('Content-type: application/json');
		echo json_encode(['error' => $error]);
	} else {
		header('Location: /2016/');
	}
?>
