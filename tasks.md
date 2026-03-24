# 🤖 AI Agent Prompt — CGChartbusters Website: Pending Corrections & Feature Updates
**Project:** CGChartbusters (cgchartbusters.com)
**Prepared By:** CG Chartbusters
**For:** Path Idea Developer Team
**Document Date:** 12 March 2026
**Prompt Scope:** Issues 13–15 + Home Screen Updates 1–18 (Issues 1–12 already resolved)

---

## ⚡ AGENT DIRECTIVE

You are a **Web Development Execution Agent** for the CGChartbusters platform — a Chhattisgarh-focused entertainment rating & discovery website. Your task is to implement all items listed below **completely and in order**, without skipping, summarizing, or deferring any task unless explicitly marked optional.

Each task includes the current broken state, the required correction, and technical implementation instructions. Treat every item as a confirmed, approved change request. Do not ask for clarification unless a direct conflict exists between two tasks.

---

## 🔧 SECTION A — BUG FIXES & CONTENT CORRECTIONS

---

### TASK-013 — Plot Paragraph Formatting Not Reflecting Properly

**Affected Areas:** Movie profile pages, TV Show profile pages, Song profile pages, Artist biography sections

**Current Problem:**
When Plot or Biography text is entered in the backend with multiple paragraphs, the frontend renders all text as one continuous block. Line breaks and paragraph breaks are lost entirely.

**Required Correction:**
- Preserve all line breaks and paragraph breaks from the backend in the frontend display
- Each paragraph must render with proper spacing between it and the next
- Text must be readable and structured

**Technical Implementation:**
1. Check if plot/biography is stored as plain text or HTML in the database
2. If plain text: convert `\n\n` → `</p><p>` and wrap entire content in `<p>` tags before rendering; alternatively apply CSS rule `white-space: pre-line`
3. If HTML: ensure sanitization is not stripping `<p>` and `<br>` tags; do not over-sanitize
4. CSS: add `.plot-content p { margin-bottom: 12px; }` or equivalent spacing
5. Security: maintain XSS protection; only allow safe tags: `p`, `br`, `strong`, `em`

**Acceptance Criteria:**
- [ ] Multi-paragraph plot text renders as separate paragraphs with visible spacing
- [ ] Single-paragraph text is unaffected
- [ ] No HTML tags visible in rendered output
- [ ] XSS protection intact

---

### TASK-014 — Songs Profile Page: Replace "Plot" Label with Dynamic "Lyrics" Section

**Affected Areas:** Song profile pages (frontend display + admin panel add/edit forms)

**Current Problem:**
Song profile pages display a section labeled "Plot" — which is a movie-specific term and is semantically incorrect for songs.

**Required Correction:**

**1. Label Change (Frontend):**
- Remove "Plot" heading from song profile pages
- Replace with a dynamic heading: `<Song Name> (Lyrics)`
- Example: if song name is "Sangwari Re", heading becomes **Sangwari Re (Lyrics)**

**2. Backend/Admin Panel Change:**
- In the Song add/edit form, rename the "Plot" field label to **"Lyrics"**
- Admin panel placeholder text should read: `"Enter full song lyrics here…"`

**3. Frontend Display Logic:**
```
if (content_type == "song") {
    heading = song_name + " (Lyrics)";
} else {
    heading = "Plot";
}
```
- Movies → show "Plot"
- TV Shows → show "Plot"
- Songs → show `<Song Name> (Lyrics)`

**Technical Notes:**
- Database column can remain the same (reuse `plot` column) OR create a separate `lyrics` column (recommended for clean structure — developer decision)
- SEO: ensure "Lyrics" keyword appears in slug and meta title for song pages
- Paragraph formatting fix from TASK-013 must also apply here

**Acceptance Criteria:**
- [ ] Song pages no longer display "Plot" heading
- [ ] Heading dynamically shows `[Song Name] (Lyrics)`
- [ ] Admin panel field is labeled "Lyrics"
- [ ] Movie and TV Show pages still display "Plot" unchanged

---

### TASK-015 — Artist Profile: Rating Feature Missing

**Affected Areas:** Artist profile pages, Homepage "Popular Artists" section, Admin/backend rating storage

**Current Problem:**
Movies, TV Shows, and Songs all have star-based rating systems. Artist profiles have no rating functionality, making the platform inconsistent and weakening the "Popular Artists" ranking logic on the homepage.

**Required Updates:**

**A. Add Rating Component to Artist Profile Page:**
- Star-based rating system (scale: 1–10, consistent with movies/songs)
- Show: average rating score, total rating count
- Include a visible **"Rate This Artist"** button
- Display format below artist name: `⭐ 8.7/10 (124 Ratings)`

**B. Backend:**
- Create or extend ratings table to support `entity_type = 'artist'`
- Store: `artist_id`, `user_id`, `rating_value`, `created_at`
- Calculate and cache average rating per artist

**C. Popular Artists Section Logic Update (Homepage):**
- Sort "Popular Artists" section dynamically by average rating (descending)
- Apply minimum threshold: artist must have **at least 5 ratings** to appear
- Artists with 0 ratings must not appear in the Popular Artists section

**Acceptance Criteria:**
- [ ] Artist profile page shows star rating widget
- [ ] Users can submit a rating for an artist
- [ ] Average rating and count display correctly below artist name
- [ ] Homepage Popular Artists section is sorted by rating
- [ ] Artists with fewer than 5 ratings are excluded from homepage section

---

## 🏠 SECTION B — HOME SCREEN UPDATES

---

### UPDATE-01 — Add Hero Section to Home Screen (Per Canva Design)

**Current Problem:**
The hero area currently shows only a movie poster slider with no platform positioning, authority messaging, or legal clarity. The site can be mistaken for a streaming platform instead of a rating platform.

**Required Update:**
Implement a new Hero Section above the banner sliders as per the provided Canva UX design. The section must clearly communicate:
- Platform identity: "Rate. Recommend. Rise." messaging
- That CGCB is a **rating platform, not a streaming site**
- Authority and trust signals
- CTA button (e.g., "Explore Now" or "Rate Now")

**Layout (per design):**
```
[HERO SECTION — full width, with text left + visual right]
↓
[BANNER SLIDERS — 16:9 ratio, with left/right arrows]
↓
[Top 10 Movies slider]
```

**Acceptance Criteria:**
- [ ] Hero section renders above banner sliders on home screen
- [ ] Platform positioning text is clearly visible
- [ ] Layout matches provided Canva design reference
- [ ] Responsive on mobile and desktop

---

### UPDATE-02 — Banner Slider: Make Clickable with Redirection

**Current Problem:**
The main home screen banner slider is visual-only. Clicking a banner does nothing — no redirect occurs.

**Required Correction:**
- Each banner must redirect to the detail page of its linked Movie/Song/TV Show on click
- Use SEO-friendly slug-based URLs (no numeric IDs)
- Example: Banner "Bhulan The Maze" → click → `/movie/bhulan-the-maze`

**Technical Implementation:**
- Attach a dynamic slug-based URL to each banner object in the database
- Wrap each slider item in an `<a href="[slug-url]">` tag instead of just an image container
- Ensure the entire banner area is clickable (full-width `<a>` tag)
- If using a JS slider library (Swiper/Slick): properly handle click event propagation
- Test clickable behavior on both mobile and desktop

**Acceptance Criteria:**
- [ ] Clicking any banner redirects to the correct detail page
- [ ] URL is slug-based (no numeric ID)
- [ ] Full banner area is clickable
- [ ] Works on mobile (touch) and desktop (mouse click)

---

### UPDATE-03 — Banner Slider: Add Status / CTA Labels

**Current System:** Banners have a "Show on Banner: Yes/No" toggle — this works correctly and must NOT be changed.

**New Requirement:**
Add an additional optional field to each banner item in the admin panel that displays a status/CTA badge on the banner in the frontend.

**Admin Panel — New Dropdown Field:**
Label: **Banner Status / CTA Option**
Options:
- None (default)
- 🎬 Watch on Official YouTube Channel
- 🎥 Watch in Theaters
- 🔜 Upcoming Release

**Frontend Display:**
- Show the selected label as a stylish badge/button on the banner (corner or side placement)
- Badge must be clearly visible but must not obscure the banner content
- If "None" is selected, no badge is shown

**Acceptance Criteria:**
- [ ] New dropdown field exists in admin panel for each banner
- [ ] Selected CTA label renders as a badge on the banner in frontend
- [ ] "None" selection shows no badge
- [ ] Badge is visible on both mobile and desktop

---

### UPDATE-04 — Top 10 List: Remove Number Prefix from Title & Remove Redundant "Details" Button

**Current Problems:**
1. Movie/Song/Artist names in the Top 10 list have a numeric prefix prepended to them (e.g., "1. Bhulan The Maze") — this is redundant since position is already shown visually
2. A "Details" button appears on each card, but the entire card/banner is already clickable — the button is a duplicate CTA

**Required Corrections:**
- Remove numeric prefix (1., 2., 3., etc.) from the title display — ranking order is already visually communicated by card position
- Remove the "Details" button from Top 10 cards
- Entire card must remain fully clickable via `<a href="[slug-url]">`

**Technical Notes:**
- If the ranking counter is generated from a loop index (e.g., `index + 1`), stop appending it to the name in the template
- Ranking value must still be maintained in the backend/database — only the UI display changes
- Remove the "Details" button HTML block or conditionally hide it
- Adjust UI spacing so layout does not break after button removal

**Acceptance Criteria:**
- [ ] No numeric prefix appears before movie/song/artist names in Top 10 cards
- [ ] "Details" button is removed from all Top 10 cards
- [ ] Cards remain fully clickable
- [ ] Layout and spacing remain clean after removal

---

### UPDATE-05 — Add Top 10 TV Shows List to Home Screen

**Current Problem:**
Home screen has Top 10 Movies and Top 10 Songs sections, but no Top 10 TV Shows section.

**Required Update:**
Add a **"Top 10 TV Shows"** horizontal slider section to the home screen, placed between the Top 10 Movies and Top 10 Songs sections (as per provided design layout).

**Design spec (same as Top 10 Movies):**
Each card shows:
- Ranking number (visual, large, left-side)
- Poster image
- Star rating (e.g., ⭐ 9/10)
- TV Show name

**Features:**
- Left/right arrow navigation buttons (desktop)
- Touch swipe (mobile)
- Each card is fully clickable → redirects to TV show detail page

**Acceptance Criteria:**
- [ ] "Top 10 TV Shows" section exists on the home screen
- [ ] Displays top 10 TV shows sorted by rating
- [ ] Left/right navigation arrows work on desktop
- [ ] Mobile swipe works
- [ ] Each card links to the correct TV show detail page

---

### UPDATE-06 — Add "See All" Buttons for Movies, TV Shows, and Songs

**Required Update:**
Add a **"See All [Category]"** button below each respective Top 10 list on the home screen:
- **"See All Movies"** → redirects to `/movies` tab
- **"See All TV Shows"** → redirects to `/tv-shows` tab
- **"See All Songs"** → redirects to `/songs` tab

Button placement: centered, below each Top 10 list section (as per provided design image).

**Acceptance Criteria:**
- [ ] "See All Movies" button present below Top 10 Movies section
- [ ] "See All TV Shows" button present below Top 10 TV Shows section
- [ ] "See All Songs" button present below Top 10 Songs section
- [ ] Each button redirects to the correct content tab/page

---

### UPDATE-07 — Rename "Top 10 Artists" Section to "Popular Artists" (Redesign)

**Required Update:**
- Change the section heading from **"Top 10 Artists"** to **"Popular Artists"**
- Redesign the section layout to match the provided design (circular artist photos in a horizontal scrollable row with left/right arrows)
- Add a **"See All Artists"** button below the section → redirects to `/artists`
- Section must pull artists sorted by average rating (ties into TASK-015 rating logic)

**Acceptance Criteria:**
- [ ] Section heading reads "Popular Artists" (not "Top 10 Artists")
- [ ] Layout matches provided Canva design reference
- [ ] Left/right navigation arrows present
- [ ] "See All Artists" button links to artists page
- [ ] Artists sorted by average rating descending

---

### UPDATE-08 — Add Complete Footer Section (Legal Links + Quick Links)

**Current Problem:**
Footer has no legal pages and T&C is not properly linked.

**Required Footer Structure (per provided design):**

**Column 1 — CG Chartbusters:**
- Logo
- Brand description (text content will be provided in `.txt` file)
- Copyright line: `© 2026 CG Chartbusters. All rights reserved.`

**Column 2 — Legal:**
- Terms & Conditions → `/terms-and-conditions`
- Privacy Policy → `/privacy-policy`
- Copyright & Takedown Policy → `/copyright-takedown-policy`
- Community Guidelines → `/community-guidelines`
- Content Moderation Policy → `/content-moderation-policy`
- Disclaimer → `/disclaimer`

**Column 3 — Quick Links:**
- Home
- Movies
- TV Shows
- Songs
- Artists
- About Us → `/about-us`

**Column 4 — Follow Us:**
- Facebook icon (link)
- YouTube icon (link)
- Instagram icon (link)
- X/Twitter icon → `https://x.com/cgchartbusters`

**Technical Requirements:**
- Create separate static pages for each legal link
- All URLs must be SEO-friendly slugs (no numeric IDs)
- Text content for all legal pages will be supplied in a `.txt` file — implement the pages as placeholder templates ready for content injection
- Footer must be responsive on mobile and desktop

**Acceptance Criteria:**
- [ ] Footer renders with all 4 columns
- [ ] All legal page routes exist and load (content can be placeholder)
- [ ] Quick links navigate correctly
- [ ] All social media icons link to correct profiles
- [ ] X/Twitter links to `https://x.com/cgchartbusters`
- [ ] Footer is responsive

---

### UPDATE-09 — Add CGCB Brand Description in Footer

**Required Update:**
In the footer's first column (CG Chartbusters column), add a short brand description paragraph below the logo.

Text content will be provided in a `.txt` file. Implement the text area now as a populated or placeholder block matching the provided design layout.

**Acceptance Criteria:**
- [ ] Brand description text area exists in footer column 1
- [ ] Layout matches provided design
- [ ] Text is readable on both mobile and desktop

---

### UPDATE-10 — Add Social Share Option on All Profile Pages

**Affected Pages:** Movie pages, TV Show pages, Song pages, Artist pages

**Required Feature:**
Add a visible Share button on every individual profile page that opens a share menu.

**Share Platforms:**
- WhatsApp
- Facebook
- Twitter (X)
- Instagram (copy link option)
- Copy Link

**Placement:** Near the page title, next to the rating — OR top-right corner — OR below the poster/image. Choose the cleanest placement per page type.

**Technical Requirements:**
- Dynamic page URL must be auto-fetched (use `window.location.href` or server-side current URL)
- Implement Open Graph (OG) meta tags on all profile pages:
  - `og:title`
  - `og:description`
  - `og:image` (use poster/profile image)
  - `og:url`
- When shared, the preview thumbnail must show the correct poster image

**Acceptance Criteria:**
- [ ] Share button visible on all Movie, TV Show, Song, and Artist pages
- [ ] Clicking opens a share menu with all 5 platforms
- [ ] Correct page URL is shared
- [ ] OG tags implemented on all profile page types
- [ ] Shared link preview shows correct title, description, and image

---

### UPDATE-11 — Add Translation Toggle for Plot & Biography

**Affected Areas:** Movie Plot, TV Show Plot, Song Description/Lyrics, Artist Biography

**Current Situation:**
All content is currently in Hindi. No translation option exists for non-Hindi users.

**Required Feature:**

**1. Translation Toggle Button:**
Place a language selector above each Plot/Biography/Lyrics section:
```
Language: [ Hindi ▼ ]
```
Options: Hindi (default), English, Chhattisgarhi, (future: other languages)

**2. Functionality:**
- User selects a language → content switches to that language instantly
- No full page reload required (preferred — use JS/AJAX)

**3. Technical Approach (Two Options — Developer to Choose):**

Option A (Recommended for SEO):
- Store separate language columns in the database:
  - `plot_hindi`, `plot_english`, `plot_chhattisgarhi`
  - `biography_hindi`, `biography_english`, `biography_chhattisgarhi`
- Frontend fetches the correct column based on selected language

Option B (Quick solution):
- Integrate Google Translate API or similar auto-translation service
- Apply translation dynamically to the plot/biography text block

**Acceptance Criteria:**
- [ ] Language toggle dropdown exists above Plot/Biography on all applicable pages
- [ ] Selecting English switches content to English version (or auto-translated)
- [ ] Hindi is the default selection
- [ ] Chhattisgarhi option is available in dropdown
- [ ] No full page reload on language switch

---

### UPDATE-12 — Add Articles / Blog Section

**Current Situation:**
Navigation currently has: Home | Movies | TV Shows | Songs | Artist
No Articles/Blog section exists.

**Required Features:**

**1. New Navigation Menu Item:**
Add **"Articles"** to the main navigation header:
`Home | Movies | TV Shows | Songs | Artist | Articles`

**2. Blog Listing Page (`/articles`):**
- Grid/list view of all published articles
- Each card shows: thumbnail image, title, short description, publish date, author name

**3. Single Article Page (`/articles/[slug]`):**
- Featured image
- Title, author, publish date
- Full content (supports text, images, embedded video)
- Category and tags display
- Social share buttons (WhatsApp, Facebook, Twitter/X, Copy Link)
- Translation toggle (Hindi/English/Chhattisgarhi) — same system as UPDATE-11

**4. SEO:**
- Slug-based URLs: `/articles/[article-slug]`
- Meta title, meta description, OG tags per article
- Proper H1/H2 heading structure

**5. Admin Panel — Article Management:**
- Add / Edit / Delete article
- Upload feature image
- Add category and tags
- Draft / Publish toggle

**Acceptance Criteria:**
- [ ] "Articles" menu item appears in navigation
- [ ] `/articles` listing page renders all published articles
- [ ] Single article page renders full content correctly
- [ ] Social share works on article pages
- [ ] Translation toggle present on article pages
- [ ] SEO meta tags implemented per article
- [ ] Admin can create, edit, publish, and delete articles

---

### UPDATE-13 — Movies Tab: Redesign Listing Card UX

**Current Problem:**
Movie listing cards currently show: poster thumbnail + movie name + year + duration (00:00 mins) + star rating. The duration field is incorrect and the card layout is outdated.

**Required UX (per provided design):**

Each movie/TV show/song listing card must display:
```
[Poster Image]    MOVIE NAME
                  2010 • U/A • Genres
                  ⭐ 9/10   (100 Votes)
```

Fields to show: Title, Release Year, CBFC Rating (U/A/A etc.), Genre(s), Star Rating, Vote Count
Fields to remove from card: Duration

**Applies To:** Movies tab, TV Shows tab, Songs tab listing views

**Acceptance Criteria:**
- [ ] Listing cards show: Title, Year, CBFC rating, Genre, Star rating, Vote count
- [ ] Duration field is NOT shown on listing cards
- [ ] Layout matches provided design mockup
- [ ] Responsive on mobile

---

### UPDATE-14 — Movie / TV Show Profile Page: Redesign Layout

**Current Problem:**
Profile page layout is outdated. Plot is crammed into a small right column. Cast section needs improvement.

**Required UX Layout (per provided design):**
```
[YouTube Embed — left, large]    [Poster — top right]
                                 MOVIE NAME
                                 ⭐ 9/10 (100 Votes)
                                 Released: 01/01/2010
                                 Genres: Comedy, Romance
                                 Language: Chhattisgarhi
                                 CBFC: U/A
                                 [Movie Name] Plot:
                                 [Plot text here]

| CAST
[Cast member cards in a row]

| Reviews
[Review section]
```

**Technical Notes:**
- YouTube embed must be linked (use existing YouTube link field)
- Plot section heading: `[Movie Name] Plot:` (dynamic)
- CBFC field must be displayed
- Cast section must show artist name + role badge

**Acceptance Criteria:**
- [ ] Profile page layout matches provided design
- [ ] YouTube embed renders correctly
- [ ] All metadata fields display (rating, release date, genre, language, CBFC)
- [ ] Plot text renders with paragraph formatting (per TASK-013)
- [ ] Cast section shows artists with roles

---

### UPDATE-15 — Song Profile Page: Redesign Layout

**Same structure as UPDATE-14 but with song-specific fields.**

**Required UX Layout (per provided design):**
```
[YouTube Embed — left, large]    [Poster — top right]
                                 SONG NAME
                                 ⭐ 9/10 (100 Votes)
                                 Released: 01/01/2010
                                 Genres: Comedy, Romance
                                 Language: Chhattisgarhi
                                 CBFC: NA
                                 [Song Name] Lyrics:
                                 [Lyrics text here]

| CAST
[Cast/artist cards]

| Reviews
[Review section]
```

**Differences from Movie profile:**
- "Plot" label replaced with "[Song Name] Lyrics:" (per TASK-014)
- CBFC shown as "NA" if not applicable
- Duration field NOT displayed

**Acceptance Criteria:**
- [ ] Song profile layout matches provided design
- [ ] Lyrics section labeled as "[Song Name] Lyrics:"
- [ ] Duration not shown
- [ ] All other fields display correctly

---

### UPDATE-16 — Link X (Twitter) Profile in Footer Follow Us Section

**Required Update:**
In the footer's "Follow Us" section, add/update the X (Twitter) icon link to:

**URL:** `https://x.com/cgchartbusters`

The icon must open in a new tab (`target="_blank"`).

**Acceptance Criteria:**
- [ ] X/Twitter icon present in footer Follow Us section
- [ ] Icon links to `https://x.com/cgchartbusters`
- [ ] Opens in new tab

---

### UPDATE-17 — Admin Dashboard Analytics Upgrade

**Current Problem:**
Dashboard only shows: Total Users, Active Users, Pending Reviews, Total Content. No traffic data, content performance, engagement metrics, or useful graphs exist.

**Required Dashboard Sections:**

**Section 1 — Platform Analytics (Traffic):**
- Total Visitors: Today / This Week / This Month
- Unique Visitors
- Page Views
- Average Session Duration
- Bounce Rate
- Graph: Traffic Trend (Last 30 Days line chart)

**Section 2 — Content Performance:**
- Most Viewed Movies (table: Title | Views | Ratings | Avg Rating)
- Most Viewed Songs
- Most Viewed Artist Profiles
- Most Rated Movies
- Most Rated Artists

**Section 3 — User Engagement:**
- Total Ratings Submitted
- Total Reviews Submitted
- Total Watchlist Adds
- Most Active Users
- Graph: Daily Ratings Activity (bar chart)

**Section 4 — Moderation Panel:**
- Pending Reviews queue (with Approve / Reject / Edit quick actions)
- Reported Content list
- Recently Added Content
- Recently Edited Content

**Technical Implementation:**

A. Traffic Tracking — Two Options (Developer to choose):
- Option A (Recommended): Integrate Google Analytics 4 (GA4) and display key metrics via GA4 Data API in the dashboard
- Option B (Internal): Create `page_views` table with fields: `id`, `user_id`, `page_type`, `content_id`, `ip_address`, `created_at`; increment on each page load

B. Content View Counter:
- Add `views` column to `movies`, `songs`, `artists` tables
- Increment `views = views + 1` on each profile page load

C. Ratings Analytics:
- Query existing ratings tables: `COUNT(ratings)`, `AVG(ratings)` per content item

D. Dashboard Graphs — Use Chart.js or ApexCharts:
- Traffic Growth chart
- Rating Activity chart
- Content Views chart

E. Real-time Stats API:
- Create endpoint: `GET /api/admin/stats`
- Returns: `total_users`, `today_visitors`, `total_ratings`, `pending_reviews`, `total_content`

**Bonus (Recommended):**
Add a **"Trending Content (Last 7 Days)"** table — content with highest view/rating activity in the past 7 days. This will support future homepage algorithm improvements.

**Acceptance Criteria:**
- [ ] Dashboard shows traffic data (via GA4 or internal tracking)
- [ ] Content view counter increments on page load
- [ ] Most Viewed and Most Rated tables render correctly
- [ ] Engagement metrics (ratings, reviews) display with counts
- [ ] Moderation panel shows pending reviews with action buttons
- [ ] At least 2 graphs render (traffic + ratings activity)
- [ ] "Trending Content (Last 7 Days)" section present
- [ ] `/api/admin/stats` endpoint returns correct data

---

### UPDATE-18 — User Management: Fix "Add User" & "Export Users" Buttons

**Current Problem:**
In the admin panel User Management section, both the "Add User" and "Export Users" buttons are visible in the UI but have no backend functionality — they do nothing when clicked.

**Required Updates:**

**A. Add User Feature:**
Implement a modal form that opens when "Add User" is clicked.
Form fields: Name, Email, Password, Role (Admin/User), Status (Active/Inactive)
Validation: unique email, minimum password length, no empty required fields
Backend: `POST /admin/users/create` → insert into `users` table with bcrypt-hashed password

**B. Export Users Feature:**
Implement file download when "Export Users" is clicked.
Export formats: CSV (required), Excel/xlsx (recommended)
Fields to export: Name, Email, Role, Status, Registration Date, Last Login
Backend: `GET /admin/users/export`
Query: `SELECT name, email, role, status, created_at, last_login FROM users`
File name format: `cgchartbusters_users_export_YYYY.csv`
Libraries: PHP → PhpSpreadsheet / Node → json2csv / Python → pandas

**C. User Search Improvement:**
Enhance the search bar to filter by: Name, Email, Role, Status (real-time filtering)

**D. Bulk Actions:**
Use existing checkboxes to enable: Bulk Delete, Bulk Deactivate, Bulk Activate

**E. Pagination:**
If user count > 50, add pagination with options: 10 / 25 / 50 per page

**Optional Advanced Upgrade (Recommended):**
Add a "User Insights" column in the user list showing: Ratings Given, Reviews Written, Join Date, Last Activity

**Acceptance Criteria:**
- [ ] "Add User" button opens a modal form
- [ ] Form validates all fields and submits correctly to backend
- [ ] New user appears in user list after creation
- [ ] "Export Users" button triggers a CSV file download
- [ ] Exported file contains all required fields
- [ ] Search filters users by name, email, role, and status in real time
- [ ] Bulk actions (delete/activate/deactivate) work via checkboxes
- [ ] Pagination renders when users > 50

---

## 📊 SUMMARY

| # | Task | Category | Priority |
|---|------|----------|----------|
| TASK-013 | Plot paragraph formatting fix | Bug Fix | High |
| TASK-014 | Songs "Plot" → "Lyrics" label change | Bug Fix / UI | High |
| TASK-015 | Artist profile rating feature | Feature | High |
| UPDATE-01 | Hero section on home screen | UI/UX | High |
| UPDATE-02 | Banner slider click redirection | Feature / Bug Fix | High |
| UPDATE-03 | Banner CTA/status labels | Feature | Medium |
| UPDATE-04 | Remove number prefix & Details button from Top 10 | Bug Fix / UI | High |
| UPDATE-05 | Add Top 10 TV Shows list to home screen | Feature | High |
| UPDATE-06 | "See All" buttons for Movies/TV/Songs | Feature | Medium |
| UPDATE-07 | Rename + redesign "Popular Artists" section | UI/UX | Medium |
| UPDATE-08 | Full footer with legal links & quick links | Feature | High |
| UPDATE-09 | CGCB brand description in footer | Content / UI | Medium |
| UPDATE-10 | Social share on all profile pages + OG tags | Feature | High |
| UPDATE-11 | Translation toggle for Plot & Biography | Feature | Medium |
| UPDATE-12 | Articles / Blogs section | Feature | Medium |
| UPDATE-13 | Movies tab listing card UX redesign | UI/UX | Medium |
| UPDATE-14 | Movie/TV Show profile page layout redesign | UI/UX | Medium |
| UPDATE-15 | Song profile page layout redesign | UI/UX | Medium |
| UPDATE-16 | Link X (Twitter) in footer | Content | Low |
| UPDATE-17 | Admin dashboard analytics upgrade | Feature | High |
| UPDATE-18 | Fix Add User & Export Users in admin | Bug Fix | High |

**Total Tasks: 21**
**Critical/High Priority: 13**
**Medium Priority: 7**
**Low Priority: 1**

---

## ⚠️ FLAGS & CROSS-DEPENDENCIES

- **TASK-013 + TASK-014 + UPDATE-15** are linked — paragraph formatting fix must be applied to Lyrics section in song profiles
- **TASK-015** (Artist Rating) must be completed **before** UPDATE-07 (Popular Artists sort by rating) can function correctly
- **UPDATE-08** requires text content to be supplied by the client in a `.txt` file before legal pages can be populated
- **UPDATE-09** also requires the brand description text from the client `.txt` file
- **UPDATE-11** (translation) and **UPDATE-12** (articles) share the same translation toggle system — implement once and reuse
- **UPDATE-02** (banner click) and **UPDATE-03** (banner CTA labels) should be implemented together to avoid double work on the slider component

---

## 🚫 CONSTRAINTS

- Do NOT modify Issues 1–12 (already fixed)
- Do NOT use numeric IDs in any new URLs — all routes must use slug-based SEO-friendly URLs
- Do NOT remove the "Show on Banner: Yes/No" toggle (UPDATE-03 — this feature is working correctly)
- Do NOT deploy to production without testing on both Android and iOS mobile devices
- All text content for legal pages and footer description will be provided by the client — build the pages/templates now, populate content when received