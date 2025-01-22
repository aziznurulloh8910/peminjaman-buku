Link Dokumentasi API :
https://documenter.getpostman.com/view/18879257/2sA3kbhJt3

# Laravel Project Documentation

## Installation

Follow these steps to set up the project:

### Prerequisites
- PHP >= 8.0
- Composer
- MySQL or any other supported database
- Node.js & NPM (for frontend assets, if applicable)

### Steps to Install

1. **Clone the Repository**
   ```sh
   git clone https://github.com/aziznurulloh8910/peminjaman-buku.git
   cd your-repository
   ```

2. **Install Dependencies**
   ```sh
   composer install
   npm install  # If using frontend assets
   ```

3. **Create Environment File**
   ```sh
   cp .env.example .env
   ```
   Update the `.env` file with your database and application configurations.

4. **Generate Application Key**
   ```sh
   php artisan key:generate
   ```

5. **Run Migrations and Seeders**
   ```sh
   php artisan migrate --seed
   ```

6. **Serve the Application**
   ```sh
   php artisan serve
   ```
   The application should be accessible at `http://127.0.0.1:8000`

## Default Admin Credentials
You can log in with the following admin credentials:

- **Email**: admin@mail.com
- **Password**: password

## Additional Commands

- **Clear Cache**
  ```sh
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  ```

- **Run Queue Workers** (If using queues)
  ```sh
  php artisan queue:work
  ```

- **Run Scheduler** (If using scheduled tasks)
  ```sh
  php artisan schedule:run
  ```


