<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\SalesOrder;
use App\Models\Installation;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $customers = Customer::withCount(['leads', 'salesOrders', 'installations'])
            ->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'customer_type' => 'required|in:residential,commercial,industrial',
            'notes' => 'nullable|string'
        ]);
        $validated['customer_code'] = 'CUST-' . strtoupper(substr(str_replace(' ', '', $validated['name']), 0, 3)) . '-' . rand(1000, 9999);
        Customer::create($validated);
        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully!');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $customer = Customer::with(['leads', 'salesOrders', 'installations', 'serviceRequests'])->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $customer = Customer::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'customer_type' => 'required|in:residential,commercial,industrial',
            'notes' => 'nullable|string'
        ]);
        $customer->update($validated);
        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Customer::findOrFail($id)->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted!');
    }
}