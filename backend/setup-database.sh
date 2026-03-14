#!/bin/bash

# Database Setup Script for Smart SuperMarket
# This script will set up a fresh database with all migrations and seeders

echo "=========================================="
echo "Smart SuperMarket - Database Setup"
echo "=========================================="
echo ""

# Check if .env file exists
if [ ! -f .env ]; then
    echo "❌ Error: .env file not found!"
    echo "Please copy .env.example to .env and configure your database settings."
    exit 1
fi

echo "📋 Step 1: Checking database configuration..."
php artisan config:clear
php artisan cache:clear
echo "✅ Configuration cleared"
echo ""

echo "📋 Step 2: Dropping all tables and recreating database..."
php artisan migrate:fresh
if [ $? -ne 0 ]; then
    echo "❌ Migration failed! Please check your database connection in .env file."
    exit 1
fi
echo "✅ Database tables created successfully"
echo ""

echo "📋 Step 3: Seeding database with sample data..."
php artisan db:seed
if [ $? -ne 0 ]; then
    echo "❌ Seeding failed!"
    exit 1
fi
echo "✅ Database seeded successfully"
echo ""

echo "=========================================="
echo "✅ Database setup completed successfully!"
echo "=========================================="
echo ""
echo "📊 Default Users Created:"
echo "  Admin:       admin@example.com / password"
echo "  Manager:     manager@example.com / password"
echo "  Cashier 1:   cashier1@example.com / password"
echo "  Cashier 2:   cashier2@example.com / password"
echo "  Storekeeper: storekeeper@example.com / password"
echo "  Customer:    customer@example.com / password"
echo ""
echo "📦 Sample Data:"
echo "  - 32 Products across 6 categories"
echo "  - 7 Customers"
echo "  - 6 Suppliers"
echo ""
echo "🚀 You can now start the application:"
echo "   php artisan serve"
echo ""
