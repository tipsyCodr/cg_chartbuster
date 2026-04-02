# PRD: User Management System Enhancements (CG Chartbusters)

## Overview

Fix and fully implement the User Management section in the Admin Panel. Enable admins to create users, export user data, perform advanced search, and execute bulk actions with proper backend APIs and responsive UI.

---

## Task 1: Add User Feature

Enable admins to manually create new users.

* UI:

  * "Add User" button opens modal form
  * Form fields:

    * Name
    * Email
    * Password
    * Role (Admin / User)
    * Status (Active / Inactive)

* Validation:

  * Email must be unique
  * Password minimum length (>= 6 or 8 as per policy)
  * Required fields must not be empty

* Backend:

  * Endpoint: `POST /admin/users/create`
  * Insert into `users` table:

    * id
    * name
    * email
    * password (bcrypt hashed)
    * role
    * status
    * created_at

---

## Task 2: Export Users Feature

Allow admins to download user data.

* UI:

  * "Export Users" button triggers file download

* Backend:

  * Endpoint: `GET /admin/users/export`
  * Query:

    * SELECT name, email, role, status, created_at, last_login FROM users

* Export formats:

  * CSV (recommended)
  * Excel (.xlsx)

* File naming:

  * `cgchartbusters_users_export_YYYY.csv`

* Suggested libraries:

  * PHP: PhpSpreadsheet
  * Node: json2csv
  * Python: pandas

---

## Task 3: User Search Improvement

Enhance search and filtering capabilities.

* Search fields:

  * Name
  * Email
  * Role
  * Status

* Features:

  * Real-time filtering (AJAX / debounce input)
  * Combined filters (e.g., role + status)

---

## Task 4: Bulk Actions

Enable actions on multiple selected users.

* UI:

  * Checkbox selection for users

* Actions:

  * Bulk Delete
  * Bulk Activate
  * Bulk Deactivate

* Backend:

  * Endpoint: `POST /admin/users/bulk-action`
  * Payload:

    * user_ids[]
    * action (delete / activate / deactivate)

---

## Task 5: Frontend Button Fix

Fix non-functional buttons and connect them to backend APIs.

* Add User button:

  * Opens modal form
  * Submits form via API

* Export Users button:

  * Calls export API
  * Initiates file download

---

## Task 6: Pagination

Improve user listing performance.

* Conditions:

  * If users > 50

* Features:

  * Pagination options: 10 / 25 / 50 per page
  * Server-side pagination

---

## Task 7: Performance & Security

Ensure system reliability and data protection.

* Use indexing on:

  * email
  * created_at

* Security:

  * Hash passwords using bcrypt
  * Validate all inputs server-side
  * Protect endpoints with admin authentication middleware

---

## Task 8: Optional Advanced Upgrade (User Insights)

Provide deeper insights into user activity.

* Add columns in user list:

  * Ratings Given (count)
  * Reviews Written (count)
  * Join Date
  * Last Activity

* Example display:

  * User Name
  * Ratings: X
  * Reviews: Y
  * Joined: Date

* Purpose:

  * Track engagement
  * Identify active users
  * Support analytics and moderation

---

## Purpose

* Enable full admin control over users
* Allow easy data export for backup and analysis
* Improve user moderation workflow
* Support marketing and analytics use cases
