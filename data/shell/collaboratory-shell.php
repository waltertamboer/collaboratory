<?php

// Set the current timezone:
date_default_timezone_set('Europe/Amsterdam');

// The username that is active:
$username = $_SERVER['argv'][1];

// The directory of today's logs:
$logDirectory = '/home/' . $_SERVER['USER'] . '/logs/git/' . $username;
if (!is_dir($logDirectory)) {
	mkdir($logDirectory, 0777, true);
}

// The file to log to:
$logFile = $logDirectory . '/' . date('Y-m-d') . '.log';

// Open the log file:
$f = fopen($logFile, 'a+');
fwrite($f, '[' . date('Y-m-d H:i:s') . '][' . $_SERVER['USER'] . '][' . $username . '][' . $_SERVER['SSH_CONNECTION'] . '][' . $_SERVER['SSH_ORIGINAL_COMMAND'] . ']');
fwrite($f, PHP_EOL);
fclose($f);

$sshCommand = $_SERVER['SSH_ORIGINAL_COMMAND'];

if (preg_match("#^(git-upload-pack|git-receive-pack|git-upload-archive) '/?(.*?)(?:\.git(\d)?)?'$#i", $_SERVER['SSH_ORIGINAL_COMMAND'], $matches)) {
	$action = $matches[1];
	$repository = $matches[2];
	$traceLevel = isset($matches[3]) ? $matches[3] : '';

	// Prefix the repository with the correct path:
	$repository = '/home/' . $_SERVER['USER'] . '/data/repositories/' . $repository;

	// Output the shell command so it can be executed:
	echo sprintf('git shell -c "%s \'%s\'"', $action, $repository);
} else {
	die('No repository found.');
}

