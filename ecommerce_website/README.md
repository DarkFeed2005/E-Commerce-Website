# E-Commerce Website

A complete, production-ready multi-vendor e-commerce platform built with Laravel 11, Livewire, and Tailwind CSS.

## Features

### 🎯 Core Features
- **Multi-Vendor Marketplace**: Multiple vendors can register, manage products, and track sales
- **Role-Based Access**: Admin, Vendor, and Customer roles with appropriate permissions
- **Product Management**: Full CRUD with approval workflow, image uploads, and inventory tracking
- **Shopping Cart**: Real-time cart system with Livewire
- **Order Management**: Complete order lifecycle with status tracking
- **Payment Integration**: Stripe and PayPal support (ready to configure)
- **Review System**: Customer reviews with ratings and admin approval
- **Category Management**: Nested categories with SEO fields
- **Address Management**: Customer address book with default address support

### 🤖 AI Features
- **Smart Recommendations**: AI-powered product suggestions based on browsing history
- **Related Products**: Intelligent cross-selling algorithm
- **Trending Products**: Automated trending product detection

### 🛡️ Security & Performance
- **Authentication**: Laravel Breeze with email verification
- **Authorization**: Role-based middleware and policies
- **Input Validation**: Comprehensive request validation
- **SEO Optimized**: Meta tags, friendly URLs, and structured data

### 🎨 UI/UX Features
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Dark Mode**: Built-in dark/light theme support
- **Real-time Updates**: Livewire-powered dynamic content
- **Modern Interface**: Clean, professional design

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade + Tailwind CSS + Alpine.js
- **Real-time**: Livewire 3
- **Database**: MySQL (configurable)
- **Authentication**: Laravel Breeze
- **Payments**: Laravel Cashier (Stripe) + PayPal SDK

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd ecommerce_website
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Storage linking**
   ```bash
   php artisan storage:link
   ```

6. **Frontend build**
   ```bash
   npm run build
   ```

## Environment Variables

Configure these variables in your `.env` file:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=

# Payment Gateways
STRIPE_KEY=pk_test_xxxx
STRIPE_SECRET=sk_test_xxxx
PAYPAL_CLIENT_ID=xxxx
PAYPAL_CLIENT_SECRET=xxxx
PAYPAL_MODE=sandbox

# Mail
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Application
APP_URL=http://localhost:8000
```

## Default Users

After running `db:seed`, you can use these test accounts:

| Role | Email | Password |
|------|--------|----------|
| Admin | admin@ecommerce.test | password |
| Vendor | vendor1@ecommerce.test | password |
| Customer | customer1@ecommerce.test | password |

## Key Commands

```bash
# Development
php artisan serve                # Start development server
npm run dev                   # Watch assets
php artisan migrate:fresh --seed # Fresh database with seed

# Queue (if needed)
php artisan queue:work

# Cache
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
```

## Architecture Overview

### Database Structure
- **Users**: Multi-role authentication system
- **Products**: Vendor products with approval workflow  
- **Categories**: Hierarchical category structure
- **Orders**: Complete order management
- **Cart Items**: Session + database cart system
- **Reviews**: Customer feedback system
- **Payments**: Transaction records

### Key Patterns
- **Repository Pattern**: For data access abstraction
- **Service Classes**: For business logic
- **Form Requests**: For validation
- **Policies**: For authorization
- **Livewire**: For dynamic components

## Features in Detail

### Multi-Vendor System
- Vendors can register and await admin approval
- Each vendor has their own product catalog
- Commission tracking (configurable rates)
- Vendor dashboard with sales analytics

### Product Management
- Product approval workflow (admin approval required)
- Bulk operations (approve, suspend, delete)
- Image uploads with automatic optimization
- Inventory tracking and alerts
- SEO fields for every product

### Shopping Experience
- Real-time cart updates
- Product search with filters
- Category browsing
- Recently viewed products
- Personalized recommendations

### Admin Features
- Comprehensive dashboard with metrics
- User management with role assignment
- Order management and fulfillment
- Financial reporting
- System notifications

## Security Features

- CSRF protection on all forms
- SQL injection prevention via Eloquent
- XSS protection via Blade escaping
- Rate limiting on sensitive routes
- Input validation and sanitization
- Role-based access control

## Performance Optimizations

- Database indexing on foreign keys
- Query optimization with eager loading
- Image lazy loading
- Page caching for static content
- CDN ready for assets
- Minified production builds

## Payment Configuration

### Stripe Setup
```bash
php artisan cashier:install
```

1. Configure Stripe keys in `.env`
2. Add webhook endpoints in Stripe dashboard
3. Test with Stripe test cards

### PayPal Setup
1. Create PayPal Developer account
2. Configure client credentials in `.env`
3. Set up webhooks for IPN

## Deployment

### Production Deployment
```bash
# Setup production environment
composer install --optimize-autoloader --no-dev
npm run build

# Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage
php artisan storage:link
```

### Deployment Checklist
- [ ] Set production APP_ENV
- [ ] Configure production database
- [ ] Set strong APP_KEY
- [ ] Configure mail settings
- [ ] Set up SSL certificates
- [ ] Configure payment gateways
- [ ] Set up cron jobs for queues
- [ ] Configure backup strategy

## Testing

```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter Feature/ProductTest

# Generate coverage report
php artisan test --coverage
```

## Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -am 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Support

For questions or support:
- Check the [documentation](docs/README.md)
- Create an issue for bugs
- Start a discussion for feature requests

## License

This project is licensed under the MIT License - see the LICENSE file for details.