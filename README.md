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

## Docker

Prerequisites: Docker Desktop with Compose enabled.

Copy `.env.example` to `.env`, generate the application key, then start the development environment:

```powershell
Copy-Item .env.example .env
docker compose run --rm app php artisan key:generate
docker compose up --build
```

The application is available at `http://localhost:8000` and Vite at `http://localhost:5173`.
Migrations run automatically when the Laravel container starts. The MySQL data, Composer dependencies and Node dependencies are stored in named Docker volumes.

To stop the services, run `docker compose down`. To remove the database as well, run `docker compose down -v`.

## CI et livraison continue

### CI - Integration continue

GitHub Actions executes the following validation pipeline on every commit and pull request targeting `main` or `master`:

`Commit / Pull Request -> dependency installation -> Vite build -> Laravel tests -> composer audit -> npm audit -> Docker image build -> Trivy scan -> validation`

The Docker image build and its Trivy security scan are part of continuous integration.

### Livraison continue

After a successful CI run on `main`, the continuous delivery workflow publishes the Docker image to GitHub Container Registry with these tags, then deploys it automatically to the examination VM through a self-hosted GitHub Actions runner:

- `ghcr.io/<owner>/<repository>:latest`
- `ghcr.io/<owner>/<repository>:sha-<commit>`

The image can be pulled on a deployment server with:

```powershell
docker login ghcr.io
docker pull ghcr.io/<owner>/<repository>:latest
```

### VM deployment

The following preparation is only required once on the Ubuntu VM. Clone the repository into `/opt/cesizen`, then create the production environment file:

```bash
sudo git clone https://github.com/oussama604/cesizen_project.git /opt/cesizen
cd /opt/cesizen
sudo cp .env.production.example .env
sudo nano .env
sudo docker run --rm ghcr.io/oussama604/cesizen_project:latest php artisan key:generate --show
```

Set the displayed key as `APP_KEY` in `.env`, replace both `CHANGE_ME` values with strong database passwords, then start the published image and MySQL:

```bash
sudo docker compose -f docker-compose.prod.yml pull
sudo docker compose -f docker-compose.prod.yml up -d
```

The application is then available at `http://192.168.0.14:8000`. The first startup runs Laravel migrations. For the examination demo data, run `sudo docker compose -f docker-compose.prod.yml exec app php artisan db:seed` once after startup.

Register a GitHub Actions self-hosted runner on the VM from the repository's **Settings > Actions > Runners > New self-hosted runner** page. Select Linux x64 and run the commands GitHub displays on the VM. Configure the runner to start as a service, and ensure its user can run Docker commands.

Once the runner is online, every successful CI run on `main` automatically pulls the published GHCR image and restarts the services with `docker compose -f docker-compose.prod.yml up -d --remove-orphans`.

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
