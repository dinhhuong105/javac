<?php
/**
 * @param Amazonjs $amazonjs
 */
function amazonjs_aws_params( Amazonjs $amazonjs ) {
	$amazonjs->search_indexes = array(
		'All'                 => array(
			'CA'    => true,
			'CN'    => true,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'All', $amazonjs->text_domain ),
		),
		'Apparel'             => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Apparel', $amazonjs->text_domain ),
		),
		'Appliances'          => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => true,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'Appliances', $amazonjs->text_domain ),
		),
		'ArtsAndCrafts'       => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'ArtsAndCrafts', $amazonjs->text_domain ),
		),
		'Automotive'          => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Automotive', $amazonjs->text_domain ),
		),
		'Baby'                => array(
			'CA'    => true,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Baby', $amazonjs->text_domain ),
		),
		'Beauty'              => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Beauty', $amazonjs->text_domain ),
		),
		'Blended'             => array(
			'CA'    => true,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Blended', $amazonjs->text_domain ),
		),
		'Books'               => array(
			'CA'    => true,
			'CN'    => true,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Books', $amazonjs->text_domain ),
		),
		'Classical'           => array(
			'CA'    => true,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Classical', $amazonjs->text_domain ),
		),
		'DigitalMusic'        => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'DigitalMusic', $amazonjs->text_domain ),
		),
		'DVD'                 => array(
			'CA'    => true,
			'CN'    => false,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'DVD', $amazonjs->text_domain ),
		),
		'Electronics'         => array(
			'CA'    => true,
			'CN'    => true,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Electronics', $amazonjs->text_domain ),
		),
		'ForeignBooks'        => array(
			'CA'    => true,
			'CN'    => false,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => false,
			'US'    => false,
			'label' => __( 'ForeignBooks', $amazonjs->text_domain ),
		),
		'Garden'              => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => true,
			'JP'    => false,
			'UK'    => false,
			'US'    => false,
			'label' => __( 'Garden', $amazonjs->text_domain ),
		),
		'GourmetFood'         => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'GourmetFood', $amazonjs->text_domain ),
		),
		'Grocery'             => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Grocery', $amazonjs->text_domain ),
		),
		'HealthPersonalCare'  => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'HealthPersonalCare', $amazonjs->text_domain ),
		),
		'Hobbies'             => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => true,
			'UK'    => false,
			'US'    => false,
			'label' => __( 'Hobbies', $amazonjs->text_domain ),
		),
		'Home'                => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => false,
			'label' => __( 'Home', $amazonjs->text_domain ),
		),
		'HomeGarden'          => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'HomeGarden', $amazonjs->text_domain ),
		),
		'HomeImprovement'     => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => false,
			'label' => __( 'HomeImprovement', $amazonjs->text_domain ),
		),
		'Industrial'          => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'Industrial', $amazonjs->text_domain ),
		),
		'Jewelry'             => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Jewelry', $amazonjs->text_domain ),
		),
		'KindleStore'         => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true, // fixed
			'UK'    => true,
			'US'    => true,
			'label' => __( 'KindleStore', $amazonjs->text_domain ),
		),
		'Kitchen'             => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Kitchen', $amazonjs->text_domain ),
		),
		'LawnAndGarden'       => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'LawnAndGarden', $amazonjs->text_domain ),
		),
		'Lighting'            => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => true,
			'JP'    => false,
			'UK'    => true,
			'US'    => false,
			'label' => __( 'Lighting', $amazonjs->text_domain ),
		),
		'Magazines'           => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'Magazines', $amazonjs->text_domain ),
		),
		'Marketplace'         => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Marketplace', $amazonjs->text_domain ),
		),
		'Miscellaneous'       => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => true,
			'US'    => false,
			'label' => __( 'Miscellaneous', $amazonjs->text_domain ),
		),
		'MobileApps'          => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'MobileApps', $amazonjs->text_domain ),
		),
		'MP3Downloads'        => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'MP3Downloads', $amazonjs->text_domain ),
		),
		'Music'               => array(
			'CA'    => true,
			'CN'    => true,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Music', $amazonjs->text_domain ),
		),
		'MusicalInstruments'  => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'MusicalInstruments', $amazonjs->text_domain ),
		),
		'MusicTracks'         => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'MusicTracks', $amazonjs->text_domain ),
		),
		'OfficeProducts'      => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'OfficeProducts', $amazonjs->text_domain ),
		),
		'OutdoorLiving'       => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'OutdoorLiving', $amazonjs->text_domain ),
		),
		'Outlet'              => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => true,
			'US'    => false,
			'label' => __( 'Outlet', $amazonjs->text_domain ),
		),
		'PCHardware'          => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => false,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'PCHardware', $amazonjs->text_domain ),
		),
		'PetSupplies'         => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'PetSupplies', $amazonjs->text_domain ),
		),
		'Photo'               => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'Photo', $amazonjs->text_domain ),
		),
		'Shoes'               => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Shoes', $amazonjs->text_domain ),
		),
		'Software'            => array(
			'CA'    => true,
			'CN'    => true,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Software', $amazonjs->text_domain ),
		),
		'SoftwareVideoGames'  => array(
			'CA'    => true,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => false,
			'UK'    => true,
			'US'    => false,
			'label' => __( 'SoftwareVideoGames', $amazonjs->text_domain ),
		),
		'SportingGoods'       => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'SportingGoods', $amazonjs->text_domain ),
		),
		'Tools'               => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Tools', $amazonjs->text_domain ),
		),
		'Toys'                => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Toys', $amazonjs->text_domain ),
		),
		'UnboxVideo'          => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'UnboxVideo', $amazonjs->text_domain ),
		),
		'VHS'                 => array(
			'CA'    => true,
			'CN'    => false,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'VHS', $amazonjs->text_domain ),
		),
		'Video'               => array(
			'CA'    => true,
			'CN'    => true,
			'DE'    => true,
			'ES'    => false,
			'FR'    => true,
			'IT'    => false,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Video', $amazonjs->text_domain ),
		),
		'VideoGames'          => array(
			'CA'    => true,
			'CN'    => true,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => true,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'VideoGames', $amazonjs->text_domain ),
		),
		'Watches'             => array(
			'CA'    => false,
			'CN'    => true,
			'DE'    => true,
			'ES'    => true,
			'FR'    => true,
			'IT'    => true,
			'JP'    => false,
			'UK'    => true,
			'US'    => true,
			'label' => __( 'Watches', $amazonjs->text_domain ),
		),
		'Wireless'            => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'Wireless', $amazonjs->text_domain ),
		),
		'WirelessAccessories' => array(
			'CA'    => false,
			'CN'    => false,
			'DE'    => false,
			'ES'    => false,
			'FR'    => false,
			'IT'    => false,
			'JP'    => false,
			'UK'    => false,
			'US'    => true,
			'label' => __( 'WirelessAccessories', $amazonjs->text_domain ),
		),
	);
}
