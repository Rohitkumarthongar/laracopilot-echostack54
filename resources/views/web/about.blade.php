@extends('layouts.web')
@section('title', 'About Us')
@section('content')
<section class="bg-gradient-to-r from-orange-500 to-amber-500 py-16 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-bold">About SolarTech Solutions</h1>
        <p class="text-orange-100 mt-3 text-lg">Committed to bringing clean, affordable solar energy to every home and business</p>
    </div>
</section>
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-orange-500 font-semibold text-sm uppercase tracking-wider">Our Story</span>
                <h2 class="text-3xl font-bold text-gray-800 mt-2 mb-5">Powering India with Clean Energy Since 2015</h2>
                <p class="text-gray-600 leading-relaxed mb-4">SolarTech Solutions was founded with a simple mission: make solar energy accessible to every Indian household and business. Starting from Gujarat, we have grown to serve customers across the country.</p>
                <p class="text-gray-600 leading-relaxed mb-4">We source only the highest quality solar products from globally certified manufacturers and back them with industry-leading warranties and 24/7 customer support.</p>
                <p class="text-gray-600 leading-relaxed">With 500+ successful installations and a team of expert technicians, we are proud to be one of the most trusted names in the solar industry.</p>
                <div class="grid grid-cols-3 gap-6 mt-8">
                    <div class="text-center p-4 bg-orange-50 rounded-xl"><p class="text-3xl font-bold text-orange-600">500+</p><p class="text-gray-500 text-sm mt-1">Installations</p></div>
                    <div class="text-center p-4 bg-orange-50 rounded-xl"><p class="text-3xl font-bold text-orange-600">9yr</p><p class="text-gray-500 text-sm mt-1">Experience</p></div>
                    <div class="text-center p-4 bg-orange-50 rounded-xl"><p class="text-3xl font-bold text-orange-600">50+</p><p class="text-gray-500 text-sm mt-1">Expert Team</p></div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-5">
                @foreach([['fas fa-award','yellow','ISO Certified','ISO 9001:2015 certified for quality management systems.'],['fas fa-leaf','green','Eco-Friendly','Helping reduce carbon emissions one installation at a time.'],['fas fa-handshake','blue','Trusted Partner','Authorized dealer for top solar brands in India.'],['fas fa-tools','orange','Expert Team','Trained and certified solar technicians across Gujarat.']] as $v)
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-{{ $v[1] }}-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="{{ $v[0] }} text-{{ $v[1] }}-500 text-xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-1">{{ $v[2] }}</h4>
                    <p class="text-gray-500 text-sm">{{ $v[3] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
