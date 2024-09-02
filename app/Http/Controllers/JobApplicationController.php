<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Mail\EmployerWithdrawn;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationWithdrawn; // Assume this mailable is created

class JobApplicationController extends Controller
{
    // Display all applied jobs
    public function index()
    {
        $applications = JobApplication::where('user_id', Auth::id())->with('listing')->get();

        return view('applications.index', compact('applications'));
    }

    // Withdraw an application
    public function withdraw($id)
    {

        $application = JobApplication::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        // Get the authenticated user
        $user = auth()->user();
        //Log::info($application);

        // Get the listing associated with the application
        $listing = Listing::findOrFail($application->listing_id);

        // Get the employer (user who posted the listing)
        $employer = User::findOrFail($listing->user_id);

        // Notify both employer and candidate via email
        Mail::to($employer->email)->send(new EmployerWithdrawn($application));
        Mail::to($application->email)->send(new ApplicationWithdrawn($application));

        // Delete the application
        $application->delete();

        // Set a flash message
        session()->flash('message', 'Application withdrawn successfully!');

        return response()->json([
            'success' => true,
            'redirect' => url()->previous(), // Redirect to the homepage or any other route
        ]);

        /* return redirect()->route('applications.index')->with('message', 'Application withdrawn successfully.'); */
    }
}
