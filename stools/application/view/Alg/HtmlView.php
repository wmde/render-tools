<?php
class Alg_HtmlView extends View {
	
	public function __construct( $templateName ) {
		parent::__construct( $templateName );
	}

	public function getFlaws() {
		return SingletonFactory::getInstance( 'Alg_Model' )->getFlawList();
	}

	public function parseFlawsFromQueryString() {
		$flaws = array();
		if( isset( $_GET['flaws'] ) ) {
			$flaws = explode( ' ', urldecode( $_GET['flaws'] ) );
		}
		return $flaws;
	}
	
	public function getResults() {
		return SingletonFactory::getInstance( 'Alg_Model' )->query();
	}
}
