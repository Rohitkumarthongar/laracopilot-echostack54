@extends('layouts.web')
@section('title', 'Contact Us')
@section('content')
<section class="bg-gradient-to-r from-orange-500 to-amber-500 py-16 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-bold">Contact Us</h1>
        <p class="text-orange-100 mt-3 text-lg">We're here to help. Reach out and we'll get back to you within 24 hours.</p>
    </div>
</section>
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Send Us a Message</h2>
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Your Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                        <textarea name="message" rows="5" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-xl font-bold transition-colors"><i class="fas fa-paper-plane mr-2"></i>Send Message</button>
                </form>
            </div>
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-800">Get in Touch</h2>
                <p class="text-gray-600">Our team of solar experts is ready to help you choose the right solution for your needs.</p>
                @foreach([['fas fa-map-marker-alt','orange','Our Office','123 Solar Park, Green City, Gujarat - 380001'],['fas fa-phone','blue','Phone','(+91) 98765 43210'],['fas fa-envelope','green','Email','info@solartech.com'],['fas fa-clock','purple','Working Hours','Monday – Saturday: 9:00 AM – 6:00 PM']] as $info)
                <div class="flex items-start space-x-4 p-5 bg-{{ $info[1] }}-50 rounded-2xl">
                    <div class="w-12 h-12 bg-{{ $info[1] }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="{{ $info[0] }} text-{{ $info[1] }}-500 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $info[2] }}</p>
                        <p class="text-gray-600 text-sm mt-1">{{ $info[3] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
