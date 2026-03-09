# Database Structure (`dpadmin`)

## 1. Entity-Relationship Diagram (ERD)

```mermaid
erDiagram
    Users {
        int id PK
        string name
        string email
        string password
    }

    DT_Customer {
        int id PK
        string name
        string code
        string phone
        string email
        string company
        int cid_users FK "Created by User"
    }

    DT_Supplier {
        int id PK
        string name
        string code
        string phone
        string email
        string company
        int cid_users FK "Created by User"
    }

    DT_Form {
        int id PK
        string name "Form Type"
    }

    DT_Order_Customer {
        int id PK
        int cid_customer FK
        int cid_form FK
        int phidichthuat
        int congchung
        int daucongty
        int tong
        int tamung
        int conglai
        enum approved "1:created, 2:approved, 3:cancelled"
    }

    DT_Order_Supplier {
        int id PK
        int cid_supplier FK
        int cid_form FK
        int phidichthuat
        int vat
        int tong
        int tamung
        int conglai
        enum approved "1:created, 2:approved, 3:cancelled"
    }

    Users ||--o{ DT_Customer : manages
    Users ||--o{ DT_Supplier : manages
    DT_Customer ||--o{ DT_Order_Customer : places
    DT_Supplier ||--o{ DT_Order_Supplier : fulfills
    DT_Form ||--o{ DT_Order_Customer : format
    DT_Form ||--o{ DT_Order_Supplier : format
```

## 2. Core Tables Description

### `DT_Customer` & `DT_Supplier`
These tables manage the profiles of Clients (Khách Hàng) and Freelancers/Agencies (Nhà Cung Cấp).
- Linked to `users` via `cid_users` to track which admin created the record.

### `DT_Order_Customer`
Represents customer requests for document translation, notarization, and related services.
- Tracks granular service costs natively in the row (e.g., `phidichthuat` for translation fee, `congchung` for notarization fee).
- Computes `tong` (total), tracks `tamung` (advance payment), and `conglai` (remaining balance).

### `DT_Order_Supplier`
Represents the subcontracted tasks sent to suppliers/freelancers. Follows a similar structure to Customer orders but strictly manages supplier payables.

### `users`
Standard Laravel authentication table for system administrators.

### `DT_Log`
System activity log table referenced by various controllers to track modifications and state changes within the application endpoints.
