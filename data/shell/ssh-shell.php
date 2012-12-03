<?php

// Set the timezone in case there is none.
if (!ini_get('date.timezone')) {
    date_default_timezone_set('Europe/Amsterdam');
}

// The id of the user that does the request:
$userId = $_SERVER['argv'][1];

// The home path on the system:
$homePath = '/home/' . $_SERVER['USER'] . '/collaboratory';

// The directory of today's logs:
$logDirectory = $homePath . '/logs/git/' . $userId;
if (!is_dir($logDirectory)) {
	mkdir($logDirectory, 0777, true);
}

// The file to log to:
$logFile = $logDirectory . '/' . date('Y-m-d') . '.log';

// Open the log file:
$f = fopen($logFile, 'a+');
fwrite($f, '[' . date('Y-m-d H:i:s') . '][' . $_SERVER['USER'] . '][' . $userId . '][' . $_SERVER['SSH_CONNECTION'] . '][' . $_SERVER['SSH_ORIGINAL_COMMAND'] . ']');
fwrite($f, PHP_EOL);
fclose($f);

if (!preg_match("#^(git-upload-pack|git-receive-pack|git-upload-archive) '/?(.*?)(?:\.git(\d)?)?'$#i", $_SERVER['SSH_ORIGINAL_COMMAND'], $matches)) {
	echo 'No repository found.';
    exit;
}

$action = $matches[1];
$repositoryLine = $matches[2];

// Split the repository, we expect the form: "project/repository/tree/a/b/c"
if (!preg_match('#^([a-z0-9-]+)/([a-z0-9-/]+)$#semi', $repositoryLine, $matches)) {
	echo 'The repository "' . $repositoryLine . '" does not exist.';
    exit;
}

// The project and repository name:
$projectName = $matches[1];
$repositoryName = preg_replace('#/+#', '/', $matches[2]);

// Load the database information:
$dbConfig = include __DIR__ . '/../../config/autoload/doctrine_orm.global.php';
$dbConfig = $dbConfig['doctrine']['connection']['orm_default']['params'];

// Create a database connection:
$connection = mysql_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password']);
if (!$connection) {
    echo 'Could not check permissions for this repository: ' . mysql_error();
    exit;
}

// Select the database or exit:
if (!mysql_select_db($dbConfig['dbname'], $connection)) {
    echo 'Could not check permissions for this repository: ' . mysql_error();
    mysql_close($connection);
    exit;
}

$neededPermissions = array('push');
if ($action == 'git-upload-pack') {
    $neededPermissions[] = 'pull';
}

$sql = "SELECT COUNT(rt.permission) AS amount
        FROM repository_team AS rt
        INNER JOIN repository AS r ON r.id = rt.repository_id
        INNER JOIN team_user AS tu ON tu.team_id = rt.team_id
        INNER JOIN project AS p ON p.id = r.project_id
        WHERE LOWER(p.name) = '" . mysql_real_escape_string($projectName) . "'
        AND LOWER(r.name) = '" . mysql_real_escape_string($repositoryName) . "'
        AND tu.user_id = " . $userId . "
        AND rt.permission = '" . implode("' OR rt.permission = '", $neededPermissions) . "'";
$rowset = mysql_query($sql, $connection);
if (!$rowset || mysql_num_rows($rowset) == 0) {
    echo 'You do not have permissions to access this repository.';
    mysql_close($connection);
    exit;
}

$row = mysql_fetch_object($rowset);
if ($row->amount == 0) {
    echo 'You do not have permissions to access this repository.';
    mysql_close($connection);
    exit;
}

// Prefix the repository with the correct path:
$repositoryPath = $homePath . '/data/projects/' . $projectName . '/repositories/' . $repositoryName;
if (is_dir($repositoryPath)) {
    echo $action . " '" . $repositoryPath . "'";
} else {
    echo 'The repository "' . $repositoryLine . '" does not exist.';
}

mysql_close($connection);
