<?php 

class DB {

    protected $servername;
    protected $username;
    protected $password;
    protected $dbname;

    public function __construct ($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function db_conn() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        } 
    }

    public function read_token() {
        $this->db_conn();
        $sql = "SELECT * FROM tokens WHERE id='1'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row['token'];
            }
        } else {
            echo 'Error: ' . $sql . '<br>' . $conn->error;
        }
    }

    public function write_token($token) {
        echo 'UPDATING TOKEN IN DB';
        $sql = "UPDATE tokens SET token = '$token' WHERE id = 1";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Error updating record: " . mysqli_error($conn);
        } 
        $this->conn->close();
    }
}