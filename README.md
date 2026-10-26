# MindCare — Interactive Mental Health Self-Assessment

A PHP/MySQL student project based on the supplied synopsis.

## Features
- Responsive public website
- 6-question self-assessment
- Simple support-level scoring
- Personalized guidance
- Professional-support recommendations for moderate/high support levels
- Admin login
- Admin CRUD for professionals
- Admin CRUD for suggestions
- MySQL storage for assessment responses
- Prepared statements and escaped output

## Important
This is an awareness/self-reflection project, NOT a clinical diagnostic tool.
Before public deployment, replace the demonstration professional records with real,
verified professionals and appropriate local emergency/crisis resources.

## Requirements
- PHP 8+
- MySQL 5.7+/8+
- Apache/Nginx with PHP

## Installation
1. Create a MySQL database by importing `database.sql`.
2. Open `config.php`.
3. Set your MySQL host, database name, username and password.
4. Upload the entire project folder to your PHP hosting public directory.
5. Visit `/index.php`.
6. Open `/admin/login.php`.
7. Demo credentials:
   Username: admin
   Password: Admin@12345
8. CHANGE THE ADMIN PASSWORD before deployment.

## Scoring
Each of the 6 questions has a value from 0 to 4. Maximum score is 24:
0-6 Low Support Need
7-12 Mild Support Need
13-18 Moderate Support Need
19-24 Higher Support Need

These thresholds are project logic only and are not a validated clinical screening instrument.

## Recommended production improvements
- Use HTTPS.
- Change the demo admin password.
- Add CSRF protection to admin forms.
- Add rate limiting/login lockout.
- Verify professional credentials and contact information.
- Add a privacy policy and data-retention policy.
- Minimize stored personal information.
- Consider encrypting or anonymizing assessment data if retained.
