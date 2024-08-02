<x-layout>

    <x-card class="max-w-lg mx-auto mt-24">
    <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">
            Apply for a Job Listing
        </h2>
        <p class="mb-4">Post a listing to find a developer</p>
    </header>
    

    <form action="/listings/{{$listing}}/save" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-input mt-1 block w-full" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-input mt-1 block w-full" required>
    </div>
    <div>
        <label for="resume">Resume:</label>
        <input type="file" id="resume" name="resume" class="form-input mt-1 block w-full" required>
    </div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center mt-4">
        <i class="fa-solid fa-paper-plane mr-2"></i> Apply Now
    </button>
</form>

    </x-card>
    </x-layout>