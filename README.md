## Prueba Técnica PHP(Symfony)

Creación de un API y conexión a otra externa mediante el framework de PHP 'Symfony'.

---

### Introducción

Necesitamos una prueba piloto de un sistema de gestión de una colección de VHS para uno de nuestros productos. Lo queremos mantener separado, así que debemos empezar un nuevo proyecto.

Empezaremos con algo sencillo, sólo queremos poder:

- Dar de alta películas.
- Listar películas

### Acceso al Contenido

Vamos a necesitar acceder al contenido desde otras aplicaciones, lo que nos requiere exponer una API. Como base de datos deberás utilizar MariaDB/MySQL, puedes:

1. Montarla por separado.
2. Incluir la configuración de docker-compose directamente en el proyecto.

### Secciones del Proyecto

Por tanto, este proyecto debe tener 2 secciones:

1. Endpoint para la obtención del listado de VHS.
2. Endpoint para la creación de un nuevo VHS.

_**Nota:** En este punto deberás también obtener datos adicionales sobre la película desde TheMovieDB (explicado más abajo)._

### Obtención de Datos

Para la obtención de datos desde TheMovieDB, simplemente deberás obtener los datos de la película y añadirlos a los datos que llegan al endpoint. Por ejemplo, si el cuerpo de la petición es este:

```json
{
  "name": "Spider-Man: No Way Home",
  "moviedb_id": 123
}
```

La entidad resultante debería ser algo parecido a esto:

```json
{
  "name": "",
  "full_details": {
    "adult": false,
    "backdrop_path": "/iQFcwSGbZXMkeyKrxbPnwnRo5fl.jpg",
    "genre_ids": [28, 12, 878],
    "id": 634649,
    "original_language": "en",
    "original_title": "Spider-Man: No Way Home",
    "overview": "Peter Parker is unmasked and no longer able to separate his normal life from the high-stakes of being a super-hero. When he asks for help from Doctor Strange the stakes become even more dangerous, forcing him to discover what it truly means to be Spider-Man.",
    "popularity": 6120.418,
    "poster_path": "/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg",
    "release_date": "2021-12-15",
    "title": "Spider-Man: No Way Home",
    "video": false,
    "vote_average": 8.2,
    "vote_count": 11355
  }
}
```

Para obtener los datos debes usar el endpoint de detalles de una película: [https://api.themoviedb.org/3/movie/{movie_id}?api_key=<<api_key>>&language=en-US](https://api.themoviedb.org/3/movie/{movie_id}?api_key=<<api_key>>&language=en-US)

Puede utilizar este API KEY de TheMovieDB API: 152718166a0c49e6dcceb43f7d5bfc21

\_**Nota**: El ID de la película en TheMovieDB es parte de lo que se enviará al endpoint para la creación. Puedes obtener IDs de películas haciendo una llamada manual al endpoint de películas populares: [https://api.themoviedb.org/3/movie/popular?api_key=<<api_key>>&language=en-US&page=1](https://api.themoviedb.org/3/movie/popular?api_key=<<api_key>>&language=en-US&page=1)

### Objetivo de la prueba

El objetivo de la prueba es la demostración de conocimientos en Symfony y PHP, por lo que se primará el cuidado de la estructura backend:

- Aplicación de principios SOLID.
- Correcta separación de servicios y responsabilidades.
- Introducción de interfaces, tolerancia ante fallos, etc.

### Requisitos Técnicos

Puedes usar librerías adicionales a las del framework si lo necesitas, pero deberás cumplir estos requisitos:

- **PHP 8+**
- **Composer**
- La última versión estable de **Symfony**
- **Testing unitario**
- La API debe devolver y consumir los datos en formato **JSON**

### Valorable (Opcional)

- Uso de herramientas de análisis estático:
  - Por ejemplo, **PHPStan** en modo máximo.
- Uso de herramientas de estilo de código:
  - Por ejemplo, **PHP CS Fixer** en modo @Symfony.
- Ofrecer un **Swagger/OpenAPI**.
