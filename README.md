# Instrucciones para utilizar la aplicación de listas de reproducción en el uso de listas de reproducción

Esta aplicación brinda a los usuarios la posibilidad de crear y almacenar sus propias listas de reproducción, basándose en listas públicas y sus pistas.  
Al almacenar un listado de reproducción, el sistema reemplaza los metadatos del listado y todas las pistas relacionadas en la colección personal del usuario, conectando las pistas con la nueva lista en la base de datos.

**Aspectos fundamentales:**

- Es necesaria la autenticación del usuario, los usuarios deben acceder para almacenar listas de música.
- Se extraen los datos de las listas de reproducción y las pistas del almacenamiento de la sesión antes de su almacenamiento.
- Solo se introducen las pistas en la base de datos si no se han registrado anteriormente, para prevenir duplicados.
- El vínculo entre listas de reproducción y pistas se preserva a través de la tabla dinámica "playlist_tracks".
- Antes de guardarlas, es posible personalizar las carátulas, los nombres y los metadatos de las pistas en las listas de reproducción.
  Las claves de acceso para los temas de las listas de reproducción públicas se rigen por el patrón "public*playlist_tracks*{playlist_id}".

# Ejecucción del proyecto

Para ejecutar el proyecto, vaya a la carpeta PWII-Grup-40 añade archivos .env usando las configuraciones de .env.example tanto en el root de PWII-Grup-40 como en la carpeta www. Después, ejecuta el comando **docker compose up -d --build** en la carpeta PWII-Grup-40. Una vez hecho esto, se creará un contenedor en docker y se podrá acceder a la página web desde el puerto indicado en nginx.
