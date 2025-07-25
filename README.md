# M.S.K College Portal

The M.S.K College Portal is a web-based application designed to streamline communication and management within a college environment. It provides separate dashboards for administrators and students, allowing for efficient handling of academic records, attendance, and internal messaging.

## ✨ Features

### Admin Panel
*   **User Management**: Add new student and admin users.
*   **Messaging System**: Send messages to individual students, multiple students, or all users. View and reply to messages in an inbox.
*   **Marks Management**: Upload and view student marks for various subjects. Visualizes average percentages per student using charts.
*   **Attendance Management**: Upload and view student attendance records (Present/Absent) for different subjects and dates.
*   **Dashboard Overview**: Quick statistics on total students, total admins, average marks, and average attendance across the college.

### Student Panel
*   **Personalized Dashboard**: View individual average marks and attendance rates.
*   **Messaging System**: Send messages to administrators and view messages received in their inbox.
*   **View Marks**: Access their own detailed marks for all subjects.
*   **View Attendance**: Access their own detailed attendance records.

### General Features
*   **Role-Based Access Control**: Secure login system distinguishing between 'admin' and 'student' roles.
*   **Responsive Design**: Built with Bootstrap for a mobile-friendly interface.
*   **Theme Toggle**: Switch between light and dark themes for user preference.
*   **Attachment Support**: Messages can include file attachments (PDF, DOCX, XLSX).

## 🚀 Technologies Used

*   **Backend**: PHP
*   **Database**: MySQL (using `mysqli` extension)
*   **Frontend**: HTML, CSS, JavaScript, Bootstrap 5
*   **Charting**: Chart.js for data visualization
*   **Select2**: For enhanced multi-select dropdowns in messaging.

## ⚙️ Setup and Installation

### Prerequisites

*   A web server (e.g., Apache, Nginx)
*   PHP (7.4 or higher recommended)
*   MySQL database

### Steps

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/college_portal.git
    cd college_portal
    ```

2.  **Set up the database:**
    *   Create a MySQL database named `msk_college`.
    *   Import the provided `college_portal.sql` file into your new database. This will create the necessary tables (`users`, `messages`, `marks`, `attendance`) and populate them with initial data.

        ```bash
        mysql -u your_username -p msk_college < college_portal.sql
        ```
        (Replace `your_username` with your MySQL username)

3.  **Configure database connection:**
    *   Open `includes/db.php`.
    *   Update the `$host`, `$username`, `$password`, and `$dbname` variables with your MySQL database credentials.

    ```php
    <?php
    $host = "localhost";
    $dbname = "msk_college";
    $username = "root"; // Your MySQL username
    $password = "";     // Your MySQL password

    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    ?>
    ```

4.  **Place the project on your web server:**
    *   Move the `college_portal` directory to your web server's document root (e.g., `htdocs` for Apache, `www` for Nginx).

5.  **Ensure `uploads` directory exists and is writable:**
    *   Create an `uploads` directory inside the `college_portal` root if it doesn't exist.
    *   Make sure your web server has write permissions to this directory for file attachments.

6.  **Access the application:**
    *   Open your web browser and navigate to the URL where you placed the project (e.g., `http://localhost/college_portal`).

## 🔑 Default Credentials (from `college_portal.sql`)

*   **Admin:**
    *   Email: `admin@example.com`
    *   Password: `admin`
*   **Student:**
    *   Email: `student@example.com`
    *   Password: `student`

## 📂 Project Structure
college_portal/ ├── admin/ # Admin-specific pages and functionalities │ ├── add_user.php │ ├── dashboard.php │ ├── inbox.php │ ├── reply_message.php │ ├── send_message.php │ ├── upload_attendance.php │ ├── upload_marks.php │ ├── view_attendance.php │ └── view_marks.php ├── student/ # Student-specific pages and functionalities │ ├── dashboard.php │ ├── inbox.php │ ├── reply_message.php │ ├── send_message.php │ ├── view_attendance.php │ └── view_marks.php ├── assets/ # Static assets like images │ └── logo.png ├── includes/ # Reusable PHP components │ ├── db.php # Database connection │ ├── footer.php # HTML footer │ ├── header.php # HTML header │ └── layout.php # Main layout with sidebar ├── uploads/ # Directory for uploaded message attachments │ ├── 1750949410_Titanic_EDA_Report.pdf │ ├── 1750949454_Titanic_EDA_Report.pdf │ ├── 1750949531_Titanic_EDA_Report.pdf │ ├── Shahid Resume1.pdf │ └── Titanic_EDA_Report.pdf ├── check_login.php # Handles user authentication ├── college_portal.sql # Database schema and initial data ├── index.html # Landing page ├── login.php # Login selection page (Admin/Student) ├── login_admin.php # Admin login form ├── login_student.php # Student login form ├── logout.php # Handles user logout └── README.md


## 📄 License

This project is open-source and available under the [MIT License](LICENSE).
