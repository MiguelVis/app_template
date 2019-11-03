<?php

	// -------------------
	// MySqlDataBase Class
	// -------------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	// Revisions:
	
	// 23 Sep 2017 : mgl : Start.

	/**
	 * MySQLDataBase Class.
	 *
	 * Uses the standard MYSQLI extension for PHP.
	 */
	class MySqlDataBase {
		private $p_server    = null;
		private $p_user      = null;
		private $p_password  = null;
		private $p_schema    = null;
		private $p_link      = null;
		
		/**
		 * Constructor.
		 */
		public function __construct($server, $user, $password, $schema) {
			
			// Assign DB values
			$this -> p_server = $server;
			$this -> p_user = $user;
			$this -> p_password = $password;
			$this -> p_schema = $schema;
		}
		
		/**
		 * Destructor.
		 */
		public function __destruct() {
			
			// Disconnect DB if needed
			if($this -> p_link !== null) {
				$this -> disconnect();
			}
		}
		
		/**
		 * Connect DB.
		 *
		 * @return true on success, else false
		 */
		public function connect() {
			
			// Connect if needed
			if($this -> p_link === null) {
				
				// Connect DB
				$rt = mysqli_connect($this -> p_server, $this -> p_user, $this -> p_password, $this -> p_schema);

				// Normalize result
				$this -> p_link = (($rt !== false && $rt !== null) ? $rt : null);
				
				// Select DB -- FIXME -- really needed?
				////if($this -> p_link !== null && $this -> p_schema !== null) {
				////	
				////	$this -> setQuery('use `' . $this -> p_schema . '`;');
				////}
			}

			// Return success or failure
			return $this -> p_link !== null;
		}
		
		/**
		 * Disconnect DB.
		 */
		public function disconnect() {
			
			// Disconnect if connected
			if($this -> p_link !== null) {
				
				mysqli_close($this -> p_link);
			}
		}
		
		/**
		 * General query operation.
		 *
		 * @param  $sql query
		 * @return result on success, else null
		 */
		public function query($sql) {
			// Continue if DB is connected
			if($this -> p_link !== null) {
		
				// Execute query
				$qr = mysqli_query($this -> p_link, $sql);

				if($qr !== false) {
					// Success
					return $qr;
				}
			}
			
			// Failure
			return null;
		}
		
		/**
		 * General GET query.
		 *
		 * @param  $sql query
		 * @return result array on success, else null
		 */
		public function getQuery($sql) {
			
			// Execute query
			$qr = $this -> query($sql);

			if($qr !== null) {
				
				// Build array to return
				$rt = array();

				while(($row = mysqli_fetch_assoc($qr))) {
					
					$rt[] = $row;
				}
				
				// Success
				return $rt;
			}
			
			// Failure
			return null;
		}
		
		/**
		 * General SET query.
		 *
		 * @param  $sql query
		 * @return number of affected rows on success, else -1
		 */
		public function setQuery($sql) {
			
			// Execute query
			$qr = $this -> query($sql);
			
			if($qr !== null) {
				
				// Success
				return  mysqli_affected_rows($this -> p_link);
			}
			
			// Failure
			return -1;
		}
		
		/**
		 * Return the number of affected rows in last query.
		 *
		 * @return number of affected rows on success, else -1
		 */
		public function getAffectedRows() {
			
			// Continue if DB is connected
			if($this -> p_link !== null) {
				
				// Success
				return mysqli_affected_rows($this -> p_link);
			}
			
			// Failure
			return -1;
		}
		
		/**
		 * Return the column id of last insert query.
		 *
		 * @return id on success, else -1
		 */
		public function getLastInsertId() {
			
			// Continue if DB is connected
			if($this -> p_link !== null) {
				
				// Success
				return mysqli_insert_id($this -> p_link);
			}
			
			// Failure
			return -1;
		}
		
		/**
		 * Escape string for use in a query.
		 *
		 * @param  str string
		 * @result escaped string on success, else same string
		 */
		public function escapeString($str) {
			
			// Continue if DB is connected
			if($this -> p_link !== null) {
				
				// Success
				return mysqli_escape_string($this -> p_link, $str);
			}
			
			// Failure
			return $str;
		}
		
		// -----------------------
		// Specialized GET queries
		// -----------------------
		
		/**
		 * Return the number of columns which have a column with a value.
		 *
		 * ie - select count(*) from `users` where `name` = "John";
		 *
		 * @param  table
		 * @param  whatColumn
		 * @param  whatValue
		 * @return number of columns on success, else -1
		 */
		public function countQueryByColumn($table, $whatColumn, $whatValue) {
			
			// Build query -- TODO -- accept null in whatValue
			$sql = 'select count(*) as c from `' . $table . '` where `' . $whatColumn . '` = "' . $this -> escapeString($whatValue) . '";';
			
			// Execute query
			$qr = $this -> getQuery($sql);
			
			if($qr !== null && count($qr) > 0) {
				
				// Success
				return $qr[0]['c'];
			}
			
			// Failure
			return -1;
		}
		
		public function countQuery($table) {
			
			// Build query
			$sql = 'select count(*) as c from `' . $table . '`;';
			
			// Execute query
			$qr = $this -> getQuery($sql);
			
			if($qr !== null && count($qr) > 0) {
				
				// Success
				return $qr[0]['c'];
			}
			
			// Failure
			return -1;
		}
		
		/**
		 * Return array of rows with columns values.
		 *
		 * ie - select name from `users`;
		 * ie - select name, phone from `users`;
		 * ie - select * from `users`;
		 *
		 * @param  table
		 * @param  columns  null for all columns, string for a column, array of strings for one of more columns
		 * @return array of rows, or null on failure
		 */
		public function selectQuery($table, $columns = null) {
			
			// Continue if parameters are OK
			if(isset($table) && ($columns === null || is_string($columns) || (is_array($columns) && count($columns) > 0))) {
				
				// Build query
				$sql = 'select ';
				
				// What columns?
				if(is_string($columns)) {
					
					// A column
					$sql .= '`' . $columns . '`';
				}
				else if(is_array($columns)) {
					
					// One or more columns
					for($i = 0; $i < count($columns); ++$i) {
						$sql .= '`' . $columns[$i] . '`';
						
						if($i < count($columns) - 1) {
							$sql .= ',';
						}
					}
				}
				else {
					
					// All columns
					$sql .= '*';
				}
				
				//
				$sql .= ' from `' . $table . '`;';
				
				// Execute query and return result
				return $this -> getQuery($sql);
			}

			// Failure
			return null;			
		}
		
		/**
		 * Return array of rows with columns values which have a column with a value.
		 *
		 * ie - select address from `users` where `name` = "John";
		 * ie - select address, phone from `users` where `name` = "John";
		 * ie - select * from `users` where `name` = "John";
		 *
		 * @param  table
		 * @param  columns     null for all columns, string for a column, array of strings for one of more columns
		 * @param  whatColumn
		 * @param  whatValue
		 * @return array of rows, or null on failure
		 */
		public function selectQueryByColumn($table, $columns = null, $whatColumn, $whatValue) {
			
			// Continue if parameters are OK -- TODO -- accept null in whatValue
			if(isset($table) && ($columns === null || is_string($columns) || (is_array($columns) && count($columns) > 0)) && isset($whatColumn) && isset($whatValue)) {
				
				// Build query
				$sql = 'select ';
				
				// What columns?
				if(is_string($columns)) {
					
					// A column
					$sql .= '`' . $columns . '`';
				}
				else if(is_array($columns)) {
					
					// One or more columns
					for($i = 0; $i < count($columns); ++$i) {
						$sql .= '`' . $columns[$i] . '`';
						
						if($i < count($columns) - 1) {
							$sql .= ',';
						}
					}
				}
				else {
					
					// All columns
					$sql .= '*';
				}
				
				//
				$sql .= ' from `' . $table . '`';
				
				//
				$sql .= ' where `' . $whatColumn . '` = "' . $this -> escapeString($whatValue) . '";';
				
				// Execute query and return result
				return $this -> getQuery($sql);
			}

			// Failure
			return null;			
		}
		
		// -----------------------
		// Specialized SET queries
		// -----------------------
		
		/**
		 * Insert a row in a table.
		 *
		 * ie - insert into `users` (`username`, `password`) values ("john", "ohohoh!");
		 *
		 * @param  table
		 * @param  values  array of key => value pairs ; value can be null
		 * @return number of inserted rows on success, else -1
		 */
		public function insertQuery($table, $values) {
		
			// Continue if parameters are OK
			if(isset($table) && is_array($values) && count($values) > 0) {
				
				// Build query
				$sql = 'insert into `' . $table . '` (';
				
				// Get column names and values.
				$colNames = '';
				$colValues = '';
				$i = 1;
				
				foreach($values as $k => $v) {
					$colNames .= '`' . $k . '`';
					
					if($v !== null) {
						$colValues .= '"' . $this -> escapeString($v) . '"';
					}
					else {
						$colValues .= 'null';
					}
					
					if($i++ < count($values)) {
						$colNames .= ', ';
						$colValues .= ', ';
					}
				}
				
				$sql .= $colNames . ') values (' . $colValues . ');';
			
				// Execute query and return result
				return $this -> setQuery($sql);
			}
			
			// Failure
			return -1;
		}
		
		/**
		 * Update rows which have a column with a value.
		 *
		 * ie - update `users` set username = "johnny" where `name` = "John";
		 * ie - update `users` set username = "johnny", password = "hahaha!" where `name` = "John";
		 *
		 * @param  table
		 * @param  values  array of key => value pairs ; value can be null
		 * @param  whatColumn
		 * @param  whatValue
		 * @return number of updated rows on success, else -1
		 */
		public function updateQueryByColumn($table, $values, $whatColumn, $whatValue) {
			
			// Continue if parameters are OK -- TODO -- accept null in whatValue
			if(isset($table) && is_array($values) && count($values) > 0 && isset($whatColumn) && isset($whatValue)) {
				
				// Build query
				$sql = 'update `' . $table . '` set ';
				
				$i = 1;
				
				foreach($values as $k => $v) {
					
					if($v !== null) {
						$sql .= '`' . $k . '` = "' . $this -> escapeString($v) . '"';
					}
					else {
						$sql .= '`' . $k . '` = null';
					}
					
					if($i++ < count($values)) {
						$sql .= ', ';
					}
				}
				
				//
				$sql .= ' where `' . $whatColumn . '` = "' . $this -> escapeString($whatValue) . '";';
				
				// Execute query and return result
				return $this -> setQuery($sql);
			}
			
			// Failure
			return -1;
		}
		
		/**
		 * Delete rows which have a column with a value.
		 *
		 * ie - update `users` set username = "johnny" where `name` = "John";
		 * ie - update `users` set username = "johnny", password = "hahaha!" where `name` = "John";
		 *
		 * @param  table
		 * @param  values  array of key => value pairs ; value can be null
		 * @param  whatColumn
		 * @param  whatValue
		 * @return number of updated rows on success, else -1
		 */
		public function deleteQueryByColumn($table, $whatColumn, $whatValue) {
			
			// Continue if parameters are OK -- TODO -- accept null in whatValue
			if(isset($table) && isset($whatColumn) && isset($whatValue)) {
				
				// Build query
				$sql = 'delete from `' . $table . '` where `' . $whatColumn . '` = "' . $this -> escapeString($whatValue) . '";';
			
				// Execute query and return result
				return $this -> setQuery($sql);				
			}
			
			// Failure
			return -1;
		}
	}
	
?>