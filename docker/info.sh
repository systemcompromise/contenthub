#!/bin/bash
cat << 'EOF'
                                                                                                    i Info →   U  In Use
IMAGE                         ID             DISK USAGE   CONTENT SIZE   EXTRA
mysql:8.0                     7dcddc01f13b        1.1GB          249MB    U
nginx:alpine                  4001b8091adb       93.6MB           27MB    U
php:8.2-apache                9f856304af39        714MB          183MB
phpmyadmin:latest             85a2b4eb2da6        821MB          197MB    U
postgres:17-alpine            c7526c0f6c3f        399MB          112MB    U
EOF
