<?php


include __DIR__ . '/../autoload.php';



use TestApp\Auth;


$user = Auth::user();


?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin page</title>
    <link rel="stylesheet" type="text/css" href="/css/main.css">

<script type="text/javascript">


    function fill_parents(block, json, for_id) {
        for(let record of json) {
            if (record.id == for_id) {
                continue;
            }
            let option_block = document.createElement('option');
            option_block.setAttribute('value', record.id);
            option_block.innerText = record.name + '(id: ' + record.id + ')';
            block.appendChild( option_block );
            fill_parents(block, record.childs, for_id);
        }
    }

    function open_edit_record(param) {
        document.getElementById('edit-form').classList.remove("hidden");

        let record_id = param.getAttribute('record-id');
        let parent_id = param.getAttribute('parent-id');
        let record_name = param.getAttribute('name');
        let record_description = param.getAttribute('description');

        document.getElementById('edit-header').innerText = 'Editing category "'+ record_name + '" (id:' + record_id + ')';
        document.getElementById('edit-name').value = record_name;
        document.getElementById('edit-description').value = record_description;
        document.getElementById('edit-id').value = record_id;

        let parent_block = document.getElementById('edit-parent');
        parent_block.innerHTML = '<option value="null">Root</option>';

        fill_parents(parent_block, jsonTree, record_id);
        parent_block.value = parent_id;
    }

    function draw_tree() {
        viewElement.innerHTML = '';
        draw_tree_child(jsonTree);
    }


    function draw_tree_child(childs, level = 0) {
        for(let child of childs) {
            let record_block = document.createElement('p');
            record_block.setAttribute('style', 'margin-left: ' + level * 30 + 'px');
            record_block.innerText = child.name + ' (id: ' + child.id + ') ';
            viewElement.appendChild( record_block );

            let description_block = document.createElement('span');
            description_block.innerText = child.description;
            record_block.appendChild( description_block );

            let edit_button = document.createElement('button');
            edit_button.setAttribute('onclick', 'open_edit_record(this)');
            edit_button.setAttribute('type', 'button');
            edit_button.setAttribute('record-id', child.id);
            edit_button.setAttribute('parent-id', child.parent_id);
            edit_button.setAttribute('name', child.name);
            edit_button.setAttribute('description', child.description);
            edit_button.innerText = 'edit';
            record_block.appendChild( edit_button );

            draw_tree_child(child.childs, level + 1);
        }
    }

    function on_edit_submit()
    {
        let form = document.getElementById('edit-parent-form');
        var data = new FormData(form);

        post('record-update.php', 'POST', data, function () {
            jsonTree = JSON.parse(this.responseText);
            if (jsonTree.status == 'OK') {
                update_tree();
            }
        });
    }

    function ajax(url, method, onload_callback) {
        let xhttp = new XMLHttpRequest();
        xhttp.onload = onload_callback;
        xhttp.open(method, url, true);
        xhttp.send();
    }

    function post(url, method, data, onload_callback) {
        let xhttp = new XMLHttpRequest();
        xhttp.onload = onload_callback;
        xhttp.open(method, url, true);
        xhttp.send(data);
    }


    function update_tree()
    {
        viewElement = document.getElementById('tree-view');
        if (viewElement === null) {
            return;
        }

        ajax('/tree.php', 'GET', function() {
            jsonTree = JSON.parse(this.responseText);
            draw_tree();
        });
    }

    window.onload = update_tree;



</script>

</head>
<body>

    <div class="panel">
        <div class="container">
            <a href="">user page</a><a href="">admin page</a><?php if ($user) : ?><a href="/logout.php">logout</a><?php endif; ?>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <?php if ($user) : ?>
            <div id="tree-view">admin three</div>
            <div id="edit-form" class="hidden">
                <form id="edit-parent-form">
                    <p id="edit-header"></p>
                    <p>Parent:</p>
                    <select id="edit-parent" name="parent_id"></select>
                    <input id="edit-id" type="hidden" name="id">
                    <p>Name:</p>
                    <input id="edit-name" type="text" name="name">
                    <p>Description:</p>
                    <input id="edit-description" type="text" name="description">
                    <button type="button" onclick="on_edit_submit()">save</button>
                </form>
            </div>
            <?php else : ?>

            <div class="login-form">
                <p>Authentification</p>
                <form action="/login.php" method="post">
                    <p>Login:</p>
                    <input type="text" name="login">
                    <p>Password:</p>
                    <input type="password" name="password">
                    <button type="submit">Submit</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>


</body>
</html>