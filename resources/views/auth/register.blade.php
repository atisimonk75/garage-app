@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card card-gradient shadow-lg" style="max-width: 600px; width: 100%;">
        <div class="card-body p-5">
            <h2 class="text-center fw-bold mb-4" style="color: #0f172a;">Créer un Compte</h2>

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Nom Complet</label>
                    <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Adresse Email</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password" required autocomplete="new-password">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirmer le mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">S'inscrire</button>
                </div>

                <div class="text-center mt-4">
                    <span class="text-muted">Déjà un compte ?</span>
                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: var(--color-primary);">Connectez-vous</a>
                </div>

                <div class="position-relative my-4">
                    <hr class="text-muted opacity-25">
                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">OU</span>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('login.social', 'google') }}" class="btn btn-outline-secondary btn-lg position-relative shadow-sm border-0 bg-light text-dark">
                        <i class="fa-brands fa-google position-absolute top-50 start-0 translate-middle-y ms-3 fs-5 text-danger"></i>
                        <span class="fw-semibold">S'inscrire avec Google</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
