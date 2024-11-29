<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIPendaki</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-['Inter']">
    <div class="min-h-screen flex">
        <!-- Left side - Mountain Image -->
        <div class="hidden lg:block lg:w-1/2 relative">
            <img src="../images/gunung2.jpg" alt="Mountain" class="w-full h-screen object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-30">
                <div class="p-12 absolute bottom-0 text-white">
                    <h1 class="text-4xl font-bold mb-2">SIPendaki</h1>
                    <p class="text-lg">Your Mountain Adventure Starts Here</p>
                </div>
            </div>
        </div>

        <!-- Right side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                    <p class="mt-2 text-gray-600">Please sign in to your account</p>
                </div>

                <form method="POST" action="{{ route('pendaki.login') }}" class="mt-8 space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" 
                            class="w-32 bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
                            Login
                        </button>
                        
                        <a href="{{ route('pendaki.register') }}" 
                            class="text-indigo-600 hover:text-indigo-500 font-medium">
                            Create account
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>