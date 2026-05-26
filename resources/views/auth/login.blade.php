@extends('layouts.guest')
@section('title', 'Login - e-Kost')

@section('content')
<div class="min-h-[calc(100vh-64px)] flex bg-[#f5e6e6]">
    <!-- Brand Panel -->
    <div class="hidden lg:flex lg:w-1/2 bg-[#400000] items-center justify-center p-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#30BF62 1px, transparent 1px); background-size: 32px 32px;"></div>
        <div class="relative z-10 text-white max-w-lg">
            <h2 class="text-4xl font-bold mb-6">Welcome Back to e-Kost</h2>
            <p class="text-lg text-gray-300">Manage your property efficiently or access your tenant dashboard to view payments and contracts seamlessly.</p>
            <div class="mt-12 space-y-4">
                <div class="flex items-center space-x-3 text-sm text-gray-300">
                    <svg class="w-6 h-6 text-[#30BF62]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Secure & hassle-free dashboard</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-md p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-[#012619]">Sign In</h1>
                <p class="text-gray-500 mt-2">Enter your credentials to continue</p>
            </div>
            
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 p-4 rounded-xl text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition" required>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs text-[#400000] hover:text-[#035949] font-medium transition">Forgot password?</a>
                    </div>
                    <input type="password" name="password" placeholder="123456" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition" required>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-[#30BF62] border-gray-300 rounded focus:ring-[#30BF62]">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                <button type="submit" class="w-full bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-4 py-2 font-semibold transition duration-200">
                    Sign In
                </button>
            </form>
            
            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account? <a href="{{ route('register') }}" class="text-[#188C4A] hover:text-[#035949] font-medium transition">Sign up</a>
            </p>

            
        </div>
    </div>
</div>
@endsection
