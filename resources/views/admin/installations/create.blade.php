@extends('layouts.admin')
@section('title', 'Schedule Installation')
@section('page-title', 'Installations')
@section('content')
<div class="space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.installations.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white shadow-sm border border-gray-200 text-gray-500 hover:text-indigo-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Schedule Installation</h2>
            <p class="text-sm text-gray-500 mt-0.5">Register a new installation job.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4">
        <ul class="list-disc list-inside text-sm font-medium">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.installations.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            {{-- Left column --}}
            <div class="xl:col-span-2 space-y-6">
                
                {{-- Client & Order Details --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-5 flex items-center gap-2">
                        <i class="fas fa-user-tag text-indigo-500"></i> Client & Order Reference
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Customer <span class="text-red-500">*</span></label>
                            <select name="customer_id" required
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                <option value="">— Select Customer —</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Sales Order Link</label>
                            <select name="sales_order_id"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                <option value="">— No Order / Independent —</option>
                                @foreach($salesOrders as $so)
                                    <option value="{{ $so->id }}" {{ old('sales_order_id') == $so->id ? 'selected' : '' }}>{{ $so->order_number }} ({{ $so->customer_name }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Optional. Link to an existing confirmed order.</p>
                        </div>
                        
                    </div>
                </div>
                
                {{-- Technical & Location --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-5 flex items-center gap-2">
                        <i class="fas fa-solar-panel text-indigo-500"></i> Installation Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">System Size (kW) <span class="text-red-500">*</span></label>
                            <input type="number" name="system_size_kw" value="{{ old('system_size_kw') }}" required min="0.1" step="0.1" placeholder="e.g. 5"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Roof Type <span class="text-red-500">*</span></label>
                            <select name="roof_type" required
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                <option value="Flat Concrete" {{ old('roof_type') == 'Flat Concrete' ? 'selected' : '' }}>Flat Concrete (RCC)</option>
                                <option value="Sloped Metal" {{ old('roof_type') == 'Sloped Metal' ? 'selected' : '' }}>Sloped Metal / Tin</option>
                                <option value="Tiled" {{ old('roof_type') == 'Tiled' ? 'selected' : '' }}>Tiled</option>
                                <option value="Ground Mount" {{ old('roof_type') == 'Ground Mount' ? 'selected' : '' }}>Ground Mount</option>
                                <option value="Other" {{ old('roof_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Installation Address (Site Location) <span class="text-red-500">*</span></label>
                            <textarea name="installation_address" required rows="2" placeholder="Full address of the site exactly where panels are to be installed..."
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('installation_address') }}</textarea>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            {{-- Right Column --}}
            <div class="space-y-6">
                
                {{-- Schedule --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-5 flex items-center gap-2">
                        <i class="fas fa-calendar-check text-indigo-500"></i> Scheduling & Team
                    </h3>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Scheduled Date <span class="text-red-500">*</span></label>
                            <input type="date" name="scheduled_date" value="{{ old('scheduled_date', \Carbon\Carbon::tomorrow()->format('Y-m-d')) }}" required
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Assigned Team</label>
                            <input type="text" name="assigned_team" value="{{ old('assigned_team') }}" placeholder="e.g. Alpha Team, John Doe"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border-t-4 border-indigo-500">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Internal Notes</label>
                    <textarea name="notes" rows="3" placeholder="Any specific instructions for technicians..."
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition shadow-sm">
                        Schedule Installation
                    </button>
                    <a href="{{ route('admin.installations.index') }}"
                        class="px-6 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 font-semibold rounded-xl transition">
                        Cancel
                    </a>
                </div>

            </div>
            
        </div>

    </form>
</div>
@endsection
