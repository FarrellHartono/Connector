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
                            <th class="text-left p-2 border w-3/6">Business</th>
                            <th class="text-left p-2 border w-2/6">Investment (IDR)</th>
                            <th class="text-left p-2 border w-1/6">Contribution</th>
                        </tr>
                    </thead>
                    <tbody id="barsTable"></tbody>
                </table>
            </div>
        </div>

        <!-- Investor History -->
        <!-- <div>
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
        </div> -->

        <div class="mb-10">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">List of Businesses</h2>
            <div class="overflow-y-auto max-h-80 bg-gray-100 p-4 rounded-lg shadow-lg">
                @foreach ($investments as $invest)
                    @php
                        $folderPath = $invest->business->image_path;
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
                    <div onclick="window.location.href='{{ route('business.show', $invest->business_id) }}'" 
                        class="flex items-center mb-4 cursor-pointer bg-white p-4 rounded-lg shadow-md hover:bg-gray-200">
                        <div class="w-16 h-16 bg-black rounded-lg mr-4"></div>
                        <div>
                            <h3 class="text-lg font-semibold">{{ $invest->business->title }}</h3>
                            <p class="text-gray-600">Total Investment: Rp {{ number_format($invest->total_amount, 0, ',', '.') }}</p>
                            <p class="text-gray-500 text-sm">
                                Period: {{ $invest->start_date }} - {{ $invest->end_date }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
        const investments = @json($investments);
        console.log(investments);
        const barsTable = document.getElementById('barsTable');
        const totalInvestment = investments.reduce((sum, invest) => sum + Number(invest.total_amount), 0);

        investments.forEach((invest) => {
            console.log(invest.total_amount);
            // Convert data ke dalam tabel alokasi investasi yang sedang berjalan
            const barRow = document.createElement('tr');
            barRow.innerHTML = `
                <td class="p-2 border">${invest.business.title}</td>
                <td class="p-2 border">Rp ${invest.total_amount.toLocaleString()}</td>
                <td class="p-2 border">${((Number(invest.total_amount) / totalInvestment) * 100).toFixed(2)}%</td>
            `;
            barsTable.appendChild(barRow);
        });
    </script>
@endsection