<?php
function current_url($script_only=false)
{
    $protocol = 'http';
    $port = ':'.$_SERVER["SERVER_PORT"];
    if (isset($_SERVER["HTTPS"])) {
        if ($_SERVER["HTTPS"] == 'on') {
            $protocol .= 's';
        }
    }
    if ($protocol == 'http' && $port == ':80') {
        $port = '';
    }
    if ($protocol == 'https' && $port == ':443') {
        $port = '';
    }
    // using strtok($_SERVER["REQUEST_URI"],'?') to remove querystring
    // from https://stackoverflow.com/questions/6969645/how-to-remove-the-querystring-and-get-only-the-url
    $path = $script_only ? $_SERVER['SCRIPT_NAME'] : strtok($_SERVER["REQUEST_URI"],'?');
    return "$protocol://$_SERVER[SERVER_NAME]$port$path";
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function debug_to_console($data, $logToFile=true)
{
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);
    }
    if ($logToFile) {
        writeToLog($output);
    }
    echo "<script>console.log( 'Debug Objects: " . date('H:i:s'). " " . $output . "' );</script>".PHP_EOL;
}

function writeToLog($txt)
{
    file_put_contents('log.txt', date('Y-m-d H:i:s'). "\t" .$txt.PHP_EOL, FILE_APPEND | LOCK_EX);
}
