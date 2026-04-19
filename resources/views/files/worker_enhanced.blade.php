<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Worker Dashboard - JOB-lyNK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-active { background-color: #374151; color: #3b82f6; font-weight: 600; }
        .job-card { transition: all 0.3s ease; }
        .job-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
