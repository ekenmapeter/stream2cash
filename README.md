# Stream2Cash 💰

A modern Laravel-based web application that allows users to earn money by completing various online tasks, surveys, and offers. Stream2Cash provides a seamless platform for users to monetize their time while offering advertisers a way to reach engaged audiences.

## 🚀 Features

### User Features
- **User Authentication**: Complete registration and login system with email verification
- **Task Management**: Browse and apply for available earning tasks
- **Real-time Earnings**: Track earnings and view payment history
- **Multiple Payment Methods**: Withdraw funds through various payment options
- **Responsive Design**: Mobile-first design that works on all devices
- **User Dashboard**: Comprehensive profile and earnings management

### Platform Features
- **Admin Panel**: Manage tasks, users, and payments
- **Task Categories**: Organized task types (surveys, offers, video watching)
- **Payment Processing**: Secure payment handling and verification
- **User Verification**: Email verification and profile completion
- **Analytics**: Track user engagement and earnings

## 🛠️ Technology Stack

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates with Tailwind CSS
- **Authentication**: Laravel Breeze
- **Database**: MySQL
- **Icons**: Font Awesome 6.4.0
- **Animations**: AOS (Animate On Scroll)
- **Styling**: Tailwind CSS with custom color scheme

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/stream2cash.git
   cd stream2cash
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database configuration**
   - Create a MySQL database
   - Update `.env` file with database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=stream2cash
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

## 🎨 Design System

### Color Palette
- **Primary Blue**: `#0A1C64` - Main brand color
- **Secondary Blue**: `#162996` - Accent color
- **Background**: `#081750` - Dark background
- **Accent Yellow**: `#FCD34D` - Call-to-action color
- **Text**: White and gray variations

### Components
- **Header**: Fixed navigation with responsive mobile menu
- **Footer**: Multi-column layout with links and information
- **Cards**: Rounded corners with shadow effects
- **Buttons**: Hover and click animations
- **Forms**: Clean input fields with validation

## 📱 Pages

### Public Pages
- **Home** (`/`) - Landing page with hero section and features
- **About** (`/about`) - Company information and story
- **How It Works** (`/how-it-works`) - Step-by-step process guide
- **Testimonies** (`/testimonies`) - User success stories
- **Contact** (`/contact`) - Contact form and information

### Authentication Pages
- **Login** (`/login`) - User login form
- **Register** (`/register`) - User registration form
- **Forgot Password** (`/forgot-password`) - Password reset request
- **Reset Password** (`/reset-password`) - Password reset form
- **Email Verification** (`/email/verify`) - Email verification page

## 🔐 Authentication

The application uses Laravel Breeze for authentication with the following features:
- Email verification
- Password reset functionality
- Remember me option
- Secure session management
- CSRF protection

## 📊 Database Schema

### Key Tables
- `users` - User accounts and profiles
- `password_reset_tokens` - Password reset functionality
- `failed_jobs` - Failed job queue
- `personal_access_tokens` - API authentication
- `sessions` - User sessions

## 🎯 User Journey

1. **Registration**: Users create an account with email verification
2. **Profile Completion**: Fill in personal details to unlock tasks
3. **Task Discovery**: Browse available earning opportunities
4. **Task Completion**: Complete assigned tasks accurately
5. **Earnings**: Accumulate earnings for completed tasks
6. **Withdrawal**: Cash out through preferred payment method

## 🚀 Deployment

### Production Setup
1. Set up a production server with PHP 8.1+
2. Configure web server (Apache/Nginx)
3. Set up MySQL database
4. Configure environment variables
5. Run migrations and seed data
6. Set up SSL certificate
7. Configure email service for notifications

### Environment Variables
```env
APP_NAME=Stream2Cash
APP_ENV=production
APP_KEY=your_app_key
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_PORT=3306
DB_DATABASE=stream2cash
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

For support, email support@stream2cash.com or join our Discord community.

## 🔮 Roadmap

- [ ] Mobile app development
- [ ] Advanced analytics dashboard
- [ ] Referral program
- [ ] Multi-language support
- [ ] API for third-party integrations
- [ ] Advanced task categories
- [ ] Social media integration

---

**Stream2Cash** - Turning Screen Time Into Earn Time! 💰
