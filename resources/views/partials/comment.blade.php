{{-- Partial view Buat Reply biar bisa dimodif fisini --}}
@foreach ($comments as $reply)
    <div class="mt-4 ml-8 flex space-x-4 w-full">
        <div class="flex flex-col w-full">
            <h6 class="text-gray-900 dark:text-white font-semibold">{{ $reply->user->name }}</h6>
            <p class="text-gray-700 dark:text-gray-400 text-sm">{{ $reply->content }}</p>

            <!-- Reply Form for Nested Replies -->
            <form action="{{ route('business.reply', ['business' => $reply->business_id, 'comment' => $reply->id]) }}" method="POST" class="mt-2">
                @csrf
                <div class="flex items-start space-x-4">
                    <input type="text" name="content" class="w-full p-2 border rounded" placeholder="Write a reply..." required>
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