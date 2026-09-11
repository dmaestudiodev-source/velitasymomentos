#!/bin/bash
set -e

# Asignar puerto 80 por defecto si la variable PORT no está definida por Railway
PORT="${PORT:-80}"

# Reemplazar el puerto de escucha predeterminado (80) por el puerto asignado en $PORT
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/*.conf

# Limpiar módulos MPM en conflicto y activar mpm_prefork
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true
a2dismod mpm_prefork 2>/dev/null || true
a2enmod mpm_prefork

# Arrancar Apache
exec apache2-foreground