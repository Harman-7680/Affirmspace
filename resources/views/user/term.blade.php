<!-- Terms Content -->
<div class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed h-[400px] overflow-y-auto pr-3 custom-scroll">

    <h1 class="text-2xl font-bold mb-4">📄 Terms and Conditions – AffirmSpace</h1>

    <p class="mt-4">
        Welcome to <strong>AffirmSpace</strong>—a safe and inclusive platform for LGBTQ+ individuals to connect,
        express,
        and access counselling services.
        By using AffirmSpace, you agree to follow these Terms and Conditions.
    </p>

    <!-- 1 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">1. Eligibility (18+ Only)</h2>
    <ul class="list-disc list-inside">
        <li>You must be at least 18 years old to use AffirmSpace.</li>
        <li>Accounts found underage will be removed without notice.</li>
    </ul>

    <!-- 2 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">2. User Accounts</h2>
    <ul class="list-disc list-inside">
        <li>You are responsible for maintaining your account credentials.</li>
        <li>All activity under your account is your responsibility.</li>
    </ul>

    <!-- 3 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">3. Community Guidelines</h2>
    <ul class="list-disc list-inside">
        <li>No harassment, abuse, or hate speech</li>
        <li>No discrimination based on identity</li>
        <li>No illegal or harmful content</li>
        <li>No impersonation or fraud</li>
    </ul>

    <!-- 4 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">4. Counselling Disclaimer</h2>
    <p>
        Counselling services are supportive in nature and do not guarantee outcomes.
        AffirmSpace is not a substitute for medical or psychiatric treatment and is not for emergencies.
    </p>

    <!-- 5 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">5. Payments</h2>
    <p>
        Paid services must be completed through approved payment methods. By making a payment, you agree to pricing and
        billing terms.
    </p>

    <!-- 6 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">6. Refund Policy</h2>
    <p>
        Refunds are handled according to our official policy.
        <a href="/refundpolicy" class="text-orange-600">View Refund Policy</a>
    </p>

    <!-- 7 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">7. User Content</h2>
    <p>
        You are responsible for all content you post. AffirmSpace may remove content that violates guidelines.
    </p>

    <!-- 8 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">8. Account Suspension</h2>
    <p>
        We reserve the right to suspend or terminate accounts for violations or misuse. No refunds will be issued in
        such cases.
    </p>

    <!-- 9 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">9. Privacy</h2>
    <p>
        Your data is handled according to our Privacy Policy.
        <a href="/privacy" class="text-orange-600">View Privacy Policy</a>
    </p>

    <!-- 10 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">10. Limitation of Liability</h2>
    <p>
        AffirmSpace is not responsible for user interactions, disputes, or outcomes.
    </p>

    <!-- 11 -->
    <h2 class="text-lg font-semibold mt-6 mb-2">11. Governing Law</h2>
    <p>
        These terms are governed by the laws of India.
    </p>

    <!-- Contact -->
    <h2 class="text-lg font-semibold mt-6 mb-2">Contact</h2>
    <p>Email: <strong>affirmspace@gmail.com</strong></p>

    <!-- Acceptance -->
    <h2 class="text-lg font-semibold mt-6 mb-2">✅ Acceptance</h2>
    <p>
        By clicking "I Agree" or using the platform, you confirm that you understand and accept these Terms.
    </p>

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

<style>
    .custom-scroll {
        -ms-overflow-style: none;
        /* IE & Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    .custom-scroll::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari */
    }
</style>
