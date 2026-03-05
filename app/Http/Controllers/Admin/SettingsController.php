<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $data = $request->except(['_token', '_method']);
        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $value = $request->file($key)->store('settings', 'public');
            }
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return redirect()->back()->with('success', 'Settings saved!');
    }

    public function email()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.email', compact('settings'));
    }

    public function emailUpdate(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'mail_driver' => 'required|in:smtp,sendmail,mailgun',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|in:tls,ssl,none',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string'
        ]);
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return redirect()->back()->with('success', 'Email configuration saved!');
    }

    public function emailTemplates()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $templates = EmailTemplate::orderBy('type')->get();
        return view('admin.settings.email-templates', compact('templates'));
    }

    public function emailTemplateStore(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:quotation,sales_order,invoice,follow_up,welcome,reminder',
            'subject' => 'required|string',
            'body' => 'required|string',
            'is_active' => 'boolean'
        ]);
        $validated['is_active'] = $request->has('is_active');
        EmailTemplate::create($validated);
        return redirect()->route('admin.settings.email-templates')->with('success', 'Email template created!');
    }

    public function emailTemplateEdit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $template = EmailTemplate::findOrFail($id);
        return view('admin.settings.email-template-edit', compact('template'));
    }

    public function emailTemplateUpdate(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $template = EmailTemplate::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'subject' => 'required|string',
            'body' => 'required|string'
        ]);
        $validated['is_active'] = $request->has('is_active');
        $template->update($validated);
        return redirect()->route('admin.settings.email-templates')->with('success', 'Template updated!');
    }

    public function emailTemplateDestroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        EmailTemplate::findOrFail($id)->delete();
        return redirect()->route('admin.settings.email-templates')->with('success', 'Template deleted!');
    }
}