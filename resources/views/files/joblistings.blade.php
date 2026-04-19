<?php
require_once 'config.php'; 

// Fetch all active jobs from the database
$sql = "SELECT j.*, u.id AS employer_id FROM jobs j 
        JOIN users u ON j.employer_id = u.id 
        WHERE j.status = 'Active' ORDER BY j.posted_at DESC";

try {
    $stmt = $pdo->query($sql);
    $jobs = $stmt->fetchAll();
} catch (PDOException $e) {
    $jobs = [];
    $db_error = "Could not load jobs: " . $e->getMessage();
}

$success_message = $_SESSION['post_success'] ?? null;
unset($_SESSION['post_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Feed - JOB-lyNK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Custom Tailwind Configuration (same as others)
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue-primary': '#1e40af', 'blue-secondary': '#3b82f6', 
                        'blue-light': '#dbeafe', 'blue-dark': '#1e3a8a' 
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
                    <a href="/home" class="text-white text-2xl font-bold">JOB-lyNK</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/login" class="text-blue-light hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Current Job Listings</h1>

        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline"><?php echo htmlspecialchars($success_message); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($jobs)): ?>
            <div class="space-y-6">
                <?php foreach ($jobs as $job): ?>
                    <div class="bg-white shadow overflow-hidden rounded-lg p-6 hover:shadow-lg transition duration-300">
                        <div class="flex justify-between items-start">
                            <h2 class="text-xl font-bold text-blue-primary"><?php echo htmlspecialchars($job['title']); ?></h2>
                            <span class="text-sm font-semibold text-gray-700 bg-blue-light px-3 py-1 rounded-full">
                                <?php echo htmlspecialchars($job['job_type']); ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1 mb-3">
                            <i class="fas fa-map-marker-alt mr-1"></i> <?php echo htmlspecialchars($job['location']); ?>
                        </p>
                        
                        <div class="text-sm text-gray-700 line-clamp-3 mb-4">
                            <?php echo nl2br(htmlspecialchars($job['description'])); ?>
                        </div>

                        <div class="flex justify-between items-center border-t pt-3">
                            <div class="text-lg font-bold text-green-600">
                                <?php 
                                    $salary = '';
                                    if ($job['salary_min'] && $job['salary_max']) {
                                        $salary = '$' . number_format($job['salary_min']) . ' - $' . number_format($job['salary_max']);
                                    } elseif ($job['salary_min']) {
                                        $salary = 'Starting $' . number_format($job['salary_min']);
                                    }
                                    echo htmlspecialchars($salary . ' (' . $job['salary_type'] . ')');
                                ?>
                            </div>
                            <a href="apply.html?job_id=<?php echo $job['id']; ?>" class="bg-blue-secondary text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-dark transition duration-300">
                                Apply Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-8 text-center bg-white rounded-lg shadow-md">
                <i class="fas fa-search-dollar text-4xl text-gray-400 mb-4"></i>
                <p class="text-lg text-gray-600">No active job listings found at this time.</p>
                <?php if (isset($db_error)): ?>
                    <p class="text-sm text-red-500 mt-2">Error: <?php echo htmlspecialchars($db_error); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>

    // ... (Previous PHP and HTML setup remains the same) ...

<div class="bg-white shadow overflow-hidden rounded-lg p-6 hover:shadow-lg transition duration-300">
    <div class="flex justify-between items-start">
        <h2 class="text-xl font-bold text-blue-primary"><?php echo htmlspecialchars($job['title']); ?></h2>
        <span class="text-sm font-semibold text-gray-700 bg-blue-light px-3 py-1 rounded-full">
            <?php echo htmlspecialchars($job['job_type']); ?>
        </span>
    </div>
    <p class="text-sm text-gray-500 mt-1 mb-3">
        <i class="fas fa-map-marker-alt mr-1"></i> <?php echo htmlspecialchars($job['location']); ?>
    </p>
    
    <div class="text-sm text-gray-700 line-clamp-3 mb-4">
        <?php echo nl2br(htmlspecialchars($job['description'])); ?>
    </div>

    <div class="flex justify-between items-center border-t pt-3">
        <div class="text-lg font-bold text-green-600">
            <?php 
                // ... (Salary display code) ...
                $salary = '';
                if ($job['salary_min'] && $job['salary_max']) {
                    $salary = '$' . number_format($job['salary_min']) . ' - $' . number_format($job['salary_max']);
                } elseif ($job['salary_min']) {
                    $salary = 'Starting $' . number_format($job['salary_min']);
                }
                echo htmlspecialchars($salary . ' (' . $job['salary_type'] . ')');
            ?>
        </div>
        
        <div class="space-x-2 flex items-center">
            
            <button id="like-btn-<?php echo $job['id']; ?>" data-job-id="<?php echo $job['id']; ?>"
                class="like-button bg-gray-200 text-red-500 hover:bg-gray-300 py-2 px-3 rounded-lg transition duration-300"
                title="Like this job">
                <i class="far fa-heart"></i> </button>

            <a href="/messages?employer_id=<?php echo $job['employer_id']; ?>&job_id=<?php echo $job['id']; ?>" 
                class="bg-blue-secondary text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-dark transition duration-300">
                <i class="fas fa-comment-dots mr-1"></i> Message Employer
            </a>
            
            <a href="/applicationForm?job_id=<?php echo $job['id']; ?>" class="bg-blue-primary text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-dark transition duration-300">
                Apply Now 
            </a>
        </div>
    </div>
</div>
</body>
</html>