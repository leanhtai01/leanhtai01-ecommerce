-- File: sample_data.sql
-- Add sample data to database ecommerce_db
-- Author: 1760169 - Lê Anh Tài
-- Email: leanhtai01@gmail.com
-- GitHub: https://github.com/leanhtai01/leanhtai01-ecommerce
USE ecommerce_db;

INSERT INTO accounts (fullname, email, password, phone_number, address, role_id)
VALUES
(
  'Administrator',
  'admin@gmail.com',
  '$2y$10$U9QcNd2ZwGTGZJaGdkOa8eddzpo5b5LCf.8.rj73lyDNxS4Ca1wAe',
  '0123123123',
  'Hồ Chí Minh',
  0
),
(
  'Lê Anh Tài',
  'leanhtai01@gmail.com',
  '$2y$10$T53Iga0pUToao7ntMk9WnuKGpYLNW2/HW3AVklyctZ939v90KuWni',
  '0357011672',
  'Bình Phước',
  1
);