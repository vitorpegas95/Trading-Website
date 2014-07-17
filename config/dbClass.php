    <?php
    /**
     * Database abstraction class.
     */
    class Database
    {
       
        public $conn = NULL;
        public $error = NULL;
        public $lastQuery = "";

        public static function microtime_float ()
        {
            list ($usec, $sec) = explode(" ", microtime());
            return ((float) $usec + (float) $sec);
        }

        /**
         * Opens a new database connection using the MySQLi library
         *
         * @param $host string
         *            database hostname
         * @param $username string
         *            database username
         * @param $password string
         *            database password
         * @param $dbname string
         *            database schema name
         */
        function Database ($host, $username, $password, $dbname)
        {
            $_SESSION["profiler_db"] = array();
           
            try
            {
                $errLevel = error_reporting();
                error_reporting(0);
                $this->conn = new mysqli($host, $username, $password, $dbname);
                error_reporting($errLevel);
                if (mysqli_connect_errno() != 0)
                    $this->error = "Cannot connect";
                if ($this->conn->connect_error != null)
                    $this->error = $this->conn->connect_error;
            }
            catch (Exception $ex)
            {
                $this->error = "Cannot connect";
            }
        }

        /**
         * Closes the connection.
         */
        function Close ()
        {
            if ($this->conn == null)
                return;
            $this->conn->Close();
            $this->conn = NULL;
        }

        /**
         * Loads the first row of a query into an array with the keys being the
         * columns names.
         * The query is then closed.
         *
         * @param $args mixed
         *            if a single sql statement is passed, then it is directly
         *            executed otherwise bind the ? with the parameters.
         * @return array an array containing the first row.
         */
        function LoadData ()
        {
            $return = array();
           
            $vars = func_get_args();
           
            if (count($vars) == 1)
                $result = $this->Execute($vars[0]);
            else
            {
                $query = array_shift($vars);
                $result = $this->Execute($query, $vars);
            }
           
            $fields = $result->FetchFields();
            for ($i = 0; $i < count($fields); $i ++)
            {
                if ($result->EOF)
                    $return[$fields[$i]->name] = NULL;
                else
                    $return[$fields[$i]->name] = $result->fields[$i];
            }
            $result->Close();
           
            return $return;
        }

        /**
         * Loads the whole result into an array.
         * The query is then closed.
         *
         * @param $args mixed
         *            if a single sql statement is passed, then it is directly
         *            executed otherwise bind the ? with the parameters.
         * @return array an array containing all the rows.
         */
        function LoadArray ()
		{
			$return = array();
		   
			$vars = func_get_args();
		   
			if (count($vars) == 1)
				$result = $this->Execute($vars[0]);
			else
			{
				$query = array_shift($vars);
				$result = $this->Execute($query, $vars);
			}
		   
			foreach ($result as $row)
				$return[] = $row;
			$result->Close();
		   
			return $return;
		}

        /**
         * Execute an SQL statement
         *
         * @param $args mixed
         *            if a single sql statement is passed, then it is directly
         *            executed otherwise bind the ? with the parameters.
         * @throws Exception
         * @return mixed for selects returns the result set. Otherwise returns true
         *         if ran successufly or false if not.
         */
        function Execute ()
        {
            global $demoEngine;
           
            $numargs = func_num_args();
            $query = func_get_arg(0);
           
            $this->lastQuery = $query;
           
            if (isset($demoEngine) && $demoEngine === TRUE)
            {
                list ($cmd, ) = explode(" ", strtolower($query));
                if ($cmd != "select" && $cmd != "show")
                {
                    return null;
                }
            }
           
            $time_start = Database::microtime_float();
           
            $res = new resultset($this->conn);
            if ($numargs > 1)
            {
                $res->Prepare($query);
                $vars = func_get_args();
                array_shift($vars);
               
                if (is_array($vars[0]))
                    $vars = $vars[0];
               
                $format = "";
                foreach ($vars as $v)
                {
                    if (is_string($v))
                        $format .= "s";
                    else if (is_int($v))
                        $format .= "i";
                    else if (is_float($v))
                        $format .= "d";
                    else if ($v == NULL)
                        $format .= "s";
                    else
                    {
                        var_dump($v);
                        throw new Exception("Type of variables not supported.");
                    }
                }
               
                array_unshift($vars, $format);
               
                $res->Bind($vars);
                $result = $res->ExecStatement();
            }
            else
                $result = $res->Exec($query);
            $this->error = $this->conn->connect_error;
           
            if (isset($_SESSION["profiler"]))
            {
                $time_end = Database::microtime_float();
                $_SESSION["profiler_db"][] = array("query" => $query, "time" => ($time_end - $time_start));
            }
           
            return $result;
        }

        /**
         * Returns the id of the last insterted row (auto_increment value)
         *
         * @return integer last id inserted in the database
         */
        function LastId ()
        {
            return $this->conn->insert_id;
        }
    }

    /**
     * Multi access the data either as column pos, or name or like an object.
     * Supports even the iteration of the array.
     * Lazy loading of the column names (for speed optimization)
     */

    class ResultRow extends ArrayObject
    {
        public $data;
        public $lookupNames = null;
        private $isInit = false;
        private $resultSet;

        public function __construct ($data, $resultSet)
        {
            $this->data = $data;
            $this->resultSet = $resultSet;
        }

        public function getIterator ()
        {
            if ($this->lookupNames == null)
                $this->lookupNames = $this->resultSet->getColumnsNames();
            return new ResultRowIterator($this);
        }

        public function offsetGet ($index)
        {
            if (is_int($index))
            {
                return $this->data[$index];
            }
            else
            {
                if ($this->lookupNames == null)
                    $this->lookupNames = $this->resultSet->getColumnsNames();
                return $this->data[$this->lookupNames[$index]];
            }
        }

        public function offsetExists ($index)
        {
            if (is_int($index))
            {
                if ($index >= 0 && $index < count($data))
                    return true;
                return false;
            }
            else
            {
                if ($this->lookupNames == null)
                    $this->lookupNames = $this->resultSet->getColumnsNames();
                return array_key_exists($index, $this->lookupNames);
            }
        }

        public function __get ($name)
        {
            if ($this->lookupNames == null)
                $this->lookupNames = $this->resultSet->getColumnsNames();
            return $this->data[$this->lookupNames[$name]];
        }
    }

    /**
     * Iterate inside the ResultRow
     *
     * @author bertrand
     */
    class ResultRowIterator implements Iterator
    {
        private $resultRow;
        private $position = 0;
        private $names;

        public function __construct ($resultRow)
        {
            $this->resultRow = $resultRow;
            $this->names = array();
            foreach ($resultRow->lookupNames as $k => $v)
            {
                $this->names[] = $k;
            }
        }

        function rewind ()
        {
            $this->position = 0;
        }

        function current ()
        {
            return $this->resultRow->data[$this->position];
        }

        function next ()
        {
            $this->position ++;
        }

        function valid ()
        {
            return key_exists($this->position, $this->resultRow->data);
        }

        function key ()
        {
            return $this->names[$this->position];
        }
    }

    class Resultset implements Iterator
    {
        public static $NOT_NULL_FLAG = 1;
        public static $PRI_KEY_FLAG = 2;
        public static $UNIQUE_KEY_FLAG = 4;
        public static $BLOB_FLAG = 16;
        public static $UNSIGNED_FLAG = 32;
        public static $ZEROFILL_FLAG = 64;
        public static $BINARY_FLAG = 128;
        public static $ENUM_FLAG = 256;
        public static $AUTO_INCREMENT_FLAG = 512;
        public static $TIMESTAMP_FLAG = 1024;
        public static $SET_FLAG = 2048;
        public static $NUM_FLAG = 32768;
        public static $PART_KEY_FLAG = 16384;
        public static $GROUP_FLAG = 32768;
        public static $UNIQUE_FLAG = 65536;
       
        private $result;
        private $stmt = NULL;
       
        private $dataRow = null;
       
        /**
         * Array containing the resulting values of a query (0 based index).
         *
         * @var array
         */
        private $fieldsData;
       
        /**
         * True if we reached the end of the result set.
         * Otherwise false.
         *
         * @var boolean
         */
        public $EOF;
       
        private $conn;
       
        public $NbRows = 0;
        private $currentRow = 0;

        function Resultset ($conn)
        {
            $this->EOF = true;
            $this->result = NULL;
            $this->conn = $conn;
        }

        function rewind ()
        {
            if ($this->stmt != NULL)
            {
                $this->stmt->data_seek(0);
            }
            else
            {
                $this->result->data_seek(0);
            }
        }
       
        private $colLookup = null;

        /**
         * Called by the ResultRow class this functions returns an array
         * with key being the column name and the value being the position in the
         * array.
         * Used for lazy loading of the column names in case a developer uses the
         * column names
         * to access the results.
         */
        public function getColumnsNames ()
        {
            if ($this->colLookup == null)
            {
                $fields = $this->FetchFields();
                $this->colLookup = array();
                $pos = 0;
                foreach ($fields as $field)
                {
                    $this->colLookup[$field->name] = $pos;
                    $pos ++;
                }
            }
           
            return $this->colLookup;
        }

        public function __get ($name)
        {
            global $dbResultAsObject;
           
            if ($name == "fields")
            {
                if ($this->dataRow == null)
                    $this->dataRow = new ResultRow($this->fieldsData, $this);
                return $this->dataRow;
            }
            else
                throw new Exception("Can't get property $name.");
        }

        function current ()
        {
            if ($this->dataRow == null)
                $this->dataRow = new ResultRow($this->fieldsData, $this);
            return $this->dataRow;
        }

        function key ()
        {
            return $this->currentRow;
        }

        function next ()
        {
            // Fix a double first row... for some reasons.
            if ($this->currentRow == 0)
            {
                $this->MoveNext();
                $this->currentRow = 0;
            }
            $this->MoveNext();
        }

        function valid ()
        {
            return ! $this->EOF;
        }

        function Prepare ($query)
        {
            $this->stmt = $this->conn->prepare($query);
            if ($this->stmt === FALSE)
            {
                /*
                 * var_dump($this->conn->error); exit;
                 */
                throw new Exception("Wrong query.");
            }
        }

        private function ArrayOfReferenced ($arr)
        {
            $refs = array();
            foreach ($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }

        function Bind ($arrParams)
        {
            $method = new ReflectionMethod('mysqli_stmt', 'bind_param');
            $method->invokeArgs($this->stmt, $this->ArrayOfReferenced($arrParams));
        }

        function ExecStatement ()
        {
            $this->EOF = false;
            $this->result = $this->stmt->execute();
            if (is_object($this->result))
                $this->NbRows = $this->result->num_rows;
            else
                $this->NbRows = $this->conn->affected_rows;
           
            $meta = $this->stmt->result_metadata();
            if (! $meta)
            {
                if ($this->result === FALSE)
                {
                    $this->result = NULL;
                    $this->EOF = true;
                    return false;
                }
                if ($this->result === TRUE)
                {
                    $this->result = NULL;
                    $this->EOF = true;
                    return true;
                }
            }
           
            $this->fieldsData = array();
            $params = array();
            $pos = 0;
            while ($field = $meta->fetch_field())
            {
                $params[] = &$this->fieldsData[$pos];
                $pos ++;
            }
            $meta->close();
           
            $this->stmt->store_result();
           
            $method = new ReflectionMethod('mysqli_stmt', 'bind_result');
            $method->invokeArgs($this->stmt, $params);
           
            if ($this->stmt->fetch() !== TRUE)
            {
                $this->EOF = true;
                $this->fieldsData = array();
            }
            else
                $this->EOF = false;
            return $this;
        }

        function Exec ($query)
        {
            $this->EOF = false;
            $this->result = $this->conn->query($query);
            if (is_object($this->result))
                $this->NbRows = $this->result->num_rows;
            else
                $this->NbRows = $this->conn->affected_rows;
           
            if ($this->result === FALSE)
            {
                $this->result = NULL;
                $this->EOF = true;
                return false;
            }
            if ($this->result === TRUE)
            {
                $this->result = NULL;
                $this->EOF = true;
                return true;
            }
            $this->fieldsData = $this->result->fetch_row();
            if ($this->fieldsData === NULL)
            {
                $this->EOF = true;
                $this->fieldsData = array();
            }
            return $this;
        }

        /**
         * Closes the result set.
         */
        function Close ()
        {
            if ($this->stmt != NULL)
                $this->stmt->close();
            else if ($this->result != NULL)
                @$this->result->free_result();
        }

        /**
         * Moves to the next row.
         */
        function MoveNext ()
        {
            $this->dataRow = null;
            if ($this->EOF)
                return;
            $this->currentRow ++;
            if ($this->stmt != NULL)
            {
                if ($this->stmt->fetch() !== TRUE)
                {
                    $this->fieldsData = array();
                    $this->EOF = true;
                }
            }
            else
            {
                $this->fieldsData = $this->result->fetch_row();
                if ($this->fieldsData == NULL)
                {
                    $this->fieldsData = array();
                    $this->EOF = true;
                }
            }
        }

        /**
         * Returns the number of rows of a result set.
         *
         * @return integer
         */
        function FieldCount ()
        {
            if ($this->stmt != null)
            {
                return count($this->FetchFields());
            }
            $arr = $this->result->fetch_fields();
            return count($arr);
        }

        /**
         * Returns an array with all the fields information.
         *
         * @return array
         */
        function FetchFields ()
        {
            if ($this->stmt != null)
            {
                $meta = $this->stmt->result_metadata();
                $result = $meta->fetch_fields();
                $meta->Close();
                return $result;
            }
            return $this->result->fetch_fields();
        }

        /**
         * Returns a field information
         *
         * @param $col integer
         *            column number
         * @return Field
         */
        function FetchField ($col)
        {
            if ($this->stmt != null)
            {
                $arr = $this->FetchFields();
                return $arr[$col];
            }
            $arr = $this->result->fetch_fields();
            return $arr[$col];
        }
    }
