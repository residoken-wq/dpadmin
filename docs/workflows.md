# Workflows Documentation

## 1. Authentication & Session Workflow

### Login
1. User accesses the login page at `/login` or attempts to visit `/admin/*` without an active session.
2. Laravel HTTP Middleware (`auth`) redirects unauthenticated requests to `/login`.
3. User submits credentials to `Auth\AuthController@login`.
4. The system validates the credentials against the `users` table.
5. Upon success, a secure session is created, and the user is redirected to the `/admin/index/index` dashboard.

### OneDrive Integration (`OnedriveController`)
The system contains an integration with Microsoft OneDrive for cloud file management/storage.
1. User clicks the OneDrive integration button.
2. The `loginUrl` method prepares an OAuth 2.0 redirect URL to Microsoft's login portal.
3. User authenticates on Microsoft and grants permissions.
4. Microsoft redirects back to the application (`onedrive`/`pathwork`), providing an access token.
5. The token is stored, and the system can interact with OneDrive APIs using AJAX handlers (`ajaxone`, `ajaxtwo`, `ajaxthree`) and standard endpoints (`openpath`, `runonedrive`).

## 2. Core Business workflows

### Customer & Supplier Management
These modules (`CustomerController`, `SupplierController`) perform standard CRUD operations:
- **Listing:** Retrieves a paginated list of entries from `DT_Customer` or `DT_Supplier` tables (`/customer/lists`).
- **Create/Edit:** Validates and saves data submitted via forms (`/customer/add`, `/customer/edit/{id}`).
- **Export/Delete:** Processes data extraction or removal requests.

### Order Management Flow
Orders represent translation/notary/delivery service requests linked between an agent (Customer/Supplier) and the system.
1. **Creation:** An order is created and linked to a Customer (`cid_customer`) and a Form (`cid_form`).
2. **Pricing Configuration:** Costs are added for specific services:
   - Translation fee (`phidichthuat`)
   - Notarization (`congchung`)
   - Company seal (`daucongty`)
   - Medical copy (`saoy`)
   - Transport fee (`phivanchuyen`), etc.
3. **Approval Flow:**
   - Orders begin with `approved = 1` (created).
   - Once reviewed, they are marked as `approved = 2` (approved) or `approved = 3` (canceled) via `IndexController@approvedcustomer` or `approvedsupplier`.
4. **Calculations:** Totals (`tong`), Advance Payments (`tamung`), and Remaining Balances (`conglai`) are maintained with each order record.

### Financial Management (Receipts & Payments)
The system manages financial inflows/outflows through Phieu Thu (Receipts) and Phieu Chi (Payment Vouchers).
- **Phieu Thu (Receipts):** Managed by `PhieuthuController`, records incoming payments from Customers.
- **Phieu Chi (Payments):** Managed by `PhieuchiController`, records outgoing payments to Suppliers.

### Reporting Module (`ReportController`)
Calculates and generates reports for analytics and auditing:
- Profitability per Customer/Supplier (`loinhuan`, `loinhuankhachhang`).
- Revenue streams (`doanhthu`).
- Expenses / Supplier Costs (`chiphi`, `chiphinhacungcap`).
