@extends('layout.master')

@section('title')
  profile
@endsection

@section('content')

@extends('layout.navbar')

<div class="justify-self-center bg-white shadow-lg rounded-lg p-6 max-w-md w-full">
    <!-- User Info -->
    <div class="flex items-center justify-around space-x-6">
        <div class="w-28 h-28 bg-gray-200 rounded-full flex justify-center items-center">
            <svg class="w-10 h-10 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 4a4 4 0 100 8 4 4 0 000-8zM2 16a8 8 0 0116 0H2z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="w-2/3 flex flex-col justify-around space-y-2">
            <h1 class="h-1/3 text-lg font-semibold text-gray-800 ">Admin</h1>
            <p class="h-2/3 text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quibusdam error in...</p>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 max-w-lg w-full">
        <div id="totalInvestment" class="text-2xl font-bold text-gray-800 text-center mb-6">
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
      <div id="businessList" class="space-y-4 "></div>
      <button onclick="location.href='{{ route('investments') }}'" class="block w-full text-center bg-blue-600 text-white py-2 mt-6 rounded-lg shadow-md">
        Show More
      </button>
    </div>
    
</div>

@endsection

@section('scripts')
<script>
        // Data dummy
        const businesses = [
            {
                name: "Business A",
                investment: 1532145,
                startDate: "2024-01-01",
                endDate: "2024-06-01",
                image: "https://via.placeholder.com/64"
            },
            {
                name: "Business B",
                investment: 2000000,
                startDate: "2024-02-15",
                endDate: "2024-07-30",
                image: "https://via.placeholder.com/64"
            },
            {
                name: "Business C",
                investment: 1000000,
                startDate: "2024-03-10",
                endDate: "2024-08-20",
                image: "https://via.placeholder.com/64"
            },
            {
                name: "Business D",
                investment: 500000,
                startDate: "2024-04-01",
                endDate: "2024-09-15",
                image: "https://via.placeholder.com/64"
            },
        ];

        const totalInvestment = businesses.reduce((sum, business) => sum + business.investment, 0);
        document.getElementById('totalInvestment').innerText = `Rp ${totalInvestment.toLocaleString()}`;

        const limitedBusiness = businesses.slice(0,3);
        const investmentBarsContainer = document.getElementById('investmentBarsContainer');
        const businessList = document.getElementById('businessList');

        // persentase setiap investmentny
        const proportions = businesses.map((business) => (business.investment / totalInvestment) * 100);
        console.log(proportions);

        // bikin setiap bar utk setiap bisnis
        limitedBusiness.forEach((business, businessIndex) => {
            console.log("b-i: ", businessIndex);

            // bar container
            const barContainer = document.createElement('div');
            barContainer.classList.add('w-full', 'bg-gray-200', 'rounded-lg', 'h-10', 'relative', 'overflow-hidden', 'flex', 'items-center', 'justify-center', 'text-sm', 'font-semibold', 'text-gray-800');

            // partisi setiap bar kecil didalam 1 bar (dibagi jadi setiap bisnis)
            let currentPosition = 0;
            proportions.forEach((percentage, index) => {
                console.log("i: ", index);
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
            descriptionText.innerText = `${business.name} (${((business.investment / totalInvestment) * 100).toFixed(2)}%)`;
            descriptionText.classList.add('z-10', 'text-gray-800');
            barContainer.appendChild(descriptionText);

            investmentBarsContainer.appendChild(barContainer);
        });

        // Bikin history investor (sementara ngambilnya juga dari limited business karena pake data dummy yang sama)
        limitedBusiness.forEach((business) => {
            // buat container utk menampung setiap bisnis
            const listItem = document.createElement('div');
            listItem.classList.add('flex', 'items-center', 'bg-gray-100', 'p-4', 'rounded-lg', 'shadow-md');

            // Business image (bagian kiri setiap list)
            const image = document.createElement('img');
            image.src = business.image;
            image.alt = business.name;
            image.classList.add('w-16', 'h-16', 'rounded-full', 'object-cover', 'mr-4');

            // Business details container (container utk bagian kanan setiap list)
            const details = document.createElement('div');
            details.classList.add('flex-1');

            // Business name (content dari bagian kanan setiap list)
            const name = document.createElement('div');
            name.classList.add('text-lg', 'font-semibold', 'text-gray-800');
            name.innerText = business.name;

            // Investment amount (content dari bagian kanan setiap list)
            const investment = document.createElement('div');
            investment.classList.add('text-sm', 'text-gray-600');
            investment.innerText = `Total Investment : Rp ${business.investment.toLocaleString()}`;

            // Investment dates (content dari bagian kanan setiap list)
            const startDates = document.createElement('div');
            startDates.classList.add('text-sm', 'text-gray-500');
            const startDate = new Date(`${business.startDate}`).toLocaleString('id-ID', { year: "numeric",month: "long",day: "numeric", });
            startDates.innerText = 'From : '+startDate;

            const endDates = document.createElement('div');
            endDates.classList.add('text-sm', 'text-gray-500');
            const endDate = new Date(`${business.endDate}`).toLocaleString('id-ID', { year: "numeric",month: "long",day: "numeric", });
            endDates.innerText = 'To : '+endDate;

            // Append details (satuin semua content ke dalam container utk bagian kanan)
            details.appendChild(name);
            details.appendChild(investment);
            details.appendChild(startDates);
            details.appendChild(endDates);

            // Append to list item (satuin container kanan dan kiri)
            listItem.appendChild(image);
            listItem.appendChild(details);

            // Append list item to business list (masukin setiap list ke container investor history)
            businessList.appendChild(listItem);
        });
    </script>


@endsection