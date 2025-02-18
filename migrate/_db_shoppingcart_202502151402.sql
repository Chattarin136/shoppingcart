-- Add category column to products table
ALTER TABLE products
ADD COLUMN category VARCHAR(50) NOT NULL DEFAULT 'other';

-- Update existing products with categories
UPDATE products 
SET category = CASE 
    WHEN product_name LIKE '%ข้าว%' OR product_name LIKE '%ต้ม%' OR product_name LIKE '%ผัด%' THEN 'thai'
    WHEN product_name LIKE '%ซูชิ%' OR product_name LIKE '%ราเมน%' OR product_name LIKE '%เทมปุระ%' THEN 'japanese'
    WHEN product_name LIKE '%เบอร์เกอร์%' OR product_name LIKE '%พิซซ่า%' OR product_name LIKE '%เฟรนช์ฟรายส์%' THEN 'fastfood'
    WHEN product_name LIKE '%ขนม%' OR product_name LIKE '%เค้ก%' OR product_name LIKE '%ไอศกรีม%' THEN 'dessert'
    WHEN product_name LIKE '%น้ำ%' OR product_name LIKE '%ชา%' OR product_name LIKE '%กาแฟ%' THEN 'beverage'
    ELSE 'other'
END;

-- Create categories reference table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default categories
INSERT INTO categories (name, display_name) VALUES
('all', 'All Foods'),
('thai', 'Thai Food'),
('japanese', 'Japanese Food'),
('fastfood', 'Fast Food'),
('dessert', 'Dessert'),
('beverage', 'Beverage'),
('other', 'Other');