# 🕯️ Velitas y Momentos

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Architecture](https://img.shields.io/badge/Architecture-MVC-green?style=for-the-badge)

**Velitas y Momentos** is an artisanal virtual shop for selling personalized candles, candle bouquets, and esoteric candles. 
Developed as a fullstack web project, it features a complete MVC system built with PHP, MySQL, Bootstrap, PHPMailer, and PhpSpreadsheet.

## ✨ Main Features
- 🎨 Public product catalog with dynamic images and categories.
- 🛒 Shopping cart management for registered users.
- 👤 Authentication system with role-based access control (Admin / Client / Visitor).
- 📝 Complete Admin CRUD panel for products, categories, and users.
- 📈 Order export functionality to Excel using **PhpSpreadsheet**.
- 💌 Interactive contact form with automated email dispatch via **PHPMailer**.
- 📱 Fully responsive design powered by Bootstrap 5 and SweetAlert2.

## 🏗️ Tech Stack

- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript, SweetAlert2.
- **Backend:** PHP 8 (Pure MVC pattern, OOP).
- **Database:** MySQL.
- **Dependencies & Tools:** Composer, PHPMailer, PhpSpreadsheet.
- **Environment:** Laragon / Docker Support.

---

## 🗂️ Project Structure

```
velitasymomentos/
│
├── config/           # Database connection
├── controllers/      # PHP controllers for each entity
├── core/             # General services (e.g. EmailService)
├── models/           # PHP models for DB queries
├── public/           # Entry point with index.php
├── views/            # Views with HTML + Bootstrap
│   ├── partials/     # Reusable header and footer
│   └── ...           # auth/, admin/, products/, etc.
└── vendor/           # Libraries installed via Composer
```

---

## 📝 Use Case Diagram

This is the use case diagram for the **Velitas y Momentos** project, showing the main interactions with the system.

![Use Case Diagram](docs/case.png)

---

## 🚀 Local Installation

1. Clone this repository
   ```bash
   git clone https://github.com/dmaestudiodev-source/velitasymomentos.git
   ```
   
2. Copy the project to your Laragon directory (e.g. `C:\laragon\www\velitasymomentos`).

3. Create the MySQL database and import the schema.sql:
   ```sql
   CREATE DATABASE velitasymomentos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```

4. Import the tables with the script `schema.sql` (includes users, products, orders, etc).

5. Configure `config/database.php` with your local credentials:
   ```php
   return new PDO('mysql:host=localhost;dbname=velitasymomentos;charset=utf8mb4', 'root', '');
   ```

6. Install Composer dependencies (PHPMailer, PhpSpreadsheet)
   ```bash
   composer install
   ```

7. Open your browser at:
   ```
   http://localhost/velitasymomentos/public
   ```

---

## ⚙️ Admin Features

- Dashboard with user list
- Full CRUD for products, users and categories
- View and export orders to Excel

---

## ⚙️ Client Features

- Registration and login
- Shopping cart
- View own orders
- Password recovery via email

---

## 📨 Contact

Contact form sends emails to official Velitas y Momentos inbox using PHPMailer.

---

## 📦 Export Orders to Excel

From the admin panel, export all orders in a `.xlsx` file using PhpSpreadsheet.

---

## 👩‍💻 Author & Credits

Developed by Diana Alfonso
Organization: dmastudiodev-source

---

## ✅ Project Status

✅ **100% functional and delivered.**  
Future plans:
- Implement online payment API.
- Advanced analytics dashboard.
- Order customization with personal messages.

---

## 📜 License

Educational and professional portfolio project. All rights reserved.

---