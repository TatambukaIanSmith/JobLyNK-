<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nearby Jobs - JOB-lyNK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map { height: 500px; width: 100%; border-radius: 12px; }
        .job-card { transition: all 0.3s ease; }
        .job-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        /* Hide navbar search on this page */
        nav form { display: none !important; }
        
        /* Force navbar to have blue gradient background */
        nav {
            background: linear-gradient(to right, #1e40af, #3b82f6, #1e3a8a) !important;
            backdrop-filter: blur(12px) !important;
        }
        
        /* Ensure navbar text is white */
        nav a, nav button, nav span {
            color: white !important;
        }
        
        /* Keep the logo container white */
        nav .bg-white {
            background-color: white !important;
        }
        
        /* Keep the Get Started button yellow */
        nav .bg-yellow-400 {
            background-color: #fbbf24 !important;
            color: #1e3a8a !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('includes.navbar')

    <div class="container mx-auto px-4 py-8 mt-20">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <i class="fas fa-map-marker-alt text-blue-600"></i> Nearby Jobs
            </h1>
            <p class="text-gray-600">Discover jobs near your location</p>
        </div>

        <div id="locationStatus" class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                <div>
                    <p class="font-semibold text-yellow-800">Location Access Required</p>
                    <p class="text-sm text-yellow-700">Please enable location access to see nearby jobs</p>
                </div>
                <button onclick="requestLocation()" class="ml-auto bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                    Enable Location
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <!-- Location Search Bar -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search"></i> Search Location
                </label>
                <div class="flex gap-2">
                    <div class="flex-1 relative">
                        <input type="text" id="locationSearch" 
                               placeholder="Search for a city or area (e.g., Kampala, Entebbe, Mukono)"
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button onclick="searchLocation()" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <button onclick="requestLocation()" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 whitespace-nowrap">
                        <i class="fas fa-crosshairs"></i> Use My Location
                    </button>
                </div>
                <div id="searchSuggestions" class="mt-2 hidden">
                    <div class="flex flex-wrap gap-2">
                        <button onclick="quickSearch('Kampala')" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-sm">
                            📍 Kampala
                        </button>
                        <button onclick="quickSearch('Entebbe')" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-sm">
                            📍 Entebbe
                        </button>
                        <button onclick="quickSearch('Mukono')" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-sm">
                            📍 Mukono
                        </button>
                        <button onclick="quickSearch('Jinja')" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-sm">
                            📍 Jinja
                        </button>
                        <button onclick="quickSearch('Mbarara')" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-sm">
                            📍 Mbarara
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">View</label>
                    <div class="flex gap-2">
                        <button onclick="showMapView()" id="mapViewBtn" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg">
                            <i class="fas fa-map"></i> Map
                        </button>
                        <button onclick="showListView()" id="listViewBtn" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">
                            <i class="fas fa-list"></i> List
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Radius (km)</label>
                    <select id="radiusSelect" onchange="updateRadius()" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="5">5 km</option>
                        <option value="10" selected>10 km</option>
                        <option value="15">15 km</option>
                        <option value="20">20 km</option>
                        <option value="50">50 km</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select id="sortSelect" onchange="updateSort()" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="distance">Nearest First</option>
                        <option value="newest">Newest First</option>
                        <option value="pay">Highest Pay</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button onclick="refreshJobs()" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between text-sm">
                <div class="flex items-center gap-4">
                    <span class="text-gray-600">
                        <i class="fas fa-briefcase text-blue-600"></i> 
                        <span id="jobCount">0</span> jobs found
                    </span>
                    <span class="text-gray-600" id="locationInfo">
                        <i class="fas fa-location-arrow text-green-600"></i> 
                        Location: <span id="userLocation">Unknown</span>
                    </span>
                </div>
                <button onclick="openAvailabilitySettings()" class="text-blue-600 hover:text-blue-700">
                    <i class="fas fa-cog"></i> Availability Settings
                </button>
            </div>
        </div>

        <div id="mapView" class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div id="map"></div>
        </div>

        <div id="listView" class="hidden">
            <div id="jobsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            </div>
        </div>

        <div id="loading" class="text-center py-12 hidden">
            <i class="fas fa-spinner fa-spin text-4xl text-blue-600 mb-4"></i>
            <p class="text-gray-600">Finding nearby jobs...</p>
        </div>

        <div id="noJobs" class="text-center py-12 hidden">
            <i class="fas fa-map-marked-alt text-6xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-600 mb-2">No jobs found nearby</p>
            <p class="text-gray-500">Try increasing your search radius</p>
        </div>
    </div>

    <div id="availabilityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-user-clock text-blue-600"></i> Availability Settings
                    </h3>
                    <button onclick="closeAvailabilitySettings()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-6">
                <form id="availabilityForm">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                        <select id="statusSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="available">Available for Work</option>
                            <option value="busy">Busy</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Maximum Travel Distance: <span id="distanceValue">10</span> km
                        </label>
                        <input type="range" id="maxDistance" min="1" max="50" value="10" 
                               oninput="document.getElementById('distanceValue').textContent = this.value"
                               class="w-full">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Acceptable Pay (UGX)</label>
                        <input type="number" id="minPay" placeholder="e.g., 50000" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="instantNotifications" checked class="mr-2">
                            <span class="text-sm font-medium text-gray-700">
                                Enable instant notifications for nearby jobs
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        <i class="fas fa-save"></i> Save Settings
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let map, userMarker;
        let jobMarkers = [];
        let currentJobs = [];
        let userLat, userLng;

        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            requestLocation();
        });

        function initMap() {
            map = L.map('map').setView([0.3476, 32.5825], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
        }

        function requestLocation() {
            if (navigator.geolocation) {
                document.getElementById('loading').classList.remove('hidden');
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        userLat = position.coords.latitude;
                        userLng = position.coords.longitude;
                        
                        // Update location on server first, then load jobs
                        updateWorkerLocation(userLat, userLng)
                            .then(() => {
                                // Location saved successfully, now load jobs
                                map.setView([userLat, userLng], 13);
                                
                                if (userMarker) map.removeLayer(userMarker);
                                
                                userMarker = L.marker([userLat, userLng], {
                                    icon: L.divIcon({
                                        className: 'custom-div-icon',
                                        html: "<div style='background-color:#4CAF50;width:20px;height:20px;border-radius:50%;border:3px solid white;box-shadow:0 2px 5px rgba(0,0,0,0.3);'></div>",
                                        iconSize: [20, 20],
                                        iconAnchor: [10, 10]
                                    })
                                }).addTo(map);
                                
                                const popupContent = `
                                    <div style="min-width:200px;">
                                        <b style="display:block;margin-bottom:8px;">Your Location</b>
                                        <input type="text" 
                                               id="popupLocationSearch" 
                                               placeholder="Search new location..." 
                                               style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;margin-bottom:6px;"
                                               onkeypress="if(event.key==='Enter'){const val=this.value;if(val){document.getElementById('locationSearch').value=val;searchLocation();map.closePopup();}}"
                                        />
                                        <small style="color:#666;">Type and press Enter to search</small>
                                    </div>
                                `;
                                userMarker.bindPopup(popupContent).openPopup();
                                document.getElementById('userLocation').textContent = `${userLat.toFixed(4)}, ${userLng.toFixed(4)}`;
                                
                                // Now load nearby jobs
                                loadNearbyJobs();
                            })
                            .catch(error => {
                                document.getElementById('loading').classList.add('hidden');
                                alert('Failed to update location. Please try again.');
                            });
                    },
                    function(error) {
                        document.getElementById('loading').classList.add('hidden');
                        document.getElementById('locationStatus').classList.remove('hidden');
                        console.error('Geolocation error:', error);
                    }
                );
            } else {
                alert('Geolocation is not supported by your browser');
            }
        }

        function updateWorkerLocation(lat, lng) {
            console.log('Updating worker location:', { lat, lng });
            
            return fetch('/api/location/update-worker', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ latitude: lat, longitude: lng })
            })
            .then(response => {
                console.log('Update location response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Location update response:', data);
                if (!data.success) {
                    console.error('Location update failed:', data.message);
                    throw new Error(data.message || 'Failed to update location');
                }
                return data;
            })
            .catch(error => {
                console.error('Error updating location:', error);
                throw error;
            });
        }

        function loadNearbyJobs() {
            const radius = document.getElementById('radiusSelect').value;
            const sortBy = document.getElementById('sortSelect').value;
            
            console.log('Loading nearby jobs:', { radius, sortBy, userLat, userLng });
            
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('noJobs').classList.add('hidden');
            
            fetch(`/api/location/job-radar?radius=${radius}&sort_by=${sortBy}`)
                .then(response => {
                    console.log('Job radar response status:', response.status);
                    if (!response.ok) {
                        // Handle error responses
                        return response.json().then(data => {
                            console.error('Job radar error:', data);
                            throw new Error(data.message || 'Failed to load jobs');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Job radar data:', data);
                    document.getElementById('loading').classList.add('hidden');
                    
                    if (data.success) {
                        currentJobs = data.jobs;
                        document.getElementById('jobCount').textContent = data.jobs.length;
                        
                        if (data.jobs.length === 0) {
                            document.getElementById('noJobs').classList.remove('hidden');
                            console.log('No jobs found in radius');
                        } else {
                            console.log(`Found ${data.jobs.length} jobs`);
                            displayJobsOnMap(data.jobs);
                            displayJobsList(data.jobs);
                        }
                    }
                })
                .catch(error => {
                    document.getElementById('loading').classList.add('hidden');
                    console.error('Error loading jobs:', error);
                    
                    // Show a user-friendly error message
                    alert('Unable to load nearby jobs. Please make sure location access is enabled and try again.');
                });
        }

        function displayJobsOnMap(jobs) {
            // Clear existing markers
            jobMarkers.forEach(marker => map.removeLayer(marker));
            jobMarkers = [];
            
            // Apply sorting to map display as well
            const sortBy = document.getElementById('sortSelect').value;
            let sortedJobs = [...jobs];
            
            if (sortBy === 'distance') {
                sortedJobs.sort((a, b) => a.distance - b.distance);
            } else if (sortBy === 'newest') {
                sortedJobs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            } else if (sortBy === 'pay') {
                sortedJobs.sort((a, b) => parseFloat(b.budget) - parseFloat(a.budget));
            }
            
            // Add markers for each job
            sortedJobs.forEach((job, index) => {
                if (job.latitude && job.longitude) {
                    // Create custom icon with number to show order
                    const marker = L.marker([job.latitude, job.longitude], {
                        icon: L.divIcon({
                            className: 'custom-marker',
                            html: `<div style="background-color:#2196F3;width:32px;height:32px;border-radius:50%;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;font-size:14px;">${index + 1}</div>`,
                            iconSize: [32, 32],
                            iconAnchor: [16, 16]
                        })
                    }).addTo(map);
                    
                    // Create popup with job details
                    marker.bindPopup(`
                        <div style="min-width:220px;">
                            <div style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:white;padding:8px;margin:-9px -9px 8px -9px;border-radius:4px 4px 0 0;">
                                <h3 style="font-weight:bold;margin:0;font-size:16px;">#${index + 1} ${job.title}</h3>
                            </div>
                            <p style="color:#666;font-size:13px;margin-bottom:6px;">
                                <i class="fas fa-map-marker-alt" style="color:#2196F3;"></i> <strong>${job.distance} km</strong> away
                            </p>
                            <p style="color:#666;font-size:13px;margin-bottom:6px;">
                                <i class="fas fa-money-bill-wave" style="color:#4CAF50;"></i> <strong>UGX ${parseInt(job.budget).toLocaleString()}</strong>
                            </p>
                            <p style="color:#666;font-size:13px;margin-bottom:8px;">
                                <i class="fas fa-clock" style="color:#FF9800;"></i> ${new Date(job.created_at).toLocaleDateString()}
                            </p>
                            <a href="/jobs/${job.id}" style="display:block;background:#2196F3;color:white;padding:8px 12px;border-radius:6px;text-decoration:none;font-size:13px;text-align:center;font-weight:600;">
                                View Details →
                            </a>
                        </div>
                    `);
                    
                    jobMarkers.push(marker);
                }
            });
            
            // Auto-fit map to show all markers if there are jobs
            if (sortedJobs.length > 0 && sortedJobs.some(job => job.latitude && job.longitude)) {
                const bounds = L.latLngBounds(
                    sortedJobs
                        .filter(job => job.latitude && job.longitude)
                        .map(job => [job.latitude, job.longitude])
                );
                // Include user location in bounds
                if (userLat && userLng) {
                    bounds.extend([userLat, userLng]);
                }
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        }

        function displayJobsList(jobs) {
            const jobsList = document.getElementById('jobsList');
            jobsList.innerHTML = '';
            
            // Apply client-side sorting based on current selection
            const sortBy = document.getElementById('sortSelect').value;
            let sortedJobs = [...jobs];
            
            if (sortBy === 'distance') {
                sortedJobs.sort((a, b) => a.distance - b.distance);
            } else if (sortBy === 'newest') {
                sortedJobs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            } else if (sortBy === 'pay') {
                sortedJobs.sort((a, b) => parseFloat(b.budget) - parseFloat(a.budget));
            }
            
            sortedJobs.forEach(job => {
                jobsList.innerHTML += `
                    <div class="job-card bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800">${job.title}</h3>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                ${job.distance} km
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">${job.description ? job.description.substring(0, 100) + '...' : 'No description'}</p>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt w-5"></i>
                                <span>${job.location}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-money-bill-wave w-5"></i>
                                <span>UGX ${parseInt(job.budget).toLocaleString()}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock w-5"></i>
                                <span>${new Date(job.created_at).toLocaleDateString()}</span>
                            </div>
                        </div>
                        <a href="/jobs/${job.id}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                            View Details
                        </a>
                    </div>
                `;
            });
        }

        function showMapView() {
            document.getElementById('mapView').classList.remove('hidden');
            document.getElementById('listView').classList.add('hidden');
            document.getElementById('mapViewBtn').classList.add('bg-blue-600', 'text-white');
            document.getElementById('mapViewBtn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('listViewBtn').classList.add('bg-gray-200', 'text-gray-700');
            document.getElementById('listViewBtn').classList.remove('bg-blue-600', 'text-white');
            setTimeout(() => map.invalidateSize(), 100);
        }

        function showListView() {
            document.getElementById('mapView').classList.add('hidden');
            document.getElementById('listView').classList.remove('hidden');
            document.getElementById('listViewBtn').classList.add('bg-blue-600', 'text-white');
            document.getElementById('listViewBtn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('mapViewBtn').classList.add('bg-gray-200', 'text-gray-700');
            document.getElementById('mapViewBtn').classList.remove('bg-blue-600', 'text-white');
        }

        function updateRadius() { 
            loadNearbyJobs(); // Reload jobs from server with new radius
        }
        
        function updateSort() { 
            // Re-display both map and list with new sorting without reloading from server
            if (currentJobs.length > 0) {
                displayJobsOnMap(currentJobs); // Update map markers
                displayJobsList(currentJobs);  // Update list
            }
        }
        
        function refreshJobs() { 
            requestLocation(); // Get fresh location and reload all jobs
        }

        // Location Search Functions
        function searchLocation() {
            const query = document.getElementById('locationSearch').value.trim();
            if (!query) {
                alert('Please enter a location to search');
                return;
            }
            
            document.getElementById('loading').classList.remove('hidden');
            
            // Use Nominatim geocoding API (free, no API key needed)
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}, Uganda&limit=1`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);
                        
                        // Update user location variables
                        userLat = lat;
                        userLng = lng;
                        
                        // Update location on server
                        updateWorkerLocation(lat, lng)
                            .then(() => {
                                // Center map on searched location
                                map.setView([lat, lng], 13);
                                
                                // Update user marker
                                if (userMarker) map.removeLayer(userMarker);
                                
                                userMarker = L.marker([lat, lng], {
                                    icon: L.divIcon({
                                        className: 'custom-div-icon',
                                        html: "<div style='background-color:#4CAF50;width:20px;height:20px;border-radius:50%;border:3px solid white;box-shadow:0 2px 5px rgba(0,0,0,0.3);'></div>",
                                        iconSize: [20, 20],
                                        iconAnchor: [10, 10]
                                    })
                                }).addTo(map);
                                
                                const popupContent = `
                                    <div style="min-width:220px;">
                                        <b style="display:block;margin-bottom:4px;">Searched Location</b>
                                        <small style="display:block;color:#666;margin-bottom:8px;">${data[0].display_name}</small>
                                        <input type="text" 
                                               id="popupLocationSearch" 
                                               placeholder="Search new location..." 
                                               style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;margin-bottom:6px;"
                                               onkeypress="if(event.key==='Enter'){const val=this.value;if(val){document.getElementById('locationSearch').value=val;searchLocation();map.closePopup();}}"
                                        />
                                        <small style="color:#666;">Type and press Enter to search</small>
                                    </div>
                                `;
                                userMarker.bindPopup(popupContent).openPopup();
                                document.getElementById('userLocation').textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                                
                                // Load jobs near this location
                                loadNearbyJobs();
                            });
                    } else {
                        document.getElementById('loading').classList.add('hidden');
                        alert('Location not found. Try: Kampala, Entebbe, Mukono, Jinja, or Mbarara');
                    }
                })
                .catch(error => {
                    document.getElementById('loading').classList.add('hidden');
                    console.error('Geocoding error:', error);
                    alert('Error searching location. Please try again.');
                });
        }

        // Quick search for popular locations
        function quickSearch(location) {
            document.getElementById('locationSearch').value = location;
            searchLocation();
        }

        // Allow Enter key to search
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('locationSearch')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchLocation();
                }
            });
            
            // Show suggestions on focus
            document.getElementById('locationSearch')?.addEventListener('focus', function() {
                document.getElementById('searchSuggestions').classList.remove('hidden');
            });
        });

        function openAvailabilitySettings() {
            document.getElementById('availabilityModal').classList.remove('hidden');
            loadAvailabilitySettings();
        }

        function closeAvailabilitySettings() {
            document.getElementById('availabilityModal').classList.add('hidden');
        }

        function loadAvailabilitySettings() {
            fetch('/api/availability-zone')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.availability) {
                        document.getElementById('statusSelect').value = data.availability.status || 'available';
                        document.getElementById('maxDistance').value = data.availability.max_travel_distance || 10;
                        document.getElementById('distanceValue').textContent = data.availability.max_travel_distance || 10;
                        document.getElementById('minPay').value = data.availability.minimum_pay || '';
                        document.getElementById('instantNotifications').checked = data.availability.instant_notifications !== false;
                    }
                });
        }

        document.getElementById('availabilityForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch('/api/availability-zone', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    status: document.getElementById('statusSelect').value,
                    max_travel_distance: parseInt(document.getElementById('maxDistance').value),
                    minimum_pay: document.getElementById('minPay').value || null,
                    instant_notifications: document.getElementById('instantNotifications').checked
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Settings saved successfully!');
                    closeAvailabilitySettings();
                }
            });
        });
    </script>
</body>
</html>
