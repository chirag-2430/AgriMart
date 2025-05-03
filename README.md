# 🌾 AgriMart - Online Agriculture Marketplace for Seeds and Tools

AgriMart is a Laravel-based web application designed to connect **farmers** and **suppliers** through a digital marketplace. It allows farmers to purchase agricultural products like seeds and tools, while suppliers can list their products for sale. The platform also includes an **admin panel** for user and product management, making it a complete solution for agricultural e-commerce.

---

## 🚀 Features

### 👨‍🌾 Farmer Module
- Register/Login as Farmer
- Browse available products
- Add items to cart
- Purchase products (demo only; no payment integration)

### 🧑‍🌾 Supplier Module
- Register/Login as Supplier
- Add new products with images and details
- View, update, or delete listed products

### 🛠️ Admin Module
- Dashboard with sales analysis and overview
- Manage users (farmers and suppliers)
- Manage all products (add, edit, delete)

---

## 🧰 Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript, Blade (Laravel templating)
- **Backend:** PHP 8.x, Laravel Framework
- **Database:** MySQL (via phpMyAdmin)
- **Server:** Localhost using XAMPP

---

## 🛠️ Installation & Setup

### Prerequisites
- PHP 8.x
- Composer
- XAMPP (Apache + MySQL)

### Steps

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/your-username/agrimart.git
   cd agrimart
````

2. **Install Dependencies:**

   ```bash
   composer install
   ```

3. **Create a `.env` File:**

   ```bash
   cp .env.example .env
   ```

4. **Configure Database:**

   * Open `.env` and set your MySQL DB credentials:

     ```
     DB_DATABASE=agrimart
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. **Run Migrations:**

   ```bash
   php artisan migrate
   ```

6. **Start the Server:**

   ```bash
   php artisan serve
   ```

   Visit: `http://127.0.0.1:8000`

7. **Access phpMyAdmin:**

   * Go to `http://localhost/phpmyadmin`
   * Create a new database named `agrimart` before running migrations.

---

## 📸 Screenshots

| Farmer View                       | Supplier Dashboard                    | Admin Panel                     |
| --------------------------------- | ------------------------------------- | ------------------------------- |
| ![Farmer](screenshots/farmer.png) | ![Supplier](screenshots/supplier.png) | ![Admin](screenshots/admin.png) |

---

## 📌 Future Improvements

* Online payment gateway integration
* Real-time order tracking
* Mobile-responsive design
* Notifications and messaging module

---

## 🙌 Acknowledgements

This project was developed as part of the MVC Programming course at **Lovely Professional University**.

---

## 📄 License

This project is for educational/demo purposes only. All rights reserved to Chirag Kaushik.

```

---

Let me know if you want a shorter version or need help adding it to your GitHub repo!
```
