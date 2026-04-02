# PRD: Admin Dashboard Analytics System (CG Chartbusters)

## Overview

Enhance the Admin Dashboard of CG Chartbusters into a structured, data-driven analytics system. The dashboard should provide insights into platform growth, content performance, user engagement, and moderation, with real-time updates and visual charts.

---

## Task 1: Platform Analytics

Track overall website traffic and growth metrics.

* Display key metrics:

  * Total Visitors (Today / Week / Month)
  * Unique Visitors
  * Page Views
  * Average Session Duration
  * Bounce Rate

* Create summary cards:

  * Total Visitors Today
  * Total Visitors This Month
  * New Users This Month

* Implement graph:

  * Traffic Trend Graph (Last 30 Days)

* Data sources:

  * Option 1: Integrate Google Analytics (sessions, users, traffic sources)
  * Option 2: Internal tracking using `page_views` table

---

## Task 2: Content Performance

Analyze and display top-performing content across the platform.

* Show:

  * Most Viewed Movies
  * Most Viewed Songs
  * Most Viewed Artist Profiles
  * Most Rated Movies
  * Most Rated Artists

* Build table:

  * Columns: Title | Views | Ratings Count | Average Rating

* Data logic:

  * Views from `movies.views`, `songs.views`, `artists.views`
  * Ratings using COUNT() and AVG() from ratings tables

---

## Task 3: User Engagement

Measure user interaction and engagement on the platform.

* Display metrics:

  * Total Ratings Submitted
  * Total Reviews Submitted
  * Total Watchlist Adds
  * Most Active Users

* Implement graph:

  * Daily Ratings Activity Chart

* Data sources:

  * Ratings table
  * Reviews table
  * Watchlist table

---

## Task 4: Moderation Panel

Provide tools for managing and moderating content.

* Display:

  * Pending Reviews
  * Reported Content
  * Recently Added Content
  * Recently Edited Content

* Add actions:

  * Approve
  * Reject
  * Edit

* Ensure quick moderation workflow with minimal clicks

---

## Task 5: Tracking System

Implement internal tracking for analytics.

### Page Views Table

Create table:

* id
* user_id (nullable)
* page_type (movie / song / artist)
* content_id
* ip_address
* created_at

### View Counter

On each page load:

* Increment:

  * movies.views
  * songs.views
  * artists.views

---

## Task 6: Ratings Analytics

Use existing rating data to generate insights.

* Calculate:

  * Total Ratings → COUNT(ratings)
  * Average Rating → AVG(ratings)

* Use for:

  * Most Rated Content
  * Highest Rated Content

---

## Task 7: Dashboard Graphs

Add visual analytics using charts.

* Traffic Trend Chart

* Rating Activity Chart

* Content Views Chart

* Suggested libraries:

  * Chart.js
  * ApexCharts

---

## Task 8: Real-time Stats API

Create API for dynamic dashboard updates.

### Endpoint

* GET /api/admin/stats

### Response

```json
{
  "total_users": 0,
  "today_visitors": 0,
  "total_ratings": 0,
  "pending_reviews": 0,
  "total_content": 0
}
```

* Use this API to update dashboard cards via AJAX

---

## Task 9: Performance & Optimization

Ensure system is efficient and scalable.

* Use indexing on:

  * views
  * ratings
  * created_at

* Cache heavy queries (analytics data)

* Use AJAX for updates (avoid full page reloads)

* Maintain architecture:

  * Controller → Service → API → UI
