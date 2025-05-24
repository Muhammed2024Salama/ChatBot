import './bootstrap';

const user = JSON.parse(localStorage.getItem('user'));
const userId = user?.id;

if (userId) {
    const channelName = `chat.${userId}`; // ✅ لازم يتطابق مع event و channels.php

    window.Echo.private(channelName)
        .listen('.message.received', (data) => {
            console.log('📩 AI Response:', data.response);

            const messageBox = document.getElementById('chat-box');
            if (messageBox) {
                const newMessage = document.createElement('div');
                newMessage.classList.add('received-message');
                newMessage.textContent = data.response;
                messageBox.appendChild(newMessage);
            }
        });
}
