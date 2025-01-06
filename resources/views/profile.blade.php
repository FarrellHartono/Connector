@extends('layout.master')

@section('title')
  profile
@endsection

@section('content')

@extends('layout.navbar')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<div class="justify-self-center bg-white shadow-lg rounded-lg p-6 max-w-md w-full">
    <!-- User Info -->
    <div class="flex items-center justify-around space-x-6">
        <div class="flex flex-col justify-around space-y-2">
            <h1 class="h-1/3 text-3xl text-center font-semibold text-gray-800 ">{{ Auth::user()->name }}</h1>
        </div>
    </div>

    <div id="emptyDataContainer" class="hidden mt-4">
        <h1 class="text-2xl font-bold text-gray-400 mb-6 text-center">No investments have been made yet</h1>
        <i class="fas fa-box-open text-8xl text-center w-full "></i>
    </div>  

    <div id="investmentContainer">
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-lg w-full">
            <div class="space-y-4 text-center mb-4 text-2xl font-semibold">Current Investment</div>
            <div id="totalInvestment" class="text-xl font-semibold text-gray-800 text-center mb-4">
                Rp 0
            </div>

            <!-- Alokasi Investasi yang lagi berjalan -->
            <div id="investmentBarsContainer" class="space-y-4"></div>
            <button onclick="location.href='{{ route('investments') }}'" class="block w-full text-center bg-blue-600 text-white py-2 mt-6 rounded-lg shadow-md">
                Show More
            </button>
        </div>

        <!-- Investory history -->
        <div class="bg-white shadow-lg rounded-lg p-6 mt-6 max-w-lg w-full">
            <div class="space-y-4 text-center mb-4 text-2xl font-semibold">Investment History</div>
            <div id="businessList" class="space-y-4 "></div>
            <button onclick="location.href='{{ route('investments') }}'" class="block w-full text-center bg-blue-600 text-white py-2 mt-6 rounded-lg shadow-md">
                Show More
            </button>
        </div>
    </div>
</div>
@php
    $filePaths = []; // Initialize an array to hold file paths

    foreach ($investments as $invest) {
        $folderPath = $invest->business->image_path;
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
        $filePath = null;

        foreach ($extensions as $extension) {
            $fullFilePath = $folderPath . '/' . 'main' . '.' . $extension;

            if (Storage::disk('public')->exists(str_replace('public/', '', $fullFilePath))) {
                $filePath = $fullFilePath;
                break;
            }
        }

        $filePaths[] = [
            'filePath' => $filePath
        ];
    }
@endphp

@endsection

@section('scripts')
<script>
        var investments = @json($investments);

        if (investments == null)
        {
            $("#emptyDataContainer").removeClass('hidden');
            $("#investmentContainer").addClass('hidden');
        }

        const filePaths = @json($filePaths);

        const totalInvestment = investments.reduce((sum, investment) => sum + Number(investment.total_amount), 0);
        document.getElementById('totalInvestment').innerText = `Rp ${totalInvestment.toLocaleString()}`;

        const limitedBusiness = investments.slice(0,3);
        const investmentBarsContainer = document.getElementById('investmentBarsContainer');
        const businessList = document.getElementById('businessList');

        // persentase setiap investmentny
        const proportions = investments.map((investment) => (investment.total_amount / totalInvestment) * 100);

        // bikin setiap bar utk setiap bisnis
        limitedBusiness.forEach((business, businessIndex) => {

            // bar container
            const barContainer = document.createElement('div');
            barContainer.classList.add('w-full', 'bg-gray-200', 'rounded-lg', 'h-10', 'relative', 'overflow-hidden', 'flex', 'items-center', 'justify-center', 'text-sm', 'font-semibold', 'text-gray-800');

            // partisi setiap bar kecil didalam 1 bar (dibagi jadi setiap bisnis)
            let currentPosition = 0;
            proportions.forEach((percentage, index) => {
                const barSegment = document.createElement('div');
                barSegment.style.position = "absolute";
                barSegment.style.left = `${currentPosition}%`;
                barSegment.style.width = `${percentage}%`;
                barSegment.style.backgroundColor = index === businessIndex ? "#16a34a" : "#d1fae5"; // Highlight current business
                barSegment.style.height = "100%";

                // Posisi awal setiap bar kecil
                currentPosition += percentage;

                barContainer.appendChild(barSegment);
            });

            // Deskripsi setiap bar container
            const descriptionText = document.createElement('span');
            descriptionText.innerText = `${business.business.title} (${((business.total_amount / totalInvestment) * 100).toFixed(2)}%, Rp ${Number(business.total_amount).toLocaleString()})`;
            descriptionText.classList.add('z-10', 'text-gray-800');
            barContainer.appendChild(descriptionText);

            investmentBarsContainer.appendChild(barContainer);
        });

        // Bikin history investor (sementara ngambilnya juga dari limited business karena pake data dummy yang sama)
        limitedBusiness.forEach((business, index) => {
            // buat container utk menampung setiap bisnis
            const listItem = document.createElement('div');
            listItem.classList.add('flex', 'items-center', 'bg-gray-100', 'p-4', 'rounded-lg', 'shadow-md', 'cursor-pointer');

            var imageUrl = "{{ asset('storage') }}" + '/' + filePaths[0].filePath.replace('public/', '');
            // Business image (bagian kiri setiap list)
            const image = document.createElement('img');
            image.src = imageUrl;
            image.alt = business.business.title;
            image.classList.add('w-16', 'h-16', 'rounded-full', 'object-cover', 'mr-4');

            // Business details container (container utk bagian kanan setiap list)
            const details = document.createElement('div');
            details.classList.add('flex-1');

            // Business name (content dari bagian kanan setiap list)
            const name = document.createElement('div');
            name.classList.add('text-lg', 'font-semibold', 'text-gray-800');
            name.innerText = business.business.title;

            // Investment amount (content dari bagian kanan setiap list)
            const investment = document.createElement('div');
            investment.classList.add('text-sm', 'text-gray-600');
            investment.innerText = `Total Investment : Rp ${business.total_amount.toLocaleString()}`;

            // Investment dates (content dari bagian kanan setiap list)
            const startDates = document.createElement('div');
            startDates.classList.add('text-sm', 'text-gray-500');
            const startDate = new Date(`${business.created_at}`).toLocaleString('id-ID', { year: "numeric",month: "long",day: "numeric", });
            startDates.innerText = 'Created Date : '+startDate;


            // Append details (satuin semua content ke dalam container utk bagian kanan)
            details.appendChild(name);
            details.appendChild(investment);
            details.appendChild(startDates);

            // Append to list item (satuin container kanan dan kiri)
            listItem.appendChild(image);
            listItem.appendChild(details);

            // Append list item to business list (masukin setiap list ke container investor history)
            businessList.appendChild(listItem);
        });
    </script>


@endsection