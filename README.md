# 🏨 Hostel Incident Management System

A web-based platform built using **HTML, CSS, PHP, and MySQL** to streamline and manage incident reporting and fine tracking within hostel premises. The system enables smooth coordination among students, wardens, the chief warden, and the registrar through structured workflows, role-based dashboards, and secure authentication.

---

## 👩‍💻 Contributors

- **Agniswar Dasmitra**  
  🔗 [LinkedIn](https://www.linkedin.com/in/agniswar-dasmitra-6103851a4)  
  📧 agniswar.dasmitra16@gmail.com  

- **Sumona Banerjee**  
  🔗 [LinkedIn](http://www.linkedin.com/in/sumona-banerjee-9b2405285)  
  📧 sumonabanerjee117@gmail.com

---

## 🛠 Technologies Used

- **Frontend:** HTML, CSS  
- **Backend:** PHP  
- **Database:** MySQL  
- **Authentication:** Secure Role-Based Login System  

---

## 👥 User Roles & Responsibilities

### 🧑‍🎓 Student
- Submit incident reports  
- Track incident status and fine history  

### 👮‍♂️ Warden
- Review and validate incident reports  
- Add comments and assign fines  
- Forward to Chief Warden for approval  

### 🧑‍✈️ Chief Warden
- Provide final approval for reports  
- Confirm disciplinary actions  

### 🧑‍💼 Registrar
- Monitor incident and fine records  
- Track fine payment status  
- Maintain reports and documentation  

---

## 🔄 Workflow Overview

1. **Incident Creation**  
   Students report incidents via an online form.

2. **Warden Review**  
   Wardens review, comment, and forward reports.

3. **Chief Warden Approval**  
   Provides final approval and defines actions.

4. **Fine Management**  
   Registrar tracks and updates fine payment statuses.

5. **Dashboard Access**  
   Each user accesses their customized dashboard.

---

## ✅ Key Features

- Secure **Role-Based Authentication**
- Tailored **Dashboards** for each role
- **Incident Tracking** with history and live status updates
- **Fine Management** with payment monitoring
- Clean and intuitive **User Interface**
- Input sanitization to prevent **SQL Injection**
- Session validation for secure access

---

## 📁 Project Structure

```bash
Hostel-Incident-Management/
├── index.html                # Landing page
├── login.php                 # Role-based login
├── dashboard/                # User dashboards
│   ├── student.php
│   ├── warden.php
│   ├── chief_warden.php
│   └── registrar.php
├── incident/                 # Incident handling
│   ├── create_incident.php
│   └── view_incident.php
├── includes/                 # Core logic and database
│   ├── db.php                # Database connection
│   └── auth.php              # Authentication functions
└── assets/                   # Static resources
    ├── css/
    └── images/
