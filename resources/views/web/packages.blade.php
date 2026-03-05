@extends('layouts.web')
@section('title', 'Solar Packages')
@section('content')
<section class="bg-gradient-to-r from-orange-500 to-amber-500 py-16 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-bold">Solar Packages</h1>
        <p class="text-orange-100 mt-3 text-lg">Complete solar solutions tailored for every need and budget</p>
    </div>
</section>
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($packages as $pkg)
            <div class="card-hover bg-white border-2 {{ $pkg->is_featured ? 'border-orange-500' : 'border-gray-200' }} rounded-2xl p-8 relative">
                @if($pkg->is_featured)<span class="absolute -top-3 left-6 bg-orange-500 text-white px-4 py-1 rounded-full text-xs font-bold">⭐ Featured</span>@endif
                <div class="flex items-center justify-between mb-2">
                    <span class="text-orange-500 text-sm font-medium uppercase">{{ ucfirst($pkg->suitable_for) }}</span>
                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-bold">{{ $pkg->system_size_kw }}kW</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $pkg->name }}</h3>
                <p class="text-gray-500 text-sm mb-4">{{ $pkg->description }}</p>
                <div class="text-3xl font-bold text-orange-600 mb-1">₹{{ number_format($pkg->price) }}</div>
                <p class="text-gray-400 text-xs mb-5">All inclusive price with installation</p>
                @if($pkg->includes)
                <ul class="space-y-2 mb-6">
                    @foreach(array_slice(explode(',', $pkg->includes), 0, 6) as $inc)
                    <li class="flex items-start text-sm text-gray-600"><i class="fas fa-check text-green-500 mr-2 flex-shrink-0 mt-0.5"></i>{{ trim($inc) }}</li>
                    @endforeach
                </ul>
                @endif
                @if($pkg->warranty_years)<p class="text-xs text-gray-400 mb-4"><i class="fas fa-shield-alt text-green-400 mr-1"></i>{{ $pkg->warranty_years }} Year Warranty</p>@endif
                <a href="{{ route('get.quote') }}?package={{ $pkg->id }}" class="block text-center {{ $pkg->is_featured ? 'bg-orange-500 text-white' : 'border-2 border-orange-500 text-orange-600 hover:bg-orange-500 hover:text-white' }} py-3 rounded-xl font-semibold transition-all">Get This Package</a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
