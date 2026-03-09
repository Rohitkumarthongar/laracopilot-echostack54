@extends('layouts.web')
@section('title', 'Solar Packages')
@section('content')
<!-- Page Header -->
<section class="py-24 bg-[#0f172a] border-b border-white/5 relative overflow-hidden text-center">
    <div class="max-w-7xl mx-auto px-4 relative z-10 fade-up">
        <span class="text-amber-500 font-black text-xs uppercase tracking-[0.3em] block mb-4">Ready to Install</span>
        <h1 class="text-4xl md:text-6xl font-bold text-white tracking-tight mb-6">Complete Solar Packages</h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto font-inter">Tailored energy solutions designed for efficiency, durability, and maximum savings.</p>
    </div>
    <div class="absolute inset-0 opacity-5 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500 rounded-full blur-[120px]"></div>
    </div>
</section>

<section class="py-24 bg-[#111a2e]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($packages as $pkg)
            <div class="glass p-10 rounded-[40px] border {{ $pkg->is_featured ? 'border-amber-500/40 shadow-2xl shadow-amber-500/10' : 'border-white/5' }} flex flex-col items-start relative group card-hover">
                @if($pkg->is_featured)
                    <span class="absolute -top-4 left-10 bg-amber-500 text-white px-5 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl shadow-amber-500/20 z-10">
                        <i class="fas fa-star mr-2"></i> Most Popular
                    </span>
                @endif
                
                <div class="flex items-center justify-between w-full mb-8">
                    <span class="text-amber-500 text-[10px] uppercase font-black tracking-widest">{{ $pkg->suitable_for }}</span>
                    <span class="bg-white/5 border border-white/10 text-white px-4 py-1.5 rounded-2xl text-xs font-bold">{{ $pkg->system_size_kw }}kW System</span>
                </div>
                
                <h3 class="text-3xl font-bold text-white mb-4 tracking-tighter">{{ $pkg->name }}</h3>
                <p class="text-gray-400 text-sm font-inter leading-relaxed mb-8 flex-1">{{ $pkg->description }}</p>
                
                <div class="mb-10 w-full">
                    <div class="flex items-baseline gap-2 mb-2">
                        <span class="text-4xl font-bold text-white tracking-tighter">₹{{ number_format($pkg->price) }}</span>
                    </div>
                    <p class="text-gray-500 text-[10px] uppercase font-black tracking-widest">Inclusive of taxes & installation</p>
                </div>
                
                @if($pkg->includes)
                <div class="w-full space-y-4 mb-10 pt-10 border-t border-white/5">
                    @foreach(array_slice(explode(',', $pkg->includes), 0, 6) as $inc)
                    <div class="flex items-start gap-3 group/item">
                        <div class="w-5 h-5 bg-amber-500/10 border border-amber-500/20 rounded-full flex items-center justify-center mt-0.5 group-hover/item:bg-amber-500 group-hover/item:border-amber-500 transition-colors">
                            <i class="fas fa-check text-[10px] text-amber-500 group-hover/item:text-white"></i>
                        </div>
                        <span class="text-gray-400 text-sm font-inter group-hover/item:text-white transition-colors">{{ trim($inc) }}</span>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($pkg->warranty_years)
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-2 rounded-2xl mb-10">
                    <i class="fas fa-shield-alt text-amber-500 text-sm"></i>
                    <span class="text-white text-xs font-bold">{{ $pkg->warranty_years }} Year System Warranty</span>
                </div>
                @endif
                
                <a href="{{ route('get.quote') }}?package={{ $pkg->id }}" class="w-full bg-[#0f172a] hover:bg-amber-500 text-white py-4 rounded-2xl font-black text-center transition-all group-hover:shadow-2xl group-hover:shadow-amber-500/20">
                    Select Package
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
