@extends('auth.layouts')
@section('content')
<header class="max-w-lg mx-auto">
    <a href="/">
        <h1 class="text-4xl font-bold text-white text-center">{{$title}}</h1>
    </a>
</header>
<main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
    <section>
        <h3 class="font-bold text-2xl">Welcome to Startup</h3>
        <p class="text-gray-600 pt-2">Sign in to your account.</p>
    </section>

    <section class="mt-10">
        <form class="flex flex-col" maction="{{ route('proses_login.login') }}" method="POST" autocomplete="off"
            novalidate>
            @csrf
            <div class="mb-6 pt-3 rounded bg-gray-200">
                <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}"
                    class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
            </div>
            <div class="mb-6 pt-3 rounded bg-gray-200">
                <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
                <input type="password" id="password" name="password"
                    class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
            </div>

            <button
                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                type="submit">Sign In</button>
        </form>
    </section>
</main>

<div class="max-w-lg mx-auto text-center mt-12 mb-6">
    <p class="text-white">Don't have an account? <a href="#" class="font-bold hover:underline">Sign up</a>.</p>
</div>

@endsection