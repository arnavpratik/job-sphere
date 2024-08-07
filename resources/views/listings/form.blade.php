<x-layout>

    <x-card class="max-w-lg mx-auto mt-24">
    <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">
            Apply for a Job Listing
        </h2>
        <p class="mb-4">Post a listing to find a developer</p>
    </header>
    

    <form action="/listings/{{$listing->id}}/save" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Applicant Name:</label>
            <input type="text" id="name" name="name" class="form-input mt-1 block w-full" required>
            @error('name')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
        </div>
        <div>
            <label for="email">Contact Email:</label>
            <input type="email" id="email" name="email" class="form-input mt-1 block w-full" required>
            @error('email')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
        </div>
        <div>
            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" placeholder="Please enter a 10-digit mobile number." pattern="[0-9]{10}" class="form-input mt-1 block w-full" required>
            @error('mobile')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            
        </div>
        
        <div>
            <label for="resume">Resume:</label>
            <input type="file" id="resume" name="resume" class="form-input mt-1 block w-full" required>
            @error('resume')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mt-4">
            <i class="fa-solid fa-paper-plane mr-2"></i> Apply Now
        </button>
    </form>
    

    </x-card>
    </x-layout>