@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Pilih Bulan Jurnal</h1>

        <!-- Dropdown Tahun -->
        <div class="relative">
            <form method="GET" action="{{ route('jurnal.month') }}">
                <select
                    name="year"
                    onchange="this.form.submit()"
                    class="block appearance-none bg-white border border-gray-300 rounded-md py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-blue-500"
                >
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                            Tahun {{ $year }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($months as $month)
            <div class="bg-white rounded-lg shadow-md p-6 flex justify-between items-center border border-gray-200">
                <div>
                    <h3 class="text-lg font-semibold">
                        {{ \Carbon\Carbon::create($month['year'], $month['month'], 1)->locale('id')->isoFormat('MMMM') }}
                    </h3>
                    @if(!$month['has_data'])
                        <p class="text-sm text-gray-500 mt-1">Belum ada data</p>
                    @endif
                </div>
                <a href="{{ route('jurnal.index', $month['month_year']) }}"
                   class="{{ $month['has_data'] ? 'bg-blue-500 hover:bg-blue-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded-md transition duration-200">
                    {{ $month['has_data'] ? 'Detail' : 'Buat Jurnal' }}
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
