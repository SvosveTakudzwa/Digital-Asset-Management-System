# Digital-Asset-Management-System
A web-based platform for registering, tracking, and verifying student-owned digital devices. Generates QR-coded asset cards, streamlines campus entry/exit checks, and provides an admin dashboard for security validation and asset management. Built to streamline the process of registering student-owned digital assets and improving security checks at campus entry/exit points.

## Overview
The system enables students to register their personal digital devices online and receive a generated **Digital Asset Card**.  
Security officials use this card to validate ownership when assets enter or leave campus.  
The platform eliminates manual paper-based forms, reduces queues, and minimizes asset-related disputes.

## Features

### Student Functions
- Online registration of digital assets (laptops, phones, tablets, accessories).  
- Ability to upload device details and identify key asset attributes.  
- Automatic generation of a **Digital Asset Card** containing QR Code + asset metadata.  
- Email delivery of the card (when SMTP configuration is available).  

### Security/Administration Functions
- Admin dashboard for viewing, validating, and managing registered assets.  
- Quick scan/lookup of asset details via asset number or student ID.  
- Verification module for entry/exit checks.  
- Reporting on the number, type, and status of assets.  

### System Functions
- QR Code generation for each asset.  
- Device uniqueness enforcement to prevent duplicate registrations.  
- Real-time validation logic at access points.  
- Centralized database for all asset records.  
- Responsive web application layout.

## Architecture

**Platform:** Web Application  
**Frontend:** HTML, CSS, JavaScript  
**Backend:** PHP  
**Database:** MySQL  
**Additional Services:**  
- QR Code generation library  
- SMTP client for email dispatch (optional depending on host configuration)

## Core Modules

### 1. Asset Registration Module  
Captures device type, brand, serial number, student details, and generates a unique asset identifier.

### 2. Digital Asset Card Generator  
Produces a downloadable/printable card with:  
- Student name  
- Student ID  
- Asset details  
- QR code linked to the asset  
- Timestamp and verification signature

### 3. Verification Module  
Used by security to confirm whether an asset belongs to the person carrying it.

### 4. Administration Panel  
Allows system admins to:  
- Approve or revoke asset entries  
- Edit asset details  
- View system logs  
- Generate summary reports  

## Data Model (Key Tables)

### `students`  
Stores student profiles.

### `assets`  
Holds asset details: type, serial, ownership, and status.

### `asset_cards`  
Stores generated card metadata and QR code info.

### `admin_users`  
System administrators and security officials.

## Installation

### Requirements
- PHP 7+  
- MySQL 5.7+  
- Apache / Nginx web server  
- Composer (if using additional libraries)  

### Setup Steps
1. Clone the repository.  
2. Import the supplied `.sql` database file into MySQL.  
3. Configure `/config/db.php` with your database credentials.  
4. Configure SMTP settings (optional) in `/config/mail.php`.  
5. Deploy to local or production server.  

## Usage

1. Students visit the registration page and submit their device details.  
2. The system generates an asset card with a QR Code.  
3. Card is downloaded or emailed to the student.  
4. Security staff scan/verify the QR code or asset ID at campus checkpoints.  
5. Admins manage and monitor all assets via the dashboard.

## Testing Summary

Black-box test categories included:  
- **Normal data**: valid student ID, valid serial numbers.  
- **Boundary cases**: long serial numbers, maximum field lengths.  
- **Invalid data**: missing fields, wrong formats, duplicate serial numbers.  
- **System tests**: QR code validity, database update correctness, login authentication.

All required functionalities passed during implementation.

## Strengths
- Eliminates manual asset recording.  
- Simplifies verification at security checkpoints.  
- Prevents fraudulent removal of devices.  
- Improves institutional asset accountability.  
- Reduces administrative overhead.  

## Limitations
- Email sending depends on secure SMTP configuration; SSL errors were encountered.  
- Hosting challenges due to paid hosting requirements.  
- Requires stable internet access for real-time verification.  

## Future Enhancements
- Mobile app for security officers.  
- Real-time QR scanning with in-app camera.  
- Integration with institutional student database.  
- Automated notification system for flagged or suspicious assets.  
- Dashboard analytics and visualization.  

## Authors
Project Group — Harare Institute of Technology  
- Takudzwa A. Svosve (https://github.com/SvosveTakudzwa)
- Golden F. Mudonhi  
- Tinotenda B. Madake  
- Blessing A. P. Chinyama  
- Tavonga D. Chauruka

