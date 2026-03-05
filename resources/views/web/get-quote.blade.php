@extends('layouts.web')
@section('title', 'Get Free Quote')
@section('content')
<section class="bg-gradient-to-r from-orange-500 to-amber-500 py-16 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-bold">Get Your Free Solar Quote</h1>
        <p class="text-orange-100 mt-3 text-lg">Fill the form below and our expert will contact you within 24 hours</p>
    </div>
</section>
<section class="py-20">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-lg p-10 border border-gray-100">
            <form action="{{ route('get.quote.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Package</label>
                        <select name="package_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Not sure yet</option>
                            @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}" {{ old('package_id', request('package')) == $pkg->id ? 'selected' : '' }}>{{ $pkg->name }} – ₹{{ number_format($pkg->price) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Installation Address *</label>
                        <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Roof Type</label>
                        <select name="roof_type" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Select roof type</option>
                            @foreach(['RCC Flat Roof','Sloped Tin Roof','Sloped Tile Roof','Ground Mount','Commercial Terrace'] as $r)
                            <option value="{{ $r }}" {{ old('roof_type') === $r ? 'selected' : '' }}>{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Electricity Bill</label>
                        <select name="monthly_bill" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Select range</option>
                            @foreach(['Below ₹1,000','₹1,000 – ₹3,000','₹3,000 – ₹5,000','₹5,000 – ₹10,000','Above ₹10,000'] as $b)
                            <option value="{{ $b }}" {{ old('monthly_bill') === $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-xl font-bold text-lg transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Quote Request
                </button>
                <p class="text-center text-gray-400 text-xs">We respect your privacy. Your information will never be shared.</p>
            </form>
        </div>
    </div>
</section>
@endsection
