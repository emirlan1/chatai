@foreach($messages as $message)
    <div class="chat {{ $message['role'] === 'user' ? 'outgoing' : 'incoming' }}">
        <div class="chat-content">
            <div class="chat-details">
                <img src="/images/{{ $message['role'] === 'user' ? 'user.jpg' : 'chatbot.jpg' }}" alt="{{ $message['role'] }}">
                <p>{{ $message['content'] }}</p>
            </div>
            @if($message['role'] === 'incoming')
                <span onclick="copyResponse(this)" class="material-symbols-rounded">content_copy</span>
            @endif
        </div>
    </div>
@endforeach
