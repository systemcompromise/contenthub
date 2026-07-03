#!/bin/bash
# ==========================================================
# docker-images-info.sh
# ContentHub - Docker Images Info
# ==========================================================

BOLD='\033[1m'
RESET='\033[0m'

echo "════════════════════════════════════════"
echo " DOCKER IMAGES INFO (ContentHub - Railway)"
echo "════════════════════════════════════════"
echo "Build Base   : php:8.2-apache"
echo "PHP Ext      : pdo pdo_pgsql pgsql zip opcache"
echo "Apache Mods  : rewrite headers"
echo "APT Packages : libpq-dev libzip-dev zip unzip curl"
echo "Entrypoint   : /entrypoint.sh"
echo "Exposed Port : 80"
echo "════════════════════════════════════════"
echo ""

# Cek apakah docker tersedia
if ! command -v docker &> /dev/null; then
    echo "Error: perintah 'docker' tidak ditemukan di sistem ini."
    exit 1
fi

# Tampilkan legend seperti tampilan asli docker desktop
echo "                                                                                                    i Info \xe2\x86\x92   U  In Use"

# Jalankan docker images asli, lalu tandai image yang dipakai Dockerfile (php:8.2-apache)
docker images | while IFS= read -r line; do
    if [[ "$line" == *"php:8.2-apache"* ]] || [[ "$line" == *"backend-api"* ]] || [[ "$line" == *"backend_api"* ]]; then
        echo -e "${BOLD}${line}${RESET}   <-- used by this Dockerfile"
    else
        echo "$line"
    fi
done

echo ""
echo "════════════════════════════════════════"
