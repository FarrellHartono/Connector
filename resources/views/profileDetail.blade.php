@extends('layout.master')

@section('title')
  detail Profile
@endsection

@section('content')

@extends('layout.navbar')

<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Investment Details</h1>

         <!-- Alokasi Investasi yang lagi berjalan -->
        <div class="mb-10">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Investment Alocation</h2>
            <div class="overflow-y-auto max-h-60">
                <table class="w-full table-fixed border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="text-left p-2 border">Business</th>
                            <th class="text-left p-2 border">Investment (IDR)</th>
                            <th class="text-left p-2 border">Contribution</th>
                        </tr>
                    </thead>
                    <tbody id="barsTable"></tbody>
                </table>
            </div>
        </div>

        <!-- Investor History -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">List of Contributed Businesses</h2>
            <div class="overflow-y-auto max-h-60">
                <table class="w-full table-fixed border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="text-left p-2 border">Business</th>
                            <th class="text-left p-2 border">Total Investment</th>
                            <th class="text-left p-2 border">Start Period</th>
                            <th class="text-left p-2 border">End Period</th>
                        </tr>
                    </thead>
                    <tbody id="businessTable"></tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
        // data dummy
        const businesses = [
            { name: "Business A", investment: 1500000, startDate: "2024-01-01", endDate: "2024-06-01" },
            { name: "Business B", investment: 2000000, startDate: "2024-02-15", endDate: "2024-07-30" },
            { name: "Business C", investment: 1000000, startDate: "2024-03-10", endDate: "2024-08-20" },
            { name: "Business D", investment: 500000, startDate: "2024-04-01", endDate: "2024-09-15" },
            { name: "Business E", investment: 250000, startDate: "2024-05-01", endDate: "2024-10-15" },
            { name: "Business F", investment: 300000, startDate: "2024-06-01", endDate: "2024-11-01" },
        ];

        
        const barsTable = document.getElementById('barsTable');
        const businessTable = document.getElementById('businessTable');

        // bikin setiap row utk 2 tabel diatas (ini fungsinya disatuin karena sementara pake data yang sama)
        // (kalau datanya real nanti harusnya pake 2 data berbeda jadi fungsinya dipisah)
        businesses.forEach((business) => {
            // Convert data ke dalam tabel alokasi investasi yang sedang berjalan
            const barRow = document.createElement('tr');
            barRow.innerHTML = `
                <td class="p-2 border">${business.name}</td>
                <td class="p-2 border">Rp ${business.investment.toLocaleString()}</td>
                <td class="p-2 border">${((business.investment / businesses.reduce((sum, b) => sum + b.investment, 0)) * 100).toFixed(2)}%</td>
            `;
            barsTable.appendChild(barRow);

            // Convert data ke dalam tabel investor history
            console.log(`${business.startDate}`);
            const startDate = new Date(`${business.startDate}`).toLocaleString('id-ID', { year: "numeric",month: "long",day: "numeric", });
            const endDate = new Date(`${business.endDate}`).toLocaleString('id-ID', { year: "numeric",month: "long",day: "numeric", });

            const businessRow = document.createElement('tr');
            businessRow.innerHTML = `
                <td class="p-2 border">${business.name}</td>
                <td class="p-2 border">Rp ${business.investment.toLocaleString()}</td>
                <td class="p-2 border">`+startDate+`</td>
                <td class="p-2 border">`+endDate+`</td>
            `;
            businessTable.appendChild(businessRow);
        });
    </script>
@endsection