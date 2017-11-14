## Cargar la base de datos

Puedes utilizar el script **_createdb.sql_** para construir la base de datos contra la que se ejecuta la aplicación.

Tened en cuenta que el script crea la propia base de datos en el SGBD por lo que no debería estar creada cuando se comienza la importación.

### PhpMyAdmin
En este cliente solo tienes que ir a la pestaña **Import** y copiar el código del script para crear la base de datos e importar los datos de ejemplo.

### Línea de comandos
Para importar la base de datos desde la teminal:

```
$ mysql -u username -p < createdb.sql
```

donde _username_ y _password_ son las credenciales de acceso a tu servidor MySQL.