# WordPress Docker Setup

A portable WordPress development environment using Docker.

## Requirements
- Docker Desktop installed
- Git installed

## Setup Instructions

### 1. Clone the repository
git clone https://github.com/sarikayadav24/wordpress-docker.git
cd wordpress-docker

### 2. Create your .env file
cp .env.example .env

Then edit .env and add your own passwords.

### 3. Start Docker containers
docker compose up

### 4. Install WordPress
Visit http://localhost:8080 and follow the setup wizard.

### 5. Access phpMyAdmin
Visit http://localhost:8081
Username: root
Password: (your DB_ROOT_PASSWORD from .env)

## Included
- Custom Portfolio Theme (sarika-portfolio)
- Contact Form Plugin (sarika-contact-form)
- WooCommerce Tweaks Plugin (sarika-woo-tweaks)
- Booking System Plugin (sarika-booking-system)
- Portfolio Manager Plugin (sarika-portfolio-manager)

## Stop Containers
docker compose down

## Author
Sarika Yadav
GitHub: github.com/sarikayadav24
