<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Messages - JOB-lyNK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Test if page is loading
        console.log('Messages page HTML loaded');
        
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue-primary': '#1e40af',
                        'blue-secondary': '#3b82f6',
                        'blue-light': '#dbeafe',
                        'blue-dark': '#1e3a8a'
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .message-bubble {
            max-width: 70%;
            word-wrap: break-word;
        }
        .conversation-item:hover {
            background-color: #374151;
        }
        .conversation-item.active {
            background-color: #1e40af;
            border-left: 4px solid #3b82f6;
        }
        .messages-container {
            height: calc(100vh - 200px);
            min-height: 400px;
        }
        .chat-area {
            height: calc(100vh - 200px);
            min-height: 400px;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Navigation -->
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if(Auth::user()->role === 'worker')
                            <a href="{{ route('worker') }}" class="text-blue-400 text-2xl font-bold">JOB-lyNK</a>
                        @elseif(Auth::user()->role === 'employer')
                            <a href="{{ route('employerDashboard') }}" class="text-blue-400 text-2xl font-bold">JOB-lyNK</a>
                        @else
                            <a href="{{ route('home') }}" class="text-blue-400 text-2xl font-bold">JOB-lyNK</a>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-blue-200">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-gray-400 capitalize">({{ Auth::user()->role }})</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="flex h-full">
                <!-- Conversations Sidebar -->
                <div class="w-1/3 border-r border-gray-700 bg-gray-900">
                    <!-- Header -->
                    <div class="p-4 border-b border-gray-700 bg-gray-800">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-200">Messages</h2>
                            <button id="newMessageBtn" class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700 transition-colors">
                                <i class="fas fa-plus mr-1"></i>
                                New
                            </button>
                        </div>
                        <div class="mt-3">
                            <input type="text" id="searchUsers" placeholder="Search users..." 
                                class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 text-sm">
                        </div>
                    </div>

                    <!-- Conversations List -->
                    <div class="messages-container overflow-y-auto">
                        <div id="conversationsList" class="divide-y divide-gray-700">
                            @if(isset($conversations) && count($conversations) > 0)
                                @foreach($conversations as $conversation)
                                    <div class="conversation-item p-4 cursor-pointer hover:bg-gray-800 transition-colors" data-user-id="{{ $conversation['user']->id }}">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                @if($conversation['user']->profile_picture)
                                                    <img src="{{ asset('storage/' . $conversation['user']->profile_picture) }}" 
                                                         alt="{{ $conversation['user']->name }}" 
                                                         class="w-10 h-10 rounded-full object-cover">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                                        {{ substr($conversation['user']->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-sm font-medium text-gray-200 truncate">
                                                        {{ $conversation['user']->name }}
                                                    </p>
                                                    @if($conversation['unread_count'] > 0)
                                                        <span class="bg-blue-600 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">
                                                            {{ $conversation['unread_count'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-400 capitalize">{{ $conversation['user']->role }}</p>
                                                @if($conversation['last_message'])
                                                    <p class="text-sm text-gray-300 truncate mt-1">
                                                        {{ Str::limit($conversation['last_message']->message, 50) }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ $conversation['last_message']->created_at->diffForHumans() }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="p-8 text-center text-gray-500">
                                    <i class="fas fa-comments text-4xl mb-4"></i>
                                    <p class="text-gray-400">No conversations yet</p>
                                    <p class="text-sm mt-2 text-gray-500">Start a conversation by clicking "New" above</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="flex-1 flex flex-col">
                    <!-- Chat Header -->
                    <div id="chatHeader" class="p-4 border-b border-gray-700 bg-gray-800 hidden">
                        <div class="flex items-center space-x-3">
                            <div id="chatUserAvatar" class="flex-shrink-0"></div>
                            <div>
                                <h3 id="chatUserName" class="text-lg font-semibold text-gray-200"></h3>
                                <p id="chatUserRole" class="text-sm text-gray-400"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div id="messagesArea" class="flex-1 overflow-y-auto p-4 space-y-4 chat-area bg-gray-900">
                        <div id="noConversationSelected" class="flex items-center justify-center h-full text-gray-500">
                            <div class="text-center">
                                <i class="fas fa-comments text-6xl mb-4 text-gray-600"></i>
                                <h3 class="text-xl font-semibold mb-2 text-gray-400">Select a conversation</h3>
                                <p class="text-gray-500">Choose a conversation from the sidebar to start messaging</p>
                            </div>
                        </div>
                        <div id="messagesContainer" class="hidden space-y-4"></div>
                    </div>

                    <!-- Message Input -->
                    <div id="messageInput" class="p-4 border-t border-gray-700 bg-gray-800 hidden">
                        <form id="sendMessageForm" class="flex space-x-3">
                            <input type="hidden" id="receiverId" value="">
                            <input type="text" id="messageText" placeholder="Type your message..." 
                                class="flex-1 px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                                maxlength="1000" required>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-colors">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Message Modal -->
    <div id="newMessageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-200">New Message</h3>
                        <button id="closeModalBtn" class="text-gray-400 hover:text-gray-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Search Users</label>
                            <input type="text" id="modalSearchUsers" placeholder="Search by name or email..." 
                                class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
                        </div>
                        <div id="searchResults" class="max-h-48 overflow-y-auto border border-gray-600 rounded-md hidden bg-gray-700">
                            <!-- Search results will be populated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentUserId = null;
        let currentUser = @json(Auth::user());
        let conversations = @json($conversations ?? []);
        
        // Debug logging
        console.log('Messages page loaded');
        console.log('Current user:', currentUser);
        console.log('Conversations:', conversations);
        
        // CSRF token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Initialize messaging system
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing messaging...');
            initializeMessaging();
        });

        function initializeMessaging() {
            console.log('Initializing messaging system...');
            
            // Event listeners
            const newMessageBtn = document.getElementById('newMessageBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const sendMessageForm = document.getElementById('sendMessageForm');
            const modalSearchUsers = document.getElementById('modalSearchUsers');
            
            if (newMessageBtn) {
                newMessageBtn.addEventListener('click', openNewMessageModal);
                console.log('New message button listener added');
            } else {
                console.error('New message button not found');
            }
            
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', closeNewMessageModal);
            }
            
            if (sendMessageForm) {
                sendMessageForm.addEventListener('submit', sendMessage);
            }
            
            if (modalSearchUsers) {
                modalSearchUsers.addEventListener('input', searchUsers);
            }
            
            // Conversation click handlers
            const conversationItems = document.querySelectorAll('.conversation-item');
            console.log('Found conversation items:', conversationItems.length);
            
            conversationItems.forEach(item => {
                item.addEventListener('click', function() {
                    const userId = this.dataset.userId;
                    console.log('Conversation clicked, user ID:', userId);
                    selectConversation(userId);
                });
            });

            // Auto-refresh unread count every 30 seconds
            setInterval(updateUnreadCount, 30000);
            
            console.log('Messaging system initialized successfully');
        }

        function selectConversation(userId) {
            currentUserId = userId;
            
            // Update UI
            document.querySelectorAll('.conversation-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`[data-user-id="${userId}"]`).classList.add('active');
            
            // Load conversation
            loadConversation(userId);
        }

        async function loadConversation(userId) {
            try {
                const response = await fetch(`/api/messages/conversations/${userId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    displayConversation(data);
                } else {
                    console.error('Error loading conversation:', data);
                    // If conversation doesn't exist, try to create a new one
                    if (response.status === 404 || response.status === 500) {
                        createNewConversation(userId);
                    }
                }
            } catch (error) {
                console.error('Error loading conversation:', error);
                // Fallback: try to create new conversation
                createNewConversation(userId);
            }
        }

        function displayConversation(data) {
            const { messages, other_user, current_user, conversation_exists } = data;
            
            // Update chat header
            document.getElementById('chatHeader').classList.remove('hidden');
            document.getElementById('chatUserName').textContent = other_user.name;
            document.getElementById('chatUserRole').textContent = other_user.role.charAt(0).toUpperCase() + other_user.role.slice(1);
            
            // Update avatar
            const avatarContainer = document.getElementById('chatUserAvatar');
            if (other_user.profile_picture) {
                avatarContainer.innerHTML = `<img src="/storage/${other_user.profile_picture}" alt="${other_user.name}" class="w-10 h-10 rounded-full object-cover">`;
            } else {
                avatarContainer.innerHTML = `<div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">${other_user.name.charAt(0)}</div>`;
            }
            
            // Show messages area and input
            document.getElementById('noConversationSelected').classList.add('hidden');
            document.getElementById('messagesContainer').classList.remove('hidden');
            document.getElementById('messageInput').classList.remove('hidden');
            document.getElementById('receiverId').value = other_user.id;
            
            // Display messages
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.innerHTML = '';
            
            if (messages.length === 0) {
                // Show welcome message for new conversation
                messagesContainer.innerHTML = `
                    <div class="flex justify-center">
                        <div class="bg-gray-700 text-gray-300 rounded-lg px-4 py-2 text-sm">
                            Start your conversation with ${escapeHtml(other_user.name)}
                        </div>
                    </div>
                `;
            } else {
                // Display existing messages
                messages.forEach(message => {
                    const messageElement = createMessageElement(message, current_user);
                    messagesContainer.appendChild(messageElement);
                });
            }
            
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            // Focus on message input
            document.getElementById('messageText').focus();
        }

        function createMessageElement(message, currentUser) {
            const isOwn = message.sender_id === currentUser.id;
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${isOwn ? 'justify-end' : 'justify-start'}`;
            
            const bubbleClass = isOwn 
                ? 'bg-blue-600 text-white' 
                : 'bg-gray-700 text-gray-100';
            
            messageDiv.innerHTML = `
                <div class="message-bubble ${bubbleClass} rounded-lg px-4 py-2">
                    <p class="text-sm">${escapeHtml(message.message)}</p>
                    <p class="text-xs ${isOwn ? 'text-blue-100' : 'text-gray-400'} mt-1">
                        ${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                    </p>
                </div>
            `;
            
            return messageDiv;
        }

        async function sendMessage(e) {
            e.preventDefault();
            
            const messageText = document.getElementById('messageText').value.trim();
            const receiverId = document.getElementById('receiverId').value;
            
            if (!messageText || !receiverId) {
                console.log('Missing message text or receiver ID:', { messageText, receiverId });
                return;
            }
            
            // Disable send button temporarily
            const sendButton = e.target.querySelector('button[type="submit"]');
            const originalText = sendButton.innerHTML;
            sendButton.disabled = true;
            sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            try {
                const response = await fetch('/api/messages/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId,
                        message: messageText
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    // Clear input
                    document.getElementById('messageText').value = '';
                    
                    // Add message to conversation
                    const messagesContainer = document.getElementById('messagesContainer');
                    
                    // Remove welcome message if it exists
                    const welcomeMessage = messagesContainer.querySelector('.bg-gray-700');
                    if (welcomeMessage) {
                        welcomeMessage.remove();
                    }
                    
                    const messageElement = createMessageElement(data.message, currentUser);
                    messagesContainer.appendChild(messageElement);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    
                    // Focus back on input
                    document.getElementById('messageText').focus();
                } else {
                    console.error('Error sending message:', data);
                    alert('Error sending message: ' + (data.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Error sending message. Please try again.');
            } finally {
                // Re-enable send button
                sendButton.disabled = false;
                sendButton.innerHTML = originalText;
            }
        }

        function openNewMessageModal() {
            console.log('Opening new message modal...');
            const modal = document.getElementById('newMessageModal');
            if (modal) {
                modal.classList.remove('hidden');
                console.log('Modal opened successfully');
            } else {
                console.error('New message modal not found');
            }
        }

        function closeNewMessageModal() {
            console.log('Closing new message modal...');
            const modal = document.getElementById('newMessageModal');
            if (modal) {
                modal.classList.add('hidden');
                document.getElementById('modalSearchUsers').value = '';
                document.getElementById('searchResults').classList.add('hidden');
            }
        }

        async function searchUsers() {
            const search = document.getElementById('modalSearchUsers').value.trim();
            
            if (search.length < 2) {
                document.getElementById('searchResults').classList.add('hidden');
                return;
            }
            
            try {
                const response = await fetch(`/api/messages/search-users?search=${encodeURIComponent(search)}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const users = await response.json();
                displaySearchResults(users);
            } catch (error) {
                console.error('Error searching users:', error);
            }
        }

        function displaySearchResults(users) {
            const resultsContainer = document.getElementById('searchResults');
            
            if (users.length === 0) {
                resultsContainer.innerHTML = '<p class="p-4 text-gray-400 text-center">No users found</p>';
            } else {
                resultsContainer.innerHTML = users.map(user => `
                    <div class="p-3 hover:bg-gray-600 cursor-pointer border-b border-gray-600 last:border-b-0" onclick="startConversation(${user.id})">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold">
                                ${user.name.charAt(0)}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-200">${escapeHtml(user.name)}</p>
                                <p class="text-xs text-gray-400">${user.role.charAt(0).toUpperCase() + user.role.slice(1)} • ${escapeHtml(user.email)}</p>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
            
            resultsContainer.classList.remove('hidden');
        }

        function startConversation(userId) {
            closeNewMessageModal();
            
            // Find if this user already exists in conversations
            const existingConversation = document.querySelector(`[data-user-id="${userId}"]`);
            
            if (existingConversation) {
                // If conversation exists, select it
                selectConversation(userId);
            } else {
                // If it's a new conversation, create it and load the user info
                createNewConversation(userId);
            }
        }

        async function createNewConversation(userId) {
            try {
                // Fetch user details
                const response = await fetch(`/api/messages/users`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const users = await response.json();
                const user = users.find(u => u.id == userId);
                
                if (user) {
                    // Add to conversations list
                    const conversationsList = document.getElementById('conversationsList');
                    const conversationItem = document.createElement('div');
                    conversationItem.className = 'conversation-item p-4 cursor-pointer';
                    conversationItem.setAttribute('data-user-id', userId);
                    
                    conversationItem.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                ${user.profile_picture 
                                    ? `<img src="/storage/${user.profile_picture}" alt="${user.name}" class="w-10 h-10 rounded-full object-cover">`
                                    : `<div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">${user.name.charAt(0)}</div>`
                                }
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-200 truncate">${escapeHtml(user.name)}</p>
                                </div>
                                <p class="text-xs text-gray-400 capitalize">${user.role}</p>
                                <p class="text-sm text-gray-300 truncate mt-1">Start a conversation...</p>
                            </div>
                        </div>
                    `;
                    
                    // Add click handler
                    conversationItem.addEventListener('click', function() {
                        selectConversation(userId);
                    });
                    
                    // Insert at the top of conversations list
                    if (conversationsList.children.length > 0 && conversationsList.children[0].classList.contains('conversation-item')) {
                        conversationsList.insertBefore(conversationItem, conversationsList.children[0]);
                    } else {
                        // If no conversations exist, replace the "no conversations" message
                        conversationsList.innerHTML = '';
                        conversationsList.appendChild(conversationItem);
                    }
                    
                    // Select this conversation
                    selectConversation(userId);
                    
                    // Show empty conversation with input ready
                    showEmptyConversation(user);
                }
            } catch (error) {
                console.error('Error creating new conversation:', error);
            }
        }

        function showEmptyConversation(user) {
            // Update chat header
            document.getElementById('chatHeader').classList.remove('hidden');
            document.getElementById('chatUserName').textContent = user.name;
            document.getElementById('chatUserRole').textContent = user.role.charAt(0).toUpperCase() + user.role.slice(1);
            
            // Update avatar
            const avatarContainer = document.getElementById('chatUserAvatar');
            if (user.profile_picture) {
                avatarContainer.innerHTML = `<img src="/storage/${user.profile_picture}" alt="${user.name}" class="w-10 h-10 rounded-full object-cover">`;
            } else {
                avatarContainer.innerHTML = `<div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">${user.name.charAt(0)}</div>`;
            }
            
            // Show messages area and input
            document.getElementById('noConversationSelected').classList.add('hidden');
            document.getElementById('messagesContainer').classList.remove('hidden');
            document.getElementById('messageInput').classList.remove('hidden');
            document.getElementById('receiverId').value = user.id;
            
            // Clear messages container and show welcome message
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.innerHTML = `
                <div class="flex justify-center">
                    <div class="bg-gray-700 text-gray-300 rounded-lg px-4 py-2 text-sm">
                        Start your conversation with ${escapeHtml(user.name)}
                    </div>
                </div>
            `;
            
            // Focus on message input
            document.getElementById('messageText').focus();
        }

        async function updateUnreadCount() {
            try {
                const response = await fetch('/api/messages/unread-count', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                // Update unread count in UI if needed
            } catch (error) {
                console.error('Error updating unread count:', error);
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Close modal when clicking outside
        document.getElementById('newMessageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeNewMessageModal();
            }
        });
    </script>
</body>
</html>