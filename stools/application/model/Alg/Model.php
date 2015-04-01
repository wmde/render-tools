<?php
class Alg_Model extends Model {
	private $_serviceUrl;
	
	public function __construct() {
		$this->_serviceUrl = ALG_SERVICE_URL_INTERNAL;
	}
	
	public function getFlawList() {
		$url = ALG_SERVICE_URL_INTERNAL . "/tlgwsgi.py";
		$url .= "?action=listflaws&i18n=" . $_SESSION['uilang'];

		$options  = array( 'http' => array( 'user_agent' => 'RENDER Article List Generator' ) );
		$context  = stream_context_create( $options );

		$result = @file_get_contents( $url, false, $context );
		
		if ( $result ) {
			$arrJson = json_decode( $result, true );
			$arrFlaws = array();
			foreach($arrJson as $flaw => $info) {
				$group = isset($info["group"]) ? $info["group"] : "nogroup";

				$arrFlaws[$info["group"]][$flaw] = array(
					"label" => $info["label"],
					"description" => $info["description"]
				);
			}
			return $arrFlaws;
		}
		
		return array();
	}
	
	public function getGraphList() {
		if( !defined( 'ALG_HOST_MAPPING_URL' ) ) {
			return array();
		}

		$hostmap = file_get_contents( ALG_HOST_MAPPING_URL );
		$hosts = str_replace(
			array( "wiki", "_ns14" ),
			array( "", "" ),
			array_keys( json_decode( $hostmap, true ) ) );
		sort( $hosts );
		
		return array_unique( $hosts );
	}
}
