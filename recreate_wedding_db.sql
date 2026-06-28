USE wedding_db;
CREATE TABLE IF NOT EXISTS tbl_users (
  UserID INT AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(50) NOT NULL UNIQUE,
  FullName VARCHAR(100) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  Role ENUM('Owner','Staff','Coordinator','Inventory Clerk') NOT NULL,
  DateCreated DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE IF NOT EXISTS tbl_vendor (
  VendorID INT PRIMARY KEY,
  VendorName VARCHAR(100) NOT NULL,
  ServiceType VARCHAR(50) NOT NULL,
  ContactNo VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE IF NOT EXISTS tbl_client (
  ClientID INT PRIMARY KEY,
  FullName VARCHAR(100) NOT NULL,
  EventType VARCHAR(50) NOT NULL,
  EventDate DATE NOT NULL,
  UserID INT,
  FOREIGN KEY (UserID) REFERENCES tbl_users(UserID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE IF NOT EXISTS tbl_booking (
  BookingID INT PRIMARY KEY,
  ClientID INT,
  VendorID INT,
  AppointmentType VARCHAR(50) NOT NULL,
  AppointmentDate DATE NOT NULL,
  AppointmentLocation VARCHAR(100) NOT NULL,
  FOREIGN KEY (ClientID) REFERENCES tbl_client(ClientID),
  FOREIGN KEY (VendorID) REFERENCES tbl_vendor(VendorID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE IF NOT EXISTS tbl_documents (
  DocID INT PRIMARY KEY,
  ClientID INT,
  DocumentType VARCHAR(50) NOT NULL,
  FileName VARCHAR(100) NOT NULL,
  PaymentAmt DECIMAL(10,2),
  PaymentDate DATE,
  FOREIGN KEY (ClientID) REFERENCES tbl_client(ClientID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT IGNORE INTO tbl_users (UserID, Username, FullName, Password, Role, DateCreated) VALUES
  (1, 'owner_pat', 'Owner Pat', '$2y$10$examplehash0000000000000000000000000000000000000000000', 'Owner', '2026-06-09'),
  (2, 'owner_robert', 'Owner Robert', '$2y$10$examplehash0000000000000000000000000000000000000000000', 'Owner', '2026-06-09'),
  (3, 'staff_reen', 'Staff Reen', '$2y$10$examplehash0000000000000000000000000000000000000000000', 'Staff', '2026-07-10'),
  (4, 'coor_rocel', 'Coordinator Rocel', '$2y$10$examplehash0000000000000000000000000000000000000000000', 'Coordinator', '2026-07-11'),
  (5, 'clerk_lukey', 'Clerk Lukey', '$2y$10$examplehash0000000000000000000000000000000000000000000', 'Inventory Clerk', '2026-06-01');
INSERT IGNORE INTO tbl_vendor (VendorID, VendorName, ServiceType, ContactNo) VALUES
  (23, 'L Studios', 'Photography', '091234567890'),
  (45, 'Elite Catering', 'Catering', '091234567890'),
  (832, 'Sweet Delights Bakery', 'Baked Goods', '091234567890'),
  (192, 'Camilla Coffee & Co.', 'Coffee Bar', '091234567890'),
  (736, 'Cheers Mobile Bar', 'Mobile Bar', '091234567890');
INSERT IGNORE INTO tbl_client (ClientID, FullName, EventType, EventDate, UserID) VALUES
  (123, 'Mheika Ramirez', 'Debut', '2027-01-18', NULL),
  (245, 'Adrian Tan', 'Wedding', '2027-03-12', NULL),
  (832, 'Lorenzo Resurreccion', 'Wedding', '2027-03-17', NULL),
  (192, 'Kahreen Arcilla', 'Wedding', '2027-06-22', NULL),
  (736, 'Jeanine Silas', 'Wedding', '2027-06-25', NULL);
INSERT IGNORE INTO tbl_booking (BookingID, ClientID, VendorID, AppointmentType, AppointmentDate, AppointmentLocation) VALUES
  (452, 123, 23, 'Consultation', '2026-07-12', 'Zoom'),
  (453, 245, 45, 'Venue Visit', '2026-08-15', 'Tagaytay'),
  (463, 832, 832, 'Prenup Photoshoot', '2026-10-30', 'Intramuros'),
  (480, 192, 192, 'Contract Signing', '2026-11-05', 'Quezon City'),
  (490, 736, 736, 'Food Tasting', '2026-11-21', 'Pasig City');
INSERT IGNORE INTO tbl_documents (DocID, ClientID, DocumentType, FileName, PaymentAmt, PaymentDate) VALUES
  (1, 123, 'ContractPayment', 'ContractPayment', 15000.00, '2026-07-12'),
  (3, 245, 'Quotation', 'Quotation', 3000.00, '2026-08-16'),
  (4, 832, 'Invoice', 'Invoice', 5000.00, '2026-10-30'),
  (6, 192, 'ContractPayment', 'ContractPayment', 15000.00, '2026-11-10'),
  (9, 736, 'ContractPayment', 'ContractPayment', 15000.00, '2026-11-23');
SELECT COUNT(*) AS users FROM tbl_users;
SELECT COUNT(*) AS vendors FROM tbl_vendor;
SELECT COUNT(*) AS clients FROM tbl_client;
SELECT COUNT(*) AS bookings FROM tbl_booking;
SELECT COUNT(*) AS documents FROM tbl_documents;
