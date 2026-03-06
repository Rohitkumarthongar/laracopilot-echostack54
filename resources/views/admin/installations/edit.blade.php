@extends('layouts.admin')
@section('title', 'Edit Installation ' . $installation->installation_number)
@section('page-title', 'Installations')
@section('content')
<div class="space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.installations.show', $installation->id) }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white shadow-sm border border-gray-200 text-gray-500 hover:text-indigo-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Edit / Update Progress</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $installation->installation_number }}</p>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4">
        <ul class="list-disc list-inside text-sm font-medium">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.installations.update', $installation->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            
            {{-- Technical / Core Details --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-5 flex items-center gap-2">
                        <i class="fas fa-sliders-h text-indigo-500"></i> Core Information
                    </h3>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Scheduled Date <span class="text-red-500">*</span></label>
                                <input type="date" name="scheduled_date" value="{{ old('scheduled_date', $installation->scheduled_date ? \Carbon\Carbon::parse($installation->scheduled_date)->format('Y-m-d') : '') }}" required
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Status <span class="text-red-500">*</span></label>
                                <select name="status" required
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 font-bold">
                                    <option value="scheduled" {{ old('status', $installation->status) == 'scheduled' ? 'selected' : '' }}>🟡 Scheduled</option>
                                    <option value="in_progress" {{ old('status', $installation->status) == 'in_progress' ? 'selected' : '' }}>🔵 In Progress</option>
                                    <option value="completed" {{ old('status', $installation->status) == 'completed' ? 'selected' : '' }}>🟢 Completed</option>
                                    <option value="cancelled" {{ old('status', $installation->status) == 'cancelled' ? 'selected' : '' }}>🔴 Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Date Completed (If Complete)</label>
                            <input type="date" name="completion_date" value="{{ old('completion_date', $installation->completion_date ? \Carbon\Carbon::parse($installation->completion_date)->format('Y-m-d') : '') }}"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">System Size (kW) <span class="text-red-500">*</span></label>
                                <input type="number" name="system_size_kw" value="{{ old('system_size_kw', $installation->system_size_kw) }}" required min="0.1" step="0.1"
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Assigned Team</label>
                                <input type="text" name="assigned_team" value="{{ old('assigned_team', $installation->assigned_team) }}"
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Installation Address <span class="text-red-500">*</span></label>
                            <textarea name="installation_address" required rows="2"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('installation_address', $installation->installation_address) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Roof Type <span class="text-red-500">*</span></label>
                            <input type="text" name="roof_type" value="{{ old('roof_type', $installation->roof_type) }}" required
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Technical / Internal Notes</label>
                            <textarea name="notes" rows="2"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('notes', $installation->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Proof Uploads & Technician Inputs --}}
            <div class="space-y-6">
                <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-200 pb-3 mb-5 flex items-center gap-2">
                        <i class="fas fa-camera text-indigo-500"></i> Proof Uploads & Remarks
                    </h3>
                    
                    <p class="text-xs text-gray-500 mb-5 pb-3 border-b border-gray-200 border-dashed">
                        Upload photos of the installation progress. Existing photos will be preserved if you leave a field empty.
                    </p>

                    <div class="space-y-4">
                        @php
                            $proofInputs = [
                                'proof_before_photo' => '1. Site Before Installation',
                                'proof_during_photo' => '2. Structure / Ongoing Work',
                                'proof_after_photo' => '3. Site After Installation (Overview)',
                                'proof_meter_photo' => '4. Meter & DB Boards',
                                'proof_panel_photo' => '5. Solar Panels (Focus)',
                                'proof_inverter_photo' => '6. Inverter (Focus)',
                            ];
                        @endphp
                        
                        @foreach($proofInputs as $field => $label)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-gray-600">{{ $label }}</label>
                                @if(!empty($installation->$field))
                                    <span class="text-[10px] text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded mt-1 inline-block"><i class="fas fa-check"></i> Uploaded</span>
                                @endif
                            </div>
                            <input type="file" name="{{ $field }}" accept="image/*" class="text-xs text-gray-500 w-full sm:w-auto
                                file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                        </div>
                        @endforeach
                        
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm mt-4 border-l-4 border-indigo-400">
                            <label class="block text-xs font-semibold text-gray-600 mb-2">Additional Photos (Optional, multiple allowed)</label>
                            <input type="file" name="proof_photos[]" multiple accept="image/*" class="text-xs text-gray-500 w-full
                                file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold
                                file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition cursor-pointer">
                            @if(!empty($installation->proof_photos))
                                <p class="text-[10px] text-gray-400 mt-2"><i class="fas fa-info-circle"></i> {{ count($installation->proof_photos) }} additional photo(s) already uploaded.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border-t-4 border-yellow-400">
                    <h3 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
                        <i class="fas fa-hard-hat text-yellow-500"></i> Field Technician Remarks
                    </h3>
                    <textarea name="technician_remarks" rows="3" placeholder="Notes directly from the engineers on site..."
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 bg-yellow-50">{{ old('technician_remarks', $installation->technician_remarks) }}</textarea>
                </div>
            </div>
            
        </div>

        <div class="mt-8 flex gap-3 border-t border-gray-100 pt-6">
            <button type="submit"
                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 flex justify-center items-center gap-2 rounded-xl transition shadow-sm">
                <i class="fas fa-cloud-upload-alt"></i> Save & Upload Updates
            </button>
            <a href="{{ route('admin.installations.show', $installation->id) }}"
                class="px-8 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 font-semibold rounded-xl transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
