<?php
/*
class todo_model
{
    public $connection;
    public function __construct(){
        $hostname = "localhost";
        $database = "todo";
        $dirctri = "root";
        $password="";
        $this->connect_to_server($hostname,$dirctri,$password,$database);
    }
    public function connect_to_server($hostname,$dirctri,$password,$database){
        try {
            $new_connection = new mysqli($hostname,$dirctri,$password,$database);
            $this->connection = $new_connection;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
*/
?>

<?php //<!-- again --> ?>

<?php 
class todo_model
{
    public $connection;
    public function __construct(){
        $hostname = "localhost";
        $dirctri = "root";
        $password="";
        $database="todo";
        $this->connect_to_server($hostname,$dirctri,$password,$database);
    }
    protected function connect_to_server($hostname="localhost",$dirctri="root",$password="",$database="todo"){
        try {
            $new_connection = new mysqli($hostname,$dirctri,$password,$database);
            $this->connection = $new_connection;
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }

    }
    protected function add_todo($table,$todo,$key){
        $sql = "INSERT INTO $table($key) VALUES('$todo')";
        $sqli = $this->connection->query($sql);
        return ($sqli == 1)? true : false;
    }
    protected function get_todo($table){
        $sql = "SELECT * FROM $table";
        $sqli = $this->connection->query($sql);
        if($sqli->num_rows > 0){
            $data = $this->jatin_fetch_All($sqli);
            return $data;
        }else{
            return false;
        }
    }
    protected function update_todo($table,$todo_obj,$key){
        $sql = "UPDATE $table SET todo = '$todo_obj->todo' WHERE todo_id = '$key'";
        $sqli = $this->connection->query($sql);
        if($sqli==1){
            return false;
        }else{
            return TRUE;
        }
    }
    protected function removeAll($table){
        $sql = "truncate table $table;";
        $sqli = $this->connection->query($sql);
        if($sqli == 1){
            return false;
        }else{
            return true;
        }
    }
    protected function remove_todo ($table,$id,$key){
        $sql = "DELETE FROM $table WHERE $key = '$id'";
        echo $sql;
        $sqli = $this->connection->query($sql);
        if($sqli == 1){
            return true;
        }else{
            return false;
        }
    }
    public function jatin_fetch_All($sqlex){
        $data = array();
        $arr = array();
        while ($a = $sqlex->fetch_object()) {
            foreach ($a as $key => $value) {
                $arr[$key]=$value;
            };
            array_push($data, $arr);
        };
        return $data;
   }

}
?>