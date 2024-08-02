<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Validation\Rule; 

class ListingController extends Controller
{
    //get and show all listings
    /* public function index() {

        return view('listings.index' ,[
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(6)
        ]);
    } */

    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()
                ->where('status', true)
                ->filter(request(['tag', 'search']))
                ->paginate(6)
        ]);
    }
    
    // show single listing
    public function show(Listing $listing) {
       // print_r($listing->id);
        return view('listings.show', [
            'listing' => $listing
    ]);

    }

    //show create form
    public function create() {
       return view('listings.create') ;
    }

    //store listing data
    public function store(Request $request) {
        $formFields =    $request->validate([
            'title' => 'required',
            'company'=> 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    //Show Edit Form
    public function edit(Listing $listing) {
        return view('listings.edit' , ['listing' =>$listing]);
    }

     //Update listing data
     public function update(Request $request , Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields =    $request->validate([
            'title' => 'required',
            'company'=> 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    //Delete Listing
    public function destroy(Listing $listing) {

         // Make sure logged in user is owner
         if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();

        return redirect('/')->with('message' , 'Listing deleted successfully');
    }

    // Manage Listings
    public function manage() {
        /* return view('listings.manage', ['listings' => auth()->user()->listings()->get()]); */
        return view('listings.manage', ['listings' => auth()->user()->listings]);
    }

    public function activate($id)
    {
        $listing = Listing::find($id);
        $listing->status = true;
        $listing->save();

        return redirect('/')->with('message', 'Listing activated successfully.');
    }

    public function deactivate($id)
    {
        $listing = Listing::find($id);
        $listing->status = false;
        $listing->save();

        return redirect('/')->with('message', 'Listing deactivated successfully.');
    }

    public function apply(Listing $listing) {
        //print_r($listing->id);
        return view('listings.form', [
            'listing' => $listing
    ]);
    }

    public function save(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
    ]);

    $listing = Listing::findOrFail($id);

    // Store the uploaded resume
    $resumePath = $request->file('resume')->store('resumes', 'public');

    // Create a new job application record
    $application = new JobApplication();
    $application->listing_id = $listing->id;
    $application->name = $request->input('name');
    $application->email = $request->input('email');
    $application->resume = $resumePath;
    $application->save();

    return redirect('/')->with('message', 'Application submitted successfully.');
}

}
