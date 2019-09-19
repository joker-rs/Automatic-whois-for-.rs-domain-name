<?php

if(!isset($_GET['a'], $_GET['z'])) {
    echo '
    <form method="GET">
        <label for="a">Insert two letters (from where to start)</label>
        <input id="a" type="text" name="a"><br />
        <label for="z">Insert two letters (where to end)</label>
        <input id="z" type="text" name="z"><br />
        <button type="submit">Send</button>
    </form>';
    die();
}

if(is_numeric($_GET['a']) && is_numeric($_GET['z'])) {
    echo 'Ukucan je broj u petlji.';
}

if(strlen($_GET['a']) > 3 && strlen($_GET['z']) > 3) {
    echo 'Za sada ne mozemo da Vam ponudimo vise od 3 karaktera.';
}


/**
 * @param string $test_server
 * @param string $test_domain
 * @return array|string
 */
function get_whois_data(string $test_server,string  $test_domain)
{
    $msg = [];
    $connection = fsockopen($test_server, 43, $errno, $errstr, 10);
    if ( !$connection ) {
        return "Can't connect to the server!";
    }
    sleep(2);
    fwrite($connection, $test_domain . "\r\n");
    while (!feof($connection)) {
        $msg[] = fgets($connection, 4096);
    }
    fclose($connection);
    return $msg;
}


/**
 * @param string $lower
 * @param string $upper
 * @return Generator
 */
function excelColumnRange(string $lower,string  $upper)
{
    ++ $upper;
    for ($i = $lower; $i !== $upper; ++ $i) {
        yield $i;
    }
}


foreach (excelColumnRange($_GET['a'], $_GET['z']) as $value) {
    $domen = $value . '.rs';
    $test = get_whois_data('whois.rnids.rs', $domen);
    if ( $test[ 0 ] === '%ERROR:103: Domain is not registered' ) {
        echo $domen . ' -Slobodan<br>';
    }
}