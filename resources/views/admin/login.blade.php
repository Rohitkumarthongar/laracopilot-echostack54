<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solar ERP - Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-500 via-orange-600 to-amber-700 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-solar-panel text-4xl text-orange-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">Solar ERP</h1>
            <p class="text-orange-100 mt-1">Enterprise Resource Planning</p>
        </div>
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Login</h2>
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <p class="text-sm"><i class="fas fa-exclamation-circle mr-1"></i>{{ $errors->first() }}</p>
            </div>
            @endif
            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-sm">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email', 'admin@solarerp.com') }}" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-sm">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" value="admin123" class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i id="toggleIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-md">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>
            </form>
            <div class="mt-6 p-4 bg-orange-50 rounded-lg border border-orange-200">
                <p class="text-xs font-semibold text-orange-800 mb-2"><i class="fas fa-key mr-1"></i>Demo Credentials:</p>
                <div class="space-y-1 text-xs text-gray-600">
                    <p><span class="font-medium">Admin:</span> admin@solarerp.com / admin123</p>
                    <p><span class="font-medium">Sales:</span> sales@solarerp.com / sales123</p>
                    <p><span class="font-medium">Tech:</span> tech@solarerp.com / tech123</p>
                </div>
            </div>
        </div>
        <p class="text-center text-orange-100 text-sm mt-4">
            <a href="{{ route('home') }}" class="hover:text-white"><i class="fas fa-arrow-left mr-1"></i>Back to Website</a>
        </p>
    </div>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
