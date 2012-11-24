<?php

// Set the timezone in case there is none.
if (!date_default_timezone_get()) {
    date_default_timezone_set('Europe/Amsterdam');
}

// The username that is active:
$username = $_SERVER['argv'][1];

// The home path on the system:
$homePath = '/home/' . $_SERVER['USER'] . '/collaboratory';

// The directory of today's logs:
$logDirectory = $homePath . '/logs/git/' . $username;
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

if (preg_match("#^(git-upload-pack|git-receive-pack|git-upload-archive) '/?(.*?)(?:\.git(\d)?)?'$#i", $_SERVER['SSH_ORIGINAL_COMMAND'], $matches)) {
	$action = $matches[1];
	$repository = $matches[2];

	// Prefix the repository with the correct path:
	$repository = $homePath . '/data/projects/' . $repository;
    if (is_dir($repository)) {
        $output = $action . "'" . $repository . "'";
    } else {
        $output = 'The repository "' . $repository . '" does not exist.';
    }
} else {
	$output = 'No repository found.';
}

echo $output;