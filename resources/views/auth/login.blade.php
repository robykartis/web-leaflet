@extends('auth.layouts')
@section('content')

<main>
    <div class="min-h-screen flex items-center justify-center">
        <div class="card w-96 bg-base-100 shadow-xl">
            <div class="card-body items-center text-center">
                <h2 class="card-title">Login 👏</h2>
                <p>Silahkan login untuk masuk</p>
                <form maction="{{ route('proses_login.login') }}" method="POST" autocomplete="off" novalidate>
                    @csrf
                    <input type="email" placeholder="email@example.com" name="email" value="{{ old('email') }}"
                        class="input mb-4 input-bordered w-full max-w-xs" />
                    <input type="password" placeholder="Password" class="input input-bordered w-full max-w-xs"
                        name="password" />
                    <div class="card-actions items-center justify-center p-3">
                        <button type="submit" class="btn btn-accent text-white">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</main>


@endsection