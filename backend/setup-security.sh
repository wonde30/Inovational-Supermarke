#!/bin/bash

# Security Enhancement Setup Script for IBMS
# This script sets up all security features

echo "========================================="
echo "IBMS Security Enhancement Setup"
echo "========================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if running in backend directory
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: Please run this script from the backend directory${NC}"
    exit 1
fi

echo -e "${YELLOW}Step 1: Running migrations...${NC}"
php artisan migrate
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Migrations completed${NC}"
else
    echo -e "${RED}✗ Migration failed${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 2: Creating secure backup directory...${NC}"
mkdir -p storage/app/private/backups
chmod 700 storage/app/private/backups
echo -e "${GREEN}✓ Backup directory created with secure permissions${NC}"

echo ""
echo -e "${YELLOW}Step 3: Moving existing backups (if any)...${NC}"
if [ -d "storage/app/backups" ]; then
    mv storage/app/backups/*.sql storage/app/private/backups/ 2>/dev/null
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ Existing backups moved${NC}"
    else
        echo -e "${YELLOW}⚠ No existing backups found${NC}"
    fi
else
    echo -e "${YELLOW}⚠ No old backup directory found${NC}"
fi

echo ""
echo -e "${YELLOW}Step 4: Clearing caches...${NC}"
php artisan config:clear
php artisan route:clear
php artisan cache:clear
echo -e "${GREEN}✓ Caches cleared${NC}"

echo ""
echo -e "${YELLOW}Step 5: Caching configuration...${NC}"
php artisan config:cache
php artisan route:cache
echo -e "${GREEN}✓ Configuration cached${NC}"

echo ""
echo -e "${YELLOW}Step 6: Running security tests...${NC}"
php artisan test --filter=SecurityTest
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Security tests passed${NC}"
else
    echo -e "${RED}✗ Some security tests failed${NC}"
    echo -e "${YELLOW}Please review the test output above${NC}"
fi

echo ""
echo "========================================="
echo -e "${GREEN}Security Setup Complete!${NC}"
echo "========================================="
echo ""
echo "Next Steps:"
echo "1. Update your .env file with mail configuration"
echo "2. Set SANCTUM_TOKEN_EXPIRATION (default: 1440 minutes)"
echo "3. Test email verification by registering a new user"
echo "4. Review SECURITY_ENHANCEMENTS.md for detailed documentation"
echo ""
echo "Important Environment Variables:"
echo "  - SANCTUM_TOKEN_EXPIRATION=1440"
echo "  - MAIL_MAILER=smtp"
echo "  - MAIL_HOST=your-smtp-host"
echo "  - MAIL_PORT=587"
echo "  - MAIL_USERNAME=your-username"
echo "  - MAIL_PASSWORD=your-password"
echo "  - MAIL_FROM_ADDRESS=noreply@yourdomain.com"
echo ""
echo -e "${YELLOW}For production deployment, see SECURITY_ENHANCEMENTS.md${NC}"
echo ""
