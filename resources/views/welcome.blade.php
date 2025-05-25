<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redicash - Your Digital Wallet Solution</title>
    <meta name="description"
        content="Redicash is a secure and convenient digital wallet that lets you make payments, transfer money, and manage your finances with ease.">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                            950: '#4c0519',
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        [x-cloak] {
            display: none !important;
        }

        .scroll-smooth {
            scroll-behavior: smooth;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .testimonial-slider {
            scroll-snap-type: x mandatory;
        }

        .testimonial-slide {
            scroll-snap-align: center;
        }
    </style>
</head>

<body
    class="font-sans antialiased bg-white dark:bg-secondary-900 text-secondary-900 dark:text-white transition-colors duration-300"
    x-data="{ mobileMenuOpen: false, darkMode: localStorage.getItem('darkMode') === 'true' }"
    :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">

    <!-- Header -->
    <header class="fixed w-full bg-white dark:bg-secondary-900 shadow-sm z-50 transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="#" class="flex items-center">
                        <span class="text-primary-600 dark:text-primary-400 text-3xl mr-2">
                            <i class="fas fa-wallet"></i>
                        </span>
                        <span class="text-2xl font-bold text-secondary-900 dark:text-white">Redi<span
                                class="text-primary-600 dark:text-primary-400">cash</span></span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#features"
                        class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors duration-200">Features</a>
                    <a href="#how-it-works"
                        class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors duration-200">How
                        It Works</a>
                    <a href="#benefits"
                        class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors duration-200">Benefits</a>
                </nav>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode"
                        class="p-2 rounded-full text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-800 focus:outline-none transition-colors duration-200"
                        aria-label="Toggle Dark Mode">
                        <i class="fas fa-moon text-lg" x-show="!darkMode"></i>
                        <i class="fas fa-sun text-lg" x-show="darkMode"></i>
                    </button>

                    <!-- Download Button -->
                    <a  href="{{route('register')}}"
                        class="hidden md:inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        Sign Up
                    </a>
                    <a href="{{route('login')}}"
                        class="hidden md:inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        Login
                    </a>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 rounded-md text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-800 focus:outline-none transition-colors duration-200"
                        aria-label="Toggle Menu">
                        <i class="fas fa-bars text-lg" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times text-lg" x-show="mobileMenuOpen"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
                class="md:hidden py-3 border-t border-secondary-200 dark:border-secondary-700">
                <nav class="flex flex-col space-y-3 px-2">
                    <a href="#features" @click="mobileMenuOpen = false"
                        class="px-3 py-2 rounded-md text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-800 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors duration-200">Features</a>
                    <a href="#how-it-works" @click="mobileMenuOpen = false"
                        class="px-3 py-2 rounded-md text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-800 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors duration-200">How
                        It Works</a>
                    <a href="#benefits" @click="mobileMenuOpen = false"
                        class="px-3 py-2 rounded-md text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-800 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors duration-200">Benefits</a>
                    <a href="#testimonials" @click="mobileMenuOpen = false"
                        class="px-3 py-2 rounded-md text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-800 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors duration-200">Testimonials</a>
                    <a href="#download" @click="mobileMenuOpen = false"
                        class="px-3 py-2 rounded-md text-white bg-primary-600 hover:bg-primary-700 font-medium transition-colors duration-200">Download
                        App</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section
        class="pt-28 pb-20 md:pt-36 md:pb-24 bg-gradient-to-br from-white to-secondary-100 dark:from-secondary-900 dark:to-secondary-800 transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 md:pr-12 mb-10 md:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        Your <span class="text-primary-600 dark:text-primary-400">Digital Wallet</span> for Modern Life
                    </h1>
                    <p class="text-lg md:text-xl text-secondary-600 dark:text-secondary-300 mb-8">
                        Experience the freedom of cashless payments, instant money transfers, and smart financial
                        management with Redicash.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#download"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            <i class="fab fa-apple mr-2"></i> App Store
                        </a>
                        <a href="#download"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                            <i class="fab fa-google-play mr-2"></i> Google Play
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 relative">
                    <div class="relative z-10 float-animation">
                        <img src="https://i.postimg.cc/V6FtsDzr/0-image.jpg/600x1200/f43f5e/ffffff?text=Redicash+App"
                            alt="Redicash App Interface" class="mx-auto h-auto max-w-full rounded-3xl shadow-2xl">
                    </div>
                    <div
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full max-w-md max-h-md bg-primary-400 dark:bg-primary-700 rounded-full opacity-20 blur-3xl -z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white dark:bg-secondary-900 transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Features</h2>
                <p class="text-lg text-secondary-600 dark:text-secondary-300 max-w-3xl mx-auto">
                    Redicash offers a comprehensive suite of features designed to make your financial life easier and
                    more secure.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="feature-card bg-white dark:bg-secondary-800 rounded-xl shadow-md p-6 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-exchange-alt text-2xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Instant Transfers</h3>
                    <p class="text-secondary-600 dark:text-secondary-300">
                        Send and receive money instantly to any Redicash user or bank account without any hassle.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="feature-card bg-white dark:bg-secondary-800 rounded-xl shadow-md p-6 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shopping-cart text-2xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Contactless Payments</h3>
                    <p class="text-secondary-600 dark:text-secondary-300">
                        Pay at thousands of merchants with just a tap of your phone. Quick, secure, and convenient.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="feature-card bg-white dark:bg-secondary-800 rounded-xl shadow-md p-6 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-2xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Secure Authentication</h3>
                    <p class="text-secondary-600 dark:text-secondary-300">
                        Protect your account with biometric authentication and advanced encryption technology.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="feature-card bg-white dark:bg-secondary-800 rounded-xl shadow-md p-6 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-2xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Financial Insights</h3>
                    <p class="text-secondary-600 dark:text-secondary-300">
                        Track your spending habits and get personalized insights to help you manage your money better.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="feature-card bg-white dark:bg-secondary-800 rounded-xl shadow-md p-6 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-gift text-2xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Wallet to Wallet</h3>
                    <p class="text-secondary-600 dark:text-secondary-300">
                        Instant sending wallet to wallet without hassle, Get step by step instructions on how to
                        transfer funds between wallets.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="feature-card bg-white dark:bg-secondary-800 rounded-xl shadow-md p-6 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-bell text-2xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Track Record</h3>
                    <p class="text-secondary-600 dark:text-secondary-300">
                        Track your record for any transaction was made and scheduled your payments.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-secondary-50 dark:bg-secondary-800 transition-colors duration-300"
        x-data="{ activeStep: 1 }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Getting Started</h2>
                <p class="text-lg text-secondary-600 dark:text-secondary-300 max-w-3xl mx-auto">
                    Getting started with Redicash is quick and easy. Follow these simple steps to begin your cashless
                    journey.
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <!-- Steps Navigation -->
                <div class="flex justify-between mb-8 relative">
                    <div
                        class="absolute top-1/2 left-0 right-0 h-1 bg-secondary-200 dark:bg-secondary-700 -translate-y-1/2 z-0">
                    </div>

                    <button @click="activeStep = 1"
                        :class="{ 'bg-primary-600 dark:bg-primary-500 text-white border-primary-600 dark:border-primary-500': activeStep === 1, 'bg-white dark:bg-secondary-700 text-secondary-500 dark:text-secondary-300 border-secondary-300 dark:border-secondary-600': activeStep !== 1 }"
                        class="relative z-10 w-10 h-10 rounded-full border-2 flex items-center justify-center font-semibold transition-colors duration-200">
                        1
                    </button>

                    <button @click="activeStep = 2"
                        :class="{ 'bg-primary-600 dark:bg-primary-500 text-white border-primary-600 dark:border-primary-500': activeStep === 2, 'bg-white dark:bg-secondary-700 text-secondary-500 dark:text-secondary-300 border-secondary-300 dark:border-secondary-600': activeStep !== 2 }"
                        class="relative z-10 w-10 h-10 rounded-full border-2 flex items-center justify-center font-semibold transition-colors duration-200">
                        2
                    </button>

                    <button @click="activeStep = 3"
                        :class="{ 'bg-primary-600 dark:bg-primary-500 text-white border-primary-600 dark:border-primary-500': activeStep === 3, 'bg-white dark:bg-secondary-700 text-secondary-500 dark:text-secondary-300 border-secondary-300 dark:border-secondary-600': activeStep !== 3 }"
                        class="relative z-10 w-10 h-10 rounded-full border-2 flex items-center justify-center font-semibold transition-colors duration-200">
                        3
                    </button>

                    <button @click="activeStep = 4"
                        :class="{ 'bg-primary-600 dark:bg-primary-500 text-white border-primary-600 dark:border-primary-500': activeStep === 4, 'bg-white dark:bg-secondary-700 text-secondary-500 dark:text-secondary-300 border-secondary-300 dark:border-secondary-600': activeStep !== 4 }"
                        class="relative z-10 w-10 h-10 rounded-full border-2 flex items-center justify-center font-semibold transition-colors duration-200">
                        4
                    </button>
                </div>

                <!-- Step Content -->
                <div class="bg-white dark:bg-secondary-800 rounded-xl shadow-md p-8 transition-all duration-300">
                    <!-- Step 1 -->
                    <div x-show="activeStep === 1" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 mb-6 md:mb-0 md:pr-8">
                            <h3 class="text-2xl font-bold mb-4">Download the App</h3>
                            <p class="text-secondary-600 dark:text-secondary-300 mb-4">
                                Get started by downloading the Redicash app from the App Store or Google Play Store.
                                It's free and takes just a few seconds.
                                See video.
                            </p>
                            <div class="flex space-x-4">
                                <a href="#download"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                                    <i class="fab fa-apple mr-2"></i> App Store
                                </a>
                                <a href="#download"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                                    <i class="fab fa-google-play mr-2"></i> Google Play
                                </a>
                            </div>
                        </div>
                        <div class="md:w-1/2">
                            <div class="relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full"
                                    src="https://www.youtube-nocookie.com/embed/FMrtSHAAPhM" frameborder="2" …></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div x-show="activeStep === 2" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 mb-6 md:mb-0 md:pr-8">
                            <h3 class="text-2xl font-bold mb-4">Create Your Account</h3>
                            <p class="text-secondary-600 dark:text-secondary-300 mb-4">
                                Sign up with your phone number and email. Verify your identity with a quick selfie and
                                your ID for enhanced security.
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary-600 dark:text-primary-400 mr-2"></i>
                                    <span class="text-secondary-600 dark:text-secondary-300">Quick registration
                                        process</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary-600 dark:text-primary-400 mr-2"></i>
                                    <span class="text-secondary-600 dark:text-secondary-300">Secure identity
                                        verification</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary-600 dark:text-primary-400 mr-2"></i>
                                    <span class="text-secondary-600 dark:text-secondary-300">Your data is encrypted and
                                        protected</span>
                                </li>
                            </ul>
                        </div>
                        <div class="md:w-1/2">
                            <img src="https://placehold.co/600x400/f43f5e/ffffff?text=Create+Account"
                                alt="Create Redicash Account" class="rounded-lg shadow-md">
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div x-show="activeStep === 3" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 mb-6 md:mb-0 md:pr-8">
                            <h3 class="text-2xl font-bold mb-4">Link Payment Methods</h3>
                            <p class="text-secondary-600 dark:text-secondary-300 mb-4">
                                Connect your bank account or debit/credit cards to fund your Redicash wallet. Top up
                                instantly whenever you need.
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary-600 dark:text-primary-400 mr-2"></i>
                                    <span class="text-secondary-600 dark:text-secondary-300">Multiple funding
                                        options</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary-600 dark:text-primary-400 mr-2"></i>
                                    <span class="text-secondary-600 dark:text-secondary-300">Instant top-ups</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary-600 dark:text-primary-400 mr-2"></i>
                                    <span class="text-secondary-600 dark:text-secondary-300">Secure payment
                                        processing</span>
                                </li>
                            </ul>
                        </div>
                        <div class="md:w-1/2">
                            <img src="https://placehold.co/600x400/f43f5e/ffffff?text=Link+Payment"
                                alt="Link Payment Methods" class="rounded-lg shadow-md">
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div x-show="activeStep === 4" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 mb-6 md:mb-0 md:pr-8">
                            <h3 class="text-2xl font-bold mb-4">Start Transacting</h3>
                            <p class="text-secondary-600 dark:text-secondary-300 mb-4">
                                You're all set! Send money, pay bills, shop online, and enjoy exclusive rewards with
                                your Redicash wallet.
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary-600 dark:text-primary-400 mr-2"></i>
                                    <span class="text-secondary-600 dark:text-secondary-300">Instant money
                                        transfers</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary-600 dark:text-primary-400 mr-2"></i>
                                    <span class="text-secondary-600 dark:text-secondary-300">Contactless payments</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary-600 dark:text-primary-400 mr-2"></i>
                                    <span class="text-secondary-600 dark:text-secondary-300">Earn rewards on every
                                        transaction</span>
                                </li>
                            </ul>
                        </div>
                        <div class="md:w-1/2">
                            <img src="https://placehold.co/600x400/f43f5e/ffffff?text=Start+Transacting"
                                alt="Start Transacting with Redicash" class="rounded-lg shadow-md">
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button @click="activeStep = activeStep === 1 ? 1 : activeStep - 1"
                        :class="{ 'opacity-50 cursor-not-allowed': activeStep === 1 }"
                        class="px-4 py-2 border border-secondary-300 dark:border-secondary-600 rounded-md text-secondary-700 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700 focus:outline-none transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i> Previous
                    </button>
                    <button @click="activeStep = activeStep === 4 ? 4 : activeStep + 1"
                        :class="{ 'opacity-50 cursor-not-allowed': activeStep === 4 }"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-20 bg-white dark:bg-secondary-900 transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose Redicash</h2>
                <p class="text-lg text-secondary-600 dark:text-secondary-300 max-w-3xl mx-auto">
                    Discover the advantages that make Redicash the preferred digital wallet for millions of users.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <!-- Left Column -->
                <div class="space-y-8">
                    <!-- Benefit 1 -->
                    <div class="flex">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-bolt text-xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Fast & Convenient</h3>
                            <p class="text-secondary-600 dark:text-secondary-300">
                                Complete transactions in seconds, not minutes. Redicash is designed for speed and
                                convenience.
                            </p>
                        </div>
                    </div>

                    <!-- Benefit 2 -->
                    <div class="flex">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-lock text-xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Security</h3>
                            <p class="text-secondary-600 dark:text-secondary-300">
                                Your fund and data are protected with advanced encryption and multi-factor
                                authentication.
                            </p>
                        </div>
                    </div>

                    <!-- Benefit 3 -->
                    <div class="flex">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-percent text-xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Exclusive</h3>
                            <p class="text-secondary-600 dark:text-secondary-300">
                                Exclusively for our customers, our priority to make sure settlement on the same day.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Benefit 4 -->
                    <div class="flex">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-globe text-xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Wide Acceptance</h3>
                            <p class="text-secondary-600 dark:text-secondary-300">
                                Use Redicash at thousands of merchants nationwide, both online and in-store.
                            </p>
                        </div>
                    </div>

                    <!-- Benefit 5 -->
                    <div class="flex">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-hand-holding-usd text-xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">No Hidden Fees</h3>
                            <p class="text-secondary-600 dark:text-secondary-300">
                                Enjoy transparent pricing with no hidden charges. Know exactly what you're paying for.
                            </p>
                        </div>
                    </div>

                    <!-- Benefit 6 -->
                    <div class="flex">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-headset text-xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
                            <p class="text-secondary-600 dark:text-secondary-300">
                                Get help whenever you need it with our dedicated customer support team.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->

    <!-- Download Section -->
    <section id="download"
        class="py-20 bg-gradient-to-br from-primary-600 to-primary-800 dark:from-primary-800 dark:to-primary-950 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 mb-10 md:mb-0">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Download Redicash Today</h2>
                        <p class="text-lg opacity-90 mb-8">
                            Join millions of users who trust Redicash for their digital payment needs. Download the app
                            now and experience the future of payments.
                        </p>
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="#"
                                class="inline-flex items-center justify-center px-6 py-3 border-2 border-white rounded-md text-base font-medium hover:bg-white hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors duration-200">
                                <i class="fab fa-apple text-2xl mr-3"></i>
                                <div class="text-left">
                                    <div class="text-xs">Download on the</div>
                                    <div class="text-base font-semibold">App Store</div>
                                </div>
                            </a>
                            <a href="#"
                                class="inline-flex items-center justify-center px-6 py-3 border-2 border-white rounded-md text-base font-medium hover:bg-white hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors duration-200">
                                <i class="fab fa-google-play text-2xl mr-3"></i>
                                <div class="text-left">
                                    <div class="text-xs">Get it on</div>
                                    <div class="text-base font-semibold">Google Play</div>
                                </div>
                            </a>
                        </div>
                        <div class="mt-8 flex items-center">
                            <div class="flex -space-x-2">
                                <img src="https://placehold.co/100x100/ffffff/f43f5e?text=U1" alt="User"
                                    class="w-10 h-10 rounded-full border-2 border-primary-600">
                                <img src="https://placehold.co/100x100/ffffff/f43f5e?text=U2" alt="User"
                                    class="w-10 h-10 rounded-full border-2 border-primary-600">
                                <img src="https://placehold.co/100x100/ffffff/f43f5e?text=U3" alt="User"
                                    class="w-10 h-10 rounded-full border-2 border-primary-600">
                                <img src="https://placehold.co/100x100/ffffff/f43f5e?text=U4" alt="User"
                                    class="w-10 h-10 rounded-full border-2 border-primary-600">
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold">Join 5M+ users</div>
                                <div class="text-sm opacity-90">Trusted by millions worldwide</div>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 md:pl-10">
                        <div class="relative">
                            <img src="https://i.postimg.cc/gjNnxbY9/pexels-emma-bauso-1183828-2833394.jpg/ffffff/f43f5e?text=Redicash+App"
                                alt="Redicash App Screenshot"
                                class="mx-auto h-auto max-w-full rounded-3xl shadow-2xl float-animation">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer
        class="bg-white dark:bg-secondary-900 border-t border-secondary-200 dark:border-secondary-700 transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <a href="#" class="flex items-center mb-4">
                        <span class="text-primary-600 dark:text-primary-400 text-2xl mr-2">
                            <i class="fas fa-wallet"></i>
                        </span>
                        <span class="text-xl font-bold text-secondary-900 dark:text-white">Redi<span
                                class="text-primary-600 dark:text-primary-400">cash</span></span>
                    </a>
                    <p class="text-secondary-600 dark:text-secondary-300 mb-4">
                        Redicash is a secure and convenient digital wallet that lets you make payments, transfer money,
                        and manage your finances with ease.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="text-secondary-500 hover:text-primary-600 dark:text-secondary-400 dark:hover:text-primary-400 transition-colors duration-200">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#"
                            class="text-secondary-500 hover:text-primary-600 dark:text-secondary-400 dark:hover:text-primary-400 transition-colors duration-200">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#"
                            class="text-secondary-500 hover:text-primary-600 dark:text-secondary-400 dark:hover:text-primary-400 transition-colors duration-200">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#"
                            class="text-secondary-500 hover:text-primary-600 dark:text-secondary-400 dark:hover:text-primary-400 transition-colors duration-200">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-secondary-900 dark:text-white">Quick Links</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#features"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Features</a>
                        </li>
                        <li>
                            <a href="#how-it-works"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">How
                                It Works</a>
                        </li>
                        <li>
                            <a href="#benefits"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Benefits</a>
                        </li>
                        <li>
                            <a href="#testimonials"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Testimonials</a>
                        </li>
                        <li>
                            <a href="#download"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Download</a>
                        </li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-secondary-900 dark:text-white">Company</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">About
                                Us</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Careers</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Press</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Blog</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-secondary-900 dark:text-white">Legal</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Terms
                                of Service</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Privacy
                                Policy</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Security</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Licenses</a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-secondary-600 dark:text-secondary-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Cookies</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="mt-12 pt-8 border-t border-secondary-200 dark:border-secondary-700 flex flex-col md:flex-row justify-between items-center">
                <p class="text-secondary-600 dark:text-secondary-300 mb-4 md:mb-0">
                    &copy; 2025 Redicash. All rights reserved.
                </p>
                <div class="flex items-center">
                    <span class="text-secondary-600 dark:text-secondary-300 mr-2">Change theme:</span>
                    <button @click="darkMode = false"
                        :class="{ 'bg-primary-100 text-primary-600': !darkMode, 'bg-secondary-200 dark:bg-secondary-700 text-secondary-600 dark:text-secondary-300': darkMode }"
                        class="px-3 py-1 rounded-l-md focus:outline-none transition-colors duration-200">
                        <i class="fas fa-sun mr-1"></i> Light
                    </button>
                    <button @click="darkMode = true"
                        :class="{ 'bg-primary-100 text-primary-600': darkMode, 'bg-secondary-200 dark:bg-secondary-700 text-secondary-600 dark:text-secondary-300': !darkMode }"
                        class="px-3 py-1 rounded-r-md focus:outline-none transition-colors duration-200">
                        <i class="fas fa-moon mr-1"></i> Dark
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-primary-600 text-white shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-primary-700 focus:outline-none">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- JavaScript -->
    <script>
        // Back to Top Button
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.getElementById('backToTop');

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                    backToTopButton.classList.add('opacity-100', 'visible');
                } else {
                    backToTopButton.classList.remove('opacity-100', 'visible');
                    backToTopButton.classList.add('opacity-0', 'invisible');
                }
            });

            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Check dark mode preference on page load
            if (!localStorage.getItem('darkMode')) {
                // Check system preference
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('darkMode', 'true');
                } else {
                    localStorage.setItem('darkMode', 'false');
                }
            } else if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.classList.add('dark');
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
