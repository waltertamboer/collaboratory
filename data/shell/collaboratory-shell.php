<?php

// Set the current timezone:
date_default_timezone_set('Europe/Amsterdam');

// The parameters:
$localUser = $_SERVER['argv'][1];
$systemUser = $_SERVER['argv'][2];
$sshOriginalCommand = $_SERVER['argv'][3];
$sshConnection = $_SERVER['argv'][4];

// The directory of today's logs:
$logDirectory = '/home/' . $systemUser . '/logs/git/' . $localUser;
if (!is_dir($logDirectory)) {
	mkdir($logDirectory, 0777, true);
}

// The file to log to:
$logFile = $logDirectory . '/' . date('Y-m-d') . '.log';

// Open the log file:
$f = fopen($logFile, 'a+');

fwrite($f, 'Date: ' . date('Y-m-d H:i:s') . PHP_EOL);
fwrite($f, 'System user: ' . $systemUser . PHP_EOL);
fwrite($f, 'Local user: ' . $localUser . PHP_EOL);
fwrite($f, 'Connection: ' . $sshConnection . PHP_EOL);
fwrite($f, 'SSH Command: ' . $sshOriginalCommand . PHP_EOL);

$sshCommand = $sshOriginalCommand;

if (preg_match("#^(git-upload-pack|git-receive-pack|git-upload-archive) '/?(.*?)(?:\.git(\d)?)?'$#i", $sshOriginalCommand, $matches)) {
	$action = $matches[1];
	$repository = $matches[2];
	$traceLevel = isset($matches[3]) ? $matches[3] : '';

	fwrite($f, '- Action: ' . $action . PHP_EOL);
	fwrite($f, '- Repository: ' . $repository . PHP_EOL);
	fwrite($f, '- Trace level: ' . $traceLevel . PHP_EOL);

	// Prefix the repository with the correct path:
	$repository = '/home/' . $systemUser . '/data/repositories/' . $repository;
	$sshCommand = $action . " '" . $repository . "'";
}

fclose($f);

// Output the shell command so it can be executed:
echo 'git shell -c "' . $sshCommand . '"';
