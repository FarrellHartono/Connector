@extends('layout.master')

@section('title')
    Manage Business
@endsection

@section('content')
@extends('layout.navbar')
<div class="relative flex items-center">
    <a href="{{ url()->previous() }}" class="absolute left-4 flex items-center bg-white border rounded-full p-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24" class="">
            <rect width="24" height="24" fill="none" />
            <path fill="currentColor" d="M19 11H7.83l4.88-4.88c.39-.39.39-1.03 0-1.42a.996.996 0 0 0-1.41 0l-6.59 6.59a.996.996 0 0 0 0 1.41l6.59 6.59a.996.996 0 1 0 1.41-1.41L7.83 13H19c.55 0 1-.45 1-1s-.45-1-1-1" />
        </svg>
    </a>
    <h1 class="mx-auto text-5xl font-bold">Manage Business</h1>
</div>


<div class="flex justify-center mt-10">
    <div class="w-full">
        <form action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input type="text" name="title" id="title" value="{{ $business->title }}" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('title')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">
                <p class="block text-gray-700 text-sm font-bold mb-2">Business Profile Picture</p>
                <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        @php
                            $folderPath = $business->image_path;
                            $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                            $filePath = null;
                            foreach ($extensions as $extension) {
                            $fullFilePath = $folderPath . '/' . 'main' . '.' . $extension;

                            if (Storage::disk('public')->exists(str_replace('public/','',$fullFilePath))) {
                                $filePath = $fullFilePath;
                                break;
                            }
                        }
                        @endphp
                        <img src="{{ asset('storage/' . str_replace('public/', '', $filePath)) }}" alt="" id="image-preview" class="max-h-44">
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPEG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="image" type="file" class="hidden" name="image"/>
                </label>
                @error('image')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6 h-auto overflow-hidden">
                <p class="block text-gray-700 text-sm font-bold mb-2">Additional Photos</p>
                <label for="file" class="flex flex-col items-center justify-center w-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 h-auto overflow-hidden">
                        @php
                            // $folderPath = $business->image_path;
                            // $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                            // $filePath = array();
                            // $filesCount = Storage::disk('public')->files(str_replace('public/','',$folderPath));
                            // $max = count($filesCount);

                            // for ($i=1; $i < $max ; $i++) {
                            //     foreach ($extensions as $extension) {
                            //     $fullFilePath = $folderPath . '/' . $i. '.' . $extension;
                            //     if (Storage::disk('public')->exists(str_replace('public/','',$fullFilePath))) {
                            //         $filePath[] = $fullFilePath;
                            //     }
                            //     }
                            // }
                            $folderPath = $business->image_path;
                            $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                            $filePath = [];

                            $filesInFolder = Storage::disk('public')->files(str_replace('public/', '', $folderPath));

                            foreach ($filesInFolder as $file) {
                                $fileName = pathinfo($file, PATHINFO_FILENAME);
                                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

                                if (in_array($fileExtension, $extensions) && $fileName !== 'main') {
                                    $filePath[] = $folderPath . '/' . basename($file);
                                }
                            }
                        @endphp
                        <div id="file-preview-container" class="flex gap-2 flex-wrap overflow-hidden">
                            @foreach ($filePath as $file)
                                <img src="{{ asset('storage/' . str_replace('public/', '', $file)) }}" alt="Image" class="max-h-44">
                            @endforeach
                        </div>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPEG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="file" type="file" class="hidden" name="file[]" multiple/>
                </label>
                @error('file')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
                @foreach ($errors->get('file.*') as $messages)
                    @foreach ($messages as $message)
                    <div style="color: red;">{{ $message }}</div>
                    @endforeach
                @endforeach
            </div>


            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea name="description" id="description" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $business->description }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex-grow">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="startDate">
                        Start Date
                    </label>
                    <input type="date" name="startDate" id="startDate" value="{{ $business->start_date }}" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('startDate')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex-grow">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="endDate">
                        End Date
                    </label>
                    <input type="date" name="endDate" id="endDate" value="{{ $business->end_date }}" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('endDate')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nominal">
                    Nominal
                </label>
                <input type="number" name="nominal" id="nominal" value="{{ $business->nominal }}" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('nominal')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mb-4">
                <button type="button" class="px-4 py-2 bg-teal-500 text-white rounded" id="addMeetingBtn">Add Meeting</button>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Hidden add Meeting Form --}}
    <div id="addMeetingModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-gray-300 w-[400px] h-auto p-6 rounded-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Add Meeting</h2>
            <form action="{{ route('addMeeting') }}" method="POST" class="max-w-sm mx-auto">
                @csrf
                <div class="grid">
                    <div class="mb-5">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                        <input type="date" name="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required />
                    </div>
                    <div class="mb-5">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                        <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required />
                    </div>
                    <div class="mb-5">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required></textarea>
                    </div>
                    <input type="hidden" name="business_id" value="{{ $business->id }}" />
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5">Submit</button>
                </div>
            </form>
            <div class="flex justify-center">
                <button type="button" id="closeModalBtn" class="mt-4 text-red-500">Close</button>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const addMeetingBtn = document.getElementById('addMeetingBtn');
        const addMeetingModal = document.getElementById('addMeetingModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        // Buat nge show pop up add meeting
        addMeetingBtn.addEventListener('click', function(){
            addMeetingModal.classList.remove('hidden');
        });

        // Buat nge close pop up add meeting
        closeModalBtn.addEventListener('click', function(){
            addMeetingModal.classList.add('hidden');
        })

        // Misal kalau user gk click close, click diluar pop up
        window.addEventListener('click', function(event){
            if(event.target === addMeetingModal){
                addMeetingModal.classList.add('hidden');
            }
        });
    });

    //buat preview image kalo ganti2
    $(document).ready(function (e){
            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image-preview').attr('src',e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#file').change(function () {
                let file = this.files[0];
                if(file){
                    $('#file-preview-container').empty();
                    // Loop through all selected files
                    Array.from(this.files).forEach(file => {
                        let reader = new FileReader();

                        reader.onload = (e) => {
                                // Create a new img element and set its src to the file's data URL
                                let img = $('<img>').attr('src', e.target.result).attr('class','max-h-44');
                                // Append the img element to the preview container
                                $('#file-preview-container').append(img);
                            };

                            // Read the file as a data URL
                            reader.readAsDataURL(file);
                    });
                }
            });
    });

</script>
@endsection
