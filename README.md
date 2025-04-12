# Hostel-Incident-Management-System
Developed a web-based platform using HTML, CSS, MySQL, and PHP for managing student and warden incident reports.  Implemented role-based authentication and dashboards for students, wardens, chief warden, registrar. Designed a workflow for incident creation, approval and fine payment tracking. A web-based platform designed to manage student and staff incident reports within hostel premises. The system enables seamless communication between students, wardens, the chief warden, and the registrar through a structured workflow, role-based access, and real-time tracking of incidents and fines. 
> This project was collaboratively developed by **Agniswar Dasmitra** and **Sumona Banerjee** as part of their Personal Project in the feild of **Web Development**.


👩‍💻 Contributors
**Agniswar Dasmitra** ( https://www.linkedin.com/in/agniswar-dasmitra-6103851a4 )
**Sumona Banerjee** ( http://www.linkedin.com/in/sumona-banerjee-9b2405285 )

🛠️ Technologies Used
Frontend: HTML, CSS
Backend: PHP
Database: MySQL
Authentication: Role-based login system

👥 User Roles
Student
Submit incident reports
Track status and fine history

Warden
Review and forward incident reports
Add comments or observations
Assign fines

Chief Warden
Final approval of incident reports

Registrar
Monitor all reports
Ensure fine collection and recordkeeping

🔄 Workflow
Incident Creation – A student reports an incident via the online form.
Warden Review – The report is reviewed and validated by the hostel warden.
Approval – The chief warden gives final approval and determines actions.
Fine Management – If applicable, the registrar handles fine tracking and updates payment status.
Dashboard Access – Each user sees relevant information and actions based on their role.

✅ Features
Secure role-based authentication
User-friendly dashboards tailored to each role
Incident history and status tracking
Fine payment monitoring system
Clean and intuitive UI

 📁 Project Structure
 Hostel-Incident-Management/
│
├── index.html               # Landing page
├── login.php                # Role-based login
├── dashboard/               # Dashboards for each user role
│   ├── student.php
│   ├── warden.php
│   ├── chief_warden.php
│   └── registrar.php
├── incident/
│   ├── create_incident.php
│   └── view_incident.php
├── includes/
│   ├── db.php               # Database connection
│   └── auth.php            # Authentication logic
└── assets/
    ├── css/
    └── images/


🔐 Security Notes
Sessions and authentication validation on each dashboard
Database input sanitization to prevent SQL injection

📌 Future Enhancements
Email/SMS notification on incident status update
File attachment support for incident evidence
Analytics dashboard for administrators

This project is 
📧 Contact
Agniswar Dasmitra
📧 agniswar.dasmitra16@gmail.com
Sumona Banerjee
📧 sumonabanerjee117@gmail.com
