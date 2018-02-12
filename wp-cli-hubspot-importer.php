<?php

/*
CLI Script Name: Hubspot data importer.
Version: 1.0
Description: Basic data to HubSpot from WordPress
Author: Maxim Semenov/Zeeland Family
Author URI: http://zeelandfamily.fi/
*/


if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'hubspot-importer', 'HubSpot_Importer_CLI' );
}

class HubSpot_Importer_CLI extends WP_CLI_Command {

	public function import( $args, $assoc_args ) {

		$data = array(
			array(
				'name'        => 'Shop1',
				'storeid'     => '1637091963799',
				'address'     => 'Uusitie 1',
				'postal_area' => 'Helsinki',
				'postal_code' => '00100',
				'lat'         => '-18.70916',
				'long'        => '-130.56497',
			),
			array(
				'name'        => 'Shop2',
				'storeid'     => '1606052245099',
				'address'     => 'Uusitie 2',
				'postal_area' => 'Vantaa',
				'postal_code' => '00200',
				'lat'         => '-26.04642',
				'long'        => '-18.48694',
			),
			array(
				'name'        => 'Shop3',
				'storeid'     => '1677051529299',
				'address'     => 'Uusitie 3',
				'postal_area' => 'Espoo',
				'postal_code' => '02650',
				'lat'         => '75.1002',
				'long'        => '-95.72092',
			),
		);

		//WP_CLI::log( print_r( $data, true ) );

		foreach ( $data as $item ) {

			//WP_CLI::log( print_r( $item, true ) );

			$hubspot_request_data = array(
				'values' => array(
					'1'  => $item['name'],
					'2'  => $item['storeid'],
					'3'  => $item['address'],
					'4'  => $item['postal_area'],
					'5'  => $item['postal_code'],
					'6'  => array(
						'lat'  => $item['lat'],
						'long' => $item['long'],
						'type' => 'location',
					),

				),
			);

			$json = wp_json_encode( $hubspot_request_data, JSON_PRETTY_PRINT );

			//WP_CLI::log( print_r($json, true) );

			$huburl = 'https://api.hubapi.com/hubdb/api/v1/tables/YOURTABLEID/rows?hapikey=YOURHUBSPOTAPIKEY';

			$response = wp_remote_post( $huburl, [
				'body' => $json,
				'headers' => [
					'Content-Type' => 'application/json',
				],
			] );
		}

		WP_CLI::success( 'Import complete.' );
	}

}
