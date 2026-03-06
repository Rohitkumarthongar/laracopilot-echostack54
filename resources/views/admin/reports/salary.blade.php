@extends('layouts.admin')

@section('title', 'Payroll Report')
@section('page-title', 'Business Intelligence')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reports.index') }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white shadow-sm border border-gray-200 text-gray-500 hover:text-green-600 transition">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Payroll Disbursement Summary</h2>
                <p class="text-sm text-gray-400 mt-0.5">Analysing staff payments for {{ date('F', mktime(0,0,0, $month, 1)) }} {{ $year }}</p>
            </div>
        </div>
        <a href="{{ route('admin.reports.salary.pdf', ['month' => $month, 'year' => $year]) }}" target="_blank"
            class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.reports.salary') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Period Month</label>
                <select name="month" required class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m, 1)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Period Year</label>
                <input type="number" name="year" value="{{ $year }}" required
                    class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 w-24">
            </div>
            <button type="submit" class="bg-green-50 text-green-600 hover:bg-green-600 hover:text-white font-bold py-2 px-6 rounded-xl transition text-sm">
                Change Period
            </button>
        </form>
    </div>

    {{-- Analysis Header --}}
    <div class="bg-gradient-to-br from-green-600 to-green-800 p-8 rounded-2xl shadow-lg border border-green-500 text-white relative overflow-hidden">
        <i class="fas fa-piggy-bank absolute -right-8 -bottom-8 text-white/10 text-9xl rotate-12"></i>
        <div class="max-w-md relative z-10">
            <p class="text-[10px] font-black uppercase tracking-widest text-green-200 mb-2">Total Monthly Disbursement</p>
            <h3 class="text-4xl font-black tracking-tighter mb-4">₹{{ number_format($totalPaid, 2) }}</h3>
            <div class="flex items-center gap-4 text-xs font-bold text-green-100">
                <div class="flex items-center gap-2">
                    <i class="fas fa-users"></i> {{ $records->count() }} Employees Paid
                </div>
                <div class="w-1 h-1 bg-green-400 rounded-full"></div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-check"></i> Verified Transactions
                </div>
            </div>
        </div>
    </div>

    {{-- List Table --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 text-sm">Detailed Payout Schedule</h3>
            <span class="bg-green-50 text-green-600 text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-wider">Historical Records</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-400 font-bold uppercase text-[10px] tracking-wider border-b border-gray-50">
                    <tr>
                        <th class="px-6 py-4">Employee Detail</th>
                        <th class="px-6 py-4">Department</th>
                        <th class="px-6 py-4 text-right">Basic</th>
                        <th class="px-6 py-4 text-right">Allowances</th>
                        <th class="px-6 py-4 text-right">Deductions</th>
                        <th class="px-6 py-4 text-right">Net Payout</th>
                        <th class="px-6 py-4 text-center">Paid on</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($records as $rec)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-800">{{ $rec->employee->name ?? 'Deleted Staff' }}</span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $rec->employee->employee_code ?? 'EMP-N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[9px] bg-gray-100 text-gray-500 font-bold px-1.5 py-0.5 rounded border border-gray-100 uppercase italic">
                                {{ $rec->employee->department ?? '' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-gray-500">₹{{ number_format($rec->basic_salary, 2) }}</td>
                        <td class="px-6 py-4 text-right text-green-600">+{{ number_format($rec->allowances ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-right text-red-400">-{{ number_format($rec->deductions ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-right font-black text-green-700 tracking-tighter">₹{{ number_format($rec->net_salary, 2) }}</td>
                        <td class="px-6 py-4 text-center text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($rec->payment_date)->format('d M') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($rec->status == 'paid')
                                <span class="bg-green-100 text-green-700 text-[9px] font-black px-2 py-0.5 rounded uppercase">Verified</span>
                            @else
                                <span class="bg-gray-100 text-gray-400 text-[9px] font-black px-2 py-0.5 rounded uppercase">Other</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-gray-300">
                            <i class="fas fa-hand-holding-usd text-4xl mb-3 opacity-10"></i>
                            <p class="font-bold">No salary records for this month/year period.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
