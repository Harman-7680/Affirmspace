function openCreatePost() {
            document.getElementById('createPostModal').classList.remove('hidden');
        }

        function closeCreatePost() {
            document.getElementById('createPostModal').classList.add('hidden');
            document.getElementById('postContent').value = '';
        }

        function createPost() {
            const content = document.getElementById('postContent').value;
            if (!content.trim()) return;

            const postsContainer = document.getElementById('posts-container');
            const newPost = `
                <div class="fb-card p-4 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500"></div>
                            <div>
                                <p class="font-semibold text-gray-900">John Doe</p>
                                <p class="text-sm text-gray-500">Just now • <i class="fas fa-globe"></i></p>
                            </div>
                        </div>
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                    <p class="text-gray-800 mb-3">${content}</p>
                    <div class="flex items-center justify-between text-gray-500 text-sm mb-3">
                        <span>0 reactions</span>
                        <span>0 comments • 0 shares</span>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t">
                        <button class="flex-1 flex items-center justify-center space-x-2 py-2 hover:bg-gray-100 rounded reaction-btn" data-reaction="like">
                            <i class="far fa-thumbs-up"></i>
                            <span>Like</span>
                        </button>
                        <button class="flex-1 flex items-center justify-center space-x-2 py-2 hover:bg-gray-100 rounded">
                            <i class="far fa-comment"></i>
                            <span>Comment</span>
                        </button>
                        <button class="flex-1 flex items-center justify-center space-x-2 py-2 hover:bg-gray-100 rounded">
                            <i class="far fa-share"></i>
                            <span>Share</span>
                        </button>
                    </div>
                </div>
            `;

            postsContainer.insertAdjacentHTML('afterbegin', newPost);
            closeCreatePost();

            // Re-attach event listeners to new reaction buttons
            attachReactionListeners();
        }

        function attachReactionListeners() {
            document.querySelectorAll('.reaction-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    const span = this.querySelector('span');

                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far', 'fa-thumbs-up');
                        icon.classList.add('fas', 'fa-thumbs-up');
                        icon.style.color = '#1877f2';
                        span.style.color = '#1877f2';
                        span.textContent = 'Liked';
                    } else {
                        icon.classList.remove('fas', 'fa-thumbs-up');
                        icon.classList.add('far', 'fa-thumbs-up');
                        icon.style.color = '';
                        span.style.color = '';
                        span.textContent = 'Like';
                    }
                });
            });
        }

        // Initialize reaction listeners
        document.addEventListener('DOMContentLoaded', function() {
            attachReactionListeners();
        });

        // Close modal when clicking outside
        document.getElementById('createPostModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreatePost();
            }
        });