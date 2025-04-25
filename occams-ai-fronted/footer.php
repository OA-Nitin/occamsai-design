<!-- Footer -->


<div class="spacing"></div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1">
        <div class="footer-logo">
            <img src="assets/images/logo/Logo_Occams.ai.svg" alt="logo" class="main-logo">
        </div>
    </div>
    <div class="spacing"></div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">

        <div class="">
            <h1 class="subheadline_medium text-[var(--primary)] mb-10">Corporate Head Office</h1>
            <p class="body-text-1">1962 Main Street, Suite 420, <br> Sarasota, Florida 34236</p>
        </div>

        <div>
            <h1 class="subheadline_medium text-[var(--primary)] mb-10">Connect With Us</h1>

            <div class="social-icon-box">
                <a class="text-[30px] px-1" href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a class="text-[30px] px-1" href="#"><i class="fa-brands fa-facebook"></i></a>
                <a class="text-[30px] px-1" href="#"><i class="fa-brands fa-linkedin"></i></a>
                <a class="text-[30px] px-1" href="#"><i class="fa-brands fa-tiktok"></i></a>
                <a class="text-[30px] px-1" href="#"><i class="fa-brands fa-reddit-alien"></i></a>
            </div>

        </div>
    </div>

    <div class="grid grid cols-1 my-10 bg-[#ECECEC] p-7 rounded-2xl">
        <p class="dark:text-black">© 2025 Occams Advisory. All Right Reserved. Occams Advisory provides independent
            corporate services. All
            other trademarks, company names, product names and brand names are the property of their respective owners.
            For further details refer <a href="https://www.iubenda.com/privacy-policy/26305627"
                class="iubenda-white iubenda-noiframe iubenda-embed iubenda-noiframe " title="Privacy Policy ">Privacy
                Policy</a>
            <script
                type="text/javascript">(function (w, d) { var loader = function () { var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "https://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s, tag); }; if (w.addEventListener) { w.addEventListener("load", loader, false); } else if (w.attachEvent) { w.attachEvent("onload", loader); } else { w.onload = loader; } })(window, document);</script>
            & <a href="https://www.iubenda.com/privacy-policy/26305627/cookie-policy"
                class="iubenda-white iubenda-noiframe iubenda-embed iubenda-noiframe " title="Cookie Policy ">Cookie
                Policy</a>
            <script
                type="text/javascript">(function (w, d) { var loader = function () { var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "https://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s, tag); }; if (w.addEventListener) { w.addEventListener("load", loader, false); } else if (w.attachEvent) { w.attachEvent("onload", loader); } else { w.onload = loader; } })(window, document);</script>
            of Use
        </p>
    </div>


</div>


<!-- javascript -->



<script>
    $(document).ready(function () {
        $(".card-header").click(function () {
            // self clicking close
            if ($(this).next(".card-body").hasClass("active")) {
                $(this).next(".card-body").removeClass("active").slideUp()
                $(this).children("span").removeClass("fa-chevron-down").addClass("fa-chevron-up")
            } else {
                $(".card_1 .card-body").removeClass("active").slideUp()
                $(".card_1 .card-header span").removeClass("fa-chevron-down").addClass("fa-chevron-up");
                $(this).next(".card-body").addClass("active").slideDown()
                $(this).children("span").removeClass("fa-plus").addClass("fa-chevron-down")
            }
        })
    })
</script>

<script>
    AOS.init();
</script>

</body>

</html>