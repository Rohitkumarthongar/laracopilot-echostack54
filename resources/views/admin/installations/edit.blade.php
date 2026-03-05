@extends('layouts.admin')
@section('title', 'Update Installation')
@section('page-title', 'Update Installation')
@section('content')
<div class="max-w-4xl mx-auto">
<div class="bg-white rounded-xl shadow-sm p-8">
    <h2 class="text-xl font-bold text-gray-800 mb-6"><i class="fas fa-tools text-orange-500 mr-2"></i>Update: {{ $installation->installation_number }}</h2>
    <form action="{{ route('admin.installations.update', $installation->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <!-- Basic Details -->
        <div class="bg-blue-50 rounded-xl p-5">
            <h3 class="font-bold text-blue-800 mb-4"><i class="fas fa-info-circle mr-2"></i>Installation Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Scheduled Date *</label>
                    <input type="date" name="scheduled_date" value="{{ old('scheduled_date', $installation->scheduled_date?->format('Y-m-d')) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                        @foreach(['scheduled'=>'Scheduled','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('status', $installation->status)===$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Completion Date</label>
                    <input type="date" name="completion_date" value="{{ old('completion_date', $installation->completion_date?->format('Y-m-d')) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">System Size (kW) *</label>
                    <input type="number" step="0.1" name="system_size_kw" value="{{ old('system_size_kw', $installation->system_size_kw) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Roof Type *</label>
                    <select name="roof_type" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                        @foreach(['RCC Flat Roof','Sloped Tin Roof','Sloped Tile Roof','Ground Mount','Commercial Terrace'] as $rt)
                        <option value="{{ $rt }}" {{ old('roof_type',$installation->roof_type)===$rt?'selected':'' }}>{{ $rt }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assigned Team</label>
                    <input type="text" name="assigned_team" value="{{ old('assigned_team', $installation->assigned_team) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Installation Address *</label>
                    <textarea name="installation_address" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500" required>{{ old('installation_address', $installation->installation_address) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Technician Remarks</label>
                    <textarea name="technician_remarks" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('technician_remarks', $installation->technician_remarks) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Proof Photos Upload -->
        <div class="bg-orange-50 rounded-xl p-5">
            <h3 class="font-bold text-orange-800 mb-2"><i class="fas fa-camera mr-2"></i>Installation Proof Photos</h3>
            <p class="text-orange-600 text-sm mb-4">Upload at least 2 photos as installation proof. All 6 slots recommended for complete documentation.</p>
            @php
            $proofSlots = [
                'proof_before_photo'   => ['Before Installation', 'blue'],
                'proof_during_photo'   => ['During Installation', 'yellow'],
                'proof_after_photo'    => ['After Installation (Full View)', 'green'],
                'proof_meter_photo'    => ['EB Meter / Board Photo', 'purple'],
                'proof_panel_photo'    => ['Solar Panels on Roof', 'orange'],
                'proof_inverter_photo' => ['Inverter & Wiring', 'red'],
            ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($proofSlots as $field => [$label, $color])
                <div class="border border-{{ $color }}-200 bg-white rounded-xl p-4">
                    <p class="text-sm font-semibold text-{{ $color }}-700 mb-2">{{ $label }}</p>
                    @if($installation->$field)
                    <img src="/storage/{{ $installation->$field }}" class="w-full h-28 object-cover rounded-lg mb-2">
                    <p class="text-xs text-green-600 mb-2"><i class="fas fa-check-circle mr-1"></i>Uploaded. Replace:</p>
                    @else
                    <div class="w-full h-28 bg-{{ $color }}-50 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-upload text-{{ $color }}-300 text-3xl"></i>
                    </div>
                    @endif
                    <input type="file" name="{{ $field }}" accept="image/*" class="w-full text-xs border border-gray-200 rounded-lg px-2 py-1.5">
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                <label class="block text-sm font-semibold text-orange-800 mb-2">Additional Photos (select multiple)</label>
                <input type="file" name="proof_photos[]" accept="image/*" multiple class="w-full border border-orange-200 rounded-lg px-4 py-2.5 bg-white">
                @if(!empty($installation->proof_photos))
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach($installation->proof_photos as $photo)
                    <img src="/storage/{{ $photo }}" class="w-16 h-16 object-cover rounded-lg border">
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.installations.show', $installation->id) }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-orange-600 text-white px-6 py-2.5 rounded-lg hover:bg-orange-700"><i class="fas fa-save mr-2"></i>Update Installation</button>
        </div>
    </form>
</div>
</div>
@endsection
