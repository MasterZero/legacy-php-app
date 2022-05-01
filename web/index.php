<?php


include __DIR__ . '/../autoload.php';



use TestApp\Auth;


$user = Auth::user();


?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User page</title>
    <link rel="stylesheet" type="text/css" href="/css/main.css">

<script type="text/javascript">


    function draw_tree() {
        viewElement.innerHTML = '';
        draw_tree_child(jsonTree, viewElement);
    }


    function show_record_info(button) {
        let record_id = button.getAttribute('record-id');
        let name = button.getAttribute('name');
        let description = button.getAttribute('description');

        document.getElementById('info-container').classList.remove('hidden');
        document.getElementById('info-header').innerText = '"' + name + '" (id: ' + record_id + ')';
        document.getElementById('info-description').innerText = description;
    }

    function show_record_childs(button) {
        record_id = button.getAttribute('record-id');

        child_container = document.getElementById('child-container-' + record_id);

        if (child_container.classList.contains('hidden')) {
            child_container.classList.remove('hidden');
        } else {
            child_container.classList.add('hidden');
        }
    }


    function draw_tree_child(childs, appendTo, level = 0) {
        for(let child of childs) {
            let record_block = document.createElement('p');
            record_block.setAttribute('style', 'margin-left: ' + level * 30 + 'px');
            record_block.innerText = child.name;
            appendTo.appendChild( record_block );

            let info_button = document.createElement('button');
            info_button.setAttribute('onclick', 'show_record_info(this)');
            info_button.setAttribute('record-id', child.id);
            info_button.setAttribute('name', child.name);
            info_button.setAttribute('description', child.description);
            info_button.innerText = 'info';
            record_block.appendChild( info_button );


            if (!child.childs.length) {
                continue;
            }

            let open_button = document.createElement('button');
            open_button.setAttribute('onclick', 'show_record_childs(this)');
            open_button.setAttribute('record-id', child.id);
            open_button.innerText = '+';
            record_block.appendChild( open_button );

            let child_container = document.createElement('div');
            child_container.setAttribute('id', 'child-container-' + child.id);
            child_container.setAttribute('class', 'hidden');
            appendTo.appendChild( child_container );
            draw_tree_child(child.childs, child_container, level + 1);

        }
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
            <a href="/">user page</a><a href="/admin.php">admin page</a><?php if ($user) : ?><a href="/logout.php">logout</a><?php endif; ?>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div id="tree-view">three</div>
            <div id="info-container" class="hidden">
                <p id="info-header"></p>
                <p id="info-description"></p>
            </div>
        </div>
    </div>


</body>
</html>


