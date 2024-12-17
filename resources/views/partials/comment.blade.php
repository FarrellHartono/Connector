{{-- Partial view Buat Reply biar bisa dimodif fisini --}}
@foreach ($comments as $reply)
    <div class="mt-4 ml-8 flex space-x-4 w-full">
        <div class="flex flex-col w-full">
            <h6 class="text-gray-900 dark:text-white font-semibold">{{ $reply->user->name }}</h6>
            <div class="flex justify-between items-start">
            <p id="reply-content-{{ $reply->id }}" class="text-gray-700 dark:text-gray-400 text-sm">
                {{ $reply->content }}</p>

            
            @if (Auth::id() === $reply->user_id || Auth::user()->is_admin)
                <div class="flex space-x-2 edit-delete-buttons">
                    <!-- Edit Button -->
                    <button type="button" onclick="toggleEditReply({{ $reply->id }}, true)">
                        <x-svg-icon name="edit-comment" />
                    </button>
                    <!-- Delete Button -->
                    <button type="button" onclick="confirmDeleteReply({{ $reply->id }})">
                        <x-svg-icon name="delete-comment" />
                    </button>
                </div>

                <!-- Hidden Edit Form -->
                <form id="edit-reply-form-{{ $reply->id }}" action="{{ route('business.updateReply', $reply->id) }}"
                    method="POST" class="hidden">
                    @csrf
                    @method('PUT')
                    <input type="text" name="content" value="{{ $reply->content }}" required
                        class="border p-2 rounded">
                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                    <button type="button" class="bg-gray-500 text-white px-2 py-1 rounded"
                        onclick="toggleEditReply({{ $reply->id }}, false)">Cancel</button>
                </form>

                <!-- Hidden Delete Form -->
                <form id="delete-reply-form-{{ $reply->id }}"
                    action="{{ route('business.deleteReply', $reply->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
            </div>
            <!-- Reply Form for Nested Replies -->
            <form action="{{ route('business.reply', ['business' => $reply->business_id, 'comment' => $reply->id]) }}"
                method="POST" class="mt-2">
                @csrf
                <div class="flex items-start space-x-4">
                    <input type="text" name="content" class="w-full p-2 border rounded"
                        placeholder="Write a reply..." required>
                    <button type="submit" class="bg-gray-500 text-white px-2 py-1 rounded">
                        <x-svg-icon name="reply" />
                    </button>
                </div>
            </form>

            <!-- Recursively Display Replies to Replies -->
            @if ($reply->replies->isNotEmpty())
                @include('partials.comment', ['comments' => $reply->replies])
            @endif
        </div>
    </div>
@endforeach
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function toggleEditReply(replyId, isEditing) {
        const contentElement = document.getElementById(`reply-content-${replyId}`);
        const formElement = document.getElementById(`edit-reply-form-${replyId}`);
        const buttonElement = document.querySelector(`#reply-content-${replyId} + .edit-delete-buttons`);

        if (isEditing) {
            contentElement.style.display = 'none';
            formElement.style.display = 'block';
            buttonElement.style.display = 'none';
        } else {
            contentElement.style.display = 'block';
            formElement.style.display = 'none';
            buttonElement.style.display = 'flex';
        }
    }

    function confirmDeleteReply(replyId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-reply-form-${replyId}`).submit();
            }
        });
    }
</script>
