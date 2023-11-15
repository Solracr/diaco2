## PEX Proyecto Base



- Instalación
- Copiar archivo .env.example en la raíz del proyecto y guardarlo como .env
- Correr la siguiente instrucción por la consola en la raíz del proyecto   
    - <pre>composer install</pre>
- Correr luego la siguiente instrucción
    - <pre>php artisan key:generate</pre>
- Luego configurar en el archivo .env las conexión a la base des datos
  
- correr la siguiente instrucción por consola.
    - <pre>npm install</pre>
    - <pre>npm run watch-poll</pre>
- Luego de configurar todo correr migraciones
    - <pre>php artisan migrate --seed </pre>
    - Para este caso ir a al siguiente path ./database/seeders/DataBaseSeeder.php
        - esto con el fin de modificar los seeders y ver la contraseña configurada para el primer usuario
