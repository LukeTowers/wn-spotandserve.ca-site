# About

SpotAndServe.ca is a project built by [Luke Towers](https://github.com/luketowers) & [Vrund Patel](https://github.com/vrund33) for the [2023 URGDSC Hackathon](https://www.eventbrite.ca/e/urgdsc-hackathon-tickets-592545307967?src=hackregina).

### Problem statement

Many people are interested in helping out their community, but they often don't have the time or resources to research ways to do so. As a result, there is a lack of community engagement and limited opportunities for people to contribute to their local area.

### Proposed solution

Our platform seeks to address this problem by providing an easy-to-use and rewarding system for connecting people to volunteer opportunities in their community. The platform will allow users to report areas that could use cleaning or post specific requests for assistance, and provide a range of volunteer opportunities in partnership with local organizations, non-profits, and government agencies. To incentivize users, the platform will incorporate a gamification system and social network aspect, as well as providing a sense of accomplishment through tracking volunteer hours and contributions. To ensure the safety and trustworthiness of users, the platform will implement a verification process and user ratings and reviews. To fund the project, the platform will explore a variety of funding models, such as crowdfunding, partnerships, grants, sponsorships, and merchandise sales.

## Contributing

All development should be done locally using [Homestead](https://laravel.com/docs/9.x/homestead) or any other local development environment.

Pushes to develop are automatically deployed on the [production server](https://spotandserve.ca/).

### Setup

1. Clone the repo
2. Copy .env.example to .env and configure accordingly (APP_URL, DB credentials, and APP_KEY (run `php artisan key:generate`))
3. Install dependencies with `composer install`
4. Install node dependencies with `npm install`
5. Run migrations to initialize your database with `php artisan winter:up`
6. Set the current version of Winter CMS for cache busting `php artisan winter:version`

> **NOTE**: If using the scheduler; ensure that the scheduler is properly configured by following https://wintercms.com/docs/setup/installation#crontab-setup (add `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1` to the crontab)
