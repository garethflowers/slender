<?php

/**
 * MySQL Database Connection
 * @author garethflowers
 */
class MySqlDb implements IDbConnection
{


	/**
	 * @var resource
	 */
	private static $connection;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $server;

	/**
	 * @var string
	 */
	private $database;


	private function __construct()
	{
		$this->server = Config::$database_server;
		$this->database = Config::$database_name;
		$htis->username = Config::$database_username;
		$this->password = Config::$database_password;
	}


	/**
	 * Get the current connection
	 * @return MySqlDb
	 */
	public static function connection()
	{
		if ( !isset( self::$connection ) )
		{
			$class = __CLASS__;
			self::$connection = new $class();
		}

		return self::$connection;
	}


	/**
	 * Format string
	 * @param mixed $value
	 */
	public static function FormatStr( $value )
	{
		if ( empty( $value ) )
		{
			return '';
		}

		return "'" . mysql_escape_string( utf8_encode( trim( $value ) ) ) . "'";
	}


	public static function FormatInt( $value )
	{
		if ( !is_numeric( $value ) )
		{
			return 'NULL';
		}

		return strval( intval( $value ) );
	}


	public static function FormatFloat( $value )
	{
		if ( !is_numeric( $value ) )
		{
			return 'NULL';
		}

		return strval( floatval( $value ) );
	}


	public static function FormatDate( $value )
	{
		if ( !empty( $value ) && count( explode( '-', $value ) ) == 3 )
		{
			return vsprintf( '\'%04d-%02d-%02d\'', array_reverse( explode( '-', $value ) ) );
		}
		else
		{
			return 'NULL';
		}
	}


	public static function FormatTimestamp( $value )
	{
		return!empty( $value ) && $value != '--' ? '\'' . $value . '\'' : 'null';
	}


	/**
	 * returns a boolean database value
	 * @param mixed $value
	 * @return string
	 */
	public static function formatBool( $value )
	{
		if ( !is_bool( $value ) )
		{
			return 'NULL';
		}

		if ( (bool) $value )
		{
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		}
	}


	/**
	 * returns a picture database value
	 * @param mixed $value
	 * @return string
	 */
	public static function formatPicture( $value )
	{
		return!empty( $value ) ? '\'' . chunk_split( base64_encode( $value ) ) . '\'' : 'null';
	}


	/**
	 * connect to a database
	 */
	private function Connect()
	{
		return mysql_connect( $this->server, $this->username, $this->password );
	}


	/**
	 * execute a database query and return the result
	 * @param string $query
	 * @return boolean
	 */
	public function execQuery( $query )
	{
		$conn = $this->Connect();

		if ( !$conn )
		{
			return NULL;
		}

		mysql_select_db( $this->database );

		$result = mysql_query( $query, $conn );

		if ( !$result )
		{
			return NULL;
		}

		mysql_close( $conn );

		return $result;
	}


	/**
	 * execute a query and return any rows
	 * @param string $query
	 * @return mixed[]
	 */
	public function getData( $query )
	{
		$conn = $this->Connect();

		if ( !$conn )
		{
			return NULL;
		}

		mysql_select_db( $this->database );

		$result = mysql_query( $query, $conn );

		if ( !$result )
		{
			return NULL;
		}

		$data = array( );

		while ( $row = mysql_fetch_assoc( $result ) )
		{
			$data[] = $row;
		}

		mysql_close( $conn );

		return $data;
	}

}
