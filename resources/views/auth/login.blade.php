@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Đăng nhập
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <p class="mb-0">Chưa có tài khoản? 
                        <a href="{{ route('register') }}">Đăng ký ngay</a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Demo Account Info -->
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Tài khoản demo
                </h6>
                <p class="small mb-2">
                    <strong>Email:</strong> demo@example.com<br>
                    <strong>Mật khẩu:</strong> password
                </p>
                <button class="btn btn-outline-secondary btn-sm" onclick="fillDemoAccount()">
                    <i class="fas fa-magic me-1"></i>Điền thông tin demo
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function fillDemoAccount() {
        document.getElementById('email').value = 'test@example.com';
        document.getElementById('password').value = 'password';
    }
</script>
@endsection
