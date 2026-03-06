@extends('layouts.admin')

@section('title', 'Sales Report')
@section('page-title', 'Business Intelligence')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumbs & Export --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reports.index') }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white shadow-sm border border-gray-200 text-gray-500 hover:text-indigo-600 transition">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Sales Performance</h2>
                <p class="text-sm text-gray-400 mt-0.5">Analysing revenue from {{ \Carbon\Carbon::parse($from)->format('d M') }} to {{ \Carbon\Carbon::parse($to)->format('d M, Y') }}</p>
            </div>
        </div>
        <a href="{{ route('admin.reports.sales.pdf', ['from' => $from, 'to' => $to]) }}" target="_blank"
            class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">From Date</label>
                <input type="date" name="from" value="{{ $from }}" 
                    class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">To Date</label>
                <input type="date" name="to" value="{{ $to }}" 
                    class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <button type="submit" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white font-bold py-2 px-6 rounded-xl transition text-sm">
                Update Report
            </button>
        </form>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Total Revenue</p>
            <h3 class="text-2xl font-black text-indigo-600 tracking-tighter">₹{{ number_format($totalRevenue, 2) }}</h3>
            <p class="text-[10px] text-gray-400 mt-1">Sum of all final invoices</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Total Orders</p>
            <h3 class="text-2xl font-black text-gray-800 tracking-tighter">{{ $totalOrders }}</h3>
            <p class="text-[10px] text-gray-400 mt-1">Booked in this period</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Completed</p>
            <h3 class="text-2xl font-black text-green-600 tracking-tighter">{{ $completedOrders }}</h3>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-2 overflow-hidden">
                <div class="bg-green-500 h-full" style="width: {{ $totalOrders > 0 ? ($completedOrders/$totalOrders)*100 : 0 }}%"></div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Avg Order Value</p>
            <h3 class="text-2xl font-black text-orange-600 tracking-tighter">₹{{ number_format($totalOrders > 0 ? $totalRevenue / $totalOrders : 0, 2) }}</h3>
            <p class="text-[10px] text-gray-400 mt-1">Ticket size per client</p>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 text-sm">List of Sales Orders</h3>
            <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-wider">{{ count($orders) }} Results</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-400 font-bold uppercase text-[10px] tracking-wider border-b border-gray-50">
                    <tr>
                        <th class="px-6 py-4">Order No</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Payment</th>
                        <th class="px-6 py-4 text-right">Amount</th>
                        <th class="px-6 py-4 text-center">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="px-6 py-4 font-black text-indigo-600 tracking-tighter">
                            <a href="{{ route('admin.sales-orders.show', $order->id) }}">{{ $order->order_number }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-800">{{ $order->customer->name ?? 'Walk-in' }}</span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $order->customer->phone ?? '' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $sCol = ['completed'=>'text-green-600 bg-green-50 border-green-100','pending'=>'text-orange-600 bg-orange-50 border-orange-100','cancelled'=>'text-red-600 bg-red-50 border-red-100'];
                            @endphp
                            <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded border {{ $sCol[$order->status] ?? 'text-gray-500 bg-gray-50' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                             <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded border {{ $order->payment_status == 'paid' ? 'text-green-600 bg-green-50 border-green-100' : 'text-gray-400 bg-gray-50 border-gray-100' }}">
                                {{ $order->payment_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-black text-gray-800 tracking-tighter">
                            ₹{{ number_format($order->final_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 text-center text-gray-500 text-xs">
                            {{ $order->created_at->format('d/m/y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-300">
                            <i class="fas fa-search-dollar text-4xl mb-3 opacity-10"></i>
                            <p class="font-medium">No sales recorded for the selected date range.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
