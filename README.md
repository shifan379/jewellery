💎 Jewelry POS System

A comprehensive Point of Sale (POS) solution tailored for jewelry businesses. This system streamlines sales, inventory, customer management, and reporting with an intuitive interface and robust backend architecture.

Designed with Laravel, the system is secure, scalable, and optimized for day-to-day retail operations in jewelry shops.

📌 Key Features
🛍️ Sales & Transactions

Barcode-based product search and quick billing

Live invoice preview before checkout

Keyboard shortcuts for faster processing

Support for multiple payment modes (cash, card, etc.)

Sales returns with proper adjustment tracking

📦 Inventory & Products

Category, brand, and unit management

Product SKUs and item codes

Real-time stock updates on sales/returns

Wholesale and retail price management

👥 Customer Management

Customer search with Select2 dropdown

Customer purchase history tracking

Loyalty and repeat customer support

📊 Dashboard & Reporting

Daily, weekly, and monthly sales overviews

Yesterday vs. today sales comparison

Top 3 selling products of the day

Exportable reports for accounting & insights

🛠️ Technology Stack

Framework: Laravel (PHP 10+)

Frontend: Blade, Bootstrap 5, jQuery, Select2

Database: MySQL (with Eloquent ORM)

Authentication: Laravel Jetstream & Sanctum

Version Control: Git/GitHub

⚙️ Installation & Setup
1. Clone Repository
git clone https://github.com/your-username/jewelry-pos.git
cd jewelry-pos

2. Install Dependencies
composer install
npm install && npm run dev

3. Configure Environment

Duplicate .env.example → .env

Update database, mail, and app settings

php artisan key:generate

4. Database Setup
php artisan migrate --seed

5. Launch Server
php artisan serve


Access the app at: http://127.0.0.1:8000

Default Credentials:

Email: admin@example.com

Password: ''

📂 Project Structure
jewelry-pos/
├── app/             # Core application logic
├── config/          # Configuration files
├── database/        # Migrations & seeders
├── public/          # Public assets (images, js, css)
├── resources/       # Blade views & frontend assets
├── routes/          # Route definitions
├── tests/           # Feature & unit tests
└── README.md        # Project documentation

🏗️ System Workflow & Architecture
🔹 Workflow (POS Lifecycle)
[Customer Purchase]
        │
        ▼
 [POS Screen: Select Products]
        │
        ▼
 [Cart & Invoice Preview]
        │
        ▼
 [Payment Processing]
        │
        ├──> Update Inventory
        ├──> Store Transaction Record
        └──> Generate Invoice (Printable/PDF)
        │
        ▼
   [Dashboard & Reports]

🔹 High-Level Architecture
             ┌─────────────────────┐
             │   Web Browser (UI)  │
             │  (Blade, jQuery)    │
             └─────────┬───────────┘
                       │
                       ▼
             ┌─────────────────────┐
             │   Laravel Backend   │
             │ (Controllers, APIs) │
             └─────────┬───────────┘
                       │
                       ▼
             ┌─────────────────────┐
             │   Business Logic    │
             │ (Sales, Returns,    │
             │  Inventory, Reports)│
             └─────────┬───────────┘
                       │
                       ▼
             ┌─────────────────────┐
             │     Database (MySQL)│
             │ Products, Customers,│
             │ Sales, Inventory    │
             └─────────────────────┘

📸 Screenshots

(Insert UI screenshots here: Dashboard, POS billing screen, Reports)

🧩 Future Enhancements

Multi-branch store management

Role-based access control (cashier, manager, admin)

Advanced analytics with charts

Integration with accounting software (QuickBooks, Tally)

SMS/email invoice notifications

🤝 Contributing

We welcome contributions to improve the system.

Fork the repository

Create a feature branch (feature/new-module)

Commit your changes

Push the branch

Submit a Pull Request

📜 License

This project is licensed under the MIT License – free for personal and commercial use.

💎 Jewelry POS System – Simplifying jewelry business operations with technology.
