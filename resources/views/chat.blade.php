<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html lang="en" dir="ltr">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (bundle includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="utf-8">
    <title>ChatGPT Clone in JavaScript | CodingNepal</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="{{ asset('/js/app.js') }}" defer></script>
    <script src="{{ asset('/js/jquery.js') }}" defer></script>
    <script src="{{ asset('/js/nav.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar" class="">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <h1><a id="chat-new" class="logo">Создать чат</a></h1>
            <ul id="chat-list" class="list-unstyled components mb-5">

            </ul>
        </nav>
        <div id="content" >
            <!-- Chats container -->
            <div class="chat-container">

            </div>


            <!-- Typing container -->
            <div class="typing-container">
                <div class="typing-content">
                    <div class="typing-textarea">
                        <textarea id="chat-input" data-chat_id="{{ request()->route('id') }}" spellcheck="false" placeholder="Enter a prompt here" required></textarea>
                        <span id="send-btn" class="material-symbols-rounded">send</span>
                    </div>
                    <div class="typing-controls">
                        <span id="theme-btn" class="material-symbols-rounded">light_mode</span>
                        <span id="delete-btn" class="material-symbols-rounded">delete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
