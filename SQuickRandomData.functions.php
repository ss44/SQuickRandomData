<?php
/**
 * Convineience methods used to return random data.
 *
 * @author SSingh <ss@ss44.ca>
 */

namespace SQuick\RandomData;

$_cacheNames = array();
$_cacheAddress = array();
$_cacheCities = array();

function getFirstName(){
	global $_cacheNames;
	
	if ( empty( $_cacheNames ) )
		loadNames();
	
	$tmp = array_rand( $_cacheNames );
	
	return $_cacheNames[$key]['first_name'];
}


function getLastName(){
	global $_cacheNames;

	if ( empty( $_cacheNames ) )
		loadNames();

	$key = array_rand( $_cacheNames );
	
	return $_cacheNames[$key]['last_name'];
}

function getName(){
	global $_cacheNames;

	if ( empty( $_cacheNames ) )
		loadNames();

	$key = array_rand( $_cacheNames );
	return $_cacheNames[ $key ];
}

function getAddressLine1(){
	global $_cacheAddress;

	if ( empty( $_cacheAddress ) )
		loadAddresses();
	
	$key = array_rand( $_cacheAddress );
	$line = $_cacheAddress[ $key ];

	return mt_rand(1, 500) . ' ' . $line['street'];
}

function getAddressLine2(){	

	$prefix = array(
		'',
		'Suite',
		'Apt',
		'Unit',
	);

	$key = array_rand( $prefix );
	$pre = $prefix[ $key ];

	if ( $pre == ''){
		return '';
	}

	return $pre . ' ' . mt_rand(1, 1000);
}

function getDigits( $len ){
	$number = '';
 	for ( $x = 0; $x < $len; $x++ ){
 		$number .= (string) mt_rand(0, 9);
 	}
 	return $number;
}

function getPhoneNumber(){	
	$str = getRandomDigits(7);
	return substr($str, 0, 3) . '-' . substr($str, 3, 4);
}

function getZipCode(){
	getDigits(5);
}

function getPostalCode(){
	return strtoupper( randomChars(1, false).getDigits(1).randomChars(1, false).getDigits(1).randomChars(1, false).getDigits(1) );
}

function getCity(){
	global $_cacheCities;

	if ( empty($_cacheCities) )
		loadAddresses();

	$key = array_rand( $_cacheCities );
	return $_cacheCities[ $key ];
}


function loadNames(){
	global $_cacheNames;

	$fh = fopen(__DIR__.'/randomNames.csv', 'r');

	while( $row = fgetcsv( $fh ) ){
		$tmp = array();
		$tmp['first_name'] = $row[0];
		$tmp['last_name'] = $row[1];
		$tmp['initial'] = $row[2];

		$_cacheNames[] = $tmp;
	}
}

function loadAddresses(){
	global $_cacheAddress, $_cacheCities;
	
	$tmpCities = array();
	
	$fh = fopen(__DIR__.'/Addresses.tsv', 'r');

	while( $row = fgetcsv( $fh,0, "\t") ){
		$tmp = array();
		
		$tmp['street'] = $row[0];
		$tmp['city'] = $row[1];
		$_cacheAddress[] = $tmp;

		$tmpCities[ $tmp['city'] ] = 1;
	}

	$_cacheCities = array_keys( $tmpCities );

}