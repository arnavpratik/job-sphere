<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="/users/authenticate">
          @csrf
          <img class="mb-4" src="{{asset('images/JobSphere.png')}}" alt="" width="72" height="57">
          <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

          {{-- <div class="form-floating">
            <input type="text" class="form-control" id="floatingName" placeholder="Enter your name" name="name" value="{{old('name')}}">
            <label for="floatingInput">Name</label>
            @error('name')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
          </div>  --}}

          <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" value="{{old('email')}}">
            <label for="floatingInput">Email address</label>
            @error('email')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
          </div>


          <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password"  value="{{old('password')}}">
            <label for="floatingPassword">Password</label>
            @error('password')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
          </div>

          {{-- <div class="form-floating">
            <input type="password" class="form-control" id="floatingPasswordConfirmation" placeholder="Password" name="password_confirmation" value="{{old('password_confirmation')}}">
            <label for="floatingPassword">Confirm Password</label>
            @error('password_confirmation')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
          </div> --}}
      
         {{--  <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              Remember me
            </label>
          </div> --}}
          <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
          <div class="mt-8">
            <p>
              Don't have an account?
              <a href="/register" class="text-laravel">Register</a>
            </p>
          </div>
          <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
        </form>
      </main>
    </x-card>
</x-layout>