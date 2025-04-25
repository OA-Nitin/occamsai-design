<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="shortcut icon" href="assets/images/logo/Fevicon.png" type="image/x-icon">
    <title>
        <?php echo $title; ?>
    </title>
    <meta name="description" content=" <?php echo $meta; ?>" />
    <meta name="keywords" content="<?php echo $metakeyword; ?>">


    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-M6D24LNN');</script>
    <!-- End Google Tag Manager -->


    

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M6D24LNN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        var _iub = _iub || [];
        _iub.csConfiguration = { "siteId": 3935348, "cookiePolicyId": 26305627, "lang": "en", "storage": { "useSiteId": true } };
    </script>
    <script type="text/javascript" src="https://cs.iubenda.com/autoblocking/3935348.js"></script>
    <script type="text/javascript" src="//cdn.iubenda.com/cs/gpp/stub.js"></script>
    <script type="text/javascript" src="//cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async></script>


    <!-- Tailwind CDN  -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- fontawsome cdn  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- jQuery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- slick cdn -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css" rel="stylesheet">

    <!-- AOS   -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>



    <!-- Dark mode JS  -->
    <script>
        tailwind.config = {
            darkMode: 'class',
        };

        function applyTheme() {
            const isDark = localStorage.getItem("theme") === "dark";
            document.documentElement.classList.toggle("dark", isDark);
            document.getElementById("themeToggle").innerText = isDark ? " ☀️" : "🌙";
        }

        function toggleDarkMode() {
            const isDark = document.documentElement.classList.toggle("dark");
            localStorage.setItem("theme", isDark ? "dark" : "light");
            document.getElementById("themeToggle").innerText = isDark ? " ☀️" : " 🌙";
        }

        // function toggleMenu() {
        //     document.getElementById("mobile-menu").classList.toggle("hidden");
        // }

        document.addEventListener("DOMContentLoaded", applyTheme);
    </script>

    <script>
        function toggleMenu() {
            let menu = document.getElementById("mobile-menu");
            let button = document.getElementById("menu-button");


            menu.classList.toggle("hidden");

            if (menu.classList.contains("hidden")) {
                button.innerHTML = "☰";
                button.style.color = '';
            } else {
                button.innerHTML = "✖";
                button.style.color = 'white';
            }
        }

    </script>



    <!-- <link rel="stylesheet" href="assets/css/styles.css"> -->
</head>

<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-all duration-300">


    <!-- Navbar -->
    <nav
        class="fixed top-0 left-0 w-full bg-transparent  z-50 dark:bg-black/30 backdrop-blur-lg dark:transition-all duration-500 delay-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex md:justify-between h-16 items-center">
                <!-- Logo -->
                <a href="/">
                    <img src="assets/images/logo/Logo_Occams.ai.svg" alt="logo" class="main-logo">
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex space-x-6">
                    <a href="#about"
                        class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 page-nav dark:text-]">About
                        us</a>
                    <a href="#our-services"
                        class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 page-nav dark:text-[var(--secondary)]">Our
                        Services</a>
                    <a href="#pricing"
                        class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 page-nav dark:text-[var(--secondary)]">Pricing
                    </a>
                    <a href="#"
                        class="text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 page-nav dark:text-[var(--secondary)]">Contact</a>

                </div>

                <!-- Right Buttons -->
                <div class="flex items-center space-x-4">

                    <a href="https://occams.ai/app/public/login" class=" cta-font login-cta hidden md:block ">Login</a>

                    <!-- <a href="#" class="signup-cta cta-font hidden md:block">Sign
                        Up</a> -->

                    <button id="themeToggle" onclick="toggleDarkMode()" class="login-cta cta-font">
                        Dark Mode 🌙
                    </button>

                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden text-gray-800 dark:text-gray-200 text-[34px]" onclick="toggleMenu()">
                        ☰
                    </button>

                    <!-- <button id="menu-button" class="lg:hidden text-gray-800 dark:text-gray-200 p-2 focus:outline-none"
                        onclick="toggleMenu()" aria-label="Toggle Menu">
                        ☰
                    </button> -->
                    <!-- <div class="ham-menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div> -->
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="hidden m-[0px_20px] flex justify-start items-center flex-col rounded-[20px] h-full dark:bg-gray-800 p-4 mobile-menu">
            <a href="#about" class="block text-gray-800 dark:text-gray-200 py-2">About</a>
            <a href="#our-services" class="block text-gray-800 dark:text-gray-200 py-2">Our Services</a>
            <a href="#pricing" class="block text-gray-800 dark:text-gray-200 py-2">Pricing</a>
            <a href="#" class="block text-gray-800 dark:text-gray-200 py-2">Contact</a>

            <div class="flex flex-col gap-y-6 mt-4">
                <a href="https://occams.ai/app/public/login" class=" cta-font login-cta  md:hidden">Login</a>

                <!-- <a href="#" class="signup-cta cta-font md:hidden">Sign
                    Up</a> -->
            </div>
        </div>

        <!-- <div class="ham-menu">
            <span></span>
            <span></span>
            <span></span>
        </div> -->
    </nav>



    <script>

        // window.addEventListener("scroll", function () {
        //     const navbar = document.querySelector("nav");
        //     if (window.scrollY > 50) {
        //         navbar.classList.add("nav-bg");
        //     } else {
        //         navbar.classList.remove("nav-bg");
        //     }
        // });

        window.addEventListener("scroll", function () {
            const navbar = document.querySelector("nav");

            if (window.scrollY > 50) {
                navbar.classList.add("nav-bg");
            } else {
                navbar.classList.remove("nav-bg");
            }
        });



    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const timelineLine = document.querySelector(".timeline-line");
            const timelineImage = document.querySelector(".timeline-image");

            const maxTimelineHeight =
                (document.querySelectorAll(".my-container").length - 1) * 100;

            window.addEventListener("scroll", () => {
                const scrollPercentage = (window.scrollY / maxTimelineHeight) * 65; //Adjust the speed as needed

                const adjustedPercentage = Math.min(100, scrollPercentage);
                timelineLine.style.height = `${adjustedPercentage}%`;
                timelineImage.style.top = `${adjustedPercentage}%`;
            });
        });

    </script>



    <!-- <script>
   
        window.addEventListener('load', function () {
            document.getElementById('loader').classList.add('hidden');
         
        });
    </script> -->