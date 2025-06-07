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
