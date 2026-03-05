@extends('layouts.web')
@section('title', 'Thank You!')
@section('content')
<section class="min-h-screen bg-gradient-to-br from-orange-50 to-amber-50 flex items-center py-20">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <!-- Success Animation -->
        <div class="w-28 h-28 bg-gradient-to-br from-orange-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl" style="animation: bounce 1s infinite alternate">
            <i class="fas fa-check text-white text-5xl"></i>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            {{ $type === 'quote' ? '🎉 Quote Request Received!' : '✅ Message Sent!' }}
        </h1>
        <p class="text-xl text-gray-600 mb-6">
            {{ $type === 'quote'
                ? 'Thank you for your solar quote request! Our expert team will review your requirements and contact you within 24 hours.'
                : 'Thank you for reaching out! Our team will get back to you shortly.' }}
        </p>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-phone text-blue-500 text-xl"></i>
                </div>
                <p class="font-bold text-gray-800">Call Back</p>
                <p class="text-gray-500 text-sm mt-1">Our expert will call you within 24 hours</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-envelope text-green-500 text-xl"></i>
                </div>
                <p class="font-bold text-gray-800">Email Confirmation</p>
                <p class="text-gray-500 text-sm mt-1">Check your inbox for confirmation details</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-sms text-purple-500 text-xl"></i>
                </div>
                <p class="font-bold text-gray-800">SMS Update</p>
                <p class="text-gray-500 text-sm mt-1">You'll receive an SMS acknowledgement</p>
            </div>
        </div>

        @if($type === 'quote')
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-green-200 mb-8 text-left">
            <h3 class="font-bold text-green-700 mb-3"><i class="fas fa-list-check mr-2"></i>What Happens Next?</h3>
            <ul class="space-y-3">
                @foreach(['Our solar expert will call you within 24 hours','We conduct a free site assessment at your location','You receive a detailed, customised solar quotation','Our certified team handles professional installation','24/7 after-sales support & AMC services'] as $i => $step)
                <li class="flex items-start space-x-3">
                    <span class="w-7 h-7 bg-orange-500 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">{{ $i + 1 }}</span>
                    <span class="text-gray-600 pt-0.5">{{ $step }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-full font-bold transition-colors">
                <i class="fas fa-home mr-2"></i>Back to Home
            </a>
            <a href="{{ route('packages') }}" class="border-2 border-orange-500 text-orange-600 hover:bg-orange-50 px-8 py-4 rounded-full font-bold transition-colors">
                <i class="fas fa-solar-panel mr-2"></i>Explore Packages
            </a>
        </div>

        <div class="mt-10 p-5 bg-orange-500 rounded-2xl text-white">
            <p class="font-semibold">Need immediate assistance?</p>
            <p class="text-2xl font-bold mt-1">+91 98765 43210</p>
            <p class="text-orange-100 text-sm mt-1">Mon–Sat: 9:00 AM – 6:00 PM</p>
        </div>
    </div>
</section>
<style>
  @keyframes bounce { from { transform: scale(1); } to { transform: scale(1.08); } }
</style>
@endsection
