#!/bin/bash
set -e

# Desactivar todos los módulos MPM para evitar duplicados
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true
a2dismod mpm_prefork 2>/dev/null || true

# Activar únicamente mpm_prefork (requerido por PHP)
a2enmod mpm_prefork

# Iniciar Apache en primer plano
exec apache2-foreground