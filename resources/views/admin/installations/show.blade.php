@extends('layouts.admin')
@section('title', 'Installation ' . $installation->installation_number)
@section('page-title', 'Installations')
@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.installations.index') }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white shadow-sm border border-gray-200 text-gray-500 hover:text-indigo-600 transition">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800 uppercase">{{ $installation->installation_number }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">Installation Details</p>
            </div>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route('admin.installations.edit', $installation->id) }}"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm">
                <i class="fas fa-edit"></i> Update / Upload Proofs
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-3 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Main Status Banner --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col sm:flex-row items-center justify-between border-l-4 
                @if($installation->status == 'completed') border-green-500 
                @elseif($installation->status == 'in_progress') border-blue-500 
                @elseif($installation->status == 'scheduled') border-yellow-500 
                @else border-red-500 @endif
            ">
                <div class="mb-4 sm:mb-0">
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide mb-1">Current Status</p>
                    <div class="flex items-center gap-2">
                        @if($installation->status == 'scheduled')
                            <span class="text-yellow-600 font-bold text-2xl flex items-center gap-2"><i class="fas fa-calendar-alt"></i> Scheduled</span>
                        @elseif($installation->status == 'in_progress')
                            <span class="text-blue-600 font-bold text-2xl flex items-center gap-2"><i class="fas fa-spinner fa-spin"></i> In Progress</span>
                        @elseif($installation->status == 'completed')
                            <span class="text-green-600 font-bold text-2xl flex items-center gap-2"><i class="fas fa-check-circle"></i> Completed</span>
                        @else
                            <span class="text-red-600 font-bold text-2xl flex items-center gap-2"><i class="fas fa-times-circle"></i> Cancelled</span>
                        @endif
                    </div>
                </div>
                
                <div class="flex gap-6 text-sm">
                    <div>
                        <p class="text-gray-400 font-semibold mb-1">Sched. Date</p>
                        <p class="font-bold text-gray-800">{{ $installation->scheduled_date ? \Carbon\Carbon::parse($installation->scheduled_date)->format('d M Y') : '-' }}</p>
                    </div>
                    @if($installation->status == 'completed' && $installation->completion_date)
                    <div>
                        <p class="text-gray-400 font-semibold mb-1">Completed On</p>
                        <p class="font-bold text-green-700">{{ \Carbon\Carbon::parse($installation->completion_date)->format('d M Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Info Grids --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Client Info --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-indigo-500"></i> Client Details
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 font-medium">Customer</span>
                            <span class="font-semibold text-gray-800 text-base">{{ $installation->customer->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex flex-col flex-1">
                                <span class="text-xs text-gray-400 font-medium">Contact</span>
                                <span class="font-semibold text-gray-700">{{ $installation->customer->phone ?? 'N/A' }}</span>
                            </div>
                            @if($installation->salesOrder)
                            <div class="flex flex-col flex-1">
                                <span class="text-xs text-gray-400 font-medium">Sales Order</span>
                                <a href="{{ route('admin.sales-orders.show', $installation->salesOrder->id) }}" class="font-semibold text-indigo-500 hover:underline">
                                    {{ $installation->salesOrder->order_number }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Install Specs --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <i class="fas fa-cogs text-indigo-500"></i> System Specifications
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">System Size</span>
                            <span class="font-bold text-indigo-700">{{ $installation->system_size_kw }} kW</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Roof Type</span>
                            <span class="font-semibold text-gray-800">{{ $installation->roof_type }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Team</span>
                            <span class="font-semibold text-gray-800">{{ $installation->assigned_team ?? 'TBD' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Location & Notes --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-indigo-500"></i> Location
                    </h3>
                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                        {{ $installation->installation_address }}
                    </p>
                </div>

                @if($installation->notes)
                <div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2 flex items-center gap-2">
                        <i class="fas fa-sticky-note text-indigo-500"></i> Internal Notes
                    </h3>
                    <p class="text-sm text-gray-600 bg-yellow-50 p-3 rounded-xl border border-yellow-100 whitespace-pre-line">
                        {{ $installation->notes }}
                    </p>
                </div>
                @endif
                
                @if($installation->technician_remarks)
                <div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2 flex items-center gap-2">
                        <i class="fas fa-comment-dots text-indigo-500"></i> Technician Remarks
                    </h3>
                    <p class="text-sm text-gray-600 bg-blue-50 p-3 rounded-xl border border-blue-100 whitespace-pre-line">
                        {{ $installation->technician_remarks }}
                    </p>
                </div>
                @endif
            </div>

            {{-- Proofs Block --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                        <i class="fas fa-images text-indigo-500"></i> Photographic Proofs
                    </h3>
                    @if($installation->proof_submitted)
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full"><i class="fas fa-check"></i> Submitted</span>
                    @else
                    <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2 py-1 rounded-full">Pending</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    {{-- Standard fields --}}
                    @php
                        $proofLabels = [
                            'proof_before_photo' => 'Before (Site)',
                            'proof_during_photo' => 'During (Structure)',
                            'proof_after_photo' => 'After (Final)',
                            'proof_meter_photo' => 'Meter Installed',
                            'proof_panel_photo' => 'Panels Focus',
                            'proof_inverter_photo' => 'Inverter Focus'
                        ];
                    @endphp

                    @foreach($proofLabels as $field => $label)
                        @if(!empty($installation->$field))
                        <div class="border border-gray-200 rounded-xl overflow-hidden group relative bg-gray-50">
                            <a href="{{ Storage::url($installation->$field) }}" target="_blank" class="block aspect-square overflow-hidden bg-gray-200">
                                <img src="{{ Storage::url($installation->$field) }}" alt="{{ $label }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </a>
                            <div class="p-2 text-center text-xs font-semibold text-gray-700 bg-white border-t border-gray-200">
                                {{ $label }}
                            </div>
                        </div>
                        @else
                        <div class="border border-dashed border-gray-300 rounded-xl aspect-square flex flex-col items-center justify-center text-gray-400 bg-gray-50/50">
                            <i class="fas fa-camera text-2xl mb-2 opacity-50"></i>
                            <span class="text-xs font-medium">{{ $label }}</span>
                            <span class="text-[10px] uppercase tracking-wider mt-1 opacity-60">Pending</span>
                        </div>
                        @endif
                    @endforeach
                    
                    {{-- Multiple Extra Photos --}}
                    @if(!empty($installation->proof_photos) && is_array($installation->proof_photos))
                        @foreach($installation->proof_photos as $idx => $photo)
                        <div class="border border-gray-200 rounded-xl overflow-hidden group relative bg-gray-50">
                            <a href="{{ Storage::url($photo) }}" target="_blank" class="block aspect-square overflow-hidden bg-gray-200">
                                <img src="{{ Storage::url($photo) }}" alt="Extra Photo" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </a>
                            <div class="p-2 text-center text-xs font-semibold text-gray-700 bg-white border-t border-gray-200">
                                Extra Photo {{ $idx+1 }}
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="space-y-6">

            {{-- Audit & Creation --}}
            <div class="bg-gray-50 rounded-2xl shadow-sm p-5 border border-gray-100 text-sm">
                <div class="flex justify-between text-gray-500 mb-2">
                    <span>Created:</span>
                    <span class="font-medium text-gray-700">{{ $installation->created_at->format('d M y, h:i A') }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Last Updated:</span>
                    <span class="font- medium text-gray-700">{{ $installation->updated_at->format('d M y, h:i A') }}</span>
                </div>
                @if($installation->proof_submitted_at)
                <div class="flex justify-between text-green-600 mt-2 font-medium">
                    <span>Proofs Submitted:</span>
                    <span>{{ \Carbon\Carbon::parse($installation->proof_submitted_at)->format('d M y') }}</span>
                </div>
                @endif
                @if($installation->auto_service_created)
                <div class="mt-4 p-2 bg-green-100 text-green-800 rounded-lg text-xs font-bold text-center border border-green-200">
                    <i class="fas fa-shield-check"></i> Auto AMC Initialized
                </div>
                @endif
            </div>

            {{-- Linked Service Requests (AMC / Fixes) --}}
            @if($installation->serviceRequests && $installation->serviceRequests->count())
            <div class="bg-white rounded-2xl shadow-sm p-5">
                <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-3 flex items-center gap-2">
                    <i class="fas fa-headset text-indigo-500"></i> Linked Service Tickets
                </h3>
                <div class="space-y-3">
                    @foreach($installation->serviceRequests as $req)
                    <a href="{{ route('admin.services.show', $req->id) }}" class="block p-3 border border-gray-100 rounded-xl hover:bg-gray-50 hover:border-indigo-200 transition group">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-xs font-bold text-indigo-600 group-hover:underline">{{ $req->ticket_number }}</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase
                                @if($req->status == 'open') bg-red-100 text-red-700
                                @elseif($req->status == 'in_progress') bg-blue-100 text-blue-700
                                @else bg-green-100 text-green-700 @endif">
                                {{ $req->status }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 line-clamp-2">{{ $req->description }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Danger action --}}
            <div class="bg-white shadow-sm p-4 rounded-xl border border-red-100">
                <form action="{{ route('admin.installations.destroy', $installation->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to completely delete this record?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full text-center text-sm font-semibold text-red-500 hover:text-red-700 transition flex justify-center items-center gap-2">
                        <i class="fas fa-trash"></i> Delete Installation Record
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
