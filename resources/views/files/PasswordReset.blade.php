<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Use Inter font for a clean, modern look */
        .font-\[Inter\] {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex items-center justify-center p-4 font-[Inter]">
        <div class="w-full max-w-md bg-white p-8 md:p-10 shadow-2xl rounded-2xl border border-gray-100">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Forgot Password</h1>
                <p class="text-gray-500 text-sm">
                    Enter your email address below and we'll send you a link to reset your password.
                </p>
            </div>

            <form id="forgot-password-form" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <input
                        id="email"
                        type="email"
                        required
                        class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out"
                        placeholder="you@example.com"
                    />
                </div>

                <!-- Message Container (hidden by default) -->
                <div id="message-container" class="hidden p-3 border rounded-xl text-sm" role="alert">
                    <!-- Message content will be inserted here by JavaScript -->
                </div>

                <button
                    id="submit-button"
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white transition duration-300 ease-in-out bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:shadow-xl"
                >
                    Send Reset Link
                </button>
            </form>

            <div class="mt-6 text-center">
                <!-- Mock link back to the login page -->
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition duration-150">
                    Remembered your password? Log In
                </a>
            </div>
        </div>
    </div>

    <script>
        // --- DOM Elements ---
        const form = document.getElementById('forgot-password-form');
        const emailInput = document.getElementById('email');
        const submitButton = document.getElementById('submit-button');
        const messageContainer = document.getElementById('message-container');

        // --- Mock API Function (Simulating Network Request) ---
        /**
         * Simulates sending a password reset email.
         * Resolves true for success, false for simulated failure.
         */
        const sendPasswordResetEmail = (email) => {
            return new Promise((resolve) => {
                setTimeout(() => {
                    console.log(`Password reset email simulated for: ${email}`);
                    // Simulate success 90% of the time, failure 10%
                    if (Math.random() > 0.1) {
                        resolve(true);
                    } else {
                        resolve(false);
                    }
                }, 1500);
            });
        };

        // --- UI Update Functions ---

        /**
         * Updates the message container with text and appropriate styling.
         * @param {string} text The message to display.
         * @param {boolean|null} isSuccess True for success (green), false for error (red), null to hide.
         */
        const updateMessage = (text, isSuccess) => {
            messageContainer.textContent = text;

            // Define base classes and state-dependent classes
            const baseClasses = ['p-3', 'border', 'rounded-xl', 'text-sm'];
            let stateClasses = [];

            if (isSuccess === true) {
                stateClasses = ['text-green-600', 'bg-green-50', 'border-green-300'];
                messageContainer.classList.remove('hidden');
            } else if (isSuccess === false) {
                stateClasses = ['text-red-600', 'bg-red-50', 'border-red-300'];
                messageContainer.classList.remove('hidden');
            } else {
                // isSuccess is null or undefined (hide message)
                messageContainer.classList.add('hidden');
                messageContainer.className = ''; // Clear classes to reset
                return;
            }

            // Apply classes
            messageContainer.className = ''; // Reset classes
            messageContainer.classList.add(...baseClasses, ...stateClasses);
        };

        /**
         * Manages the loading state for the button and input.
         * @param {boolean} isLoading True to show spinner/disable, false to revert.
         * @param {boolean} isFinalSuccess True if the process completed successfully.
         */
        const toggleLoading = (isLoading, isFinalSuccess = false) => {
            const defaultText = 'Send Reset Link';
            const finalSuccessText = 'Link Sent!';
            const spinnerSVG = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;

            // Base button classes
            const baseClasses = 'w-full flex justify-center py-2 px-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white transition duration-300 ease-in-out';
            submitButton.className = baseClasses;

            if (isLoading || isFinalSuccess) {
                // Disable input and button
                emailInput.disabled = true;
                submitButton.disabled = true;

                if (isLoading) {
                    submitButton.innerHTML = spinnerSVG + 'Processing...';
                    submitButton.classList.add('bg-indigo-300', 'cursor-not-allowed');
                } else if (isFinalSuccess) {
                    submitButton.textContent = finalSuccessText;
                    submitButton.classList.add('bg-indigo-300', 'cursor-not-allowed');
                }
            } else {
                // Re-enable input and button
                emailInput.disabled = false;
                submitButton.disabled = false;
                submitButton.textContent = defaultText;
                submitButton.classList.add('bg-indigo-600', 'hover:bg-indigo-700', 'focus:outline-none', 'focus:ring-2', 'focus:ring-offset-2', 'focus:ring-indigo-500', 'hover:shadow-xl');
            }
        };


        // --- Main Submit Handler ---
        const handleSubmit = async (event) => {
            event.preventDefault();
            const email = emailInput.value.trim();

            // 1. Reset state
            updateMessage('', null);
            let isSuccess = null;

            if (!email) {
                updateMessage('Please enter your email address.', false);
                return;
            }

            // 2. Start loading
            toggleLoading(true);

            try {
                const result = await sendPasswordResetEmail(email);

                if (result) {
                    updateMessage('Success! Check your inbox for a password reset link.', true);
                    emailInput.value = ''; // Clear email on success
                    isSuccess = true;
                } else {
                    updateMessage('Error: Could not process request. Please try again later.', false);
                    isSuccess = false;
                }
            } catch (error) {
                console.error(error);
                updateMessage('An unexpected error occurred during the reset process.', false);
                isSuccess = false;
            } finally {
                // 3. Stop loading and set final button state
                toggleLoading(false, isSuccess);
            }
        };

        // --- Event Listener ---
        form.addEventListener('submit', handleSubmit);

    </script>
</body>
</html>