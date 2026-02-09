@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card card-gradient shadow-lg" style="max-width: 500px; width: 100%;">
        <div class="card-body p-5">
            <h2 class="text-center fw-bold mb-4" style="color: #0f172a;">Connexion</h2>
            
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Adresse Email</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">Se Connecter</button>
                </div>

                <div class="text-center mt-4">
                    <span class="text-muted">Pas encore de compte ?</span>
                    <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: var(--color-primary);">Inscrivez-vous</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
