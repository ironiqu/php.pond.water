<?php
class SqlitePdo extends PDO {
	const MAIN_DATABESE = "db.sqlite";
	
	function __construct($filename) {
		parent::__construct ( "sqlite:" . "data/database/".$filename );
	}
	
	function existsTable($tablename){
		$exist = false;
		try {
			//is search
			$p = parent::prepare ( "select * from sqlite_master where tbl_name = :tbn" );
			$p->bindParam ( ":tbn", $tablename, PDO::PARAM_STR);
			$p->execute ();
			// is exist
			$c = count($p->fetchAll());
			if($c == 1){
				$exist = true;
			}
		} catch ( PDOException $e ) {
			echo "問い合わせが失敗しました。管理者に問い合わせてください。";
		}
		return $exist;
	}
}
?>