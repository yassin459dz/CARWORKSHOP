# CARWORKSHOP

## What We Do
CARWORKSHOP is a modern management system for car workshops. It enables you to efficiently manage clients, orders, and payments, with real-time updates, robust business logic, and a user-friendly interface. The system provides:
- Full client lifecycle management
- Order creation and status tracking
- Payment processing with smart modal logic
- Visual indicators for client financial status
- Reliable validation and error handling

A modern car workshop management system built with Laravel and Livewire.

---

## Table of Contents
- [Project Overview](#project-overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Setup Instructions](#setup-instructions)
- [Usage Guide](#usage-guide)
- [Business Logic](#business-logic)
- [Troubleshooting & Known Issues](#troubleshooting--known-issues)
- [Contributing](#contributing)
- [Changelog](#changelog)
- [License](#license)

---

## Project Overview
CARWORKSHOP is a comprehensive management system for car workshops. It helps manage clients, orders, and payments efficiently, with a focus on clear business logic and user-friendly UI.

## Features
- Client management (add, view, update, delete)
- Order creation and tracking
- Payment processing with modal logic
- Real-time UI updates using Livewire
- Visual indicators for client financial status (Debt, Credit, Settled)
- Robust validation and error handling

## Technology Stack
- **Backend:** Laravel (PHP)
- **Frontend:** Blade, Livewire
- **Database:** MySQL (or any Laravel-supported DB)
- **Other:** Composer, NPM/Yarn

## Setup Instructions
1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd CARWORKSHOP
   ```
2. **Install PHP dependencies:**
   ```bash
   composer install
   ```
3. **Install JS dependencies:**
   ```bash
   npm install
   # or
   yarn install
   ```
4. **Copy and configure environment file:**
   ```bash
   cp .env.example .env
   # Edit .env with your database and mail settings
   ```
5. **Generate application key:**
   ```bash
   php artisan key:generate
   ```
6. **Run migrations:**
   ```bash
   php artisan migrate
   ```
7. **Serve the application:**
   ```bash
   php artisan serve
   ```

## Usage Guide
- Access the app at `http://localhost:8000` (or your configured domain).
- Use the dashboard to manage clients and orders.
- When creating or updating orders, the payment modal will appear based on client financial status (see Business Logic below).

## Business Logic
### Payment Modal Display Rules
- **If client has Debt (sold < 0):** Always open payment modal.
- **If client has Credit (sold > 0):** Always open payment modal.
- **If client is Settled (sold = 0):** Open modal only if "Client will make partial/full payment now" checkbox is checked.
- **Otherwise:** Submit order directly without opening payment modal.

The UI displays an indicator showing client sold status (Debt/Credit/Settled) with color coding. The `validateOrder()` function logic matches this indicator.

### Data Handling
- The Livewire Client component receives data via the `setClient` listener, not via constructor or mount arguments.

## Troubleshooting & Known Issues
- **Livewire BindingResolutionException:** May occur if cached/old compiled views are present. Clear caches and recompile views if unexplained errors persist.
- **API or Database Connection Issues:** Check your `.env` configuration and ensure all services are running.
- **See `CHANGELOG.md` for more known issues and solutions.**

## Contributing
Contributions are welcome! Please fork the repo and submit a pull request. For major changes, open an issue first to discuss your ideas.

## Changelog
See [CHANGELOG.md](./CHANGELOG.md) for a detailed history of changes and technical decisions.

## License
This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
