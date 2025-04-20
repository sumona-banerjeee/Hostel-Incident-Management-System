# 🏨 Hostel Incident Management System

A web-based application designed to streamline the reporting, tracking, and management of disciplinary incidents within hostel premises. Developed using **HTML, CSS, PHP, and MySQL**, the system improves communication among stakeholders like wardens, chief warden, registrar, and students, while ensuring transparency, accountability, and operational efficiency.

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
- **Authentication:** Role-based login system with session control  

---

## 👥 User Roles & Responsibilities

### 👮‍♂️ Warden (Boys/Girls)
- Submit incident reports against students  
- Add comments and suggest disciplinary actions (fines, outing/hostel restrictions)  
- Forward reports to Chief Warden for review  

### 🧑‍✈️ Chief Warden
- Review and approve/decline submitted reports  
- Trigger email notifications based on approved actions  
- Route approved cases to Registrar, Accounts, or Security as required  

### 🧑‍💼 Registrar
- Monitor approved cases with serious consequences  
- Oversee final documentation for major restrictions  

### 🧑‍💻 Accounts Section
- Track fine-related incidents  
- Update fine collection status  

### 🛡 Security In-Charge
- Enforce outing restrictions  
- Review and act on flagged student movement issues  

### 🧑‍🎓 Student
- View personal incident history  
- Track current status of disciplinary cases  
- Check fine details and updates  

---

## 🔄 Workflow Overview

1. **Incident Reporting**  
   Warden logs incident against a student.

2. **Review & Approval**  
   Chief Warden reviews and approves or rejects the report.

3. **Action Notification**  
   Based on severity:
   - Fine → Notifies Accounts  
   - Outing Restriction → Notifies Security  
   - Hostel Restriction → Notifies Registrar  

4. **Parent Communication**  
   Automated email is sent to parents after final approval.

5. **Student Access**  
   Students can log in to view status, history, and fines (no submission rights).

---

## ✅ Key Features

- Role-based secure login system  
- Structured, multi-level approval workflow  
- Real-time incident and fine tracking  
- Automated email notifications to stakeholders and parents  
- Clean, user-friendly dashboards customized for each role  
- Secure and sanitized database operations  

---

## 📁 Project Structure

```bash
Hostel-Incident-Management/
├── index.html                # Landing page
├── login.php                 # Login portal for all roles
├── dashboard/                # Role-specific dashboards
│   ├── student.php
│   ├── warden.php
│   ├── chief_warden.php
│   ├── registrar.php
│   └── accounts.php
├── incident/                 # Incident management
│   ├── create_incident.php   # For wardens only
│   └── view_incident.php     # For all users to track
├── includes/                 
│   ├── db.php                # Database connection
│   └── auth.php              # Authentication and session control
└── assets/
    ├── css/
    └── images/


## 🔐 Security Notes
PHP sessions with role validation for each dashboard

Input sanitization to protect against SQL injection

Email verification and activity logging for traceability

## 📈 Future Enhancements
📱 Mobile app support for Android and iOS

🔔 SMS alerts for real-time updates

👨‍👩‍👧 Parent portal with secure login access

📊 Admin analytics dashboard for behavior pattern analysis

## 📬 Contact
For feedback, queries, or contributions, reach out to:

Agniswar Dasmitra: agniswar.dasmitra16@gmail.com

Sumona Banerjee: sumonabanerjee117@gmail.com
