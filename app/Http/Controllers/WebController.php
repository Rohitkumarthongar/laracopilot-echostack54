<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Product;
use App\Models\ProductCategory;
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
        $settings   = $this->getSettings();
        $packages   = Package::where('is_active', true)->where('is_featured', true)->take(3)->get();
        $products   = Product::where('is_active', true)->with('productCategory')->take(6)->get();
        $categories = ProductCategory::where('is_active', true)->withCount('products')->orderBy('sort_order')->take(6)->get();
        return view('web.home', compact('settings', 'packages', 'products', 'categories'));
    }

    public function about()
    {
        $settings = $this->getSettings();
        return view('web.about', compact('settings'));
    }

    public function products(Request $request)
    {
        $settings   = $this->getSettings();
        $categories = ProductCategory::where('is_active', true)->withCount('products')->orderBy('sort_order')->get();
        $query      = Product::where('is_active', true)->with('productCategory');
        if ($request->category) {
            $cat = ProductCategory::where('slug', $request->category)->first();
            if ($cat) $query->where('category_id', $cat->id);
        }
        $products        = $query->orderBy('name')->paginate(12)->appends($request->only('category'));
        $activeCategory  = $request->category;
        return view('web.products', compact('settings', 'products', 'categories', 'activeCategory'));
    }

    public function productCategory($slug)
    {
        $settings = $this->getSettings();
        $category = ProductCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = Product::where('is_active', true)->where('category_id', $category->id)->with('productCategory')->paginate(12);
        $categories = ProductCategory::where('is_active', true)->withCount('products')->orderBy('sort_order')->get();
        return view('web.products', compact('settings', 'products', 'categories', 'category'));
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
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string',
            'message' => 'required|string',
        ]);
        Lead::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'address'     => 'Contact Form Inquiry',
            'lead_source' => 'website',
            'status'      => 'new',
            'notes'       => $validated['message'],
            'lead_number' => 'LEAD-' . date('Ymd') . '-' . rand(100, 999),
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
            'name'         => 'required|string',
            'email'        => 'required|email',
            'phone'        => 'required|string',
            'address'      => 'required|string',
            'package_id'   => 'nullable|exists:packages,id',
            'system_size'  => 'nullable|string',
            'roof_type'    => 'nullable|string',
            'monthly_bill' => 'nullable|string',
        ]);
        Lead::create(array_merge($validated, [
            'lead_source' => 'website',
            'status'      => 'new',
            'lead_number' => 'LEAD-' . date('Ymd') . '-' . rand(100, 999),
            'notes'       => 'Monthly Bill: ' . ($validated['monthly_bill'] ?? 'N/A') . ', System Size: ' . ($validated['system_size'] ?? 'N/A'),
        ]));
        return redirect()->back()->with('success', 'Quote request submitted! Our team will contact you within 24 hours.');
    }
}