<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - JOB-lyNK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Custom Tailwind Configuration to match the project's color palette
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue-primary': '#1e40af', 
                        'blue-secondary': '#3b82f6', 
                        'blue-light': '#dbeafe', 
                        'blue-dark': '#1e3a8a' 
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    
    <nav class="bg-blue-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.html" class="text-white text-2xl font-bold">JOB-lyNK</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="employer-dashboard.html" class="text-blue-light hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    <a href="logout.php" class="bg-blue-secondary text-white hover:bg-blue-dark px-3 py-2 rounded-md text-sm font-medium transition duration-300">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden rounded-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-3">Post a New Job</h1>

            <form action="post_job.php" method="POST" class="space-y-6">
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                    <input type="text" id="title" name="title" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent"
                        placeholder="e.g., Senior PHP Developer" maxlength="255">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
                    <textarea id="description" name="description" rows="6" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent"
                        placeholder="Detail the responsibilities, requirements, and benefits of the role."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="job_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select id="job_type" name="job_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            <option value="">Select Job Type</option>
                            <option value="Full-Time">Full-Time</option>
                            <option value="Part-Time">Part-Time</option>
                            <option value="Contract">Contract</option>
                        </select>
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" id="location" name="location" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent"
                            placeholder="e.g., Remote, San Francisco, CA">
                    </div>
                    <div>
                        <label for="salary_type" class="block text-sm font-medium text-gray-700 mb-1">Salary Basis</label>
                        <select id="salary_type" name="salary_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            <option value="">Select Basis</option>
                            <option value="Annual">Annual</option>
                            <option value="Hourly">Hourly</option>
                            <option value="Fixed">Fixed Project Rate</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-1">Minimum Compensation (Optional)</label>
                        <input type="number" id="salary_min" name="salary_min" step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent"
                            placeholder="e.g., 50000 or 25.00">
                    </div>
                    <div>
                        <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-1">Maximum Compensation (Optional)</label>
                        <input type="number" id="salary_max" name="salary_max" step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent"
                            placeholder="e.g., 75000 or 40.00">
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-blue-primary text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-dark transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-primary focus:ring-offset-2">
                    <i class="fas fa-paper-plane mr-2"></i> Post Job Now
                </button>
            </form>
        </div>
    </main>

</body>
</html>