#!/bin/bash

set -e

# Resolve root project path
PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../../.." && pwd)"

BIN="${PROJECT_ROOT}/vendor/bin"

# Colors
GREEN="\033[0;32m"
YELLOW="\033[1;33m"
BLUE="\033[1;34m"
RED="\033[0;31m"
NC="\033[0m"

divider() {
    echo -e "${YELLOW}-------------------------------------------------------------------------------${NC}"
}

section() {
    divider
    echo -e "${BLUE}🔍 $1${NC}"
    divider
}

finish() {
    echo -e "${GREEN}✅ $1 completed successfully!${NC}\\n"
}

fail() {
    echo -e "${RED}❌ $1 failed!${NC}\\n"
}

echo -e "${GREEN}🚀 Starting full code quality analysis...${NC}\\n"

# Laravel Pint
section "Running Laravel Pint"
"${BIN}/pint" --config "${BASH_SOURCE%/*}/src/pint.json" || fail "Laravel Pint"
finish "Laravel Pint"


# PHP CodeSniffer (full report)
section "Running PHP CodeSniffer"
"${BIN}/phpcs" --config-set installed_paths "${BASH_SOURCE%/*}/src/"
"${BIN}/phpcs" --colors -s --standard="${BASH_SOURCE%/*}/src/phpcs.xml" || fail "PHP CodeSniffer"
finish "PHP CodeSniffer"

# PHP CodeSniffer (summary)
section "Running PHP CodeSniffer"
"${BIN}/phpcs" --colors -s --standard="${BASH_SOURCE%/*}/src/phpcs.xml" --report=summary || fail "PHP CodeSniffer"
finish "PHP CodeSniffer"


# PHPArkitect
section "Running PHPArkitect"
"${BIN}/phparkitect" check --config="${BASH_SOURCE%/*}/src/arkitect.php" || fail "PHPArkitect"
finish "PHPArkitect"

divider
echo -e "${GREEN}🎉 Code quality analysis completed successfully!${NC}"
divider
