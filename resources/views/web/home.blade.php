@extends('layouts.web')
@section('title', $settings['company_name'] ?? 'SolarVolt Solutions')
@section('content')
<!-- Hero -->
<section class="hero-bg min-h-screen flex items-center relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 py-32 relative z-10 w-full">
        <div class="max-w-3xl fade-up">
            <span class="inline-flex items-center gap-2 bg-amber-500/10 border border-amber-500/20 text-amber-500 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-8">
                <i class="fas fa-bolt"></i> Powering a Sustainable Future
            </span>
            <h1 class="text-6xl md:text-[5.5rem] font-black leading-[1] mb-8 text-white tracking-tighter">
                Harness the <br> <span class="text-amber-500">Power</span> of the Sun
            </h1>
            <p class="text-lg md:text-xl text-gray-400 mb-12 leading-relaxed font-inter max-w-2xl">
                Premium solar energy solutions for modern homes and businesses. Engineering a cleaner, brighter tomorrow with high-efficiency technology.
            </p>
            <div class="flex flex-col sm:flex-row gap-6">
                <a href="{{ route('get.quote') }}" class="relative inline-flex items-center justify-center px-12 py-5 overflow-hidden font-black text-white transition-all bg-amber-500 rounded-2xl group active:scale-95 shadow-2xl shadow-amber-500/30">
                    <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                    <span class="relative">Calculate My Savings</span>
                    <i class="fas fa-bolt ml-4 text-xs opacity-50"></i>
                </a>
                <a href="{{ route('products') }}" class="group inline-flex items-center justify-center px-12 py-5 font-black text-white glass hover:bg-white/10 rounded-2xl transition-all border border-white/10 active:scale-95">
                    Live Catalog <i class="fas fa-arrow-right ml-4 text-xs group-hover:translate-x-2 transition-transform opacity-30"></i>
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mt-20 pt-10 border-t border-white/10">
                <div>
                    <h3 class="text-3xl font-bold text-amber-500 mb-1">5,000+</h3>
                    <p class="text-gray-500 text-sm font-medium">Installations</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-amber-500 mb-1">98%</h3>
                    <p class="text-gray-500 text-sm font-medium">Client Satisfaction</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-amber-500 mb-1">25yr</h3>
                    <p class="text-gray-500 text-sm font-medium">Panel Warranty</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative solar panel grid overlay -->
    <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-20 hidden lg:block pointer-events-none">
        <div class="h-full w-full" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-32 bg-[#0f172a] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="text-center mb-20 fade-up">
            <span class="text-amber-500 font-black text-xs uppercase tracking-[0.3em] block mb-4">Why Choose Us</span>
            <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">The {{ explode(' ', $settings['company_name'] ?? 'SolarVolt Solutions')[0] }} Advantage</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $advantages = [
                    ['icon' => 'fas fa-dollar-sign', 'title' => 'Save Up to 70%', 'desc' => 'Drastically reduce your electricity bills with our high-efficiency solar panels.'],
                    ['icon' => 'fas fa-leaf', 'title' => 'Eco-Friendly', 'desc' => 'Reduce your carbon footprint and contribute to a cleaner, greener planet.'],
                    ['icon' => 'fas fa-shield-alt', 'title' => '25-Year Warranty', 'desc' => 'Industry-leading warranty coverage for complete peace of mind.'],
                    ['icon' => 'fas fa-tools', 'title' => 'Expert Installation', 'desc' => 'Certified technicians handle everything from design to installation.'],
                    ['icon' => 'fas fa-clock', 'title' => 'Quick Turnaround', 'desc' => 'From consultation to installation in as little as 2 weeks.'],
                    ['icon' => 'fas fa-trophy', 'title' => 'Premium Quality', 'desc' => 'Tier-1 solar panels with the highest efficiency ratings available.'],
                ];
            @endphp

            @foreach($advantages as $adv)
            <div class="glass p-12 rounded-[40px] border border-white/5 card-hover group relative">
                <div class="absolute -top-6 -right-6 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-colors"></div>
                
                <div class="w-20 h-20 bg-amber-500/10 rounded-3xl flex items-center justify-center mb-10 border border-amber-500/20 group-hover:bg-amber-500 group-hover:scale-110 transition-all duration-500 shadow-xl group-hover:shadow-amber-500/20">
                    <i class="{{ $adv['icon'] }} text-amber-500 text-3xl group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-3xl font-black text-white mb-6 tracking-tighter">{{ $adv['title'] }}</h3>
                <p class="text-gray-400 leading-relaxed font-inter font-medium">
                    {{ $adv['desc'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Energy Solutions -->
<section class="py-32 bg-[#111a2e]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-20 fade-up">
            <span class="text-amber-500 font-black text-xs uppercase tracking-[0.3em] block mb-4">Energy Solutions</span>
            <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Tailored for your specific needs</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $solutions = [
                    ['img' => 'product-residential.jpg', 'title' => 'Residential Solar', 'desc' => 'Power your home with clean energy and eliminate your electricity bills forever.'],
                    ['img' => 'product-commercial.jpg', 'title' => 'Commercial Solar', 'desc' => 'High-capacity solar systems for businesses, industries, and large-scale buildings.'],
                    ['img' => 'product-portable.jpg', 'title' => 'Portable & Backup', 'desc' => 'Advanced battery storage and portable solar solutions for off-grid power anywhere.'],
                ];
            @endphp

            @foreach($solutions as $sol)
            <div class="group relative h-[450px] rounded-[40px] overflow-hidden border border-white/5 card-hover shadow-2xl">
                <!-- Image with Zoom on Hover -->
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('{{ asset('storage/'.$sol['img']) }}')"></div>
                
                <!-- Dark Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/40 to-transparent"></div>
                
                <!-- Content -->
                <div class="absolute inset-0 p-10 flex flex-col justify-end">
                    <h3 class="text-3xl font-black text-white mb-4 tracking-tight group-hover:text-amber-500 transition-colors">{{ $sol['title'] }}</h3>
                    <p class="text-gray-300 font-inter leading-relaxed text-sm mb-6 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                        {{ $sol['desc'] }}
                    </p>
                    <a href="{{ route('get.quote') }}" class="inline-flex items-center gap-2 text-amber-500 font-black uppercase text-xs tracking-widest group-hover:gap-4 transition-all">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-32 bg-[#111a2e] border-y border-white/5">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div class="fade-up">
                <span class="text-amber-500 font-black text-xs uppercase tracking-[0.3em] block mb-4">Our Catalog</span>
                <h2 class="text-4xl font-bold text-white tracking-tight">Premium Solar Hardware</h2>
            </div>
            <a href="{{ route('products') }}" class="text-amber-500 font-bold hover:text-amber-400 transition-colors flex items-center gap-2">
                View All Products <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="glass rounded-3xl overflow-hidden border border-white/5 card-hover flex flex-col h-full">
                <div class="aspect-square bg-[#0f172a] p-8 flex items-center justify-center relative overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain relative z-10 group-hover:scale-110 transition-transform duration-500">
                    @else
                        <i class="fas fa-solar-panel text-6xl text-white/5"></i>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
                </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-amber-500/80 text-[10px] uppercase font-black tracking-widest block mb-2">{{ $product->productCategory->name ?? 'Product' }}</span>
                            <h3 class="text-lg font-black text-white hover:text-amber-500 transition-colors tracking-tight">{{ $product->name }}</h3>
                        </div>
                        <div class="mt-6 flex items-center justify-between pt-6 border-t border-white/5">
                            <span class="text-white font-black">₹{{ number_format($product->selling_price) }}</span>
                            <a href="{{ route('products') }}" class="w-10 h-10 bg-white/5 hover:bg-amber-500 rounded-xl flex items-center justify-center transition-all">
                                <i class="fas fa-arrow-right text-[10px] text-white"></i>
                            </a>
                        </div>
                    </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-amber-500"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 20px 20px;"></div>
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
        <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tighter">
            Ready to switch to clean energy?
        </h2>
        <p class="text-white/80 text-xl font-medium mb-12 max-w-2xl mx-auto">
            Join thousands of happy homeowners and businesses who saved millions on electricity bills.
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('get.quote') }}" class="bg-white text-amber-600 px-12 py-5 rounded-2xl font-black text-xl hover:shadow-2xl transition-all hover:-translate-y-1">
                Start Saving Today
            </a>
            <a href="{{ route('contact') }}" class="bg-[#0f172a] text-white px-12 py-5 rounded-2xl font-black text-xl hover:shadow-2xl transition-all hover:-translate-y-1">
                Contact Expert
            </a>
        </div>
    </div>
</section>
@endsection

