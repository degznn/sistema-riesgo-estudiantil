# Sistema de Monitoreo de Riesgo Estudiantil

Aplicacion Laravel + MySQL para carga CSV de estudiantes, asignacion de tutorias, entrevistas, semaforo de riesgo y dashboard institucional.

## Stack y buenas practicas

- Laravel 12 + PHP 8.2+
- MySQL
- Blade + Bootstrap 5 responsive
- Chart.js para dashboard
- Laravel Sanctum para API tokens
- Laravel Excel para importar CSV
- Policies y Gates para permisos
- FormRequest para validaciones
- Repositories y Services para separar logica
- Seeders y Factories
- Logs con `Log::info()` / `Log::error()`
- Railway para despliegue
- GitHub Actions para CI/CD

## Usuarios de prueba

Todos usan la contrasena: `password`

| Rol | Correo |
|---|---|
| Administrador | admin@tecsup.edu.pe |
| Bienestar Estudiantil | bienestar@tecsup.edu.pe |
| Tutor | tutor@tecsup.edu.pe |

## Instalacion local con XAMPP

```powershell
cd C:\xampp83\htdocs\sistema-riesgo-estudiantil
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Abrir:

```text
http://127.0.0.1:8000
```

Config local sugerida:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_riesgo_estudiantil
DB_USERNAME=root
DB_PASSWORD=
LOG_CHANNEL=stack
```

## Estructura profesional

| Capa | Ubicacion |
|---|---|
| Requests | `app/Http/Requests` |
| Policies | `app/Policies` |
| Gates | `app/Providers/AppServiceProvider.php` |
| Repositories | `app/Repositories` |
| Services | `app/Services` |
| Imports Laravel Excel | `app/Imports` |
| Factories | `database/factories` |
| Seeders | `database/seeders` |
| CI/CD | `.github/workflows/deploy.yml` |
| Railway | `railway.json` |

## CSV de estudiantes

Columnas obligatorias:

```csv
codigo,apellidos,nombres,carrera,semestre,grupo
```

Ejemplo:

```csv
codigo,apellidos,nombres,carrera,semestre,grupo
2024001,Quispe Mamani,Luis Alberto,Diseno y Desarrollo de Software,1,AB
2024002,Flores Condori,Ana Maria,Big Data y Ciencia de Datos,1,CD
```

Validaciones:

- Archivo requerido y tipo CSV.
- Columnas obligatorias.
- Filas vacias omitidas.
- Codigo, nombres, apellidos y carrera obligatorios.
- Semestre numerico.
- Grupo con dos letras: `AB`, `CD`, `EF`.
- Codigos duplicados dentro del CSV.
- Codigos duplicados en el mismo periodo.
- Errores mostrados por fila.
- Logs de importacion en `storage/logs/laravel.log`.

## Modulos

- Autenticacion con login/logout y correo `@tecsup.edu.pe`.
- Roles: `administrador`, `bienestar`, `tutor`.
- CRUD de periodos academicos.
- CRUD de tutores.
- Carga CSV con Laravel Excel.
- Asignacion por carrera, ciclo y grupo.
- Tutor ve solo sus estudiantes asignados.
- Entrevistas con seis indicadores.
- Puntaje automatico y semaforo.
- Dashboard con filtros y Chart.js.
- API JSON protegida por Sanctum.

## Semaforo de riesgo

| Nivel | Regla |
|---|---|
| Rojo | >= 14 |
| Ambar | 8 a 13 |
| Verde | <= 7 |

## API con Laravel Sanctum

Obtener token:

```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Accept: application/json" \
  -d "email=admin@tecsup.edu.pe" \
  -d "password=password"
```

Usar token:

```bash
curl -H "Authorization: Bearer TU_TOKEN_SANCTUM" \
  http://127.0.0.1:8000/api/estudiantes
```

Endpoints:

| Metodo | Ruta | Descripcion |
|---|---|---|
| POST | `/api/login` | Genera token Sanctum |
| GET | `/api/estudiantes` | Lista estudiantes |
| GET | `/api/tutores` | Lista tutores |
| GET | `/api/entrevistas` | Lista entrevistas |
| POST | `/api/entrevistas` | Registra entrevista |
| GET | `/api/dashboard` | Resumen dashboard |

## Railway

Variables recomendadas:

```env
APP_NAME="Sistema de Monitoreo de Riesgo Estudiantil"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.up.railway.app
LOG_CHANNEL=stderr
DB_CONNECTION=mysql
DB_HOST=host-mysql
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=password
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

El archivo `railway.json` define el start command:

```bash
php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=${PORT}
```

## GitHub Actions deploy automatico

Workflow:

```text
.github/workflows/deploy.yml
```

Secrets necesarios:

```text
RAILWAY_TOKEN
RAILWAY_SERVICE_ID
```

Flujo:

1. Push a `main`.
2. Instala dependencias.
3. Levanta MySQL de prueba.
4. Ejecuta migraciones.
5. Ejecuta tests.
6. Despliega con Railway CLI.

## Comandos de produccion

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

## Casos de prueba

| Caso | Pasos | Resultado esperado | Estado |
|---|---|---|---|
| Login administrador | Entrar con admin@tecsup.edu.pe | Menu completo | Pendiente demo |
| Correo no Tecsup | Login con Gmail | Error de correo institucional | Pendiente demo |
| Crear periodo | Registrar 2026-I | Periodo listado | Pendiente demo |
| Importar CSV valido | Subir CSV con periodo | Estudiantes cargados | Pendiente demo |
| CSV con duplicados | Repetir codigo | Error por fila | Pendiente demo |
| Crear tutor | Registrar tutor Tecsup | Tutor activo | Pendiente demo |
| Asignar tutor | Asignar por carrera/ciclo/grupo | Estudiantes con tutor | Pendiente demo |
| Login tutor | Entrar como tutor | Ve solo asignados | Pendiente demo |
| Registrar entrevista | Completar indicadores | Puntaje y riesgo calculado | Pendiente demo |
| Dashboard | Ver resumen | Grafico y tabla actualizados | Pendiente demo |
| API sin token | GET /api/estudiantes | 401 | Pendiente demo |
| API con token | GET con Bearer token | JSON correcto | Pendiente demo |

## Flujo demo final

1. Login administrador.
2. Crear periodo academico.
3. Importar CSV de estudiantes.
4. Crear tutor.
5. Asignar tutorias.
6. Login tutor.
7. Registrar entrevista.
8. Mostrar dashboard con Chart.js.
9. Probar API Sanctum.
10. Mostrar README, Railway y GitHub Actions.

## Checklist

- [x] Laravel + MySQL.
- [x] Sanctum.
- [x] Policies y Gates.
- [x] Repositories y Services.
- [x] FormRequest.
- [x] Laravel Excel.
- [x] Chart.js.
- [x] Seeders.
- [x] Factories.
- [x] Logs.
- [x] Railway.
- [x] GitHub Actions.
- [x] README de instalacion, API, pruebas y demo.
