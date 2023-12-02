<?php
/*
require_once("/Xampp/xammp/htdocs/todo/model/todo_model.php");
class todo extends todo_model
{
    public function __construct (){
        parent::__construct();

        if (isset($_POST)) {
            $data = file_get_contents("php://input");
            $user = json_decode ($data, true); // with true it will return array if not its object
            print_r($user["todo"]) ; // only return input sent by the user
            echo json_encode($user); // return json object that you will have to decode in front end

        }
    }
};

$todo_ob = new todo();
$todo_ob->__construct();
*/
?>

<?php //<!-- again --> ?>

<?php 
require_once("/Xampp/xammp/htdocs/todo/model/todo_model.php");
  class todo_controller extends todo_model
  {
    public function __construct(){
        parent::__construct();
        if (isset($_POST)) {
            $data = file_get_contents("php://input");
            if($data === "NULL"){
                $todos=$this->get_todo("todos");
                if($todos !== false) {
                    $todos = json_encode($todos);
                    header("Content-type: application/json; charset=UTF-8");
                    echo $todos;
                    return;
                }
            }
            else if(isset(json_decode($data)->remove_id)){
                $answer = $this->remove_todo("todos",json_decode($data)->remove_id,"todo_id");
                if($answer === false){
                    echo "Error removing todo: " . $answer;
                }
            }
            else{

                $todo_input = json_decode($data)->todo ; //
                $todo_obj = json_decode($data); //
                $answer =(json_decode($data)->id == null)? ( (json_decode($data)->todo == null)? $this->removeAll("todos") : $this->add_todo("todos",$todo_input,"todo") ): ($this->update_todo("todos",$todo_obj,$todo_obj->id));
                $todos=($answer == true)? $this->get_todo("todos") : false;
                if($todos !== false) {
                    $todos = json_encode($todos);
                    header("Content-type: application/json; charset=UTF-8");
                    echo $todos;
                    return;
                }
            }
        };   
    }

  }

  $todo_controller_obj = new todo_controller();
?>