<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'OS Gadgets') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/icon.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1498049794561-7780e7231661?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80');
            background-size: cover;
            background-position: center;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-indigo-600">TechSphere</a>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-800 hover:text-indigo-600 font-medium">Home</a>
                    <a href="#" class="text-gray-800 hover:text-indigo-600 font-medium">Products</a>
                    <a href="#" class="text-gray-800 hover:text-indigo-600 font-medium">Categories</a>
                    <a href="#" class="text-gray-800 hover:text-indigo-600 font-medium">Deals</a>
                    <a href="#" class="text-gray-800 hover:text-indigo-600 font-medium">About</a>
                    <a href="#" class="text-gray-800 hover:text-indigo-600 font-medium">Contact</a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-800 hover:text-indigo-600">
                        <i class="fas fa-search text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-800 hover:text-indigo-600">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span
                            class="bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center -mt-3 -mr-2 relative inline-block">3</span>
                    </a>
                    <a href="#" class="text-gray-800 hover:text-indigo-600">
                        <i class="fas fa-user text-lg"></i>
                    </a>
                    <button class="md:hidden text-gray-800">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
