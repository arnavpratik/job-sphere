<x-layout>
    <x-card class="max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Apply for a Job Listing
            </h2>
            <p class="mb-4">Fill Your Application for the Opportunity</p>
        </header>
        
        <form id="applicationForm" action="/listings/{{$listing->id}}/save" method="POST" enctype="multipart/form-data">
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

        <!-- Loader Element -->
        <div id="loader" style="display:none; text-align: center; margin-top: 20px;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <h2>Submitting your application, please wait...</h2>
        </div>

        <script>
          document.getElementById('applicationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Show loader and hide the form and header
    document.getElementById('loader').style.display = 'block';
    document.getElementById('applicationForm').style.display = 'none';
    document.querySelector('header').style.display = 'none';

    // Gather the form data
    let formData = new FormData(this);

    // Use Fetch API to submit the form
    fetch(`/listings/{{ $listing->id }}/save`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Expect JSON from the server
    })
    .then(data => {
        if (data.success) {
            // Redirect to the home page or specified URL
            window.location.href = data.redirect;
        } else {
            throw new Error('Submission failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);

        // Hide loader and restore the form and header
        document.getElementById('loader').style.display = 'none';
        document.getElementById('applicationForm').style.display = 'block';
        document.querySelector('header').style.display = 'block';

        // Display an alert on error
        alert('There was an error submitting your application. Please try again.');
    });
});


        </script>
    </x-card>
</x-layout>
