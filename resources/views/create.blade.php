@extends('layout.master')

@section('title')
    Upload Business Image
@endsection

@section('content')

@extends('layout.navbar')

<div class="relative flex items-center">
    <a href="{{ route('listBusiness') }}" class="absolute left-4 flex items-center bg-white border rounded-full p-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24" class="">
            <rect width="24" height="24" fill="none" />
            <path fill="currentColor"
                d="M19 11H7.83l4.88-4.88c.39-.39.39-1.03 0-1.42a.996.996 0 0 0-1.41 0l-6.59 6.59a.996.996 0 0 0 0 1.41l6.59 6.59a.996.996 0 1 0 1.41-1.41L7.83 13H19c.55 0 1-.45 1-1s-.45-1-1-1" />
        </svg>
    </a>
    <h1 class="text-3xl mx-auto font-bold lg:text-5xl">Create Business</h1>
</div>



<div class="flex justify-center mt-10">
    <div class="w-full">
        <form action="{{ route('business.upload') }}" method="POST" enctype="multipart/form-data" id="create-business" oninput="validateForm()">
            @csrf

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">
                <p class="block text-gray-700 text-sm font-bold mb-2">Business Profile Picture</p>
                <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg id = "main-upload" class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <img src="" alt="" id="image-preview" class="max-h-44">
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPEG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="image" type="file" class="hidden" name="image" required accept="image/*"/>
                </label>
                @error('image')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6 h-auto overflow-hidden">
                <p class="block text-gray-700 text-sm font-bold mb-2">Additional Photos</p>
                <label for="file" class="flex flex-col items-center justify-center w-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 h-auto overflow-hidden">
                        <svg id="file-upload" class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <div id="file-preview-container" class="flex gap-2 flex-wrap overflow-hidden"></div>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPEG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="file" type="file" class="hidden" name="file[]" multiple required accept="image/*"/>
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
                <textarea name="description" id="description" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                    Address
                </label>
                <textarea name="address" id="address" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                    Phone Number
                </label>
                <input type="tel" id="phone" name="phone" pattern="08\d{8,}" title="The number must start with 08 and have at least 10 digits" value="{{ old('phone') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @error('phone')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 max-lg:flex-col">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex-grow">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="startDate">
                        Start Date
                    </label>
                    <input type="date" name="startDate" id="startDate" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old ('startDate') }}">
                    @error('startDate')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex-grow">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="endDate">
                        End Date
                    </label>
                    <input type="date" name="endDate" id="endDate" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old ('endDate') }}">
                    @error('endDate')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nominal">
                    Nominal
                </label>
                <input type="number" name="nominal" id="nominal" required value="{{ old ('nominal') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('nominal')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center">
                <button id="create-button" type="submit" class="w-full py-2 px-4 rounded bg-gray-200 text-black font-bold cursor-not-allowed opacity-50" disabled>
                    Create Business
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function (e){
            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#main-upload').attr('class','hidden');
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
                                $('#file-upload').attr('class','hidden');
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

        function validateForm() {
        const form = document.getElementById('create-business');
        const inputs = form.querySelectorAll('input[required],textarea[required]');
        const button = document.getElementById('create-button');
        const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
        if(!allFilled){
            button.classList.remove('bg-blue-500', 'hover:bg-blue-700', 'text-black', 'font-bold', 'rounded', 'focus:outline-none', 'focus:shadow-outline');
            button.classList.add('bg-gray-200','text-black', 'font-bold', 'cursor-not-allowed', 'opacity-50');
            button.disabled = true;
        }else{
            button.classList.remove('bg-gray-200','text-black', 'font-bold', 'cursor-not-allowed', 'opacity-50');
            button.classList.add('bg-blue-500', 'hover:bg-blue-700', 'text-black', 'font-bold', 'rounded', 'focus:outline-none', 'focus:shadow-outline');
            button.disabled = false;
        }
        }

        $('#create-business').validate({
            rules: {
                title: {
                    required: true,
                    maxlength: 50,
                    remote: {
                        url: '/check-title',
                        type: 'GET',
                        data: {
                            title: function() {
                                return $('#title').val();
                            }
                        },
                        message: "This title has already been taken.",
                        dataFilter: function(response) {
                            return response === 'true' ? 'true' : 'false';
                        }
                    }
                },
                description: {
                    required: true,
                    maxlength: 255,
                },
                image: {
                    required: true,
                    extension: "png|jpg|jpeg|gif|svg",
                    filesize: 2048 * 1024,
                },
                file: {
                    required: true,
                },
                'file.*': {
                    extension: "jpeg|png|jpg|gif|svg",
                    filesize: 2048 * 1024,
                },
                startDate: {
                    required: true,
                },
                endDate: {
                    required: true,
                    greaterThanOrEqual: '#startDate',
                },
                nominal: {
                    required: true,
                },
                address: {
                    required: true,
                },
                phone: {
                    required: true,
                },
            },
            messages: {
                title: {
                    required: "Title is required.",
                    maxlength: "Title must not exceed 50 characters.",
                    remote: "This title has already been taken."
                },
                description: {
                    required: "Description is required.",
                    maxlength: "Description must not exceed 255 characters.",
                },
                image: {
                    required: "An image is required.",
                    extension: "Invalid file type. Only PNG, JPG, JPEG, GIF, SVG are allowed.",
                    filesize: "File size must not exceed 2MB.",
                },
                file: {
                    required: "A file is required.",
                },
                'file.*': {
                    extension: "Invalid file type. Only JPEG, PNG, JPG, GIF, SVG are allowed.",
                    filesize: "File size must not exceed 2MB.",
                },
                startDate: {
                    required: "Start date is required.",
                },
                endDate: {
                    required: "End date is required.",
                    greaterThanOrEqual: "End date must be the same or later than the start date.",
                },
                nominal: {
                    required: "Nominal value is required.",
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
                    title: 'Do you want to create business?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Success!','Your business has been submitted','success').then((result)=>{
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


        $.validator.addMethod('greaterThanOrEqual', function(value, element, param) {
            var startDate = $(param).val();
            if (startDate) {
                return new Date(value) >= new Date(startDate);
            }
            return true;
        }, 'The end date must be the same or later than the start date.');

    </script>
@endsection
