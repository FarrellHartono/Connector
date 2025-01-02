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
                <path fill="currentColor"
                    d="M19 11H7.83l4.88-4.88c.39-.39.39-1.03 0-1.42a.996.996 0 0 0-1.41 0l-6.59 6.59a.996.996 0 0 0 0 1.41l6.59 6.59a.996.996 0 1 0 1.41-1.41L7.83 13H19c.55 0 1-.45 1-1s-.45-1-1-1" />
            </svg>
        </a>
        <h1 class="mx-auto text-5xl font-bold">Manage Business</h1>
    </div>


    <div class="flex justify-center mt-10">
        <div class="w-full">
            <form action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data"
                oninput="validateForm()" id="manage-business">
                @csrf
                @method('PUT')
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Title
                    </label>
                    <input type="text" name="title" id="title" value="{{ $business->title }}" readonly
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 cursor-not-allowed leading-tight focus:outline-none focus:shadow-outline">
                    @error('title')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">
                    <p class="block text-gray-700 text-sm font-bold mb-2">Business Profile Picture</p>
                    <label for="image"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            @php
                                $folderPath = $business->image_path;
                                $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                                $filePath = null;
                                foreach ($extensions as $extension) {
                                    $fullFilePath = $folderPath . '/' . 'main' . '.' . $extension;

                                    if (Storage::disk('public')->exists(str_replace('public/', '', $fullFilePath))) {
                                        $filePath = $fullFilePath;
                                        break;
                                    }
                                }
                            @endphp
                            <img src="{{ asset('storage/' . str_replace('public/', '', $filePath)) }}" alt=""
                                id="image-preview" class="max-h-44">
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                    upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPEG, JPG or GIF (MAX. 800x400px)
                            </p>
                        </div>
                        <input id="image" type="file" class="hidden" name="image" accept="image/*" />
                    </label>
                    @error('image')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6 h-auto overflow-hidden">
                    <p class="block text-gray-700 text-sm font-bold mb-2">Additional Photos</p>
                    <label for="file"
                        class="flex flex-col items-center justify-center w-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 h-auto overflow-hidden">
                            @php
                                $folderPath = $business->image_path;
                                $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                                $filePath = [];

                                $filesInFolder = Storage::disk('public')->files(
                                    str_replace('public/', '', $folderPath),
                                );

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
                                    <img src="{{ asset('storage/' . str_replace('public/', '', $file)) }}" alt="Image"
                                        class="max-h-44">
                                @endforeach
                            </div>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                    upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPEG, JPG or GIF (MAX. 800x400px)
                            </p>
                        </div>
                        <input id="file" type="file" class="hidden" name="file[]" multiple accept="image/*" />
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
                    <textarea name="description" id="description" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $business->description }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                        Address
                    </label>
                    <textarea name="address" id="address" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $business->address }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                        Phone Number
                    </label>
                    <input type="tel" id="phone" name="phone" pattern="08\d{8,}"
                        title="The number must start with 08 and have at least 10 digits" value="{{ $business->phone_number }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('phone')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nominal">
                        Nominal
                    </label>
                    <input type="number" name="nominal" id="nominal" value="{{ $business->nominal }}" readonly
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 cursor-not-allowed leading-tight focus:outline-none focus:shadow-outline">
                    @error('nominal')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between items-center mb-4">
                    <button type="button" class="px-4 py-2 bg-teal-500 text-white rounded" id="addMeetingBtn">Add
                        Meeting</button>
                </div>

                <div class="flex justify-center">
                    <button type="submit" id="save-button"
                        class="w-full py-2 px-4 rounded bg-gray-200 text-black font-bold cursor-not-allowed opacity-50"
                        disabled>
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

            <div class="grid">
                <div class="mb-5">
                    <label for="dateMeeting" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                    <input type="datetime-local" name="dateMeeting" id="dateMeeting" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required />
                </div>
                <div class="mb-5">
                    <label for="titleMeeting"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                    <input type="text" name="titleMeeting" id="titleMeeting"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required />
                </div>
                <div class="mb-5">
                    <label for="descriptionMeeting"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea name="descriptionMeeting" id="descriptionMeeting"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required></textarea>
                </div>
                <input type="hidden" name="business_id" value="{{ $business->id }}" />
                <button id="submitMeetingButton"
                    class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5">Submit</button>
            </div>
            <div class="flex justify-center">
                <button type="button" id="closeModalBtn" class="mt-4 text-red-500">Close</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addMeetingBtn = document.getElementById('addMeetingBtn');
            const addMeetingModal = document.getElementById('addMeetingModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const submitMeetingButton = document.getElementById('submitMeetingButton');

        // Meeting Elements
        const dateMeeting = document.getElementById('dateMeeting');
        const titleMeeting = document.getElementById('titleMeeting');
        const descriptionMeeting = document.getElementById('descriptionMeeting');

            // Buat nge show pop up add meeting
            addMeetingBtn.addEventListener('click', function() {
                addMeetingModal.classList.remove('hidden');
            });

            // Buat nge close pop up add meeting
            closeModalBtn.addEventListener('click', function() {
                addMeetingModal.classList.add('hidden');
            });

            submitMeetingButton.addEventListener('click', function() {
                if (!dateMeeting.value)
                {
                    Swal.fire({
                        text: 'Meeting date must be filled!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }else if (new Date(dateMeeting.value) < Date.now())
                {
                    Swal.fire({
                        text: 'Meeting date must be later than today or today!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }else if (!titleMeeting.value)
                {
                    Swal.fire({
                        text: 'Meeting title must be filled!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }else if (!descriptionMeeting.value)
                {
                    Swal.fire({
                        text: 'Meeting description must be filled!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
                $.ajax({
                    url: "{{ route('addMeeting') }}",
                    method: "GET",
                    data: { business_id: {{ $business->id }},
                            date: dateMeeting.value,
                            title: titleMeeting.value,
                            description: descriptionMeeting.value
                        },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Add Meeting successful!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Failed!',
                                text: 'Add Meeting failed!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });

            // Misal kalau user gk click close, click diluar pop up
            window.addEventListener('click', function(event) {
                if (event.target === addMeetingModal) {
                    addMeetingModal.classList.add('hidden');
                }
            });
        });

        //buat preview image kalo ganti2
        $(document).ready(function(e) {
            $('#image').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#file').change(function() {
                let file = this.files[0];
                if (file) {
                    $('#file-preview-container').empty();
                    // Loop through all selected files
                    Array.from(this.files).forEach(file => {
                        let reader = new FileReader();

                        reader.onload = (e) => {
                            // Create a new img element and set its src to the file's data URL
                            let img = $('<img>').attr('src', e.target.result).attr('class',
                                'max-h-44');
                            // Append the img element to the preview container
                            $('#file-preview-container').append(img);
                        };

                        // Read the file as a data URL
                        reader.readAsDataURL(file);
                    });
                }
            });
        });

        $('#manage-business').validate({
            rules: {
                description: {
                    required: true,
                    maxlength: 255,
                },
                image: {
                    extension: "png|jpg|jpeg|gif|svg",
                    filesize: 2048 * 1024,
                },
                'file.*': {
                    extension: "jpeg|png|jpg|gif|svg",
                    filesize: 2048 * 1024,
                },
                address: {
                    required: true,
                },
                phone: {
                    required: true,
                },
            },
            messages: {
                description: {
                    required: "Description is required.",
                    maxlength: "Description must not exceed 255 characters.",
                },
                image: {
                    extension: "Invalid file type. Only PNG, JPG, JPEG, GIF, SVG are allowed.",
                    filesize: "File size must not exceed 2MB.",
                },
                'file.*': {
                    extension: "Invalid file type. Only JPEG, PNG, JPG, GIF, SVG are allowed.",
                    filesize: "File size must not exceed 2MB.",
                },
                address: {
                    required: "Address is required.",
                },
                phone: {
                    required: "Phone number is required.",
                },
            },
            onfocusout: false,
            onkeyup: false,
            onclick: false,

            submitHandler: function(form) {
                Swal.fire({
                    title: 'Do you want to save changes?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Success!', 'Your changes has been saved', 'success').then((
                        result) => {
                            form.submit();
                        });
                    }
                });
            },

            invalidHandler: function(event, validator) {
                const errors = validator.errorList;
                if (errors.length > 0) {
                    const message = errors[0].message;
                    Swal.fire({
                        title: 'Error!',
                        text: message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            errorPlacement: function(error, element) {
                return false;
            }
        });

        function validateForm() {
            const form = document.getElementById('manage-business');
            const inputs = form.querySelectorAll('input[required],textarea[required]');
            const button = document.getElementById('save-button');
            const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
            if (!allFilled) {
                button.classList.remove('bg-blue-500', 'hover:bg-blue-700', 'text-black', 'font-bold', 'rounded',
                    'focus:outline-none', 'focus:shadow-outline');
                button.classList.add('bg-gray-200', 'text-black', 'font-bold', 'cursor-not-allowed', 'opacity-50');
                button.disabled = true;
            } else {
                button.classList.remove('bg-gray-200', 'text-black', 'font-bold', 'cursor-not-allowed', 'opacity-50');
                button.classList.add('bg-blue-500', 'hover:bg-blue-700', 'text-black', 'font-bold', 'rounded',
                    'focus:outline-none', 'focus:shadow-outline');
                button.disabled = false;
            }
        }
    </script>
@endsection
