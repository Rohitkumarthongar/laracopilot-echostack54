<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Product;
use App\Models\Lead;
use App\Models\Setting;
use Illuminate\Http\Request;

class WebController extends Controller
{
    private function getSettings()
    {
        return Setting::pluck('value', 'key')->toArray();
    }

    public function home()
    {
        $settings = $this->getSettings();
        $packages = Package::where('is_active', true)->where('is_featured', true)->take(3)->get();
        $products = Product::where('is_active', true)->take(6)->get();
        return view('web.home', compact('settings', 'packages', 'products'));
    }

    public function about()
    {
        $settings = $this->getSettings();
        return view('web.about', compact('settings'));
    }

    public function products()
    {
        $settings = $this->getSettings();
        $products = Product::where('is_active', true)->orderBy('category')->paginate(12);
        return view('web.products', compact('settings', 'products'));
    }

    public function packages()
    {
        $settings = $this->getSettings();
        $packages = Package::where('is_active', true)->orderBy('price')->get();
        return view('web.packages', compact('settings', 'packages'));
    }

    public function contact()
    {
        $settings = $this->getSettings();
        return view('web.contact', compact('settings'));
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string'
        ]);
        Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => 'Contact Form Inquiry',
            'lead_source' => 'website',
            'status' => 'new',
            'notes' => $validated['message'],
            'lead_number' => 'LEAD-' . date('Ymd') . '-' . rand(100, 999)
        ]);
        return redirect()->back()->with('success', 'Thank you! We will contact you shortly.');
    }

    public function getQuote()
    {
        $settings = $this->getSettings();
        $packages = Package::where('is_active', true)->get();
        return view('web.get-quote', compact('settings', 'packages'));
    }

    public function getQuoteStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'package_id' => 'nullable|exists:packages,id',
            'system_size' => 'nullable|string',
            'roof_type' => 'nullable|string',
            'monthly_bill' => 'nullable|string'
        ]);
        $lead = Lead::create(array_merge($validated, [
            'lead_source' => 'website',
            'status' => 'new',
            'lead_number' => 'LEAD-' . date('Ymd') . '-' . rand(100, 999),
            'notes' => 'Monthly Bill: ' . ($validated['monthly_bill'] ?? 'N/A') . ', System Size: ' . ($validated['system_size'] ?? 'N/A')
        ]));
        return redirect()->back()->with('success', 'Quote request submitted! Our team will contact you within 24 hours.');
    }
}