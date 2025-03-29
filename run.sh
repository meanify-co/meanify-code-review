#!/bin/bash

set -e

# Colors
GREEN="\033[0;32m"
YELLOW="\033[1;33m"
BLUE="\033[1;34m"
RED="\033[0;31m"
NC="\033[0m" # No Color

divider() {
    echo -e "${YELLOW}--------------------------------------------------${NC}"
}

section() {
    divider
    echo -e "${BLUE}🔍 $1${NC}"
    divider
}

finish() {
    echo -e "${GREEN}✅ $1 completed successfully!${NC}\n"
}

fail() {
    echo -e "${RED}❌ $1 failed!${NC}\n"
}

echo -e "${GREEN}🚀 Starting full code quality analysis...${NC}\n"

# Laravel Pint
section "Running Laravel Pint"
./vendor/bin/pint --config review/pint.json
if [ $? -eq 0 ]; then finish "Laravel Pint"; else fail "Laravel Pint"; fi

# PHP CodeSniffer
section "Running PHP CodeSniffer"
./vendor/bin/phpcs --colors -s --standard=review/phpcs.xml
if [ $? -eq 0 ]; then finish "PHP CodeSniffer"; else fail "PHP CodeSniffer"; fi

# PHPArkitect
section "Running PHPArkitect"
./vendor/bin/phparkitect check --config=review/arkitect.php
if [ $? -eq 0 ]; then finish "PHPArkitect"; else fail "PHPArkitect"; fi

divider
echo -e "${GREEN}🎉 Code quality analysis completed successfully!${NC}"
divider
