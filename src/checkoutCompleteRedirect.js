document.addEventListener('DOMContentLoaded', function () {
    if (window.Shopify && Shopify.checkout) {
        // URL to redirect to
        var redirectUrl = 'http://localhost:5173/complete';

        // Function to handle the redirect
        function handleRedirect() {
            window.location.href = redirectUrl;
        }

        // Listen for the order confirmation event
        document.addEventListener('shopify:checkout:order-confirmation', handleRedirect);
    }
});
