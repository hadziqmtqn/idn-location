#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color
echo -e "${GREEN}================================${NC}"
echo -e "${GREEN}IDN Location Docker Manager${NC}"
echo -e "${GREEN}================================${NC}"

# Function to start containers
start() {
    echo -e "${YELLOW}Starting Docker containers...${NC}"
    docker-compose up -d
    echo -e "${GREEN}Containers started successfully!${NC}"
}

# Function to stop containers
stop() {
    echo -e "${YELLOW}Stopping Docker containers...${NC}"
    docker-compose down
    echo -e "${GREEN}Containers stopped successfully!${NC}"
}

# Function to restart containers
restart() {
    echo -e "${YELLOW}Restarting Docker containers...${NC}"
    docker-compose restart
    echo -e "${GREEN}Containers restarted successfully!${NC}"
}

# Function to build containers
build() {
    echo -e "${YELLOW}Building Docker containers...${NC}"
    docker-compose build --no-cache
    echo -e "${GREEN}Containers built successfully!${NC}"
}

# Function to run migrations
migrate() {
    echo -e "${YELLOW}Running migrations...${NC}"
    docker-compose exec app php artisan migrate
    echo -e "${GREEN}Migrations completed!${NC}"
}

# Function to seed database
seed() {
    echo -e "${YELLOW}Seeding database...${NC}"
    docker-compose exec app php artisan db:seed
    echo -e "${GREEN}Database seeded!${NC}"
}

# Function to clear cache
clear_cache() {
    echo -e "${YELLOW}Clearing cache...${NC}"
    docker-compose exec app php artisan cache:clear
    docker-compose exec app php artisan config:clear
    docker-compose exec app php artisan route:clear
    docker-compose exec app php artisan view:clear
    echo -e "${GREEN}Cache cleared!${NC}"
}

# Function to install dependencies
install() {
    echo -e "${YELLOW}Installing dependencies...${NC}"
    docker-compose exec app composer install
    docker-compose exec app npm install
    echo -e "${GREEN}Dependencies installed!${NC}"
}

# Function to show logs
logs() {
    docker-compose logs -f
}

# Function to access bash
bash() {
    docker-compose exec app bash
}

# Main menu
case "$1" in
    start)
        start
        ;;
    stop)
        stop
        ;;
    restart)
        restart
        ;;
    build)
        build
        ;;
    migrate)
        migrate
        ;;
    seed)
        seed
        ;;
    clear)
        clear_cache
        ;;
    install)
        install
        ;;
    logs)
        logs
        ;;
    bash)
        bash
        ;;
    *)
        echo -e "${YELLOW}Usage: $0 {start|stop|restart|build|migrate|seed|clear|install|logs|bash}${NC}"
        echo ""
        echo "Commands:"
        echo "  start    - Start Docker containers"
        echo "  stop     - Stop Docker containers"
        echo "  restart  - Restart Docker containers"
        echo "  build    - Build Docker containers"
        echo "  migrate  - Run database migrations"
        echo "  seed     - Seed database"
        echo "  clear    - Clear application cache"
        echo "  install  - Install dependencies"
        echo "  logs     - Show container logs"
        echo "  bash     - Access container bash"
        exit 1
        ;;
esac
