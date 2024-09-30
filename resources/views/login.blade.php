<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes randomMovement1 {
            0% { transform: translate(0, 0); }
            25% { transform: translate(100vw, -100vh); }
            50% { transform: translate(-100vw, 100vh); }
            75% { transform: translate(100vw, 100vh); }
            100% { transform: translate(0, 0); }
        }

        @keyframes randomMovement2 {
            0% { transform: translate(0, 0); }
            25% { transform: translate(-100vw, 100vh); }
            50% { transform: translate(100vw, -100vh); }
            75% { transform: translate(-100vw, -100vh); }
            100% { transform: translate(0, 0); }
        }

        @keyframes randomMovement3 {
            0% { transform: translate(0, 0); }
            25% { transform: translate(100vw, 100vh); }
            50% { transform: translate(-100vw, -100vh); }
            75% { transform: translate(100vw, -100vh); }
            100% { transform: translate(0, 0); }
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100 overflow-hidden">
    <div class="relative w-full h-full flex items-center justify-center p-6 lg:p-0 bg-gradient-to-tr from-teal-900 to-teal-400">
        <div class="moving-bg-1 absolute -top-10 -left-10 w-40 h-40 bg-white rounded-full opacity-20"></div>
        <div class="moving-bg-2 absolute -top-20 -right-20 w-72 h-72 bg-white rounded-full opacity-20"></div>
        <div class="moving-bg-3 absolute -bottom-20 -left-20 w-64 h-64 bg-white rounded-full opacity-20"></div>
        <div class="moving-bg-4 absolute top-1/2 left-1/2 w-96 h-32 bg-white rounded-full opacity-20 transform -translate-x-1/2 -translate-y-1/2 rotate-45"></div>

        <!-- Centered White Background Div -->
        <div class="w-full max-w-md bg-white p-10 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold mb-6">Dinas Kesehatan Banyuwangi</h1>
            <form autocomplete="off" action="{{ route('login-process') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Username
                    </label>
                    <input name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="username">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Kata Sandi">
                </div>
                @if (session('errors') || session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Whoops!</strong> Ada Kesalahan:
                        <ul class="mt-3 list-disc list-inside">
                            @if (session('error'))
                                <li>{{ session('error') }}</li>
                            @endif
                        </ul>
                    </div>
                @endif
                <div class="flex items-center justify-center mt-4">
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
