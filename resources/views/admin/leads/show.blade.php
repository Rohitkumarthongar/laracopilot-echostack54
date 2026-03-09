@extends('layouts.admin')
@section('title', 'Lead Details: ' . $lead->lead_number)
@section('page-title', 'Lead Profile')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.leads.index') }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white shadow-sm border border-gray-200 text-gray-500 hover:text-indigo-600 transition">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $lead->name }}</h2>
                <div class="flex items-center gap-2 mt-0.5 mt-1">
                    <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full font-bold uppercase tracking-wide">
                        {{ $lead->lead_number }}
                    </span>
                    <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-md
                        @if($lead->status == 'new') bg-blue-100 text-blue-700 
                        @elseif($lead->status == 'contacted') bg-yellow-100 text-yellow-700 
                        @elseif($lead->status == 'follow_up') bg-purple-100 text-purple-700 
                        @elseif($lead->status == 'mature') bg-indigo-100 text-indigo-700 
                        @elseif($lead->status == 'converted') bg-green-100 text-green-700 
                        @else bg-red-100 text-red-700 @endif">
                        {{ str_replace('_', ' ', $lead->status) }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex gap-2">
            @if($lead->status !== 'converted')
                <form action="{{ route('admin.leads.convert', $lead->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm">
                        <i class="fas fa-check-circle"></i> Convert to Quotation
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.leads.edit', $lead->id) }}"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm">
                <i class="fas fa-edit"></i> Edit Lead
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

            {{-- Contact & General Details --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                    <i class="fas fa-address-card text-indigo-500"></i> Lead Profile
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold mb-0.5 uppercase tracking-wide">Email</p>
                                <p class="text-gray-800 font-medium">{{ $lead->email }}</p>
                                <a href="mailto:{{ $lead->email }}" class="text-xs text-indigo-500 hover:underline">Send Email</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold mb-0.5 uppercase tracking-wide">Phone</p>
                                <p class="text-gray-800 font-medium">{{ $lead->phone }}</p>
                                <a href="tel:{{ $lead->phone }}" class="text-xs text-indigo-500 hover:underline">Call</a> | 
                                <form action="{{ route('admin.leads.send-sms', $lead->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-green-600 hover:underline font-bold">Send Auto SMS</button>
                                </form>
                            </div>
                        </div>
                        
                        @if($lead->customer)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div>
                                <p class="text-xs text-green-600 font-semibold mb-0.5 uppercase tracking-wide">Linked Customer</p>
                                <a href="{{ route('admin.customers.show', $lead->customer->id) }}" class="text-gray-800 font-bold hover:text-indigo-600">{{ $lead->customer->name }}</a>
                            </div>
                        </div>
                        @else
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-times"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold mb-0.5 uppercase tracking-wide">Customer Link</p>
                                <p class="text-gray-600 font-medium text-sm">Not linked to existing customer</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold mb-0.5 uppercase tracking-wide">Address / Location</p>
                                <p class="text-gray-800 font-medium text-sm leading-relaxed">
                                    {{ $lead->address }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-filter"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold mb-0.5 uppercase tracking-wide">Lead Source</p>
                                <p class="text-gray-800 font-medium text-sm capitalize">{{ str_replace('_', ' ', $lead->lead_source) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Technical Requirements --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                    <i class="fas fa-solar-panel text-indigo-500"></i> Technical Requirements & Status
                </h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wide mb-1">K-Number</span>
                        <span class="font-semibold text-gray-800">{{ $lead->k_number ?? 'N/A' }}</span>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wide mb-1">Req. Load</span>
                        <span class="font-semibold text-gray-800">{{ $lead->required_load_kw ? $lead->required_load_kw . ' kW' : 'N/A' }}</span>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wide mb-1">Avg Bill</span>
                        <span class="font-semibold text-gray-800">{{ $lead->monthly_electricity_bill ? '₹'.number_format($lead->monthly_electricity_bill, 2) : 'N/A' }}</span>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wide mb-1">Subsidy Required</span>
                        @if($lead->has_subsidy)
                            <span class="font-bold text-green-600"><i class="fas fa-check-circle mr-1"></i> Yes</span>
                        @else
                            <span class="font-semibold text-gray-600">No</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-500">Sanctioned Load:</span>
                        <span class="font-medium text-gray-800">{{ $lead->sanctioned_load ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-500">Meter Type:</span>
                        <span class="font-medium text-gray-800 capitalize">{{ str_replace('_', ' ', $lead->meter_type ?? '-') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-500">Property Type:</span>
                        <span class="font-medium text-gray-800">{{ $lead->property_type ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-500">Roof Area:</span>
                        <span class="font-medium text-gray-800">{{ $lead->roof_area_sqft ? $lead->roof_area_sqft . ' sq.ft' : '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Notes & Follow Ups --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <i class="fas fa-sticky-note text-indigo-500"></i> Initial Notes
                    </h3>
                    @if($lead->notes)
                        <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-600 border border-gray-100 whitespace-pre-wrap">
                            {{ $lead->notes }}
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic">No initial notes provided.</p>
                    @endif
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                        <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                            <i class="fas fa-calendar-check text-indigo-500"></i> Follow Up Info
                        </h3>
                    </div>
                    @if($lead->next_follow_up_date)
                        <div class="mb-4 bg-indigo-50 p-3 rounded-lg border border-indigo-100">
                            <span class="block text-[10px] text-indigo-500 font-bold uppercase tracking-wide mb-1">Next Scheduled Follow-up</span>
                            <span class="font-bold text-indigo-800"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($lead->next_follow_up_date)->format('d M Y, h:i A') }}</span>
                        </div>
                    @else
                        <div class="mb-4 bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="text-sm text-gray-500">No scheduled follow-up.</span>
                        </div>
                    @endif

                    @if($lead->follow_up_notes)
                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wide mb-2 mt-4">Follow-up Notes</span>
                        <div class="bg-yellow-50 rounded-xl p-4 text-sm text-gray-700 border border-yellow-100 whitespace-pre-wrap">
                            {{ $lead->follow_up_notes }}
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- Generated Quotations --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                    <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                        <i class="fas fa-file-invoice text-indigo-500"></i> Generated Quotations
                    </h3>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ collect($lead->quotations)->count() }}</span>
                </div>

                @if(isset($lead->quotations) && collect($lead->quotations)->count())
                    <div class="space-y-3">
                        @foreach($lead->quotations as $quotation)
                        <a href="{{ route('admin.quotations.show', $quotation->id) }}" class="block p-4 border border-gray-100 rounded-xl hover:bg-gray-50 hover:border-indigo-200 transition group relative overflow-hidden">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-bold text-gray-800 group-hover:text-indigo-600">{{ $quotation->quotation_number }}</span>
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-md
                                    @if($quotation->status == 'pending') bg-yellow-100 text-yellow-700 
                                    @elseif($quotation->status == 'accepted' || $quotation->status == 'ordered') bg-green-100 text-green-700 
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ str_replace('_', ' ', $quotation->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="font-semibold text-indigo-600 text-sm">₹{{ number_format($quotation->final_amount, 2) }}</span>
                                <span class="text-gray-500"><i class="far fa-clock mr-1"></i> Valid till: {{ \Carbon\Carbon::parse($quotation->valid_until)->format('d M y') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-gray-400">
                        <i class="fas fa-file-invoice-dollar text-3xl mb-3 opacity-30"></i>
                        <p class="text-sm">No quotations generated yet.</p>
                        @if($lead->status === 'mature')
                        <form action="{{ route('admin.leads.convert', $lead->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">Generate One Now</button>
                        </form>
                        @endif
                    </div>
                @endif
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="space-y-6">
            
            {{-- Package Interest --}}
            <div class="bg-indigo-900 rounded-2xl shadow-md p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-800 rounded-full blur-2xl -mr-10 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-indigo-700 rounded-full blur-xl -ml-10 -mb-10 opacity-50"></div>
                
                <h3 class="font-bold text-indigo-100 text-sm mb-6 relative z-10 uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-box-open"></i> Package Interest
                </h3>
                
                <div class="space-y-5 relative z-10">
                    @if($lead->package)
                        <div>
                            <p class="text-indigo-300 text-[10px] font-semibold mb-1 uppercase tracking-wide">Selected Package</p>
                            <p class="text-xl font-bold text-white mb-2">{{ $lead->package->name }}</p>
                            <span class="inline-block bg-indigo-800 text-indigo-100 text-xs px-2.5 py-1 rounded-md font-medium border border-indigo-700">
                                {{ $lead->package->system_size_kw }} kW System
                            </span>
                        </div>
                        
                        <div class="pt-4 border-t border-indigo-800">
                            <p class="text-indigo-300 text-[10px] font-semibold mb-1 uppercase tracking-wide">Package Est. Value</p>
                            <p class="text-2xl font-bold">₹{{ number_format($lead->package->price, 2) }}</p>
                        </div>
                    @else
                        <div>
                            <p class="text-indigo-300 text-[10px] font-semibold mb-1 uppercase tracking-wide">Estimated Value (Manual)</p>
                            <p class="text-3xl font-bold text-white mb-2">₹{{ number_format($lead->estimated_value ?? 0, 2) }}</p>
                            <p class="text-xs text-indigo-200">No specific package selected.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Activity & Audit --}}
            <div class="bg-gray-50 rounded-2xl shadow-sm p-6 border border-gray-100 text-sm">
                <h3 class="font-bold text-gray-800 text-sm border-b border-gray-200 pb-3 mb-4 flex items-center gap-2">
                    <i class="fas fa-history text-indigo-500"></i> Lead Timeline
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between pt-2 border-b border-gray-200 pb-2">
                        <span class="text-gray-500">Created At:</span>
                        <span class="font-medium text-gray-800">{{ $lead->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500">Last Updated:</span>
                        <span class="font-medium text-gray-800">{{ $lead->updated_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @if($lead->last_contacted_at)
                    <div class="flex justify-between text-green-700 bg-green-50 p-2 rounded-lg border border-green-100 font-medium">
                        <span class="flex items-center gap-1"><i class="fas fa-headset text-xs"></i> Last Contacted:</span>
                        <span>{{ \Carbon\Carbon::parse($lead->last_contacted_at)->diffForHumans() }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white shadow-sm p-4 rounded-xl border border-gray-100">
                <h3 class="font-bold text-gray-800 text-xs mb-3 uppercase tracking-wider text-center">Quick Status Update</h3>
                <div class="grid grid-cols-2 gap-2">
                    @if($lead->status === 'new')
                        <form action="{{ route('admin.leads.update', $lead->id) }}" method="POST" class="col-span-2">
                            @csrf @method('PUT')
                            <!-- Hidden inputs to satisfy validation rules -->
                            <input type="hidden" name="name" value="{{ $lead->name }}">
                            <input type="hidden" name="email" value="{{ $lead->email }}">
                            <input type="hidden" name="phone" value="{{ $lead->phone }}">
                            <input type="hidden" name="address" value="{{ $lead->address }}">
                            <input type="hidden" name="lead_source" value="{{ $lead->lead_source }}">
                            <input type="hidden" name="status" value="contacted">
                            <button type="submit" class="w-full text-center text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 transition py-2 rounded-lg border border-blue-200">Mark Contacted</button>
                        </form>
                    @endif
                    
                    @if($lead->status !== 'mature' && $lead->status !== 'converted')
                        <form action="{{ route('admin.leads.mature', $lead->id) }}" method="POST" class="col-span-2">
                            @csrf
                            <button type="submit" class="w-full text-center text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition py-2 rounded-lg shadow-sm">Mark Mature & Auto-Quote</button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Danger action --}}
            <div class="bg-white shadow-sm p-4 rounded-xl border border-red-100 mt-4">
                <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="POST"
                    onsubmit="return confirm('Delete this lead immediately? This action is irreversible.');">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full text-center text-sm font-semibold text-red-500 hover:text-red-700 transition flex justify-center items-center gap-2">
                        <i class="fas fa-trash"></i> Delete Lead Profile
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
