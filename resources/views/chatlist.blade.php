@foreach($chats as $chat)
    <li class="active">
        <a class="chat-select" data-chat_id="{{ $chat->id }}" >{{ $chat->name }}</a>
    </li>
@endforeach
