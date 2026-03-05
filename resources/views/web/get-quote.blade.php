@extends('layouts.web')
@section('title', 'Get Free Solar Quote')
@section('content')
<section class="bg-gradient-to-r from-orange-500 to-amber-500 py-16 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-bold">Get Your Free Solar Quote</h1>
        <p class="text-orange-100 mt-3 text-lg">Tell us about your requirements — our expert will call you within 24 hours</p>
    </div>
</section>
<section class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">
            <form action="{{ route('get.quote.store') }}" method="POST" class="space-y-6" id="quoteForm">
                @csrf

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <p class="text-red-700 font-semibold text-sm mb-2"><i class="fas fa-exclamation-circle mr-1"></i>Please fix the following:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                        <li class="text-red-600 text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Contact Info -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center"><span class="w-7 h-7 bg-orange-500 text-white rounded-full flex items-center justify-center text-sm mr-3">1</span>Your Contact Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('name') border-red-500 @enderror" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('phone') border-red-500 @enderror" required placeholder="10-digit mobile number">
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
                                <option value="{{ $pkg->id }}" {{ old('package_id', request('package')) == $pkg->id ? 'selected' : '' }}>{{ $pkg->name }} ({{ $pkg->system_size_kw }}kW) – ₹{{ number_format($pkg->price) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Installation Address *</label>
                            <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Electricity Details -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center"><span class="w-7 h-7 bg-orange-500 text-white rounded-full flex items-center justify-center text-sm mr-3">2</span>Electricity Details <span class="text-gray-400 text-sm font-normal ml-2">(helps us give accurate quote)</span></h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">EB K-Number / Consumer No</label>
                            <input type="text" name="k_number" value="{{ old('k_number') }}" placeholder="Optional — from your EB bill" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Electricity Bill (₹)</label>
                            <input type="number" name="monthly_electricity_bill" value="{{ old('monthly_electricity_bill') }}" placeholder="e.g. 3500" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Required Load / System Size</label>
                            <select name="required_load_kw" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Not sure</option>
                                @foreach(['1','2','3','4','5','6','7','8','10','12','15','20','25','30','50'] as $kw)
                                <option value="{{ $kw }}" {{ old('required_load_kw')===$kw?'selected':'' }}>{{ $kw }} kW</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Meter Type</label>
                            <select name="meter_type" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Not sure</option>
                                <option value="single_phase" {{ old('meter_type')==='single_phase'?'selected':'' }}>Single Phase (1Φ)</option>
                                <option value="three_phase" {{ old('meter_type')==='three_phase'?'selected':'' }}>Three Phase (3Φ)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                            <select name="property_type" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Select</option>
                                @foreach(['Residential Home','Commercial Building','Industrial Unit','Agricultural Land','School / Institution'] as $pt)
                                <option value="{{ $pt }}" {{ old('property_type')===$pt?'selected':'' }}>{{ $pt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Roof Type</label>
                            <select name="roof_type" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Select</option>
                                @foreach(['RCC Flat Roof','Sloped Tin Roof','Sloped Tile Roof','Ground Mount','Commercial Terrace'] as $r)
                                <option value="{{ $r }}" {{ old('roof_type')===$r?'selected':'' }}>{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Available Roof Area (sq.ft approx)</label>
                            <input type="text" name="roof_area_sqft" value="{{ old('roof_area_sqft') }}" placeholder="e.g. 400" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="has_subsidy" value="1" {{ old('has_subsidy')?'checked':'' }} class="w-5 h-5 text-orange-600 rounded">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">PM Surya Ghar Subsidy</p>
                                    <p class="text-xs text-gray-400">Interested in government subsidy?</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-xl font-bold text-lg transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Quote Request
                </button>
                <p class="text-center text-gray-400 text-xs">🔒 Your information is private and never shared. You'll receive an SMS & email confirmation.</p>
            </form>
        </div>
    </div>
</section>
@endsection
