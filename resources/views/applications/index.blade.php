<x-layout>
    <x-card id="main-content" class="p-10">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-6">
                Your Job Applications
            </h2>
        </header>

        @if ($applications->isEmpty())
            <p class="text-center">You have not applied for any jobs yet.</p>
        @else
            <ul class="list-none p-0">
                @foreach ($applications as $application)
                    <li class="mb-4 pb-4 border-b border-gray-300">
                        <div class="flex justify-start items-center">
                            <div class="flex-1">
                                <h2 class="font-semibold">{{ $application->listing->title }}</h2>
                                <p class="text-gray-600">Applied on: {{ $application->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <form action="{{ route('applications.withdraw', $application->id) }}" method="POST" class="withdrawForm">
                                    @csrf
                                    <button type="submit" class="text-red-500 flex items-center gap-1 hover:underline">
                                        <i class="fas fa-trash-alt"></i> Withdraw Application
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-card>

    <!-- Loader Element -->
    <div id="loader" style="display:none; text-align: center; margin-top: 20px;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h2>Processing your request, please wait...</h2>
    </div>

    <script>
        document.querySelectorAll('.withdrawForm').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Hide the main content
                document.getElementById('main-content').style.display = 'none';

                // Show the loader
                document.getElementById('loader').style.display = 'block';

                // Gather the form data
                let formData = new FormData(this);

                // Use Fetch API to submit the form
                fetch(this.action, {
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
                        // Redirect to the specified URL or refresh the page
                        window.location.href = data.redirect || window.location.href;
                    } else {
                        throw new Error('Submission failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Hide loader and show the main content again
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('main-content').style.display = 'block';

                    // Display an alert on error
                    alert('There was an error processing your request. Please try again.');
                });
            });
        });
    </script>
</x-layout>
