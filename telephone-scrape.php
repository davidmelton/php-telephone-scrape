<?php
# Telephone Scrape Function
# author: David Melton
# web: davidmelton.me

// display errors:
// this is for debugging,
// remove from final script
error_reporting(E_ALL);
ini_set('display_errors', 1); 


function telephone_scrape($url){
	
	/* Check for cURL library
  	/* -------------------------------------------- */
	
	if (!function_exists('curl_init')){
		die('cURL is not installed. Install and try again.');
	}

	
	/* Initialize a cURL session
  	/* -------------------------------------------- */
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	// Store the retreived web page in $html var
	$html = curl_exec($ch);
	
	// close the session
	curl_close($ch);

	
	/* Find telephone numbers on the page
	/*
	/* Search $html for all matches to the
	/* regular expression. The pattern below
	/* will match phone numbers in the
	/* following formats:
	/*
	/* 800-555-1212
	/* (800) 555-1212
	/* (800)555-1212
	/* 800.555.1212
	/* 800 555-1212
  	/* -------------------------------------------- */
	
	
	// fyi: http://php.net/manual/en/function.preg-match-all.php
	preg_match_all('(\d{3}\-\d{3}\-\d{4}|\d{3}\.\d{3}\.\d{4}|\(\d{3}\)\d{3}\-\d{4}|\(\d{3}\)\s\d{3}\-\d{4}|\d{3}\s\d{3}\-\d{4})', $html, $numbers);
	
	// store matches from $html in $numbers array
	$numbers = $numbers[0];
	
	// change all the telephone numbers in the
	// $numbers array to a uniform format, in this
	// case "800-555-1212" (not required)
	foreach ($numbers as &$number){
	
		$patterns = array( '(', ') ', ' ', '.', ')' );
		$replacements = array( '', '-', '-', '-', '-' );
		$number = str_replace($patterns, $replacements, $number);
	}
	unset($number);
	
	// some pages might contain the same telephone
	// number more than once, this removes duplicate
	// numbers from the array (not required)
	$numbers = array_unique($numbers);
	
	// initialize the variable that will hold the
	// final output
	$output = '';

	// format the final output, in this case create
	// comma separated values (.csv) to import into an
	// Excel spreadsheet	
	foreach ($numbers as $number){

		$output .= "{$number}, {$url} \n";
	}
	
	// return the $output
	return $output;
}


/* Usage
/*
/* To collect phone numbers from a single web
/* page, pass a url directly to the
/* telephone_scrape() function
/*
/* example:
/* print telephone_scrape('http://www.example.com');
/*
/* To collect phone numbers from a list of web
/* pages, pass an array of URLs to telephone_scrape()
/*
/* example:
/* $urls = array(	'http://www.example.com/contact.html',
/*					'http://www.example.com/about.html',
/*					'http://www.example.com/blog.html'
/*					);
/*
/* foreach ($urls as $url){
/*		print telephone_scrape( $url );
/* }
/* -------------------------------------------------- */


// a live example to demonstrate
print '<pre>';
print  "Phone Number, URL \n";
print telephone_scrape('http://davidmelton.me/demos/telephone-numbers.html');
print '</pre>';
?>