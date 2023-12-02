<?php

?>
<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO</title>
</head>
<body>
    <div class="todo-input-wrapper">
        <input type="text" name="todo_name" id="todo_name" placeholder="add TODO">
        <button type="submit" name="submit" id="todo_add" onclick="todo_add()"> Add </button>
    </div>

    <div class="todo-wrapper">

    </div>

</body>
</html>

<script>
    
    function todo_add(){
        event.preventDefault();
        const todo_input =(document.getElementById("todo_name"))? document.getElementById("todo_name") : undefined;
        const todo_add =(document.getElementById("todo_add"))? document.getElementById("todo_add") : undefined;
        const todo_update =(document.getElementById("todo_update"))? document.getElementById("todo_update"): undefined;
        const todo_input_update =(document.getElementById("todo_name_update"))? document.getElementById("todo_name_update"): undefined;
        
        // console.log(todo_input.value);
        let data ={ "todo": (todo_input !== undefined)? todo_input.value : todo_input_update.value};
         fetch("http://localhost/todo/controller/todo.php", {
             method: "POST",
             body: JSON.stringify(data),
             headers: {
                 "Content-type": "application/json; charset=UTF-8"
             }
             })
             .then((response) => {return response.json();})
            //  .then((json) => console.log(json));
    
    };
</script> -->

<!-- again -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO</title>
</head>
<body>
    <form action="" method="post" class="todo_input_wrapper">
        <input type="text" name="todo_input" id="todo_input" placeholder="ADD TODO">
        <button type="submit" name="todo_add" id="todo_add" onclick="Add(this)">ADD</button>
        <button type="submit" name="todo_remove" id="todo_remove" onclick="removeAll(this)">delet all</button>
    </form>
    <div class="todo_wrapper">
       
    </div>
</body>
</html>
<script>
    Get();
    let todo_pre;
    let todo_obj = {
            "id":null,
            "todo":""
        };
    async function Get(todo=null){
        let get_data ;
        if(todo === null){
            get_data= await fetch("http://localhost/todo/controller/todo.php",{
                                    "method":"post",
                                    "body":"NULL",
                                    "headers":{
                                        "Content-type": "application/json; charset=UTF-8"
                                    }
                                 });
        }else{
            get_data=await fetch("http://localhost/todo/controller/todo.php",{
                                    "method":"post",
                                    "body":JSON.stringify(todo),
                                    "headers":{
                                        "Content-type": "application/json; charset=UTF-8"
                                    }
                                });
        };
        get_data = get_data.json();
        get_data.then((obj)=>{ 
                try {
                    console.log(obj);
                    add_todo_html(obj);
                } catch (error) {
                    console.log(error);
                    
                }
            });
    }
    function Add(e){
        event.preventDefault();

        console.log(e.previousElementSibling.value);
        todo_obj.id=null;
        todo_obj.todo=e.previousElementSibling.value;
        // console.log(todo_obj);
        Get(todo_obj);
        
    };
    function removeAll(e){
        event.preventDefault();

        console.log(e.previousElementSibling.value);
        todo_obj.id=null;
        todo_obj.todo=null;

        // console.log(todo_obj);
        Get(todo_obj);
        const todo_wrapper =document.querySelector(".todo_wrapper");
        todo_wrapper.innerHTML=null;
    };
    function remove(e){
        let parent = e.parentElement;
        let remove_obj = {
            "remove_id":parent.id
        }
        Get(remove_obj);
        parent.style.display="none";
    }
    function add_todo_html(data){
        const todo_wrapper =document.querySelector(".todo_wrapper");
        let stuf="";
            data.forEach(e => {
                console.log(e);
               stuf += `
            <div class="wrapper" id="${e.todo_id}">
                <input type="text" name="input_edit" id="" onclick="save_btn_show(this)" 
                value="${e.todo}" >
                <button type="submit" name="todo_edit"  class="todo_edit" id="" hidden onclick="save(this)" >save</button>
                <button type="submit" name="todo_reset" class="todo_reset"  id="" hidden onclick="reset(this)" >reset</button>
                <button type="submit" name="todo_delet" class="todo_delet"  id="" hidden onclick="remove(this)" >delete</button>
            </div>
            `;
            });
        todo_wrapper.innerHTML = stuf;            
    };
    function save_btn_show(e){
        event.preventDefault();
        let parent = e.parentElement;
        let input = parent.childNodes[1];
        let save_btn = parent.childNodes[3];
        let reset_btn = parent.childNodes[5];
        let delete_btn = parent.childNodes[7];
        // console.log(parent.id);
        this.todo_pre = input.value;
        // console.log(this.todo_pre);
        hide_save_reset_btn();
        save_btn.removeAttribute("hidden");
        reset_btn.removeAttribute("hidden");
        delete_btn.removeAttribute("hidden");
    }
    function save(e){
        parent = e.parentElement;
        let previewsChild = parent.childNodes[1];
        let input = parent.childNodes[1];
        todo_obj.id = parent.id;
        todo_obj.todo = input.value;
        Get(todo_obj);
        input.value =input.value;
        let save_btn = parent.childNodes[3];
        let reset_btn = parent.childNodes[5];
        let delete_btn = parent.childNodes[7];
        save_btn.setAttribute("hidden","");
        reset_btn.setAttribute("hidden","");
        delete_btn.setAttribute("hidden","");
    }
    function reset(e){
        parent = e.parentElement;
        previewsChild = parent.childNodes[1];
        console.log( this.todo_pre);
        previewsChild.value = this.todo_pre;
        let save_btn = parent.childNodes[3];
        let reset_btn = parent.childNodes[5];
        let delete_btn = parent.childNodes[7];
        save_btn.setAttribute("hidden","");
        reset_btn.setAttribute("hidden","");
        delete_btn.setAttribute("hidden","");
    }
   function hide_save_reset_btn(){
    const save = document.querySelectorAll(".todo_edit");
    if(save == undefined || null){
        return;
    }
    save.forEach(e => {
        let parent = e.parentElement;
        let save_btn = parent.childNodes[3];
        let reset_btn = parent.childNodes[5];
        let delete_btn = parent.childNodes[7];
        // console.log(e);
        save_btn.setAttribute("hidden","");
        reset_btn.setAttribute("hidden","");
        delete_btn.setAttribute("hidden","");
    });
   }
</script>