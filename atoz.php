<?php
set_time_limit(120);
function get_whois_data($test_server, $test_domain) {
	$msg = [];
	$connection = fsockopen($test_server, 43, $errno, $errstr, 10);
	if (!$connection) {
		$msg = "Can't connect to the server!";
	} else {
		sleep(2);
		fwrite($connection, $test_domain."\r\n");
		while (!feof($connection)) {
			$msg[] = fgets($connection, 4096);
		}
		fclose($connection);
	}
	return $msg;
}
function excelColumnRange($lower, $upper) {
    ++$upper;
    for ($i = $lower; $i !== $upper; ++$i) {
        yield $i;
    }
}
if(isset($_GET['a'], $_GET['z'])){
	if(!is_numeric($_GET['a']) && !is_numeric($_GET['z'])){
		if(strlen($_GET['a'])<=3 && strlen($_GET['z'])<=3){
			foreach (excelColumnRange($_GET['a'], $_GET['z']) as $value) {
				$domen = $value.'.rs';
				$test = get_whois_data('whois.rnids.rs', $domen);
				if($test[0] === '%ERROR:103: Domain is not registered' ){
					echo $domen. '-Slobodan<br>';
			    }
			}
		}else{
			echo 'Za sada ne mozemo da Vam ponudimo vise od 3 karaktera.';
		}
	}else{
		echo 'Ukucan je broj u petlji.';
	}
}else{
	echo 'Ako ste ovde, onda znate kako se ovaj program koristi ;)<br>';
	echo 'Ali ako ne znate kako se koristi ovaj program idite na <a href="https://joker.rs">JOKER.RS</a><br>';
	echo 'If you are here, you know how to use this program ;)<br>';
	echo 'But if you don\'t know how to use this program, then go to <a href="https://joker.rs">JOKER.RS</a>';
}
echo '<br><br><br>';