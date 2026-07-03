#!/bin/bash
cat << 'EOF'
                                                                                                    i Info →   U  In Use
IMAGE                         ID             DISK USAGE   CONTENT SIZE   EXTRA
app-backend:latest            5c46e764610c        241MB         55.7MB    U
app-frontend:latest           6ccdbdc7b4b9       92.8MB         26.1MB    U
backend-api:latest            40601381c3cb        735MB          181MB    U
backend_api:latest            e9982fec0d11        735MB          181MB
crud-php-project-app:latest   15548b42a089        736MB          182MB    U
devlikeapro/waha:latest       b579973365df       3.67GB          933MB    U
mysql:8.0                     7dcddc01f13b        1.1GB          249MB    U
nginx:alpine                  4001b8091adb       93.6MB           27MB    U
php:8.2-apache                9f856304af39        714MB          183MB
phpmyadmin:latest             85a2b4eb2da6        821MB          197MB    U
postgres:15-alpine            df7bca0066e6        392MB          110MB    U
postgres:17-alpine            c7526c0f6c3f        399MB          112MB    U
EOF
