@extends('layouts.admin')
@section('title', 'Installation Details')
@section('page-title', 'Installation Details')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $installation->installation_number }}</h2>
            <p class="text-gray-500 mt-1">{{ $installation->customer->name ?? 'N/A' }} &bull; {{ $installation->scheduled_date->format('d M Y') }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            @php $sc=['scheduled'=>'bg-yellow-100 text-yellow-800','in_progress'=>'bg-blue-100 text-blue-800','completed'=>'bg-green-100 text-green-800','cancelled'=>'bg-red-100 text-red-800']; @endphp
            <span class="px-3 py-1.5 rounded-full font-semibold text-sm {{ $sc[$installation->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst(str_replace('_',' ',$installation->status)) }}</span>
            <a href="{{ route('admin.installations.edit', $installation->id) }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 text-sm"><i class="fas fa-edit mr-1"></i>Update / Upload Proof</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-info-circle text-orange-500 mr-2"></i>Installation Details</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-gray-400">System Size</p><p class="font-medium">{{ $installation->system_size_kw }} kW</p></div>
                    <div><p class="text-gray-400">Roof Type</p><p class="font-medium">{{ $installation->roof_type }}</p></div>
                    <div><p class="text-gray-400">Assigned Team</p><p class="font-medium">{{ $installation->assigned_team ?? 'Not assigned' }}</p></div>
                    <div><p class="text-gray-400">Scheduled Date</p><p class="font-medium">{{ $installation->scheduled_date->format('d M Y') }}</p></div>
                    @if($installation->completion_date)
                    <div><p class="text-gray-400">Completed On</p><p class="font-medium text-green-600">{{ $installation->completion_date->format('d M Y') }}</p></div>
                    @endif
                    <div><p class="text-gray-400">Proof Submitted</p><p class="font-medium {{ $installation->proof_submitted ? 'text-green-600' : 'text-red-500' }}">{{ $installation->proof_submitted ? 'Yes - '.$installation->proof_submitted_at?->format('d M Y') : 'Pending' }}</p></div>
                </div>
                @if($installation->technician_remarks)
                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-600 font-semibold">Technician Remarks:</p>
                    <p class="text-sm text-blue-800 mt-1">{{ $installation->technician_remarks }}</p>
                </div>
                @endif
            </div>

            <!-- Proof Photos -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-images text-orange-500 mr-2"></i>Installation Proof Photos</h3>
                @php
                $proofSlots = [
                    'proof_before_photo'   => ['Before Installation', 'fa-camera', 'blue'],
                    'proof_during_photo'   => ['During Installation', 'fa-tools', 'yellow'],
                    'proof_after_photo'    => ['After Installation', 'fa-check-circle', 'green'],
                    'proof_meter_photo'    => ['Meter/EB Board', 'fa-tachometer-alt', 'purple'],
                    'proof_panel_photo'    => ['Solar Panels Installed', 'fa-solar-panel', 'orange'],
                    'proof_inverter_photo' => ['Inverter Setup', 'fa-bolt', 'red'],
                ];
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($proofSlots as $field => [$label, $icon, $color])
                    <div class="border-2 border-dashed border-{{ $color }}-200 rounded-xl overflow-hidden">
                        @if($installation->$field)
                        <img src="/storage/{{ $installation->$field }}" alt="{{ $label }}" class="w-full h-32 object-cover">
                        <div class="bg-{{ $color }}-50 px-3 py-2 flex items-center space-x-2">
                            <i class="fas {{ $icon }} text-{{ $color }}-500 text-xs"></i>
                            <span class="text-xs font-medium text-{{ $color }}-700">{{ $label }}</span>
                            <i class="fas fa-check-circle text-green-500 ml-auto text-xs"></i>
                        </div>
                        @else
                        <div class="h-32 flex flex-col items-center justify-center bg-gray-50">
                            <i class="fas {{ $icon }} text-3xl text-gray-200"></i>
                        </div>
                        <div class="bg-gray-50 px-3 py-2 flex items-center space-x-2">
                            <span class="text-xs font-medium text-gray-400">{{ $label }}</span>
                            <i class="fas fa-clock text-gray-300 ml-auto text-xs"></i>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if(!empty($installation->proof_photos))
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-600 mb-3">Additional Photos:</p>
                    <div class="grid grid-cols-3 md:grid-cols-5 gap-3">
                        @foreach($installation->proof_photos as $photo)
                        <img src="/storage/{{ $photo }}" class="w-full h-20 object-cover rounded-lg border">
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-5">
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="font-bold text-gray-800 mb-3"><i class="fas fa-user text-orange-500 mr-2"></i>Customer</h3>
                @if($installation->customer)
                <p class="font-medium">{{ $installation->customer->name }}</p>
                <p class="text-gray-500 text-sm">{{ $installation->customer->phone }}</p>
                <p class="text-gray-500 text-sm">{{ $installation->customer->email }}</p>
                @endif
            </div>

            <!-- Auto-created Service Requests -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-800"><i class="fas fa-headset text-orange-500 mr-2"></i>Service Tickets</h3>
                    @if($installation->auto_service_created)<span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">AMC Auto-Created</span>@endif
                </div>
                @forelse($installation->serviceRequests as $srv)
                <div class="border border-gray-100 rounded-lg p-3 mb-2">
                    <p class="text-xs font-medium text-gray-700">{{ $srv->ticket_number }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ str_replace('_',' ',$srv->service_type) }}</p>
                    <span class="text-xs {{ $srv->status==='open'?'text-red-500':'text-green-500' }}">{{ ucfirst($srv->status) }}</span>
                </div>
                @empty
                <p class="text-gray-400 text-sm">No service tickets yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
