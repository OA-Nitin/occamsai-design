<?php
$title = "Occams Ai";
include('header.php');
?>

<!-- hero section  -->

<!-- Loader with Logo -->
<!-- <div id="loader" class="loader">
        <img src="assets/images/logo/occamsai.png" alt="Loading..." class="loader-logo">
    </div> -->



<style type="text/css">
    .get_stared_field {
        padding: 8px 30px 8px 30px;
        border-radius: 1.87rem;
        border: 0.5px solid var(--primary);
    }
    .text-red-600{
        color: #E53935;
    }
    /* popup css   */
.swal2-popup.custom-swal {
  background: linear-gradient(to bottom, #FFFFFF, #DCEEF6, #F5E9E3);
  border-radius: 14px;
  padding: 40px 20px;
  font-family: 'Segoe UI', sans-serif;
  width: 100%;
  max-width: 530px;
}
 
.swal2-title.custom-title {
  font-size: 30px;
  font-weight: 700;
  color: #333;
  margin-top: 15px;
  margin-bottom: 10px;
}
 
.swal2-html-container.custom-text {
  font-size: 20px;
  color: #444;
  font-weight: 500;
  margin-bottom: 15px;
  line-height: 1.6;
}
 
.swal2-confirm.custom-button {
  background-color: #f36b21 !important;
  color: #fff !important;
  font-weight: 600;
  font-size: 16px;
  padding: 12px 30px;
  border-radius: 6px;
  box-shadow: none;
  border:none;
  transition: background-color 0.3s ease;
  cursor: pointer;
}
 
.swal2-confirm.custom-button:hover {
  background-color: #e05c1d !important;
}
 
.swal2-icon.swal2-success {
  border-color: #90e190;
  color: #4CAF50;
}
 
.swal2-icon.swal2-success [class^=swal2-success-line] {
  background-color: #4CAF50;
}
 
.swal2-icon.swal2-success .swal2-success-ring {
  border: 4px solid #c4f1c4;
}
 
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-[100px] mx-auto px-4 sm:px-6 lg:px-8">
    <div class="hero-section">
        <div class="grid grid-cols-1  gap-4  ">
            <div class="hero-content">
                <h1 class="heading-1-bold "><span class="heading-color">Launch Your U.S. Business with
                        Confidence</span> </h1>
                <p class="body-text-2 dark:text-white md:pr-[137px] md:pl-[137px]">Start, Structure & Succeed in the
                    U.S. with AI-powered business formation & compliance. </p>

                <div class="mt-6 mx-auto banner-form-box  lg:px-[300px]">
                    <form class="lg:flex lg:align-center justify-between banner-form ">
                        <div class="py-2 w-100">
                            <input type="text" id="get_name" placeholder="Full Name " required="" class="get_stared_field w-100 lg:w-[280px] w-64">
                             <div id="name-error" class="text-red-600 text-sm mt-1"></div>
                        </div>
                        <div class="py-2 w-100">
                            <input type="email" id="get_email" placeholder="Email ID " required="" class="get_stared_field w-100 lg:w-[280px] w-64">
                             <div id="email-error" class="text-red-600 text-sm mt-1"></div>
                        </div>
                        <div class="py-2 w-100">
                            <input type="text" id="get_phone" placeholder="Phone No. " required="" class="get_stared_field w-100 lg:w-[280px] w-64">
                             <div id="phone-error" class="text-red-600 text-sm mt-1"></div>
                        </div>


                    </form>
                </div>

                <div class="mt-6">
                    <a class="signup-cta mt-4" href="#" id="get-started-btn">Get Started Now</a>
                </div>

            </div>
        </div>
        <div
            class="grid sm:grid-cols-1 md:grid-cols-3 justify-center md:gap-[16px] md:pr-[44px] md:pl-[44px] gap-y-[20px]">

            <div class="hero-sub-content justify-start md:justify-center">
                <div class="hero-sub-content-logo">

                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="41" viewBox="0 0 35 41" fill="none">
                        <path
                            d="M26.6296 10.7353H30.1376C31.0675 10.7353 31.8282 11.496 31.8282 12.4258V17.9203C31.8282 18.7233 32.4622 19.3995 33.3075 19.3995C34.1528 19.3995 34.7868 18.7656 34.7868 17.9203V12.4258C34.7868 9.88996 32.7158 7.77672 30.1376 7.77672H26.6296C25.9111 3.38118 22.1072 0 17.5003 0C12.8934 0 9.08955 3.38118 8.37105 7.81899H4.86304C2.32713 7.81899 0.213867 9.88996 0.213867 12.4681V17.9625C0.213867 18.7656 0.847845 19.4418 1.69315 19.4418C2.53845 19.4418 3.17243 18.8078 3.17243 17.9625V12.4681C3.17243 11.5383 3.9332 10.7775 4.86304 10.7775H8.37105C9.08955 15.1308 12.8934 18.512 17.5003 18.512C22.1072 18.512 25.9534 15.1308 26.6296 10.7353ZM22.0227 8.11484L17.2467 12.8908C16.9931 13.1444 16.6128 13.3134 16.2746 13.3134C15.9365 13.3134 15.5561 13.1866 15.3025 12.8908L12.9357 10.5239C12.3862 9.97449 12.3862 9.08693 12.9357 8.53749C13.4851 7.98805 14.3727 7.98805 14.9222 8.53749L16.2324 9.93223L20.0362 6.1284C20.5857 5.57895 21.4733 5.57895 22.0227 6.1284C22.5721 6.67784 22.5299 7.5654 22.0227 8.11484Z"
                            fill="#F36B21" />
                        <path
                            d="M9.46929 31.3605C11.7093 31.3605 13.4845 29.5431 13.4845 27.3454C13.4845 25.1053 11.6671 23.3302 9.46929 23.3302C7.22924 23.3302 5.4541 25.1476 5.4541 27.3454C5.4541 29.5431 7.22924 31.3605 9.46929 31.3605Z"
                            fill="#F36B21" />
                        <path
                            d="M13.1465 31.8254C12.1321 32.6285 10.8641 33.1356 9.46938 33.1356C8.28596 33.1356 7.1448 32.7553 6.21496 32.1635C6.00364 32.0368 5.79231 31.8677 5.62325 31.6986C4.1017 30.4307 3.29866 27.8525 3.38319 24.26V23.2457C3.38319 22.2736 2.58016 21.5128 1.60806 21.5551C0.720488 21.5973 0.00197989 22.4004 0.00197989 23.3302V24.2178C-0.0402853 27.768 0.593692 30.5575 1.94618 32.5439C2.62242 33.5583 2.87601 34.7417 2.79148 35.9251C2.79148 36.0519 2.79148 36.221 2.79148 36.3478V39.3063C2.79148 39.7712 3.17187 40.1516 3.63679 40.1516H15.302C15.7669 40.1516 16.1473 39.7712 16.1473 39.3063V36.3478C16.1473 33.9809 14.8371 32.5862 13.1465 31.8254Z"
                            fill="#F36B21" />
                        <path
                            d="M21.4727 27.3031C21.4727 29.5431 23.2901 31.3605 25.4878 31.3605C27.7279 31.3605 29.503 29.5431 29.503 27.3031C29.503 25.063 27.6856 23.2879 25.4878 23.2879C23.2901 23.2879 21.4727 25.063 21.4727 27.3031Z"
                            fill="#F36B21" />
                        <path
                            d="M33.3918 21.5128C32.4197 21.4705 31.6166 22.2313 31.6166 23.2034V24.2177C31.6589 27.8102 30.8981 30.3884 29.3766 31.6563C29.1652 31.8254 28.9962 31.9945 28.7849 32.1213C27.855 32.7552 26.7561 33.0933 25.5304 33.0933C24.1357 33.0933 22.8677 32.5862 21.8534 31.7831C20.1628 32.5439 18.8525 33.9386 18.8525 36.3055V39.264C18.8525 39.7289 19.2329 40.1093 19.6978 40.1093H31.363C31.828 40.1093 32.2083 39.7289 32.2083 39.264V36.3055C32.2083 36.1787 32.2083 36.0096 32.2083 35.8828C32.1238 34.6994 32.3774 33.516 33.0536 32.5016C34.4061 30.5152 35.0401 27.6834 34.9978 24.1755V23.2879C34.9556 22.4003 34.2793 21.5973 33.3918 21.5128Z"
                            fill="#F36B21" />
                    </svg>
                </div>
                <div class="hero-sub-content-text">
                    <h6 class="subheadline_medium">Incorporate in the <br>
                        U.S. with ease</h6>
                </div>
            </div>

            <div class="hero-sub-content justify-start md:justify-center">
                <div class="hero-sub-content-logo">

                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 25 35" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M16.2331 20.2473C15.9137 20.5683 15.7166 21.0121 15.7166 21.5006C15.7166 21.989 15.9138 22.4328 16.2331 22.7538C16.5525 23.0748 16.9926 23.273 17.48 23.273C17.9674 23.273 18.4075 23.0748 18.7269 22.7538C19.0462 22.4328 19.2434 21.9904 19.2434 21.5006C19.2434 21.0121 19.0462 20.5683 18.7269 20.2473C18.4075 19.9264 17.9674 19.7282 17.48 19.7282C16.994 19.7282 16.5525 19.9264 16.2331 20.2473ZM6.77984e-07 0.82062V34.1781H0.00277736C0.00277736 34.3637 0.06526 34.5494 0.193005 34.7029C0.480426 35.049 0.99556 35.0951 1.33993 34.8062L6.65938 30.336L11.9703 34.8004C12.2674 35.0572 12.7131 35.067 13.0228 34.8074L18.3422 30.3372L23.624 34.7767C23.7698 34.9149 23.9669 35 24.1835 35C24.6334 35 25 34.633 25 34.1794V0.821868H24.9972C24.9972 0.636254 24.9347 0.450625 24.807 0.297105C24.5182 -0.0490032 24.0044 -0.0950736 23.6601 0.193832L18.3406 4.66403L13.0297 0.199548C12.7326 -0.0572419 12.2869 -0.0670097 11.9772 0.19257L6.65778 4.66277L1.37602 0.223296C1.23022 0.085131 1.03306 0 0.816454 0C0.365199 0 6.77984e-07 0.367027 6.77984e-07 0.82062ZM17.4786 24.913C16.5414 24.913 15.693 24.532 15.0779 23.9137C14.4642 23.2968 14.0837 22.4427 14.0837 21.5007C14.0837 20.5587 14.4628 19.706 15.0779 19.0877C15.6916 18.4709 16.5414 18.0885 17.4786 18.0885C18.4159 18.0885 19.2642 18.4695 19.8794 19.0877C20.4931 19.7046 20.8736 20.5587 20.8736 21.5007C20.8736 22.4427 20.4945 23.2955 19.8794 23.9137C19.2656 24.5306 18.4159 24.913 17.4786 24.913ZM7.96726 23.2145C7.6479 23.5355 7.13275 23.5355 6.81341 23.2145C6.49405 22.8935 6.49405 22.3758 6.81341 22.0548L17.03 11.786C17.3494 11.4651 17.8645 11.4651 18.1839 11.786C18.5032 12.107 18.5032 12.6248 18.1839 12.9458L7.96726 23.2145ZM9.91813 15.9126C9.30439 16.5295 8.45463 16.9118 7.51739 16.9118C6.58015 16.9118 5.73178 16.5308 5.11666 15.9126C4.50292 15.2957 4.12109 14.4416 4.12109 13.4996C4.12109 12.5576 4.50015 11.7049 5.11666 11.0866C5.73039 10.4697 6.58015 10.0874 7.51739 10.0874C8.45463 10.0874 9.30301 10.4683 9.91674 11.0866C10.5305 11.7035 10.9123 12.5576 10.9123 13.4996C10.9123 14.4416 10.5319 15.2943 9.91813 15.9126ZM7.51739 15.272C8.00338 15.272 8.44493 15.0738 8.76427 14.7528C9.08363 14.4319 9.28079 13.9881 9.28079 13.4996C9.28079 13.0111 9.08362 12.5673 8.76427 12.2464C8.44491 11.9254 8.00476 11.7272 7.51739 11.7272C7.03002 11.7272 6.58986 11.9254 6.27051 12.2464C5.95115 12.5673 5.754 13.0097 5.754 13.4996C5.754 13.9895 5.95116 14.4319 6.27051 14.7528C6.58987 15.0738 7.03002 15.272 7.51739 15.272Z"
                            fill="#F36B21" />
                    </svg>
                </div>
                <div class="hero-sub-content-text">
                    <h6 class="subheadline_medium">Get expert-backed <br>
                        compliance & tax strategies</h6>
                </div>
            </div>

            <div class="hero-sub-content justify-start md:justify-center">
                <div class="hero-sub-content-logo">

                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35" fill="none">
                        <path
                            d="M5.46397 23.7282C5.46397 23.2315 5.46397 22.7347 5.46397 22.238C5.5786 18.1878 6.53384 13.0295 9.51419 7.83298C9.28493 7.60373 9.09389 7.29805 8.97926 6.95416C6.49563 7.29805 4.24127 7.9094 2.44541 8.52076C0.878821 11.1572 0 14.214 0 17.5C0 20.0218 0.534935 22.3908 1.49017 24.5688C2.33079 24.7598 3.13319 24.9127 3.9738 25.0655C4.20306 24.416 4.7762 23.9192 5.46397 23.7282Z"
                            fill="#F36B21" />
                        <path
                            d="M8.32941 25.5622C11.6919 25.7532 14.825 25.4858 17.7672 24.7216C17.8054 24.2248 18.0347 23.8045 18.3403 23.4607C15.5892 19.6015 12.8381 14.6342 11.1569 8.48249C10.9277 8.48249 10.7366 8.44428 10.5456 8.36786C8.13836 12.5709 6.87745 17.1943 6.72461 22.1997C6.72461 22.6965 6.72461 23.1932 6.72461 23.6899C7.4888 23.9574 8.17657 24.6834 8.32941 25.5622Z"
                            fill="#F36B21" />
                        <path
                            d="M12.0351 4.08836C13.0667 2.75103 14.2895 1.41369 15.665 0.076355C13.9456 0.267403 12.3408 0.687709 10.8506 1.29906C10.9652 2.17788 11.0798 3.0567 11.2327 3.93552C11.5001 3.93552 11.7676 3.97373 12.0351 4.08836Z"
                            fill="#F36B21" />
                        <path
                            d="M34.9614 18.6463C34.9996 18.2642 34.9996 17.8821 34.9996 17.5C34.9996 15.8952 34.7703 14.3286 34.3882 12.8766C34.159 13.297 33.8915 13.7555 33.624 14.1758C33.8915 14.5579 34.0061 14.9782 34.0061 15.4749C34.0061 15.9334 33.8915 16.3155 33.6622 16.6976C34.1208 17.309 34.5411 17.9585 34.9614 18.6463Z"
                            fill="#F36B21" />
                        <path
                            d="M17.4228 0C15.7416 1.52838 14.2132 3.09498 12.9141 4.7762C13.1051 5.00546 13.2197 5.23472 13.3344 5.54039C15.818 5.5786 18.4545 5.9607 21.0909 6.87773C24.7972 8.13865 28.0833 10.3166 30.949 13.3734C31.1782 13.2969 31.4457 13.2205 31.7132 13.2205C32.0571 13.2205 32.401 13.2969 32.7066 13.4498C33.1652 12.7238 33.5472 12.036 33.8911 11.3483C31.3693 4.69978 24.9883 0 17.4992 0C17.461 0 17.461 0 17.4228 0Z"
                            fill="#F36B21" />
                        <path
                            d="M8.94041 5.76964C9.09325 5.08186 9.51356 4.50872 10.1249 4.20304C9.97207 3.43885 9.85744 2.63645 9.74281 1.79584C7.2974 3.01854 5.15766 4.77619 3.51465 6.95413C5.11945 6.45741 6.95351 6.0371 8.94041 5.76964Z"
                            fill="#F36B21" />
                        <path
                            d="M5.84598 28.2369C4.77611 28.1223 3.89729 27.2817 3.78266 26.2118C3.24773 26.1354 2.67458 26.0208 2.13965 25.9061C3.20952 27.893 4.66148 29.6507 6.41912 31.0644C6.18987 30.1856 5.99882 29.2686 5.84598 28.2369Z"
                            fill="#F36B21" />
                        <path
                            d="M20.0214 22.6965C20.6328 22.6965 21.2059 22.9639 21.6262 23.346C21.9701 23.1932 22.2758 23.0404 22.5815 22.8875C25.7147 21.2827 28.1601 19.1812 30.0324 17.0032C29.6503 16.5829 29.421 16.048 29.421 15.4366C29.421 14.8635 29.6121 14.3668 29.9559 13.9465C27.2813 11.119 24.1863 9.09385 20.7092 7.90935C18.2638 7.06874 15.7802 6.68665 13.4112 6.64844C13.2583 7.33621 12.838 7.90935 12.1885 8.25324C13.8697 14.2521 16.5444 19.1048 19.219 22.8493C19.4865 22.7729 19.7158 22.6965 20.0214 22.6965Z"
                            fill="#F36B21" />
                        <path
                            d="M21.0924 27.0142C20.7867 27.2053 20.4046 27.2817 20.0225 27.2817C19.0673 27.2817 18.2649 26.7085 17.921 25.8679C15.5902 26.4793 13.0684 26.785 10.4701 26.785C9.74413 26.785 9.01815 26.7467 8.25396 26.7085C8.0247 27.2817 7.60439 27.7784 7.03125 28.0459C7.26051 29.6125 7.56618 31.0262 7.91007 32.1343C10.623 33.9301 13.9472 35 17.5007 35C20.8631 35 24.0345 34.0448 26.7092 32.4018C25.4101 31.3701 23.3468 29.6125 21.0924 27.0142Z"
                            fill="#F36B21" />
                        <path
                            d="M32.8225 17.4618C32.4786 17.6528 32.1347 17.7675 31.7144 17.7675C31.4851 17.7675 31.2559 17.7293 31.0648 17.6528C29.0779 19.9454 26.4797 22.1998 23.1172 23.9192C22.8116 24.0721 22.5059 24.2249 22.2002 24.3395C22.2766 24.5306 22.2766 24.7598 22.2766 24.9891C22.2766 25.4476 22.1238 25.8679 21.8945 26.25C24.3017 29.0011 26.4415 30.7969 27.6642 31.7522C31.3323 29.1157 33.9306 25.1419 34.733 20.5186C34.1216 19.4487 33.5102 18.417 32.8225 17.4618Z"
                            fill="#F36B21" />
                    </svg>
                </div>
                <div class="hero-sub-content-text">
                    <h6 class="subheadline_medium">Expand globally with a <br>
                        strong legal foundation </h6>
                </div>
            </div>

        </div>
    </div>


</div>

<!-- hero section ends -->

<div class="spacing"></div>

<!-- How its work section  -->


<div class="container mx-auto px-4 sm:px-6 lg:px-8 " id="our-services">
    <div class="grid grid-cols-1 text-center">
        <h1 data-aos="zoom-in-up" data-aos-duration="1000" class="caption-1 text-[var(--primary)]">Features</h1>
        <h2 data-aos-delay="250" data-aos="zoom-in-up" data-aos-duration="1000">
            <span class="heading-color heading-3">What Makes Occams.ai Different?</span>
        </h2>
    </div>
</div>

<!-- How its work section Ends -->

<div class="spacing"></div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <div class="mx-auto grid gap-6 grid-cols-1 lg:grid-cols-3">


        <div class="how-it-works-box" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="how-it-works-box-content">
                <div class="how-it-works-box-content-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M32.1457 16.2511V26.9001L34.4089 28.7186C34.4068 24.2887 34.7424 18.9467 32.1457 16.2511ZM16.3381 50C14.811 50 14.811 47.6802 16.3381 47.6802H20.3172C21.0199 46.1721 21.5129 44.5633 21.7016 42.921H28.2984C28.4872 44.5633 28.9801 46.1742 29.6828 47.6802H33.6619C35.1889 47.6802 35.1889 50 33.6619 50H16.3381ZM21.5002 32.7819C19.9732 32.7819 19.9732 30.4621 21.5002 30.4621H28.5019C30.029 30.4621 30.029 32.7819 28.5019 32.7819H21.5002ZM18.57 5.81214C17.8694 8.49064 17.8568 10.393 17.8568 13.3505C14.4608 15.2508 13.2736 19.4922 13.2736 24.6432V31.1351C13.2736 32.0789 14.3916 32.7019 15.2222 31.9845L19.4195 28.6096H30.5784L34.7756 31.9845C35.6063 32.7019 36.7243 32.0789 36.7243 31.1351V24.6432C36.7243 19.4918 35.5371 15.2529 32.1411 13.3505C32.1411 10.393 32.1285 8.49059 31.4279 5.81214H47.3214C48.7897 5.81214 50 7.01192 50 8.49064V37.9224C50 39.3927 48.7918 40.6009 47.3214 40.6009H2.67861C1.2082 40.6009 0 39.3927 0 37.9224V8.49064C0 7.01401 1.20192 5.81214 2.67861 5.81214H18.57ZM28.7978 5.10529L28.2755 3.81745C27.0652 1.21234 25.6262 0 25.0011 0C23.8118 0 22.1526 2.66379 21.2045 5.10948C20.1662 7.78798 20.1788 10.8232 20.1788 14.0681V26.2925H29.8256L29.8235 11.7151C29.8256 9.04081 29.4103 6.85061 28.7978 5.10529ZM17.8568 26.9004V16.2515C15.258 18.9488 15.5936 24.2892 15.5936 28.7191L17.8568 26.9004Z"
                            fill="#1086BE" />
                    </svg>
                    <h1 class="heading-4 dark:text-black">Comprehensive Business Formation</h1>
                    <ul>
                        <li class="dark:text-black subheadline_medium">LLC, C Corp, S Corp</li>
                        <li class="dark:text-black subheadline_medium flex">State selection for tax & operational
                            benefits </li>
                    </ul>

                </div>

            </div>
        </div>

        <div class="how-it-works-box" data-aos-delay="200" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="how-it-works-box-content">
                <div class="how-it-works-box-content-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="55" height="50" viewBox="0 0 55 50" fill="none">
                        <path
                            d="M44.9215 48.6726V45.5752C44.9215 44.9115 44.3684 44.3584 43.7047 44.2478L37.51 43.5841C33.5277 43.1416 30.5409 39.823 30.5409 35.8407V17.146C31.979 16.3717 32.9746 15.0442 33.5277 13.6062H41.0498L34.7445 25.9956C34.5233 26.4381 34.4126 26.9912 34.6339 27.5443C35.9613 32.5221 39.833 35.7301 44.3684 35.7301C48.9038 35.7301 52.7755 32.5221 54.1029 27.5443C54.2135 27.1018 54.2135 26.5487 53.9923 25.9956L45.9171 9.95575C45.5852 9.40266 45.1427 9.0708 44.479 8.96018L33.5277 9.0708C32.9746 7.52213 31.8684 6.19469 30.4303 5.42035V3.31858C30.4303 1.43805 28.8817 0 27.1117 0C25.3418 0 23.7932 1.54867 23.7932 3.31858V5.42035C22.3551 6.19469 21.2489 7.52213 20.6958 9.0708L9.74449 8.96018C9.08077 8.96018 8.63829 9.40266 8.30643 9.95575L0.231214 25.9956C0.00997483 26.4381 -0.100645 26.9912 0.120594 27.5443C1.44803 32.5221 5.31971 35.7301 9.85511 35.7301C14.3905 35.7301 18.2622 32.5221 19.5896 27.5443C19.7002 27.1018 19.7002 26.5487 19.479 25.9956L13.1737 13.6062H20.6958C21.2489 15.1549 22.3551 16.3717 23.6825 17.146V35.7301C23.6825 39.7124 20.6958 43.031 16.7135 43.4735L10.5188 44.2478C9.85511 44.3584 9.30201 44.9115 9.30201 45.5752V48.6726C9.30201 49.4469 9.85511 50 10.6294 50H43.4834C44.2578 50 44.9215 49.3363 44.9215 48.6726ZM49.5675 25.3319H39.1693L44.3684 14.9336L49.5675 25.3319ZM15.0542 25.3319H4.65599L9.85511 14.9336L15.0542 25.3319Z"
                            fill="#1086BE" />
                    </svg>
                    <h1 class="heading-4  dark:text-black lg:pr-[33px]">Legal & Compliance <br> Support</h1>
                    <ul>
                        <li class="subheadline_medium flex dark:text-black">Corporate Transparency Act (CTA) filings
                        </li>
                        <li class="subheadline_medium flex dark:text-black">Annual reports, stock transfers & corporate
                            amendments  
                        </li>
                    </ul>

                </div>

            </div>
        </div>

        <div class="how-it-works-box" data-aos-delay="300" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="how-it-works-box-content">
                <div class="how-it-works-box-content-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M49.9997 29.1666C49.9997 28.0166 49.0663 27.0833 47.9163 27.0833H29.1663C28.0163 27.0833 27.083 28.0166 27.083 29.1666V47.9166C27.083 49.0666 28.0163 50 29.1663 50H47.9163C49.0663 50 49.9997 49.0666 49.9997 47.9166V29.1666Z"
                            fill="#1086BE" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M22.9167 29.1666C22.9167 28.0166 21.9833 27.0833 20.8333 27.0833H2.08333C0.933333 27.0833 0 28.0166 0 29.1666V47.9166C0 49.0666 0.933333 50 2.08333 50H20.8333C21.9833 50 22.9167 49.0666 22.9167 47.9166V29.1666Z"
                            fill="#1086BE" />
                        <path
                            d="M37.5 25C44.4036 25 50 19.4036 50 12.5C50 5.59644 44.4036 0 37.5 0C30.5964 0 25 5.59644 25 12.5C25 19.4036 30.5964 25 37.5 25Z"
                            fill="#1086BE" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M22.9167 2.08333C22.9167 0.933333 21.9833 0 20.8333 0H2.08333C0.933333 0 0 0.933333 0 2.08333V20.8333C0 21.9833 0.933333 22.9167 2.08333 22.9167H20.8333C21.9833 22.9167 22.9167 21.9833 22.9167 20.8333V2.08333Z"
                            fill="#1086BE" />
                    </svg>
                    <h1 class="heading-4  dark:text-black lg:pr-[150px]">Business Essentials</h1>
                    <ul>
                        <li class="subheadline_medium flex dark:text-black">EIN registration & U.S. business bank
                            account assistance 
                        </li>
                        <li class="subheadline_medium flex  dark:text-black">Registered agent services & virtual office 
                        </li>
                    </ul>

                </div>

            </div>
        </div>


    </div>


    <!-- <div class="mx-auto grid-cols-1 mt-6">
        <div class="how-it-works-box pt-[20px]">
            <div class="how-it-works-box-content">
                <div class="how-it-works-box-content-left">
                    <img src="assets/images/logo/book-icon-2.png" alt="icon">
                    <h1 class="heading-3 mt-6 dark:text-black">Banking & Financial Setup </h1>
                    <p class="caption-1 mt-3 dark:text-black">Submit your information quickly and securely. </p>

                </div>
                <div class="how-it-works-box-content-right">
                    <img src="assets/images/logo/OBJECTS.png" alt="vector">

                </div>

            </div>
        </div>

    </div> -->
</div>

<div class="spacing"></div>

<!-- Benefits Section -->

<div class="container mx-auto px-4 sm:px-6 lg:px-8 " id="about">
    <div class="grid grid-cols-1 text-center">
        <h1 class="caption-1 text-[var(--primary)]" data-aos="zoom-in-up" data-aos-duration="1000">Benefits</h1>
        <h2>
            <span class="heading-color heading-3" data-aos-delay="250" data-aos="zoom-in-up"
                data-aos-duration="1000">Why Choose Occams.ai? </span>
        </h2>
    </div>
</div>

<div class="spacing"></div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid sm:grid-cols-1 md:grid-cols-1 lg:flex lg:justify-between gap-4">
        <!-- Box 1 -->
        <div class="benefit-box registration-box w-full lg:w-[32%]" data-aos="zoom-in-up" data-aos-duration="1000">
            <img class="hidden md:block lg:hidden" src="assets/images/images/hasslefree-tablet.webp"
                alt="Document Processing">
            <img class="hidden md:hidden lg:block" src="assets/images/images/hasslefree-desktop.webp"
                alt="Document Processing">
            <img class=" md:hidden lg:hidden" src="assets/images/images/hasslefree-mobile.webp"
                alt="Document Processing">
            <div class="benefit-box-text md:top-[198px] lg:top-[150px]">
                <h1 class="heading-4 text-white dark:text-white lg:pr-[70px] pr-[126px]">Hassle-Free U.S. Business Setup
                </h1>
                <p class="body-text-2 pt-[14px] md:pt-[0px] pr-[126px]">From entity selection to compliance, we handle
                    everything. </p>
            </div>
        </div>


        <!-- Box 2 -->
        <div class="benefit-box w-full lg:w-[38%]" data-aos-delay="200" data-aos="zoom-in-up" data-aos-duration="1000">
            <img class="hidden md:block lg:hidden" src="assets/images/images/tailored-tablet.webp"
                alt="Document Processing">
            <img class="hidden md:hidden lg:block" src="assets/images/images/tailored-desktop.webp"
                alt="Document Processing">
            <img class=" md:hidden lg:hidden" src="assets/images/images/tailored-mobile.webp" alt="Document Processing">
            <div class="benefit-box-text md:top-[198px] lg:top-[150px]">
                <h1 class="heading-4 text-white dark:text-white pr-[126px]">Tailored for Global & Local Entrepreneurs
                </h1>
                <p class="body-text-2 pt-[14px] pr-[100px]  md:pt-[0px]">We make U.S. incorporation seamless for foreign
                    founders. </p>
            </div>
        </div>

        <!-- Box 3 -->
        <div class="benefit-box w-full lg:w-[24%]" data-aos-delay="250" data-aos="zoom-in-up" data-aos-duration="1000">
            <img class="hidden md:block lg:hidden" src="assets/images/images/tax-tablet.webp" alt="Document Processing">
            <img class="hidden md:hidden lg:block" src="assets/images/images/tax-desktop.webp"
                alt="Document Processing">
            <img class=" md:hidden lg:hidden" src="assets/images/images/tax-mobile.webp" alt="Document Processing">
            <div class="benefit-box-text md:top-[198px] lg:top-[150px]">
                <h1 class="heading-4 text-white dark:text-white pr-[126px] lg:pr-[60px]">Tax-Optimized Structuring</h1>
                <p class="body-text-2 pr-[86px] pt-[14px]  md:pt-[0px]  ">Strategies like Section 1202 to reduce capital
                    gains tax. </p>
            </div>
        </div>


    </div>

    <div class="grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mt-8">


        <div class="benefit-box" data-aos-delay="300" data-aos="zoom-in-up" data-aos-duration="1000">
            <img class="hidden md:block lg:hidden" src="assets/images/images/allinone-tablet.webp"
                alt="Document Processing">
            <img class="hidden md:hidden lg:block" src="assets/images/images/allinone-desktop.webp"
                alt="Document Processing">
            <img class=" md:hidden lg:hidden" src="assets/images/images/allinone-mobile.webp" alt="Document Processing">
            <div class="benefit-box-text md:top-[198px] lg:top-[150px]">
                <h1 class="heading-4 text-white pr-[76px] ">All-in-One Business Essentials  </h1>
                <p class="body-text-2 lg:pr-[316px] pr-[126px] pt-[14px]">EIN, bank account setup, and legal
                    documents—all in one place. </p>
            </div>
        </div>

        <div class="benefit-box " data-aos-delay="350" data-aos="zoom-in-up" data-aos-duration="1000">
            <img class="hidden md:block lg:hidden" src="assets/images/images/stay-tablet.webp"
                alt="Document Processing">
            <img class="hidden md:hidden lg:block" src="assets/images/images/stay-desktop.webp"
                alt="Document Processing">
            <img class=" md:hidden lg:hidden" src="assets/images/images/stay-mobile.webp" alt="Document Processing">
            <div class="benefit-box-text md:top-[198px] lg:top-[150px]">
                <h1 class="heading-4 text-white pr-[78px]">Stay Compliant, Stay Protected</h1>
                <p class="body-text-2 lg:pr-[316px] pr-[100px] pt-[14px]">We handle CTA filings, annual reports, and
                    regulatory compliance. </p>
            </div>
        </div>


    </div>
</div>

<div class="spacing"></div>

<!-- benefits section ends -->

<!-- Incorporate Now section -->

<div class="container mx-auto px-4 sm:px-6 lg:px-8 ">
    <div class="grid grid-cols-1 text-center text-black">

        <h1 class="heading-4 dark:text-white">A strong foundation today means fewer costly mistakes tomorrow. </h1>

        <div class="mt-6">
            <a class="signup-cta mt-4" href="#">Incorporate Now</a>
        </div>

    </div>
</div>

<div class="spacing"></div>

<!-- Incorporate Now section ends -->


<!-- timeline section -->

<?php
include('timeline.php');
?>


<div class="spacing"></div>



<!-- Description & Pricing -->

<div class="container mx-auto px-4 sm:px-6 lg:px-8 " id="pricing">
    <div class="grid grid-cols-1 text-center">

        <h2>
            <span class="heading-color heading-3" data-aos="zoom-in-up" data-aos-duration="1000">Description &
                Pricing</span>
        </h2>

        <p class="caption-2" data-aos-delay="250" data-aos="zoom-in-up" data-aos-duration="1000">We believe in
            straightforward, competitive pricing so you can build your business with confidence.</p>
    </div>
</div>

<div class="spacing"></div>


<div class="container mx-auto px-4 sm:px-6 lg:px-8 ">
    <div class="grid grid-cols-1 lg:grid-cols-3  gap-6">


        <!-- classic pack -->

        <div class="classic-price-box dark:bg-black dark:text-white hover:bg-[#F5E9E3] dark:hover:bg-[#F5E9E3] dark:hover:text-black transition transition-all duration-200 hover:delay-200"
            data-aos="zoom-in-up" data-aos-duration="1000">

            <div class="pricing-cta-box ">
                <div class="flex items-center space-x-4">
                    <a href="#" class=""></a>

                </div>
                <div class="pricing-logo-box flex gap-4 ">
                    <div class="flex pricing-logo-box-inner">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="11" height="25" viewBox="0 0 11 15" fill="none">
                            <path
                                d="M0 0.969948V14.9699H1V7.28995C4.333 5.74995 7.666 11.0239 11 7.96995C11 5.63695 11 3.30295 11 0.969948C7.333 4.32995 3.667 -2.39005 0 0.969948Z"
                                fill="black" />
                        </svg> -->
                        <h1 class="cta-font dark:text-black"></h1>
                    </div>
                </div>

                <div class="pricing-name-box">
                    <h1 class="heading-2 text-black dark:text-white hover:text-black">Classic</h1>
                    <h6 class="subheadline_medium"><b>$299.00 </b><span class="body-text-2">/ Year + <b class="subheadline_medium">State Fee</b> </span></h6>
                </div>

                <div class="pricing-cta-box my-8">
                    <a class="dark-cta-pricing" href="#">Get Classic</a>
                </div>


            </div>

            <div class="pricing-list ">
                <h1 class="heading-4 text-[#1086BE] ">Business Incorporation</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium">Identify the optimal structure for the business to be
                        incorporated (LLC/C Corp/S Corp/ Non Profit)</li>
                    <li class="flex  subheadline_medium">Identify the best state for the business to be incorporated in
                    </li>
                    <li class="flex  subheadline_medium">Incorporate the business in a jurisdiction as agreed upon</li>
                    <li class="flex  subheadline_medium">Registered Agent Services for 1 Year</li>
                    <li class="flex subheadline_medium ">Provide virtual US address for 1 Year</li>
                    <li class="flex subheadline_medium ">Obtain a Employer Identification number from IRS Issue </li>
                </ul>

                <!--  <h1 class="heading-4 text-[#1086BE]">Annual Report</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium">Registered Agent Services for 1 Year</li>
                    <li class="flex  subheadline_medium">Provide virtual US address for 1 Year </li>
                    <li class="flex  subheadline_medium">File State annual reports (1 State)</li>
                </ul> -->


                <!-- <h1 class="heading-4 text-[#1086BE]"> Add on Services</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium">Business Amendment - Filing with State</li>
                    <li class="flex  subheadline_medium">Foreign Qualification</li>
                    <li class="flex  subheadline_medium">Certificate of good standing</li>
                    <li class="flex  subheadline_medium">Business reinstatement</li>
                    <li class="flex  subheadline_medium">Business dissolution (State Dissolution + EIN Cancellation with IRS)</li>
                </ul> -->



            </div>

        </div>

        <!-- premium package -->


        <div class="preminum-price-box dark:bg-black dark:text-white hover:bg-[#F5E9E3] dark:hover:bg-[#F5E9E3] dark:hover:text-black transition transition-all duration-200 hover:delay-200"
            data-aos-delay="250" data-aos="zoom-in-up" data-aos-duration="1000">

            <div class="pricing-cta-box ">
                <div class="flex items-center space-x-4">
                    <a href="#" class=""></a>
                </div>
                <div class="pricing-logo-box flex gap-4 ">
                    <div class="text-white flex pricing-logo-box-inner">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="11" height="25" viewBox="0 0 11 18" fill="none">
                            <path
                                d="M10.5409 4.01252L6.44574 0.358097C5.91319 -0.119366 5.08681 -0.119366 4.55426 0.358097L0.477463 4.01252C0.183639 4.28798 0 4.65526 0 5.05927V16.0225C0 16.8122 0.624374 17.4366 1.41402 17.4366H9.58598C10.3756 17.4366 11 16.8122 11 16.0225V5.05927C11 4.65526 10.8347 4.28798 10.5409 4.01252ZM5.50918 3.27796C6.22538 3.27796 6.81302 3.86561 6.81302 4.5818C6.81302 5.298 6.22538 5.88564 5.50918 5.88564C4.79299 5.88564 4.20534 5.298 4.20534 4.5818C4.20534 3.86561 4.79299 3.27796 5.50918 3.27796ZM8.19032 11.2846L7.16194 12.1477C7.10684 12.2028 7.07012 12.2763 7.08848 12.3497L7.41903 13.6536C7.51085 14.0392 7.10684 14.3331 6.77629 14.1311L5.63773 13.4149C5.56427 13.3781 5.49082 13.3781 5.41736 13.4149L4.2788 14.1311C3.94825 14.3331 3.54424 14.0392 3.63606 13.6536L3.96661 12.3497C3.98497 12.2763 3.96661 12.2028 3.89316 12.1477L2.82805 11.2846C2.53422 11.0275 2.68113 10.5501 3.08514 10.5134L4.42571 10.4215C4.49917 10.4215 4.57262 10.3664 4.59098 10.293L5.10518 9.04424C5.25209 8.67696 5.76628 8.67696 5.91319 9.04424L6.42738 10.293C6.46411 10.3664 6.5192 10.4032 6.59265 10.4215L7.93322 10.5134C8.31886 10.5501 8.48414 11.0459 8.19032 11.2846Z"
                                fill="black" />
                        </svg> -->
                        <h1 class="cta-font"></h1>
                    </div>
                </div>

                <div class="pricing-name-box">
                    <h1 class="heading-2 text-black dark:text-white">Premium</h1>
                    <h6 class="subheadline_medium"><b>1,499.00</b> <span class="body-text-2">/ Year + <b class="subheadline_medium"> State Fee</b> </span></h6>
                </div>

                <div class="pricing-cta-box my-8">
                    <a class="dark-cta-pricing bg-[#1086BE]" href="#">Get Premium</a>
                </div>


            </div>

            <div class="pricing-list ">
                <h1 class="heading-4 text-[#1086BE] ">Business Incorporation</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium" style="font-weight: 700;">Everything included in the Classic
                        plan</li>
                    <!-- <li class="flex  subheadline_medium">Identify the best state for the business to be incorporated in</li>
                    <li class="flex  subheadline_medium">Incorporate the business in a jurisdiction as agreed upon</li>
                    <li class="flex  subheadline_medium">Registered Agent Services for 1 Year</li>
                    <li class="flex subheadline_medium ">Provide virtual US address for 1 Year</li>
                    <li class="flex subheadline_medium ">Obtain a Employer Identification number from IRS</li> -->
                    <li class="flex subheadline_medium ">Provide Bylaws and Operating Documents</li>
                    <li class="flex subheadline_medium ">Complete filing for Corporate Transparency Act</li>
                </ul>

                <h1 class="heading-4 text-[#1086BE]">Annual Report</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium">Registered Agent Services for 1 Year</li>
                    <li class="flex  subheadline_medium">Provide virtual US address for 1 Year </li>
                    <li class="flex  subheadline_medium">File State annual reports ( 1 State)</li>

                    <li class="flex  subheadline_medium">File Alternatete names such as DBA with the applicable state
                    </li>
                    <li class="flex  subheadline_medium">File for change in Corporate Structure (eg S Corp to C Corp)
                    </li>
                    <li class="flex  subheadline_medium">Compliance for change in ownership (stock transfer, IRS change
                        in responsible party)</li>
                    <li class="flex  subheadline_medium">Corporate Transparency Act related compliance</li>
                </ul>
                <h1 class="heading-4 text-[#1086BE]">Corporate Tax Filing</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium">File Annual Income Tax Returns for Federal and State (1 State)
                    </li>
                </ul>



            </div>

        </div>

        <!-- Elite paclage    -->

        <div class="Elite-price-box dark:bg-black dark:text-white hover:bg-[#F5E9E3] dark:hover:bg-[#F5E9E3] dark:hover:text-black transition transition-all duration-200  hover:delay-200"
            data-aos-delay="300" data-aos="zoom-in-up" data-aos-duration="1000">

            <div class="pricing-cta-box">
                <div class="flex items-center space-x-4 pb-[20px]">
                    <button  class="border bordr-[#BBB] transition-all ease-out duration-300 hover:scale-110 elite-pack-cta rounded-2xl px-[9px] py-[2px] active hidden md:block"  id="annualBtn">Annual</button>

                    <button class="border bordr-[#BBB] transition-all ease-out duration-300 hover:scale-110 elite-pack-cta rounded-2xl px-[9px] py-[2px]  hidden md:block " id="monthlyBtn">Monthly</button>
                </div>
                <!-- <div class="pricing-logo-box flex  ">
                    <div class="flex pricing-logo-box-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="25" viewBox="0 0 28 17" fill="none">
                            <path
                                d="M23.2908 3.37842H4.69295C4.52166 4.01772 4.01625 4.52192 3.37695 4.69442V12.0333C4.01625 12.2046 4.52046 12.71 4.69295 13.3493H23.2918C23.463 12.71 23.9685 12.2058 24.6078 12.0333V4.69442C23.9685 4.52313 23.4643 4.01772 23.2918 3.37842H23.2908ZM13.992 12.2406C11.8546 12.2406 10.1151 10.5012 10.1151 8.36363C10.1151 6.22608 11.8545 4.48669 13.992 4.48669C16.1296 4.48669 17.869 6.22608 17.869 8.36363C17.869 10.5012 16.1296 12.2406 13.992 12.2406Z"
                                fill="black" />
                            <path
                                d="M13.9919 5.45166C12.3864 5.45166 11.0801 6.75802 11.0801 8.36352C11.0801 9.96901 12.3864 11.2754 13.9919 11.2754C15.5974 11.2754 16.9038 9.96901 16.9038 8.36352C16.9038 6.75802 15.5974 5.45166 13.9919 5.45166Z"
                                fill="black" />
                            <path
                                d="M27.5022 0H0.482494C0.215917 0 0 0.215917 0 0.482494V16.2432C0 16.5097 0.215917 16.7256 0.482494 16.7256H27.5022C27.7688 16.7256 27.9847 16.5097 27.9847 16.2432V0.482494C27.9847 0.215917 27.7688 0 27.5022 0ZM25.5722 12.4507C25.5722 12.7172 25.3563 12.9332 25.0897 12.9332C24.5951 12.9332 24.1935 13.3348 24.1935 13.8294C24.1935 14.096 23.9776 14.3119 23.711 14.3119H4.2738C4.00723 14.3119 3.79131 14.096 3.79131 13.8294C3.79131 13.3348 3.38842 12.9332 2.89509 12.9332C2.62851 12.9332 2.4126 12.7172 2.4126 12.4507V4.27374C2.4126 4.00716 2.62851 3.79125 2.89509 3.79125C3.38966 3.79125 3.79131 3.38957 3.79131 2.89503C3.79131 2.62845 4.00723 2.41253 4.2738 2.41253H23.7098C23.9763 2.41253 24.1923 2.62845 24.1923 2.89503C24.1923 3.3896 24.5951 3.79125 25.0885 3.79125C25.3551 3.79125 25.571 4.00716 25.571 4.27374V12.4507H25.5722Z"
                                fill="black" />
                        </svg>
                        <h1 class="cta-font text-white"></h1>
                    </div>
                </div> -->

                <div class="pricing-name-box ">
                    <h1 class="heading-2 text-black dark:text-white">Elite</h1>
                    <h6 class="subheadline_medium" id="annualPrice"><b>$5,089.00 </b><span class="body-text-2">/ Year + <b class="subheadline_medium">State Fee</b> </span></h6>
                    <h6 class="subheadline_medium hidden" id="monthlyPrice"><b>$499.00</b><span class="body-text-2">/ Month + <b class="subheadline_medium">State Fee</b> </span></h6>
                </div>

                <div class="pricing-cta-box my-8">
                    <a class="dark-cta-pricing bg-[#F36B21] tex-white" href="#">Get Elite</a>
                </div>


            </div>

            <div class="pricing-list ">
                <h1 class="heading-4 text-[#1086BE] ">Business Incorporation</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium" style="font-weight: 700;">Everything included in the Classic
                        plan and Premium plan</li>
                    <!-- <li class="flex  subheadline_medium">Identify the optimal structure for the business to be incorporated (LLC/C Corp/S Corp/ Non Profit)</li> -->
                    <!--   <li class="flex  subheadline_medium">Identify the best state for the business to be incorporated in</li>
                    <li class="flex  subheadline_medium">Incorporate the business in a jurisdiction as agreed upon</li>
                    <li class="flex  subheadline_medium">Registered Agent Services for 1 Year</li>
                    <li class="flex subheadline_medium ">Provide virtual US address for 1 Year</li>
                    <li class="flex subheadline_medium ">Obtain a Employer Identification number from IRS Issue</li>
                    <li class="flex subheadline_medium ">Provide Bylaws and Operating Documents</li> -->
                    <!-- <li class="flex subheadline_medium ">Complete filing for Corporate Transparency Act</li> -->
                    <li class="flex subheadline_medium ">File Trade Name / DBA with State</li>
                    <li class="flex subheadline_medium ">Assist in opening business bank account</li>
                </ul>

                <h1 class="heading-4 text-[#1086BE]">Annual Report</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium" style="font-weight: 700;">Everything included in the Premium
                        plan</li>
                    <!-- <li class="flex  subheadline_medium">Registered Agent Services for 1 Year</li>
                    <li class="flex  subheadline_medium">Provide virtual US address for 1 Year </li>
                    <li class="flex  subheadline_medium">File State annual reports (1 State)</li>
                    <li class="flex  subheadline_medium">File Alternatete names such as DBA with the applicable state</li>
                    <li class="flex  subheadline_medium">File for change in Corporate Structure (eg S Corp to C Corp)</li>
                    <li class="flex  subheadline_medium">Compliance for change in ownership (stock transfer, IRS change in responsible party)</li>
                    <li class="flex  subheadline_medium">Corporate Transparency Act related compliance</li> -->
                </ul>


                <h1 class="heading-4 text-[#1086BE]"> Payroll Services</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium">Full Service Payroll Processing</li>
                    <li class="flex  subheadline_medium">Tax Filing for payroll related liabilities</li>
                    <li class="flex  subheadline_medium">Compliance with employment tax laws</li>
                </ul>

                <h1 class="heading-4 text-[#1086BE]">Corporate Tax Filing</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium">File Annual Income Tax Returns for Federal and State (1 State)
                    </li>
                </ul>

                <h1 class="heading-4 text-[#1086BE]">Book-Keeping</h1>

                <ul class="pricing-list-items">
                    <li class="flex  subheadline_medium">Maintain books of accounts for the US entity (Upto 100 bank +
                        cc transactions pm)</li>
                    <li class="flex  subheadline_medium">Bank and Credit Card reconciliation</li>
                    <li class="flex  subheadline_medium">Prepare Income Statement, Balance Sheet & Cash Flow</li>
                    <li class="flex  subheadline_medium">Accounts receivable/Payable Management</li>
                </ul>



            </div>

        </div>



    </div>
</div>

<div class="spacing"></div>



<!-- Description & Pricing Ends -->




<div class="spacing"></div>
<div class="spacing"></div>

<!-- client testimonial section -->

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-wrap lg:flex-nowrap gap-6 justify-between">

        <!-- heading of tesimonial -->
        <div class="w-full md:w-1/4">
            <div class="testimonial-head text-center md:text-left">
                <h1 class="heading-3 heading-color hidden md:block">
                    <span>What Our <br> Clients Say </span>
                </h1>
                <h1 class="heading-3 heading-color  md:hidden text-center">
                    <span>What Our Clients Say </span>
                </h1>
            </div>
        </div>

        <!-- cards  -->

        <div class="w-full md:w-2/3 testimonial-slider ">

            <!-- <div class="testimonial-slider"> -->
            <div class="p-10 rounded-2xl bg-[#FFE7DA] testimonial-card-box">
                <div class="testimonial-card">

                    <div class="testimonial-content mt-6">
                        <h1 class="subheadline_light dark:text-black">Working with Occams was a fantastic experience.
                            They were
                            excellent
                            communicators and came through on all of their promises. I was a little skeptical of at
                            first, as I am sure most people were, but they delivered!</h1>

                        <h6 class="subheadline_medium dark:text-black">Rye Nazarian</h6>
                        <p class="subheadline_medium dark:text-black">Surface Painting and Design Inc</p>
                    </div>
                </div>
            </div>

            <div class="p-10 rounded-2xl bg-[#DDF4FF] testimonial-card-box">
                <div class="testimonial-card">


                    <div class="testimonial-content mt-6">
                        <h1 class="subheadline_light dark:text-black">The folks were awesome and took care of it all
                            just had to provide
                            proper
                            documentation. CSC(SS) Ret. USN Mark Martin</h1>
                        <br> <br>

                        <h6 class="subheadline_medium dark:text-black">Mark Martin</h6>
                        <p class="subheadline_medium dark:text-black">Detect Termite & Moisture Services</p>
                    </div>
                </div>
            </div>

            <div class="p-10 rounded-2xl bg-[#FFE7DA] testimonial-card-box">
                <div class="testimonial-card">
                    <div class="testimonial-content mt-6">
                        <h1 class="subheadline_light dark:text-black">Great experience
                            All of the people I worked with were very professional and prompt in answering all the
                            questions I had.
                            Great Job!! To all involved</h1>
                        <br>

                        <h6 class="subheadline_medium dark:text-black">Bill Wegleitner</h6>
                        <p class="subheadline_medium dark:text-black">Product Manager, Microsoft</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- </div> -->

</div>

<div class="spacing"></div>

<!-- client testimonial section ends -->


<div class="spacing"></div>



<!-- FAQ section started  -->

<?php
include('faq.php');
?>

<div class="spacing"></div>

<!-- FAQ section ends -->





<script>
    $(document).ready(function () {
        $('.testimonial-slider').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: true,
            dots: false,
            infinite: true,
            prevArrow: '<button class="slick-prev"><i class="fa-solid fa-arrow-left"></i></i></button>',
            nextArrow: '<button class="slick-next"><i class="fa-solid fa-arrow-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    });
</script>

<script>
    document.getElementById('annualBtn').addEventListener('click', function () {
        // Toggle price
        document.getElementById('annualPrice').classList.remove('hidden');
        document.getElementById('monthlyPrice').classList.add('hidden');

        // Toggle active class
        document.getElementById('annualBtn').classList.add('active');
        document.getElementById('monthlyBtn').classList.remove('active');
    });

    document.getElementById('monthlyBtn').addEventListener('click', function () {
        // Toggle price
        document.getElementById('monthlyPrice').classList.remove('hidden');
        document.getElementById('annualPrice').classList.add('hidden');

        // Toggle active class
        document.getElementById('monthlyBtn').classList.add('active');
        document.getElementById('annualBtn').classList.remove('active');
    });
</script>

<script>
    // Field references
    const nameInput = document.getElementById("get_name");
    const emailInput = document.getElementById("get_email");
    const phoneInput = document.getElementById("get_phone");

    const nameError = document.getElementById("name-error");
    const emailError = document.getElementById("email-error");
    const phoneError = document.getElementById("phone-error");

    // Regex patterns
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    // const phoneRegex = /^\d{15}$/;
    const phoneRegex = /^\(\d{3}\)\s\d{3}-\d{4}$/;
    // Validation functions
    function validateName() {
        const name = nameInput.value.trim();
        nameError.textContent = name ? "" : "Please enter your full name.";
    }

    function validateEmail() {
        const email = emailInput.value.trim();
        emailError.textContent = emailRegex.test(email) ? "" : "Please enter a valid email address.";
    }

    function validatePhone() {
        const phone = phoneInput.value.trim();
        phoneError.textContent = phoneRegex.test(phone) ? "" : "Please enter a valid phone number (10 digits).";
    }


      phoneInput.addEventListener("input", function () {
        // console.log(this.value.length);
          let digits = this.value.replace(/\D/g, '').substring(0, 10);
        let formatted = "";

        if (digits.length > 0) {
            formatted += "(" + digits.substring(0, 3);
        }
        if (digits.length >= 4) {
            formatted += ") " + digits.substring(3, 6);
        }
        if (digits.length >= 7) {
            formatted += "-" + digits.substring(6, 10);
        }

        this.value = formatted;
    });

    // Add event listeners for real-time validation
    nameInput.addEventListener("input", validateName);
    emailInput.addEventListener("input", validateEmail);
    phoneInput.addEventListener("input", validatePhone);

    // Submit handler (same as before)
    document.getElementById("get-started-btn").addEventListener("click", function (e) {
        e.preventDefault();

        validateName();
        validateEmail();
        validatePhone();

        // Check if all fields are valid
        const isValid = 
            nameError.textContent === "" &&
            emailError.textContent === "" &&
            phoneError.textContent === "";

        if (!isValid) return;

        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();

        const btn = document.getElementById("get-started-btn");
        btn.textContent = "Submitting...";
        btn.disabled = true;

                $.ajax({
                    url: "https://occams.ai/app/public/api/user-register",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        name: name,
                        email: email,
                        mobile: phone
                    }),
                    success: function (response) {
                        console.log(response);
                        if(response.status=='email_already'){
                             Swal.fire({
                                icon: 'error',
                                title: response.title,
                                html: response.message,
                                confirmButtonText: 'Go to Login',
                                buttonsStyling: false,
                                showClass: {
                                  popup: 'swal2-show swal2-animate-success'
                                },
                                customClass: {
                                  popup: 'custom-swal',
                                  title: 'custom-title',
                                  htmlContainer: 'custom-text',
                                  confirmButton: 'custom-button'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    startNextStep("go_login"); 
                                }
                            });
                        }else{
                            Swal.fire({
                                icon: 'success',
                                title: response.title,
                                html: response.message,
                                confirmButtonText: 'Get Started',
                                buttonsStyling: false,
                                showClass: {
                                  popup: 'swal2-show swal2-animate-success'
                                },
                                customClass: {
                                  popup: 'custom-swal',
                                  title: 'custom-title',
                                  htmlContainer: 'custom-text',
                                  confirmButton: 'custom-button'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    startNextStep("logedIn"); 
                                }
                            });
                        }

                        // Reset form
                        nameInput.value = "";
                        emailInput.value = "";
                        phoneInput.value = "";
                        btn.textContent = "Get Started Now";
                        btn.disabled = false;
                    }
                });
    });

    function startNextStep(response){
        if(response=="go_login"){
            // window.location.href = "/app/public/login";
            window.open("/app/public/login", "_blank");
        }else if(response=="logedIn"){
            // window.location.href = "/app/public/account/company-formation";
            window.open("/app/public/account/company-formation", "_blank");
        }
    }

</script>



<?php
include('footer.php');

?>