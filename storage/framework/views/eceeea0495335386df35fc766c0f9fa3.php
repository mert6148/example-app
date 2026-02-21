<script idate="contact-script">
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    if (!form) return;

    form.addEventListener("submit", (e) => {
        const name = form.querySelector("input[name='name']").value.trim();
        const email = form.querySelector("input[name='email']").value.trim();
        const message = form.querySelector("textarea[name='message']").value.trim();

        if (name.length < 3) {
            alert("Ad en az 3 karakter olmalıdır.");
            e.preventDefault();
            return;
        }

        if (!email.includes("@")) {
            alert("Geçerli bir e-posta giriniz.");
            e.preventDefault();
            return;
        }

        if (message.length < 10) {
            alert("Mesaj en az 10 karakter olmalıdır.");
            e.preventDefault();
            return;
        }
    });
});
</script>
<?php /**PATH C:\wamp64\www\example-app\resources\views\script.blade.php ENDPATH**/ ?>