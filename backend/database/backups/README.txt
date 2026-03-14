========================================
  DATABASE BACKUPS FOLDER
========================================

This folder contains your database backups.

IMPORTANT: 
- Copy these files to a safe location OUTSIDE of XAMPP folder
- Before uninstalling XAMPP, backup your database!
- Keep multiple backups for safety

========================================
  HOW TO USE
========================================

CREATE BACKUP:
  Run: backup-database.ps1 (or .bat)
  Location: backend folder

RESTORE BACKUP:
  Run: restore-database.ps1 (or .bat)
  Location: backend folder

CHECK BACKUPS:
  Run: check-backup.ps1
  Location: backend folder

========================================
  BACKUP FILE FORMAT
========================================

Manual backups:
  backup_YYYYMMDD-HHMMSS.sql
  Example: backup_20260311-155517.sql

Auto backups:
  auto_backup_YYYYMMDD-HHMMSS.sql

========================================
  SAFE STORAGE LOCATIONS
========================================

✅ Desktop
✅ Documents folder
✅ External USB drive
✅ Cloud storage (Google Drive, OneDrive)
✅ Network drive

❌ DO NOT store ONLY in XAMPP folder!
   (Will be deleted when XAMPP is uninstalled)

========================================
  NEED HELP?
========================================

Read: DATABASE_BACKUP_GUIDE.md
Quick guide: QUICK_BACKUP_GUIDE.md

Both files are in the project root folder.

========================================
