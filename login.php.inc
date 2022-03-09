<?php

class loginDB
{
private $logindb;

public function __construct()
{
	$this->logindb = new mysqli("127.0.0.1","usertest","password","testdb");

	if ($this->logindb->connect_errno != 0)
	{
		echo "Error connecting to database: ".$this->logindb->connect_error.PHP_EOL;
		exit(1);
	}
	echo "correctly connected to database".PHP_EOL;
}

public function genSessionID($timestamp) {
	$ts = $this->logindb->real_escape_string($timestamp);
	
	// get timestamp from front end to send over to backend as a request!
	// pass the time stamp as a string 
	// hash it using sha1() 
	// store the string to the sessions table 
}

public function validateLogin($username,$password)
{
	$un = $this->logindb->real_escape_string($username);
	$pw = $this->logindb->real_escape_string($password);
	$statement = "select * from testusers where username = '$un'";
	$response = $this->logindb->query($statement);

	while ($row = $response->fetch_assoc())
	{
		echo "checking password for $username".PHP_EOL;
		if ($row["password"] == $pw)
		{
			echo "passwords match for $username".PHP_EOL;
			//$response2 = $this->logindb->query($ins);
		}
		else
		{
			echo "passwords did not match for $username".PHP_EOL;
			//return "incorrect password. try again."; 
		}
	}	
	return 0;//no users matched username
}



public function createLogin($username,$password)
{
        $un = $this->logindb->real_escape_string($username);
        $pw = $this->logindb->real_escape_string($password);
        $statement = "insert into users values('$un','$pw');";
        $response = $this->logindb->query($statement);

}

}

?>
