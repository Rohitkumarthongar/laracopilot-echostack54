<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $installations = Installation::with(['customer', 'salesOrder'])->orderBy('scheduled_date', 'desc')->paginate(15);
        return view('admin.installations.index', compact('installations'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $customers = Customer::orderBy('name')->get();
        $salesOrders = SalesOrder::where('status', 'confirmed')->get();
        $employees = Employee::where('department', 'installation')->where('is_active', true)->get();
        return view('admin.installations.create', compact('customers', 'salesOrders', 'employees'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'scheduled_date' => 'required|date',
            'system_size_kw' => 'required|numeric',
            'installation_address' => 'required|string',
            'roof_type' => 'required|string',
            'notes' => 'nullable|string',
            'assigned_team' => 'nullable|string'
        ]);
        $validated['installation_number'] = 'INST-' . date('Ymd') . '-' . rand(100, 999);
        $validated['status'] = 'scheduled';
        $installation = Installation::create($validated);

        Notification::create([
            'title' => 'Installation Scheduled',
            'message' => 'Installation ' . $installation->installation_number . ' scheduled for ' . $installation->scheduled_date,
            'type' => 'installation', 'related_id' => $installation->id, 'related_type' => 'Installation'
        ]);

        return redirect()->route('admin.installations.index')->with('success', 'Installation scheduled!');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $installation = Installation::with(['customer', 'salesOrder'])->findOrFail($id);
        return view('admin.installations.show', compact('installation'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $installation = Installation::findOrFail($id);
        $customers = Customer::orderBy('name')->get();
        $salesOrders = SalesOrder::all();
        return view('admin.installations.edit', compact('installation', 'customers', 'salesOrders'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $installation = Installation::findOrFail($id);
        $validated = $request->validate([
            'scheduled_date' => 'required|date',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'system_size_kw' => 'required|numeric',
            'installation_address' => 'required|string',
            'roof_type' => 'required|string',
            'assigned_team' => 'nullable|string',
            'completion_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);
        $installation->update($validated);

        if ($validated['status'] === 'completed') {
            Notification::create([
                'title' => 'Installation Completed',
                'message' => 'Installation ' . $installation->installation_number . ' has been completed.',
                'type' => 'installation', 'related_id' => $installation->id, 'related_type' => 'Installation'
            ]);
        }

        return redirect()->route('admin.installations.show', $id)->with('success', 'Installation updated!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Installation::findOrFail($id)->delete();
        return redirect()->route('admin.installations.index')->with('success', 'Installation deleted!');
    }
}