<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Mail\CandidateApplicationMail;
use App\Mail\EmployerApplicationMail;
use Illuminate\Support\Facades\Mail;

class ListingController extends Controller
{
    // Get and show all listings
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()
                ->where('status', true)
                ->filter(request(['tag', 'search']))
                ->paginate(6)
        ]);
    }

    // Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show create form
    public function create() {
        return view('listings.create');
    }

    // Store listing data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    // Show edit form
    public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update listing data
    public function update(Request $request, Listing $listing) {
        // Make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    // Delete listing
    public function destroy(Listing $listing) {
        // Make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();

        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    // Manage listings
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings]);
    }

    // Activate listing
    public function activate($id) {
        $listing = Listing::find($id);
        $listing->status = true;
        $listing->save();

        return redirect('/')->with('message', 'Listing activated successfully.');
    }

    // Deactivate listing
    public function deactivate($id) {
        $listing = Listing::find($id);
        $listing->status = false;
        $listing->save();

        return redirect('/')->with('message', 'Listing deactivated successfully.');
    }

    // Show application form
    public function apply($id) {
        return view('listings.form', [
            'listing' => Listing::findOrFail($id)
        ]);
    }

    // Save job application
    public function save(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|digits:10',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $listing = Listing::findOrFail($id);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        $application = new JobApplication();
        $application->listing_id = $listing->id;
        $application->name = $request->input('name');
        $application->email = $request->input('email');
        $application->mobile = $request->input('mobile');
        $application->resume = $resumePath;
        $application->save();

        // Send email to the candidate
    Mail::to($application->email)->send(new CandidateApplicationMail($application, $listing));

    // Send email to the employer
    Mail::to($listing->user->email)->send(new EmployerApplicationMail($application, $listing, $resumePath));

        return redirect('/')->with('message', 'Application submitted successfully.');
    }
}
