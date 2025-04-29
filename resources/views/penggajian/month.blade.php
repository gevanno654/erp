@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Pilih Bulan Penggajian</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($months as $month)
            <div class="bg-white rounded-lg shadow-md p-6 flex justify-between items-center border border-gray-200">
                <div>
                    <h3 class="text-lg font-semibold">
                        {{ \Carbon\Carbon::create($month['year'], $month['month'], 1)->locale('id')->isoFormat('MMMM YYYY') }}
                    </h3>
                    @if(!$month['has_data'])
                        <p class="text-sm text-gray-500 mt-1">Belum ada data</p>
                    @endif
                </div>
                <a href="{{ route('penggajian.index', $month['month_year']) }}"
                   class="{{ $month['has_data'] ? 'bg-blue-500 hover:bg-blue-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded-md transition duration-200">
                    {{ $month['has_data'] ? 'Detail' : 'Buat Penggajian' }}
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
