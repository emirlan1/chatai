const chatInput = document.querySelector("#chat-input");
const sendButton = document.querySelector("#send-btn");
const selectChatButtons = document.querySelectorAll(".chat-select");
const newChatButton = document.querySelector("#chat-new");
const chatContainer = document.querySelector(".chat-container");
const chatListContainer = document.querySelector("#chat-list");
const themeButton = document.querySelector("#theme-btn");
const deleteButton = document.querySelector("#delete-btn");
let userText = null;
var getChatID = function() {
    // Получаем путь из URL
    var path = window.location.pathname;
    // Разбиваем путь на части, используя разделитель /
    var parts = path.split('/');
    // Последний элемент массива parts будет chatId
    var chatId = parts[parts.length - 1];

    // Проверяем, является ли chatId корректным идентификатором чата
    if (typeof parseInt(chatId) === 'number' && parseInt(chatId) > 0) {
        return chatId;
    } else {
        return null;
    }
};
const loadChatList = async () => {
    let metaElement = document.querySelector('meta[name="csrf-token"]');
    let csrfToken = metaElement ? metaElement.getAttribute('content') : null;
    const requestOptions = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': csrfToken
        },
    }
    try {
        const defaultText = ``
        const response = await (await fetch('/chatlist', requestOptions)).text();
        chatListContainer.innerHTML = response || defaultText;
        document.querySelectorAll(".chat-select").forEach(button => {
            button.addEventListener('click', loadChat);
        });
    } catch (error) { // Add error class to the paragraph element and set error text
        console.log(error);
        pElement.classList.add("error");
        pElement.textContent = "Oops! Something went wrong while retrieving the response. Please try again.";
    }
}
const loadDataFromLocalstorage = async () => {
    chatContainer.innerHTML = `<div id="loadingIndicator" class="spinner" style="display: block;">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>`
    let metaElement = document.querySelector('meta[name="csrf-token"]');
    let csrfToken = metaElement ? metaElement.getAttribute('content') : null;
    // Define the properties and data for the API request
    const requestOptions = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id: getChatID(),
        })
    }
    // Send POST request to API, get response and set the reponse as paragraph element text
    try {
        const defaultText = `<div class="default-text">
                                <h1>ChatGPT Clone</h1>
                                <p>Start a conversation and explore the power of AI.<br> Your chat history will be displayed here.</p>
                            </div>`
        const response = await (await fetch('/context', requestOptions)).text();
        chatContainer.innerHTML = response || defaultText;
        chatContainer.scrollTo(0, chatContainer.scrollHeight); // Scroll to bottom of the chat container
    } catch (error) { // Add error class to the paragraph element and set error text
        console.log(error);
        pElement.classList.add("error");
        pElement.textContent = "Oops! Something went wrong while retrieving the response. Please try again.";
    }
}

const createNewChat = async () => {
    const defaultText = `<div class="default-text">
                                <h1>ChatGPT Clone</h1>
                                <p>Start a conversation and explore the power of AI.<br> Your chat history will be displayed here.</p>
                            </div>`;
    history.pushState({}, document.title, '/chat');
    chatContainer.innerHTML = defaultText;
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
}

async function loadChat(event) {
    chatContainer.innerHTML = `<div id="loadingIndicator" class="spinner" style="display: block;">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>`
    chatId = event.currentTarget.getAttribute('data-chat_id');
    window.history.pushState({}, '', '/chat/' + chatId);
    let metaElement = document.querySelector('meta[name="csrf-token"]');
    let csrfToken = metaElement ? metaElement.getAttribute('content') : null;
    // Define the properties and data for the API request
    const requestOptions = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id: getChatID(),
        })
    }
    // Send POST request to API, get response and set the reponse as paragraph element text
    try {
        const defaultText = `<div class="default-text">
                                <h1>ChatGPT Clone</h1>
                                <p>Start a conversation and explore the power of AI.<br> Your chat history will be displayed here.</p>
                            </div>`
        const response = await (await fetch('/context', requestOptions)).text();
        chatContainer.innerHTML = response || defaultText;
        chatContainer.scrollTo(0, chatContainer.scrollHeight); // Scroll to bottom of the chat container
    } catch (error) { // Add error class to the paragraph element and set error text
        console.log(error);
        pElement.classList.add("error");
        pElement.textContent = "Oops! Something went wrong while retrieving the response. Please try again.";
    }
}
const createChatElement = (content, className) => {
    // Create new div and apply chat, specified class and set html content of div
    const chatDiv = document.createElement("div");
    chatDiv.classList.add("chat", className);
    chatDiv.innerHTML = content;
    return chatDiv; // Return the created chat div
}
const getChatResponse = async (incomingChatDiv) => {
    const url = "/chat";
    const pElement = document.createElement("p");
    let metaElement = document.querySelector('meta[name="csrf-token"]');
    let csrfToken = metaElement ? metaElement.getAttribute('content') : null;
    // Define the properties and data for the API request

    const requestOptions = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            prompt: userText,
            id: getChatID(),
        })
    }
    // Send POST request to API, get response and set the reponse as paragraph element text
    try {
        const response = await (await fetch(url, requestOptions)).json();
        if (!getChatID()) {
            loadChatList();
        }
        pElement.textContent = response.response.choices[0].message.content;
        window.history.pushState({}, '', '/chat/' + response.chat_id);
    } catch (error) { // Add error class to the paragraph element and set error text
        console.log(error);
        pElement.classList.add("error");
        pElement.textContent = "Oops! Something went wrong while retrieving the response. Please try again.";
    }


    // Remove the typing animation, append the paragraph element and save the chats to local storage
    incomingChatDiv.querySelector(".typing-animation").remove();
    incomingChatDiv.querySelector(".chat-details").appendChild(pElement);
    localStorage.setItem("all-chats", chatContainer.innerHTML);
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
    //j
}
const copyResponse = (copyBtn) => {
    // Copy the text content of the response to the clipboard
    const reponseTextElement = copyBtn.parentElement.querySelector("p");
    navigator.clipboard.writeText(reponseTextElement.textContent);
    copyBtn.textContent = "done";
    setTimeout(() => copyBtn.textContent = "content_copy", 1000);
}
const showTypingAnimation = () => {
    // Display the typing animation and call the getChatResponse function
    const html = `<div class="chat-content">
                    <div class="chat-details">
                        <img src="/images/chatbot.jpg" alt="chatbot-img">
                        <div class="typing-animation">
                            <div class="typing-dot" style="--delay: 0.2s"></div>
                            <div class="typing-dot" style="--delay: 0.3s"></div>
                            <div class="typing-dot" style="--delay: 0.4s"></div>
                        </div>
                    </div>
                    <span onclick="copyResponse(this)" class="material-symbols-rounded">content_copy</span>
                </div>`;
    // Create an incoming chat div with typing animation and append it to chat container
    const incomingChatDiv = createChatElement(html, "incoming");
    chatContainer.appendChild(incomingChatDiv);
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
    getChatResponse(incomingChatDiv);
}
const handleOutgoingChat = () => {
    userText = chatInput.value.trim(); // Get chatInput value and remove extra spaces
    chatId = getChatID(); // Get chatInput value and remove extra spaces
    if(!userText) return; // If chatInput is empty return from here
    // Clear the input field and reset its height
    chatInput.value = "";
    chatInput.style.height = `${initialInputHeight}px`;
    const html = `<div class="chat-content">
                    <div class="chat-details">
                        <img src="/images/user.jpg" alt="user-img">
                        <p>${userText}</p>
                    </div>
                </div>`;
    // Create an outgoing chat div with user's message and append it to chat container
    const outgoingChatDiv = createChatElement(html, "outgoing");
    chatContainer.querySelector(".default-text")?.remove();
    chatContainer.appendChild(outgoingChatDiv);
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
    setTimeout(showTypingAnimation, 500);
}
deleteButton.addEventListener("click", () => {
    // Remove the chats from local storage and call loadDataFromLocalstorage function
    if(confirm("Are you sure you want to delete all the chats?")) {
        localStorage.removeItem("all-chats");
        loadDataFromLocalstorage();
    }
});
themeButton.addEventListener("click", () => {
    // Toggle body's class for the theme mode and save the updated theme to the local storage
    document.body.classList.toggle("light-mode");
    localStorage.setItem("themeColor", themeButton.innerText);
    themeButton.innerText = document.body.classList.contains("light-mode") ? "dark_mode" : "light_mode";
});
const initialInputHeight = chatInput.scrollHeight;
chatInput.addEventListener("input", () => {
    // Adjust the height of the input field dynamically based on its content
    chatInput.style.height =  `${initialInputHeight}px`;
    chatInput.style.height = `${chatInput.scrollHeight}px`;
});
chatInput.addEventListener("keydown", (e) => {
    // If the Enter key is pressed without Shift and the window width is larger
    // than 800 pixels, handle the outgoing chat
    if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
        e.preventDefault();
        handleOutgoingChat();
    }
});
loadDataFromLocalstorage();
loadChatList();
sendButton.addEventListener("click", handleOutgoingChat);
newChatButton.addEventListener("click", createNewChat);
selectChatButtons.forEach(button => {
    button.addEventListener('click', loadChat);
});
