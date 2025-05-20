## Food Zero

Food Zero is a modern and eco-friendly restaurant that offers a healthy, zero-waste dining experience. Focused on sustainability, it serves fresh, organic, and locally sourced meals in a minimalist yet cozy environment. With a menu inspired by global cuisines, Food Zero caters to all dietary preferences, including vegan, vegetarian, and gluten-free options.

## Technologies Used

- **Laravel**: Backend framework for routing, models, controllers, and database management.
- **Blade**: Templating engine used for rendering views.
- **MySQL**: Database system for storing user and card-related data.

## Launch instructions

1. Clone the repository: `git clone https://github.com/Grizerl/FoodZero.git`.
2. Change to the project folder: `cd zero`.
3. Install the dependencies: `composer install`.
4. Set up the .env file by copying from the example: `cp .env.example .env`.
5. Configure the database connection in your .env file:
DB_CONNECTION=mysql  
DB_HOST=your_database_host  
DB_PORT=your_database_port  
DB_DATABASE=your_database_name  
DB_USERNAME=your_database_user  
DB_PASSWORD=your_database_password
6. Generate the application key: `php artisan key:generate`.
7. Run the database migrations: `php artisan migrate`.
8. Start the Laravel development server: `php artisan serve`.