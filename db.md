# Database Architecture


## Tables

### 1. role
```sql
    id (int)
    name (string)
    description (string)
    created_at (datetime)
    updated_at (datetime)
```

### 2. user:
 ```sql   
    id (int)
    role_id (int)
    name (string)
    email (string)
    password (string)
    created_at (datetime)
    updated_at (datetime)
```
### 3. user_address:
```sql
    id (int)
    user_id (int)
    city (string)
    street (string)
    postal_code (string)
    telegram_username (string)
    created_at (datetime)
    updated_at (datetime)
```

### 4. product_type:
```sql
    id (int)
    name (string)
    description (string)
    created_at (datetime)
    updated_at (datetime)
```    

### 5. category:
```sql
    id (int)
    product_type_id (int)
    name (string)
    description (string)
    created_at (datetime)
    updated_at (datetime)
```

### 6. category_detail:
```sql
    id (int)
    category_id (int)
    name (string)
    created_at (datetime)
    updated_at (datetime)
```
### 7. product:
```sql
    id (int)
    user_id (int)
    category_id (int)
    name (string)
    description (string)
    expiry_date (datetime)
    brand (string)
    manufactur_date (datetime)
    quantity (int)
    price (real)
    created_at (datetime)
    updated_at (datetime)
```

### 8. product_category_detail:
```sql
    id (int)
    product_id (int)
    category_detail_id (int)
    value (string)
    created_at (datetime)
    updated_at (datetime)
```

### 9. product_images:
```sql
    id (int)
    product_id (int)
    image_url (string)
    created_at (datetime)
    updated_at (datetime)
```

## Optional Features

### 10. chat: 
```sql
    id (int)
    user_1 (int)
    user_2 (int)
    is_active (boolean)
    created_at (datetime)
    updated_at (datetime)
```

### 11. message:
```sql
    id (int)
    chat_id (int)
    sender_id (int)
    receiver_id (int)
    message (string)
    created_at (datetime)
    updated_at (datetime)
```

### 12. cart:
```sql
    id (int)
    user_id (int)
    product_id (int)
    quantity (int)
    created_at (datetime)
    updated_at (datetime)
```
