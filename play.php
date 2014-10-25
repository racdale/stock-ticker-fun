<?php

date_default_timezone_set('UTC');
$y1 = 2012;
$y2 = 2014;
$m = date("n")-1; # Yahoo ichart requires month - 1
$d = date("d"); # fields spec'ed here:
# http://stackoverflow.com/questions/754593/source-of-historical-stock-data

# get this on nasdaq's FTP: ftp://ftp.nasdaqtrader.com/SymbolDirectory/
$tickers = explode("\n",file_get_contents("nasdaqlisted.txt"));

foreach ($tickers as $tick) {
	$s = explode("|",$tick)[0];
	$symb = preg_match('/^[A-Z]+\b/',$s)*preg_match('/Common Stock/',$tick);
	if ($symb==1) {
		echo $s."\n";
		# returns in CSV format
		$dt = file_get_contents("http://ichart.finance.yahoo.com/table.csv?s=$s&d=$m&e=$d&f=$y2&g=d&a=$m&b=$d&c=$y1&ignore=.csv");	
		$fo = fopen("stocks/".$s.".dat","w");
		fprintf($fo,"%s",$dt);
		fclose($fo);
		sleep(rand(1,5)/10); # just in case
	}
}

?>

