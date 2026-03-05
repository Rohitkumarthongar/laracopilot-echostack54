<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SolarTech Solutions') - Powering a Greener Tomorrow</title>
    <meta name="description" content="@yield('meta_description', 'Premium solar solutions for homes and businesses. Quality panels, inverters, batteries and complete installation services.')">    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html { scroll-behavior: smooth; }
        .hero-bg { background: linear-gradient(135deg, #ea580c 0%, #d97706 50%, #ca8a04 100%); }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: #ea580c; transition: width .3s; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        .card-hover { transition: transform .3s, box-shadow .3s; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.12); }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp .6s ease forwards; }
    </style>
</head>
<body class="font-sans bg-white text-gray-800">
<!-- Navbar -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-solar-panel text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-bold text-lg text-gray-800">SolarTech</span>
                    <span class="text-orange-500 font-bold text-lg"> Solutions</span>
                </div>
            </a>
            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-orange-600 font-medium {{ request()->routeIs('home') ? 'active text-orange-600' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-orange-600 font-medium {{ request()->routeIs('about') ? 'active text-orange-600' : '' }}">About</a>
                <a href="{{ route('products') }}" class="nav-link text-gray-700 hover:text-orange-600 font-medium {{ request()->routeIs('products*') ? 'active text-orange-600' : '' }}">Products</a>
                <a href="{{ route('packages') }}" class="nav-link text-gray-700 hover:text-orange-600 font-medium {{ request()->routeIs('packages') ? 'active text-orange-600' : '' }}">Packages</a>
                <a href="{{ route('contact') }}" class="nav-link text-gray-700 hover:text-orange-600 font-medium {{ request()->routeIs('contact') ? 'active text-orange-600' : '' }}">Contact</a>
                <a href="{{ route('get.quote') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-full font-semibold transition-colors">Get Free Quote</a>
            </div>
            <!-- Mobile toggle -->
            <button class="md:hidden text-gray-600" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-gray-100 py-4 space-y-3">
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-orange-600 font-medium py-2">Home</a>
            <a href="{{ route('about') }}" class="block text-gray-700 hover:text-orange-600 font-medium py-2">About</a>
            <a href="{{ route('products') }}" class="block text-gray-700 hover:text-orange-600 font-medium py-2">Products</a>
            <a href="{{ route('packages') }}" class="block text-gray-700 hover:text-orange-600 font-medium py-2">Packages</a>
            <a href="{{ route('contact') }}" class="block text-gray-700 hover:text-orange-600 font-medium py-2">Contact</a>
            <a href="{{ route('get.quote') }}" class="block bg-orange-500 text-white text-center px-5 py-2 rounded-full font-semibold">Get Free Quote</a>
        </div>
    </div>
</nav>
@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-6 py-4 flex justify-between items-center">
    <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
</div>
@endif
@yield('content')
<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16 grid grid-cols-1 md:grid-cols-4 gap-10">
        <div>
            <div class="flex items-center space-x-3 mb-5">
                <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-solar-panel text-white"></i>
                </div>
                <span class="font-bold text-xl">SolarTech Solutions</span>
            </div>
            <p class="text-gray-400 text-sm leading-relaxed">Leading provider of solar energy solutions. We bring the power of the sun to your doorstep with quality products and expert installation.</p>
            <div class="flex space-x-4 mt-5">
                <a href="#" class="w-9 h-9 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition-colors"><i class="fab fa-facebook-f text-sm"></i></a>
                <a href="#" class="w-9 h-9 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition-colors"><i class="fab fa-twitter text-sm"></i></a>
                <a href="#" class="w-9 h-9 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition-colors"><i class="fab fa-instagram text-sm"></i></a>
                <a href="#" class="w-9 h-9 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition-colors"><i class="fab fa-linkedin-in text-sm"></i></a>
            </div>
        </div>
        <div>
            <h4 class="font-bold text-lg mb-5">Quick Links</h4>
            <ul class="space-y-3 text-gray-400 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-orange-400 transition-colors">Home</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-orange-400 transition-colors">About Us</a></li>
                <li><a href="{{ route('products') }}" class="hover:text-orange-400 transition-colors">Products</a></li>
                <li><a href="{{ route('packages') }}" class="hover:text-orange-400 transition-colors">Packages</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-orange-400 transition-colors">Contact Us</a></li>
                <li><a href="{{ route('get.quote') }}" class="hover:text-orange-400 transition-colors">Get Free Quote</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-lg mb-5">Product Categories</h4>
            <ul class="space-y-3 text-gray-400 text-sm">
                @foreach(\App\Models\ProductCategory::where('is_active',true)->orderBy('sort_order')->take(6)->get() as $cat)
                <li><a href="{{ route('products.category', $cat->slug) }}" class="hover:text-orange-400 transition-colors flex items-center space-x-2"><i class="{{ $cat->icon ?? 'fas fa-solar-panel' }} text-xs mr-2"></i>{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-lg mb-5">Contact Info</h4>
            <ul class="space-y-4 text-gray-400 text-sm">
                <li class="flex items-start space-x-3"><i class="fas fa-map-marker-alt text-orange-500 mt-1"></i><span>123 Solar Park, Green City, Gujarat - 380001</span></li>
                <li class="flex items-center space-x-3"><i class="fas fa-phone text-orange-500"></i><span>+91 98765 43210</span></li>
                <li class="flex items-center space-x-3"><i class="fas fa-envelope text-orange-500"></i><span>info@solartech.com</span></li>
                <li class="flex items-center space-x-3"><i class="fas fa-clock text-orange-500"></i><span>Mon–Sat: 9:00 AM – 6:00 PM</span></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-gray-700 py-6 text-center text-sm text-gray-500">
        <p>© {{ date('Y') }} SolarTech Solutions. All rights reserved.</p>
        <p class="mt-1">Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="text-orange-400 hover:underline">LaraCopilot</a></p>
    </div>
</footer>
</body>
</html>
