<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

# Laboratory 5 API Documentation

## API Version

Current version: `/api/78709/v1`

Base endpoint:

```text
http://127.0.0.1:8080/api/78709/v1/tasks
```

Health endpoint:

```text
http://127.0.0.1:8080/api/health
```

## Status Codes

- `200 OK` – successful read or update operation
- `201 Created` – resource successfully created
- `204 No Content` – resource successfully deleted
- `404 Not Found` – requested resource does not exist
- `422 Unprocessable Content` – validation error

## API Endpoints

### Get all tasks

```http
GET /api/78709/v1/tasks
```

Expected status: `200 OK`

### Create a task

```http
POST /api/78709/v1/tasks
```

Expected status: `201 Created`

Example JSON body:

```json
{
  "title": "Example task",
  "description": "Task description",
  "status": "pending",
  "album_number": "1"
}
```

### Get one task

```http
GET /api/78709/v1/tasks/{id}
```

Expected status: `200 OK`

If the task does not exist: `404 Not Found`

### Update a task

```http
PUT /api/78709/v1/tasks/{id}
```

Expected status: `200 OK`

Example JSON body:

```json
{
  "title": "Updated task",
  "description": "Updated task description",
  "status": "done",
  "album_number": "1"
}
```

### Delete a task

```http
DELETE /api/78709/v1/tasks/{id}
```

Expected status: `204 No Content`

## Error Responses

### Missing resource

Expected status: `404 Not Found`

```json
{
  "error": {
    "status": 404,
    "message": "Task not found",
    "path": "/api/78709/v1/tasks/99999"
  }
}
```

### Validation error

Expected status: `422 Unprocessable Content`

```json
{
  "message": "The title field is required. (and 1 more error)",
  "errors": {
    "title": [
      "The title field is required."
    ],
    "album_number": [
      "The album number field is required."
    ]
  }
}
```

## Cache Behavior

The API uses Redis caching for the task list endpoint.

- `GET /api/78709/v1/tasks` repopulates the cache.
- `POST /api/78709/v1/tasks` invalidates the cache.
- `PUT /api/78709/v1/tasks/{id}` invalidates the cache.
- `DELETE /api/78709/v1/tasks/{id}` invalidates the cache.

Redis cache database:

```text
REDIS_CACHE_DB=1
```

Useful cache test commands:

```bash
docker compose exec redis redis-cli -n 1 FLUSHDB
docker compose exec redis redis-cli -n 1 DBSIZE
curl http://127.0.0.1:8080/api/78709/v1/tasks
docker compose exec redis redis-cli -n 1 DBSIZE
```

## Full API Flow Test

### GET

```bash
curl -i -H "Accept: application/json" http://127.0.0.1:8080/api/78709/v1/tasks
```

Expected status: `200 OK`

### POST

```bash
curl -i -X POST http://127.0.0.1:8080/api/78709/v1/tasks \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"title":"Full flow test","description":"Step 8 test","status":"pending","album_number":"8"}'
```

Expected status: `201 Created`

### PUT

Replace `{id}` with the id returned from the POST response.

```bash
curl -i -X PUT http://127.0.0.1:8080/api/78709/v1/tasks/{id} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"title":"Updated full flow test","description":"Updated Step 8 test","status":"done","album_number":"8"}'
```

Expected status: `200 OK`

### DELETE

Replace `{id}` with the id returned from the POST response.

```bash
curl -i -X DELETE http://127.0.0.1:8080/api/78709/v1/tasks/{id} \
  -H "Accept: application/json"
```

Expected status: `204 No Content`