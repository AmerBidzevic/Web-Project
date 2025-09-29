# Respawn Shop - E-commerce Web Application

A modern, full-stack e-commerce web application built with PHP backend and vanilla JavaScript frontend. This project implements a complete online gaming merchandise store with user authentication, product management, shopping cart, and admin panel functionality.

## Live Demo

The application is currently designed to run on a local XAMPP server environment.

**Note:** This project was originally planned for cloud deployment (AWS/Heroku/DigitalOcean) in the final development phase, but was reverted to local hosting for simplicity and ease of setup during development and testing. The codebase is deployment-ready and can be easily adapted for production hosting environments.

## Features

### User Features

- **User Registration & Authentication** - Secure JWT-based authentication system
- **Product Browsing** - Browse gaming merchandise with detailed product pages
- **Shopping Cart** - Add, remove, and manage items in cart
- **Checkout Process** - Complete purchase transactions
- **Product Reviews** - Read and write product reviews
- **User Profile Management** - Update personal information

### Admin Features

- **Admin Dashboard** - Comprehensive admin panel
- **Product Management** - CRUD operations for products
- **User Management** - Manage user accounts and permissions
- **Transaction Monitoring** - View and manage all transactions
- **Review Moderation** - Moderate user reviews

### Technical Features

- **RESTful API** - Well-structured REST API with proper HTTP methods
- **JWT Authentication** - Secure token-based authentication
- **CORS Support** - Cross-origin resource sharing enabled
- **Input Validation** - Server-side validation and sanitization
- **Error Handling** - Comprehensive error handling and logging
- **Unit Testing** - PHPUnit test suite for backend components

## Technology Stack

### Backend

- **PHP 8.x** - Server-side scripting language
- **FlightPHP 3.15** - Lightweight PHP micro-framework for RESTful APIs
- **MySQL/MariaDB** - Relational database management system
- **PDO** - PHP Data Objects for database interactions
- **JWT (Firebase)** - JSON Web Tokens for authentication
- **Swagger/OpenAPI 3.3** - API documentation
- **PHPUnit 9.6** - Unit testing framework
- **Composer** - Dependency management

### Frontend

- **HTML5** - Markup language
- **CSS3/SCSS** - Styling and preprocessor
- **Vanilla JavaScript (ES6+)** - Client-side scripting
- **Bootstrap 5** - CSS framework for responsive design
- **jQuery** - JavaScript library for DOM manipulation
- **Font Awesome 5.10** - Icon library
- **Animate.css** - CSS animation library
- **Owl Carousel** - Touch enabled jQuery plugin for carousels

### Development Tools

- **XAMPP** - Local development environment
- **Git** - Version control system
- **VS Code** - Code editor
- **Postman** - API testing (recommended)

## Project Structure

```
Web-Project/
├── README.md
└── project-folder/
    ├── backend/                    # PHP Backend API
    │   ├── composer.json          # PHP dependencies
    │   ├── config.php             # Database configuration
    │   ├── Database.php           # Database connection class
    │   ├── index.php              # Main entry point
    │   ├── phpunit.xml            # PHPUnit configuration
    │   ├── dump-webdev_project-202506081158.sql  # Database schema
    │   ├── dao/                   # Data Access Objects
    │   │   ├── BaseDao.php        # Base DAO class
    │   │   ├── UsersDao.php       # User data operations
    │   │   ├── ProductsDao.php    # Product data operations
    │   │   ├── ReviewsDao.php     # Review data operations
    │   │   ├── TransactionsDao.php # Transaction data operations
    │   │   ├── AdministratorsDao.php # Admin data operations
    │   │   └── AuthDao.php        # Authentication operations
    │   ├── services/              # Business Logic Layer
    │   │   ├── BaseService.php    # Base service class
    │   │   ├── UsersService.php   # User business logic
    │   │   ├── ProductsService.php # Product business logic
    │   │   ├── ReviewsService.php # Review business logic
    │   │   ├── TransactionsService.php # Transaction business logic
    │   │   ├── AdministratorsService.php # Admin business logic
    │   │   └── AuthService.php    # Authentication business logic
    │   ├── routes/                # API Routes
    │   │   ├── UserRoutes.php     # User-related endpoints
    │   │   ├── ProductRoutes.php  # Product-related endpoints
    │   │   ├── ReviewRoutes.php   # Review-related endpoints
    │   │   ├── TransactionRoutes.php # Transaction-related endpoints
    │   │   ├── AdminRoutes.php    # Admin-related endpoints
    │   │   └── AuthRoutes.php     # Authentication endpoints
    │   ├── middleware/            # Middleware Components
    │   │   └── AuthMiddleware.php # JWT authentication middleware
    │   ├── test/                  # Unit Tests
    │   │   ├── AuthRoutesTest.php # Authentication tests
    │   │   ├── ProductRoutesTest.php # Product tests
    │   │   └── ReviewRoutesTest.php # Review tests
    │   ├── data/                  # Static Data
    │   │   └── roles.php          # User roles configuration
    │   └── vendor/                # Composer dependencies
    └── frontend/                  # Frontend Application
        ├── index.html             # Main HTML file
        ├── README.md              # Frontend documentation
        ├── css/                   # Stylesheets
        │   ├── bootstrap.min.css  # Bootstrap framework
        │   ├── style.css          # Custom styles
        │   └── style.min.css      # Minified custom styles
        ├── scss/                  # SCSS Source Files
        │   ├── style.scss         # Main SCSS file
        │   └── bootstrap/         # Bootstrap SCSS components
        ├── js/                    # JavaScript Files
        │   ├── main.js            # Main application logic
        │   └── services/          # Service layer
        │       ├── ApiService.js  # API communication service
        │       └── AuthService.js # Authentication service
        ├── img/                   # Images and Assets
        │   ├── carousel-*.jpg     # Carousel images
        │   ├── product-*.jpg      # Product images
        │   └── WebProject-ER_Diagram-AmerBidzevic.png # Database ER Diagram
        ├── lib/                   # Third-party Libraries
        │   ├── animate/           # Animation library
        │   ├── easing/            # Easing functions
        │   └── owlcarousel/       # Carousel component
        └── tpl/                   # HTML Templates
            ├── home.html          # Homepage template
            ├── shop.html          # Shop page template
            ├── detailed_product.html # Product details template
            ├── shopping_cart.html # Shopping cart template
            ├── checkout.html      # Checkout page template
            ├── contact.html       # Contact page template
            └── admin_panel.html   # Admin dashboard template
```

## Database Schema

The application uses a MySQL database with the following main entities:

### Tables

- **users** - User account information and profiles
- **admins** - Administrator accounts with roles and permissions
- **products** - Product catalog with details, pricing, and inventory
- **reviews** - Product reviews and ratings from users
- **transactions** - Purchase transactions and order history

### Relationships

- Users can have multiple transactions
- Users can write multiple reviews
- Products can have multiple reviews
- Transactions are linked to users and products
- Admins are linked to user accounts

## Installation

### Prerequisites

- **XAMPP** (Apache, MySQL, PHP 8.x)
- **Composer** (PHP package manager)
- **Git** (version control)
- **Web browser** (Chrome, Firefox, Safari, Edge)

### Step 1: Clone the Repository

```bash
git clone https://github.com/AmerBidzevic/Web-Project.git
cd Web-Project
```

### Step 2: Set Up XAMPP

1. Install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Start Apache and MySQL services
3. Copy the project to `C:\xampp\htdocs\` (Windows) or `/opt/lampp/htdocs/` (Linux)

### Step 3: Database Setup

1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `webdev_project`
3. Import the SQL file: `project-folder/backend/dump-webdev_project-202506081158.sql`

### Step 4: Install Backend Dependencies

```bash
cd project-folder/backend
composer install
```

### Step 5: Configure Database Connection

Update the database configuration in `project-folder/backend/config.php`:

```php
public static function DB_NAME() {
    return 'webdev_project';
}

public static function DB_USER() {
    return 'root'; // Your MySQL username
}

public static function DB_PASS() {
    return ''; // Your MySQL password
}
```

### Step 6: Access the Application

- **Frontend**: http://localhost/Web-Project/project-folder/frontend/
- **Backend API**: http://localhost/Web-Project/project-folder/backend/
- **API Documentation**: http://localhost/Web-Project/project-folder/backend/public/v1/docs/

## Configuration

### Environment Variables

The application uses configuration files instead of environment variables:

- **Backend Config**: `project-folder/backend/config.php`
- **Database Config**: `project-folder/backend/dao/config.php`

### CORS Configuration

CORS is configured in `project-folder/backend/index.php`:

```php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Authentication");
```

## API Documentation

### Authentication Endpoints

- `POST /auth/login` - User login
- `POST /auth/register` - User registration
- `POST /auth/logout` - User logout

### Product Endpoints

- `GET /products` - Get all products
- `GET /products/{id}` - Get product by ID
- `POST /products` - Create new product (Admin)
- `PUT /products/{id}` - Update product (Admin)
- `DELETE /products/{id}` - Delete product (Admin)

### User Endpoints

- `GET /users` - Get all users (Admin)
- `GET /users/{id}` - Get user by ID
- `PUT /users/{id}` - Update user profile
- `DELETE /users/{id}` - Delete user account

### Review Endpoints

- `GET /reviews` - Get all reviews
- `GET /reviews/product/{productId}` - Get reviews for a product
- `POST /reviews` - Create new review
- `PUT /reviews/{id}` - Update review
- `DELETE /reviews/{id}` - Delete review

### Transaction Endpoints

- `GET /transactions` - Get all transactions (Admin)
- `GET /transactions/user/{userId}` - Get user transactions
- `POST /transactions` - Create new transaction
- `PUT /transactions/{id}` - Update transaction status

### Admin Endpoints

- `GET /admin/dashboard` - Get admin dashboard data
- `GET /admin/users` - Manage users
- `GET /admin/products` - Manage products
- `GET /admin/transactions` - Manage transactions

## Testing

### Running Backend Tests

```bash
cd project-folder/backend
composer test
# or
vendor/bin/phpunit
```

### Test Coverage

The test suite covers:

- Authentication routes and services
- Product management functionality
- Review system operations
- API endpoint validation

### Manual Testing

Use tools like Postman or curl to test API endpoints:

```bash
# Login example
curl -X POST http://localhost/Web-Project/project-folder/backend/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email": "test@example.com", "password": "password123"}'
```

## Author

**Amer Bidzevic**

- GitHub: [@AmerBidzevic](https://github.com/AmerBidzevic)
- Email: [bdzamer@gmail.com](mailto:bdzamer@gmail.com)

## Acknowledgments

- FlightPHP framework for the lightweight REST API structure
- Bootstrap team for the responsive CSS framework
- Font Awesome for the comprehensive icon library
- The open-source community for various libraries and tools used

## Future Enhancements

- [ ] Payment gateway integration (Stripe, PayPal)
- [ ] Real-time notifications using WebSockets
- [ ] Product recommendation system
- [ ] Multi-language support (i18n)
- [ ] Mobile app development (React Native)
- [ ] Advanced analytics dashboard
- [ ] Inventory management system
- [ ] Email marketing integration
- [ ] Social media login (OAuth)
- [ ] Performance optimization and caching

---

**Made by Amer Bidzevic**
