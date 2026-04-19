# How to Access Nearby Jobs Feature

## 🎯 Quick Access Methods

### Method 1: Worker Dashboard Sidebar (Recommended)
1. Log in as a **Worker**
2. Go to your Worker Dashboard
3. Look at the left sidebar
4. Click on **"Nearby Jobs"** (highlighted with a green badge that says "NEW")
5. The feature is located right below "My Profile"

### Method 2: Top Navigation Bar
1. Log in as a **Worker**
2. Look at the top navigation bar
3. Click on **"Nearby Jobs"** (between "Jobs" and "How It Works")
4. Has a green "NEW" badge

### Method 3: Direct URL
Simply navigate to:
```
http://127.0.0.1:8000/nearby-jobs
```
(You must be logged in as a worker)

## 📍 What You'll See

When you access the Nearby Jobs page, you'll get:

### 1. Location Request
- Browser will ask for location permission
- Click "Allow" to enable location-based job matching
- Your location will be shown on the map with a green marker

### 2. Interactive Map View
- **Your Location**: Green marker showing where you are
- **Job Locations**: Blue markers showing nearby jobs
- Click any job marker to see:
  - Job title
  - Distance from you
  - Pay amount
  - "View Details" button

### 3. Control Panel
- **View Toggle**: Switch between Map and List view
- **Radius Selector**: Choose search radius (5, 10, 15, 20, or 50 km)
- **Sort Options**: 
  - Nearest First (default)
  - Newest First
  - Highest Pay
- **Refresh Button**: Update your location and reload jobs

### 4. List View
- Grid of job cards showing:
  - Job title
  - Distance from your location
  - Job description
  - Location
  - Pay amount
  - "View Details" button

### 5. Availability Settings
- Click the "Availability Settings" button (gear icon)
- Configure:
  - **Current Status**: Available, Busy, or Unavailable
  - **Maximum Travel Distance**: Slider from 1-50 km
  - **Minimum Acceptable Pay**: Set your minimum rate
  - **Instant Notifications**: Enable/disable alerts for nearby jobs

## 🔧 Features

### Real-Time Location Tracking
- Your location updates automatically
- Jobs are filtered based on your current position
- Distance calculations are precise (using Haversine formula)

### Smart Filtering
- Only shows jobs within your selected radius
- Respects your availability settings
- Filters by your maximum travel distance preference

### Performance
- Uses geohashing for ultra-fast searches
- Spatial database queries for efficiency
- Can handle thousands of jobs without lag

## 📱 Mobile Support

The Nearby Jobs feature works great on mobile:
- Responsive design adapts to screen size
- Uses device GPS for accurate location
- Touch-friendly map controls
- Swipe-friendly list view

## 🚨 Troubleshooting

### "Location Access Required" Message
**Problem**: Browser blocked location access
**Solution**: 
1. Click "Enable Location" button
2. Or manually enable in browser settings
3. Refresh the page

### No Jobs Showing
**Problem**: No jobs found in your radius
**Solution**:
1. Increase search radius (try 20-50 km)
2. Check if you're in an area with posted jobs
3. Try refreshing your location

### Map Not Loading
**Problem**: Map appears blank
**Solution**:
1. Check internet connection
2. Refresh the page
3. Clear browser cache

## 🎓 Tips for Best Experience

1. **Enable Location Sharing**: Always allow location access for accurate results
2. **Set Realistic Radius**: Start with 10 km, adjust based on results
3. **Update Availability**: Keep your status current to get relevant matches
4. **Check Regularly**: New jobs are added frequently
5. **Use Map View**: Visual representation helps understand job distribution
6. **Save Preferences**: Your settings are saved automatically

## 🔐 Privacy & Security

- Your exact location is never shared with employers
- Only approximate distance is shown
- You control location sharing via settings
- Location data is encrypted
- You can disable location sharing anytime

## 📊 What Employers See

When you enable location sharing:
- Employers see you're "nearby" (not exact location)
- They see approximate distance (e.g., "5 km away")
- Your profile appears in their "nearby workers" search
- Increases your chances of getting matched

## 🎯 Next Steps

After finding a nearby job:
1. Click "View Details" to see full job description
2. Review requirements and pay
3. Click "Apply" if interested
4. Track application in "My Applications"

## 💡 Pro Tips

- **Morning Check**: Check nearby jobs in the morning for new postings
- **Set Alerts**: Enable instant notifications for immediate updates
- **Flexible Radius**: Adjust radius based on urgency and availability
- **Update Location**: Refresh location if you move to a different area
- **Availability Status**: Set to "Available" when actively looking for work

## 📞 Need Help?

If you encounter any issues:
1. Check this guide first
2. Try refreshing the page
3. Clear browser cache
4. Contact support if problem persists

---

**Enjoy discovering jobs near you! 🚀**
