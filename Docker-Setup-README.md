# Configuración Docker para QAP Online MySQL

## Estructura de archivos necesaria

Crea la siguiente estructura en tu proyecto:

```
proyecto/
├── Dockerfile
├── docker-compose.yml
├── database/
│   ├── mysql.cnf
│   └── panequik_qaponline_v4.sql
├── logs/
└── Docker-Setup-README.md
```

## Preparación

1. **Crear directorio database:**
   ```bash
   mkdir database
   mkdir logs
   ```

2. **Colocar el archivo SQL:**
   - Copia tu archivo `panequik_qaponline_v4.sql` en la carpeta `database/`

## Comandos para ejecutar

### Construir y ejecutar por primera vez:
```bash
docker-compose up --build -d
```

### Ejecutar después de la primera vez:
```bash
docker-compose up -d
```

### Detener los contenedores:
```bash
docker-compose down
```

### Ver logs:
```bash
docker-compose logs mysql_qaponline
docker-compose logs phpmyadmin
```

## Acceso a los servicios

- **MySQL:** `localhost:3306`
  - Usuario: `u669796078_panequik_qap`
  - Contraseña: `QuikSAS2019*`
  - Base de datos: `u669796078_panequik_qap`

- **phpMyAdmin:** `http://localhost:8080`
  - Usuario: `u669796078_panequik_qap`
  - Contraseña: `QuikSAS2019*`

## Configuración para tu aplicación PHP

Modifica tu archivo `php/sql_connection.php`:

```php
$db_host = "localhost"; // o "mysql_qaponline" si PHP también está en Docker
$db_user = "u669796078_panequik_qap";
$db_pass = "QuikSAS2019*";
$db_name = "u669796078_panequik_qap";
```

## Comandos útiles

### Acceder al contenedor MySQL:
```bash
docker exec -it qaponline_mysql mysql -u u669796078_panequik_qap -p
```

### Backup de la base de datos:
```bash
docker exec qaponline_mysql mysqldump -u u669796078_panequik_qap -p u669796078_panequik_qap > backup.sql
```

### Restaurar backup:
```bash
docker exec -i qaponline_mysql mysql -u u669796078_panequik_qap -p u669796078_panequik_qap < backup.sql
```

### Ver estado de los contenedores:
```bash
docker-compose ps
```

## Solución de problemas

### Si el contenedor no inicia:
```bash
docker-compose logs mysql_qaponline
```

### Eliminar volúmenes y empezar desde cero:
```bash
docker-compose down -v
docker-compose up --build -d
```

### Verificar conectividad:
```bash
docker exec qaponline_mysql mysqladmin ping -h localhost
```

## Notas importantes

- Los datos se almacenan en un volumen Docker persistente
- La configuración está optimizada para MySQL 5.7.44
- El timezone está configurado para America/Bogota
- La base de datos se inicializa automáticamente con tu archivo SQL