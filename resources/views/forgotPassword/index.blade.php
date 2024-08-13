<x-layout>
    <div class="flex min-h-full flex-col justify-center px-3 py-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
          <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
          <h2 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Forgot Password</h2>
        </div>
      
        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
          <form class="space-y-6" action="/forgotPassword" method="POST">
            @csrf
            <div>
              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
              <div class="mt-2">
                <input id="email" name="email" type="email" autocomplete="email" value="{{old('email')}}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>
            </div>
      
            <div>
              <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
            </div>
          </form>
      
          <p class="mt-10 text-center text-sm text-gray-500">
            @session('session')
                <p class="text-red-700">{{session('session')}}</p>
            @endsession
            @foreach ($errors->all() as $message)
            <p class="text-red-700 my-2">{{ $message }}</p>
            @endforeach
          </p>
        </div>
      </div>
      
    </x-layout>