<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Apply for a Casual Job</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center">
  <form id="casualJobForm" action="submit-casual-job.php" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-md w-full max-w-xl">
    <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Apply for a Casual Job</h2>

    <label class="block mb-4">
      <span class="text-blue-700 font-semibold">Full Name</span>
      <input type="text" name="full_name" required class="mt-1 block w-full border border-blue-300 rounded-md p-2" />
    </label>

    <label class="block mb-4">
      <span class="text-blue-700 font-semibold">Email Address</span>
      <input type="email" name="email" required class="mt-1 block w-full border border-blue-300 rounded-md p-2" />
    </label>

    <label class="block mb-4">
      <span class="text-blue-700 font-semibold">Phone Number</span>
      <input type="tel" name="phone" required class="mt-1 block w-full border border-blue-300 rounded-md p-2" />
    </label>

    <label class="block mb-4">
      <span class="text-blue-700 font-semibold">Preferred Casual Role</span>
      <select name="role" id="roleSelect" required class="mt-1 block w-full border border-blue-300 rounded-md p-2">
        <option value="">Select a role</option>
        <option value="Event Staff">Event Staff</option>
        <option value="Data Entry">Data Entry</option>
        <option value="Other">Other (specify below)</option>
      </select>
    </label>

    <label class="block mb-4" id="otherRoleField" style="display: none;">
      <span class="text-blue-700 font-semibold">Other Specify Role</span>
      <input type="text" name="other_role" class="mt-1 block w-full border border-blue-300 rounded-md p-2" />
    </label>

    <label class="block mb-4">
      <span class="text-blue-700 font-semibold">Your Availability (e.g., weekends after 5 PM)</span>
      <input type="text" name="availability" required class="mt-1 block w-full border border-blue-300 rounded-md p-2" />
    </label>

    <label class="block mb-4">
      <span class="text-blue-700 font-semibold">Briefly describe your relevant experience</span>
      <textarea name="experience" rows="4" required class="mt-1 block w-full border border-blue-300 rounded-md p-2"></textarea>
    </label>
       <div class="col-span-full">
          <label for="photo" class="block text-sm/6 font-medium text-white">Photo</label>
          <div class="mt-2 flex items-center gap-x-3">
            <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-12 text-gray-500">
              <path d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" fill-rule="evenodd" />
            </svg>
            <button type="button" class="rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20">Change</button>
          </div>
        </div>
        
    <label class="block mb-6">
      <span class="text-blue-700 font-semibold">Upload Your Resume (PDF, DOCX)</span>
      <input type="file" name="resume" accept=".pdf,.doc,.docx" class="mt-1 block w-full" />
    </label>
     <div class="text-center">
              <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true" class="mx-auto size-12 text-gray-600">
                <path d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" fill-rule="evenodd" />
              </svg>
              <div class="mt-4 flex text-sm/6 text-gray-400">
                <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-indigo-400 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-indigo-500 hover:text-indigo-300">
                  <span>Upload a file</span>
                  <input id="file-upload" type="file" name="file-upload" class="sr-only" />
                </label>
                <p class="pl-1">or drag and drop</p>
              </div>
              <p class="text-xs/5 text-gray-400">PNG, JPG, GIF up to 10MB</p>
            </div>
    <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 w-full">Submit Application</button>

    <p id="confirmationMessage" class="text-green-600 mt-4 hidden">Thank you for your application! ✅</p>
    <p id="errorMessage" class="text-red-600 mt-2 hidden">Correct errors and try again.</p>
  </form>

  

  <script>
    const roleSelect = document.getElementById('roleSelect');
    const otherRoleField = document.getElementById('otherRoleField');

    roleSelect.addEventListener('change', function () {
      otherRoleField.style.display = this.value === 'Other' ? 'block' : 'none';
    });

    document.getElementById('casualJobForm').addEventListener('submit', function (e) {
      const name = this.full_name.value.trim();
      const email = this.email.value.trim();
      const phone = this.phone.value.trim();
      if (!name || !email || !phone) {
        e.preventDefault();
        document.getElementById('errorMessage').style.display = 'block';
      }
    });
  </script>
</body>
</html>
