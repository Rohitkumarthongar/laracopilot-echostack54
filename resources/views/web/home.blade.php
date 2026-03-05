@extends('layouts.web')
@section('title', $settings['company_name'] ?? 'SolarTech Solutions')
@section('content')
<!-- Hero -->
<section class="hero-bg min-h-screen flex items-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-64 h-64 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-yellow-300 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-white fade-up">
                <span class="inline-block bg-white/20 text-white px-4 py-1 rounded-full text-sm font-medium mb-6">🌞 India's Trusted Solar Brand</span>
                <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">{{ $settings['website_hero_title'] ?? 'Switch to Solar, Save More' }}</h1>
                <p class="text-xl text-orange-100 mb-8 leading-relaxed">{{ $settings['website_hero_subtitle'] ?? 'Premium solar solutions for homes and businesses. Reduce your electricity bill by up to 90%.' }}</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('get.quote') }}" class="bg-white text-orange-600 px-8 py-4 rounded-full font-bold text-lg hover:shadow-xl transition-all inline-flex items-center justify-center"><i class="fas fa-calculator mr-2"></i>Get Free Quote</a>
                    <a href="{{ route('products') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-orange-600 transition-all inline-flex items-center justify-center"><i class="fas fa-solar-panel mr-2"></i>Explore Products</a>
                </div>
                <div class="flex flex-wrap gap-8 mt-10">
                    <div class="text-center"><p class="text-3xl font-bold">500+</p><p class="text-orange-100 text-sm">Installations</p></div>
                    <div class="text-center"><p class="text-3xl font-bold">25yr</p><p class="text-orange-100 text-sm">Panel Warranty</p></div>
                    <div class="text-center"><p class="text-3xl font-bold">90%</p><p class="text-orange-100 text-sm">Bill Reduction</p></div>
                    <div class="text-center"><p class="text-3xl font-bold">24/7</p><p class="text-orange-100 text-sm">Support</p></div>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/20 rounded-2xl p-5 text-white text-center"><i class="fas fa-sun text-4xl text-yellow-300 mb-2 block"></i><p class="font-semibold">Solar Panels</p><p class="text-sm text-orange-100">High Efficiency</p></div>
                        <div class="bg-white/20 rounded-2xl p-5 text-white text-center"><i class="fas fa-bolt text-4xl text-yellow-300 mb-2 block"></i><p class="font-semibold">Inverters</p><p class="text-sm text-orange-100">Smart & Reliable</p></div>
                        <div class="bg-white/20 rounded-2xl p-5 text-white text-center"><i class="fas fa-battery-full text-4xl text-yellow-300 mb-2 block"></i><p class="font-semibold">Batteries</p><p class="text-sm text-orange-100">24/7 Backup</p></div>
                        <div class="bg-white/20 rounded-2xl p-5 text-white text-center"><i class="fas fa-tools text-4xl text-yellow-300 mb-2 block"></i><p class="font-semibold">Installation</p><p class="text-sm text-orange-100">Expert Team</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Categories -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-14">
            <span class="text-orange-500 font-semibold text-sm uppercase tracking-wider">What We Offer</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Browse by Category</h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">Explore our complete range of solar products organized by category</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5">
            @foreach($categories as $cat)
            @php
                $colorMap = ['yellow'=>['bg'=>'bg-yellow-50','icon'=>'text-yellow-500','border'=>'border-yellow-200','hover'=>'hover:bg-yellow-100'],'blue'=>['bg'=>'bg-blue-50','icon'=>'text-blue-500','border'=>'border-blue-200','hover'=>'hover:bg-blue-100'],'green'=>['bg'=>'bg-green-50','icon'=>'text-green-500','border'=>'border-green-200','hover'=>'hover:bg-green-100'],'red'=>['bg'=>'bg-red-50','icon'=>'text-red-500','border'=>'border-red-200','hover'=>'hover:bg-red-100'],'gray'=>['bg'=>'bg-gray-50','icon'=>'text-gray-500','border'=>'border-gray-200','hover'=>'hover:bg-gray-100'],'purple'=>['bg'=>'bg-purple-50','icon'=>'text-purple-500','border'=>'border-purple-200','hover'=>'hover:bg-purple-100'],'orange'=>['bg'=>'bg-orange-50','icon'=>'text-orange-500','border'=>'border-orange-200','hover'=>'hover:bg-orange-100']];
                $c = $colorMap[$cat->color] ?? $colorMap['orange'];
            @endphp
            <a href="{{ route('products.category', $cat->slug) }}" class="card-hover {{ $c['bg'] }} border {{ $c['border'] }} {{ $c['hover'] }} rounded-2xl p-5 text-center transition-all">
                <div class="w-14 h-14 mx-auto mb-3 flex items-center justify-center">
                    <i class="{{ $cat->icon ?? 'fas fa-solar-panel' }} text-3xl {{ $c['icon'] }}"></i>
                </div>
                <p class="font-semibold text-gray-800 text-sm">{{ $cat->name }}</p>
                <p class="text-gray-400 text-xs mt-1">{{ $cat->products_count }} products</p>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('products') }}" class="inline-flex items-center text-orange-600 font-semibold hover:text-orange-700">View All Products <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </div>
</section>

<!-- Featured Packages -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-14">
            <span class="text-orange-500 font-semibold text-sm uppercase tracking-wider">Ready to Install</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Popular Solar Packages</h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">Complete solar packages designed for different needs and budgets</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($packages as $i => $pkg)
            <div class="card-hover bg-white border-2 {{ $i === 1 ? 'border-orange-500 relative' : 'border-gray-200' }} rounded-2xl p-8">
                @if($i === 1)<span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-orange-500 text-white px-4 py-1 rounded-full text-xs font-bold">⭐ Most Popular</span>@endif
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ $pkg->name }}</h3>
                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium">{{ $pkg->system_size_kw }}kW</span>
                </div>
                <div class="text-3xl font-bold text-orange-600 mb-1">₹{{ number_format($pkg->price) }}</div>
                <p class="text-gray-500 text-sm mb-5">{{ $pkg->description }}</p>
                @if($pkg->includes)
                <ul class="space-y-2 mb-6">
                    @foreach(explode(',', $pkg->includes) as $inc)
                    <li class="flex items-center text-sm text-gray-600"><i class="fas fa-check text-green-500 mr-2 flex-shrink-0"></i>{{ trim($inc) }}</li>
                    @endforeach
                </ul>
                @endif
                <a href="{{ route('get.quote') }}?package={{ $pkg->id }}" class="block text-center {{ $i === 1 ? 'bg-orange-500 text-white' : 'border-2 border-orange-500 text-orange-600' }} py-3 rounded-xl font-semibold hover:bg-orange-500 hover:text-white transition-all">Get This Package</a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('packages') }}" class="inline-flex items-center text-orange-600 font-semibold hover:text-orange-700">View All Packages <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </div>
</section>

<!-- Why Us -->
<section class="py-20 bg-gradient-to-br from-orange-50 to-amber-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-14">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Why Choose SolarTech?</h2>
            <p class="text-gray-500 mt-3">We are committed to quality, reliability and customer satisfaction</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([['fas fa-award','orange','Premium Quality','Top-tier solar products from globally certified manufacturers.'],['fas fa-user-cog','blue','Expert Installation','Our trained technicians ensure safe and efficient installation.'],['fas fa-headset','green','24/7 Support','Round-the-clock customer support and AMC services.'],['fas fa-rupee-sign','purple','Best Price','Competitive pricing with easy EMI options available.']] as $f)
            <div class="text-center">
                <div class="w-16 h-16 bg-{{ $f[1] }}-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="{{ $f[0] }} text-{{ $f[1] }}-500 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">{{ $f[2] }}</h3>
                <p class="text-gray-500 text-sm">{{ $f[3] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 hero-bg text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Go Solar?</h2>
        <p class="text-xl text-orange-100 mb-8">Get a free consultation and customized quote within 24 hours.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('get.quote') }}" class="bg-white text-orange-600 px-8 py-4 rounded-full font-bold hover:shadow-xl transition-all"><i class="fas fa-calculator mr-2"></i>Get Free Quote</a>
            <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold hover:bg-white hover:text-orange-600 transition-all"><i class="fas fa-phone mr-2"></i>Call Us Now</a>
        </div>
    </div>
</section>
@endsection
