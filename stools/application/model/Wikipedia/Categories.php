<?php
class Wikipedia_Categories extends Model {

	public function __construct() { }
	
	public function getCategoryNames( $term ) {
		$response = array();
		$term = rawurldecode( $term );
		if ( $term ) {
			$prepend = "";
			if ( $term[0] === "+" || $term[0] === "-" ) {
				$prepend = $term[0];
				$term = substr( $term, 1 );
			}
			$term = str_replace( " ", "_", $term );

			$dbConn = SingletonFactory::getInstance( 'Database' )
				->getDbConnection( SingletonFactory::getInstance( 'Request' )->getVar( 'lang' ) . 'wiki' );
		
			$sql = "SELECT cat_title, (cat_subcats + cat_pages) AS subcount ".
					"FROM category ".
					"INNER JOIN page ON page_title = cat_title AND page_namespace = 14 ".
					"WHERE CONVERT(cat_title USING latin1) LIKE ? ".
					"ORDER BY subcount DESC ".
					"LIMIT 10";
			$statement = $dbConn->prepare( $sql );
			$statement->execute( array( $term . "%" ) );

			$result = $statement->fetchAll();
			foreach( $result as $row ) {
				$catTitle = $prepend . str_replace( "_", " ", $row["cat_title"] );
				$response[] = array( "label" => $catTitle, "value" => $catTitle );
			}
			return $response;
		} else {
			return array();
		}
	}
}
