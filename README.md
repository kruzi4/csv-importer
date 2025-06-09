# Laravel CSV Importer

This is a Laravel-based console application for importing products from a CSV file into a MySQL database, with business rules and test mode support.

## 🚀 Features

- CSV import via artisan command
- Business rules:
    - Skip products with price < $5 and stock < 10
    - Skip products with price > $1000
    - Mark discontinued products with current date
- Test mode (`--test`): validates and parses but does **not insert**
- Error reporting for failed inserts
- Laravel Sail support (Docker-based)

---

## ⚙️ Requirements

- Docker + Docker Compose
- Git

---

## 🧑‍💻 Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/your-username/csv-importer.git
cd csv-importer
```

### 2. Start Laravel Sail
```bash
./vendor/bin/sail up -d
```

### 3. Install dependencies
```bash
./vendor/bin/sail composer install
```

### 4. Run migrations
```bash
./vendor/bin/sail artisan migrate
```

## Usage
### Importing Products
To import products from the CSV file:
```bash
./vendor/bin/sail artisan products:import
```

### Test Mode
To run the import in test mode (no database inserts):
```bash
./vendor/bin/sail artisan products:import --test
```
