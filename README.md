<p align="center"><a href="https://softline.com.cy" target="_blank"><img src="https://dtvvdk1fxf9q6.cloudfront.net/logos/softline.svg" width="400"></a></p>

## About Exercise

This exercise was a part of Summer School 2022 webinar that took place on July-August. We built a simple CRM using Laravel Framework in 10 lessons. Application contains the
following parts:

- User Registration/Login
- Contacts CRUD
- Departments CRUD
- Reports Generation
- Queues
- Jobs
- Notifications
- Policies
- Unit/Feature Testing
- Blade views using Bootstrap 5

## Installation

- php -r "file_exists('.env') || copy('.env.example', '.env');"
- php artisan key:generate
- npm install
- composer install
- npm run dev
- php artisan migrate --seed

## Fake Data Population

- php artisan db:seed --class="Database\Seeders\FakeDatabaseSeeder"

## Homework

- Model Unit Tests
- Add notifications to user for various actions
- Create Dashboard with statistics/charts
- Add ability for multiple phones
- Add ability for multiple addresses
- Create more reports
- Add 2-step authentication
- Convert frontend to VueJS

## Security Vulnerabilities

If you discover a security vulnerability within App, please send an e-mail to Marios Vasiliou via [mariosv@softine.com.cy](mailto:mariosv@softline.com.cy). All security
vulnerabilities will be promptly addressed.

## License

The Exercise is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<p align="center"> <b>Made with ❤️ by <a href="https://www.linkedin.com/in/darkpain0/">Marios Vasiliou aka DarkPain</a> <b> </p>
