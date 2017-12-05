# Instalación

Configurar el archivo .env.example con tus datos de acceso a la base de datos.
Renombrar el **.env.example** a **.env**
## Cargar la base de datos

Puedes utilizar el script **_createdb.sql_** para construir la base de datos contra la que se ejecuta la aplicación.

### Línea de comandos
Para importar la base de datos desde la teminal:

```
$ mysql -u username -p < createdb.sql
```

donde _username_ y _password_ son las credenciales de acceso a tu servidor MySQL.