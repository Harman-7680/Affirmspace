<!-- Terms Content -->
<div class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed">
    <h1 class="text-2xl font-bold mb-4">📄 Terms and Conditions – AffirmSpace</h1>

    <p class="mt-4">
        Welcome to <strong>AffirmSpace</strong>—a safe and inclusive social platform and counselling space designed
        especially for LGBTQ+ individuals.
        By accessing or using AffirmSpace, you agree to the following Terms and Conditions. If you do not agree, please
        do not use the platform.
    </p>

    <h2 class="text-lg font-semibold mt-6 mb-2">1. Eligibility</h2>
    <ul class="list-disc list-inside">
        <li>You must be at least 18 years old to register and use AffirmSpace.</li>
    </ul>

    <h2 class="text-lg font-semibold mt-6 mb-2">2. Account & Identity</h2>
    <ul class="list-disc list-inside">
        <li>You are responsible for maintaining the confidentiality of your login credentials.</li>
        <li>You may not impersonate others or create accounts for anyone other than yourself without permission.</li>
    </ul>

    <h2 class="text-lg font-semibold mt-6 mb-2">3. Safe Space Policy</h2>
    <ul class="list-disc list-inside">
        <li>AffirmSpace is a platform built for LGBTQ+ safety and expression. Harassment, hate speech, bullying, or
            discrimination of any kind will result in immediate removal.</li>
    </ul>

    <h2 class="text-lg font-semibold mt-6 mb-2">✅ Acceptance</h2>
    <p>By clicking "I Agree" or using the platform, you confirm that you understand and accept these Terms and
        Conditions.</p>
</div>

<script>
    function openModal() {
        document.getElementById("termsModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("termsModal").classList.add("hidden");
    }

    function acceptTerms() {
        let termsCheckbox = document.getElementById("accept-terms");
        if (termsCheckbox) {
            termsCheckbox.checked = true;
        }
        closeModal();
    }
</script>
