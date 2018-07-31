<?php
	class Database {

	    protected $mysql_hostname   = 'IP_ADDRESS';
	    protected $mysql_username   = 'USERNAME';
	    protected $mysql_password   = 'PASSWORD';
	    protected $mysql_database   = 'DATABASE';
	    protected $mysql_port       = 3306;
	    
	    protected $mysqli;
	    protected $stmt;

	    public function connect() {
	        $this->mysqli = mysqli_connect($this->mysql_hostname, $this->mysql_username, $this->mysql_password, $this->mysql_database, $this->mysql_port);
	    }
	    
	    public function disconnect() {
	    	if(isset($this->stmt)){
	    		$this->stmt->close();
	    	}
	    }

	    public function bindParams($bind = array()){
	    	if(sizeof($bind) > 0){
	    		$this->stmt->bind_param(...$bind);
	    	}
	    }

	    public function select($query, $bind = array(), $disconnect = true){
	        
	        if (!$this->mysqli) {
	            return false;
	        }

	        $this->stmt = $this->mysqli->prepare($query);

	        // if $bind is not an empty array shift the type element off the beginning and call stmt->bind_param() with variables to bind passed as reference
	        $this->bindParams($bind);

	        $this->stmt->execute();

	        // Get metadata for field names
		    $meta = $this->stmt->result_metadata();

		    $results = array();

		    // This is the tricky bit dynamically creating an array of variables to use
		    // to bind the results
		    while ($field = $meta->fetch_field()) { 
		        $var = $field->name; 
		        $$var = null; 
		        $fields[$var] = &$$var;
		    }

		    // Bind Results
		    call_user_func_array(array($this->stmt,'bind_result'), $fields);

		    // Fetch Results
		    $i = 0;
		    while ($this->stmt->fetch()) {
		        $results[$i] = array();
		        foreach($fields as $k => $v)
		            $results[$i][$k] = $v;
		        $i++;
		    }

	        $this->stmt->free_result();
	        
	        if($disconnect){
	            $this->stmt->close();
	        }

	        return $results;
	    }

	    public function insert($query, $bind = array(), $disconnect = true){

	    	if (!$this->mysqli) {
	            return false;
	        }

	        $this->stmt = $this->mysqli->prepare($query);

	        $this->bindParams($bind);

	        $this->stmt->execute();

	        $insertId = $this->mysqli->insert_id;

	        $this->stmt->free_result();
	        
	        if($disconnect){
	            $this->stmt->close();
	        }

	        return $insertId;
	    }

	    public function update($query, $bind = array(), $disconnect = true){

	    	if (!$this->mysqli) {
	            return false;
	        }

	        $this->stmt = $this->mysqli->prepare($query);

	        $this->bindParams($bind);

	        $this->stmt->execute();
	        $this->stmt->free_result();
	        
	        if($disconnect){
	            $this->stmt->close();
	        }

	        return true;
	    }
	}

?>