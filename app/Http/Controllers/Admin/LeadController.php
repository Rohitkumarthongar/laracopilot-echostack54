<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $leads = Lead::with('customer')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.leads.index', compact('leads'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $customers = Customer::orderBy('name')->get();
        $packages = Package::where('is_active', true)->get();
        return view('admin.leads.create', compact('customers', 'packages'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'lead_source' => 'required|in:website,referral,cold_call,social_media,exhibition,other',
            'package_id' => 'nullable|exists:packages,id',
            'estimated_value' => 'nullable|numeric',
            'roof_type' => 'nullable|string|max:100',
            'system_size' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'status' => 'required|in:new,contacted,follow_up,mature,converted,lost'
        ]);
        $validated['lead_number'] = 'LEAD-' . date('Ymd') . '-' . rand(100, 999);
        $validated['assigned_to'] = session('admin_user_id');
        $lead = Lead::create($validated);

        Notification::create([
            'title' => 'New Lead Created',
            'message' => 'New lead ' . $lead->name . ' has been created from ' . $lead->lead_source,
            'type' => 'lead',
            'related_id' => $lead->id,
            'related_type' => 'Lead'
        ]);

        return redirect()->route('admin.leads.index')->with('success', 'Lead created successfully!');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $lead = Lead::with(['customer', 'package', 'quotations'])->findOrFail($id);
        return view('admin.leads.show', compact('lead'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $lead = Lead::findOrFail($id);
        $customers = Customer::orderBy('name')->get();
        $packages = Package::where('is_active', true)->get();
        return view('admin.leads.edit', compact('lead', 'customers', 'packages'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $lead = Lead::findOrFail($id);
        $oldStatus = $lead->status;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'lead_source' => 'required|string',
            'package_id' => 'nullable|exists:packages,id',
            'estimated_value' => 'nullable|numeric',
            'roof_type' => 'nullable|string',
            'system_size' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:new,contacted,follow_up,mature,converted,lost'
        ]);
        $lead->update($validated);

        if ($oldStatus !== 'mature' && $validated['status'] === 'mature') {
            $this->autoCreateQuotation($lead);
        }

        return redirect()->route('admin.leads.index')->with('success', 'Lead updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Lead::findOrFail($id)->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead deleted!');
    }

    public function markMature(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $lead = Lead::findOrFail($id);
        $lead->update(['status' => 'mature']);
        $this->autoCreateQuotation($lead);
        return redirect()->route('admin.leads.show', $id)->with('success', 'Lead marked as mature and quotation auto-created!');
    }

    public function convertToQuotation($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $lead = Lead::findOrFail($id);
        $quotation = $this->autoCreateQuotation($lead);
        return redirect()->route('admin.quotations.show', $quotation->id)->with('success', 'Quotation created from lead!');
    }

    private function autoCreateQuotation(Lead $lead)
    {
        $quotationNumber = 'QUO-' . date('Ymd') . '-' . rand(100, 999);
        $package = $lead->package;
        $totalAmount = $package ? $package->price : ($lead->estimated_value ?? 0);

        $quotation = Quotation::create([
            'quotation_number' => $quotationNumber,
            'lead_id' => $lead->id,
            'customer_id' => $lead->customer_id,
            'customer_name' => $lead->name,
            'customer_email' => $lead->email,
            'customer_phone' => $lead->phone,
            'customer_address' => $lead->address,
            'package_id' => $lead->package_id,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'valid_until' => now()->addDays(30),
            'notes' => 'Auto-generated from mature lead: ' . $lead->lead_number
        ]);

        if ($package) {
            foreach ($package->items as $item) {
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $item['product_id'] ?? null,
                    'description' => $item['description'] ?? $package->name,
                    'quantity' => $item['quantity'] ?? 1,
                    'unit_price' => $item['price'] ?? $package->price,
                    'total_price' => $item['total'] ?? $package->price
                ]);
            }
        }

        Notification::create([
            'title' => 'Quotation Auto-Generated',
            'message' => 'Quotation ' . $quotationNumber . ' has been automatically created for mature lead: ' . $lead->name,
            'type' => 'quotation',
            'related_id' => $quotation->id,
            'related_type' => 'Quotation'
        ]);

        return $quotation;
    }
}