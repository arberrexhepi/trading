# trading

Trading system with DACTS framework. Work in Progress, working features include: register, log in, trade logging, risk target preference setting.
THIS IS NOT FINANCIAL ADVICE. SUGGESTIONS ARE FIGURES BASED ON IDEAS, FORMULAS, and CONCEPTS TO HELP YOU MAKE SENSE OF THE MARKET, NOT TO ACT ON IT.

## Prerequisites

- PHP 7.4 or higher
- Composer (https://getcomposer.org/)
- MySQL or MariaDB
- WAMP (for Windows) or any LAMP/LEMP stack

## Installation

1. Clone the repository:
   ```powershell
   git clone https://github.com/your-username/trading.git
   cd trading
   ```
2. Install PHP dependencies:
   ```powershell
   composer install
   ```

## Environment Setup

1. In the project root, create a `.env` file:
   ```powershell
   copy .env.example .env  # or create manually
   ```
2. Define the following variables in `.env`:
   ```dotenv
   DB_HOST=your_db_host
   DB_USER=your_db_user
   DB_PASSWORD=your_db_password
   DB_DATABASE=your_db_name
   ```

## Database Setup

Run the migration script to set up the database schema:

```powershell
php migrations/setup_database.php
```

## Running the Application

1. Ensure the project is served by your web server (e.g., place under `C:\wamp64\www`).
2. Open your browser and navigate to:
   ```
   http://localhost/trading/public/index.php
   ```

## License

This project is licensed under the Apache License.
