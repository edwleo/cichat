## INSTRUCCIONES ##

**No olvidar**
Ejecutar desde terminal:

_Primero_

```bash
composer install
```

_Segundo_

```bash
php server.php
```

_Tercero_

**En el navegador**
Verificar consola la conexión exitosa

# MIGRACIÓN #

```bash
php spark make:migration averiasMigrate
```

Construye la estructura de la tabla, luego ejecuta la migración
```bash
php spark migrate
```

Crea el seeder

```bash
 php spark make:seeder AveriasSeeder   
 ```

 Construye los datos de prueba dentro del arreglo **$data = []**

 Ejecuta la semilla "_AveriasSeeder_"


```bash
php spark db:seed AveriasSeeder 
 ```
