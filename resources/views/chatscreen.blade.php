@foreach($messages as $message)
    <div class="chat {{ $message['user_type'] === 1 ? 'outgoing' : 'incoming' }}">
        <div class="chat-content">
            <div class="chat-details">
                <img src="/images/{{ $message['user_type'] === 1 ? 'user.jpg' : 'chatbot.jpg' }}" alt="{{ $message['role'] }}">
                <p>{{ $message['message'] }}</p>
            </div>
            @if($message['user_type'] === 0)
                <span onclick="copyResponse(this)" class="material-symbols-rounded">content_copy</span>
            @endif
        </div>
    </div>
@endforeach
