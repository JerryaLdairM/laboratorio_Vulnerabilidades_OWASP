-- Laboratorio de Vulnerabilidades OWASP Top 10
-- Base de datos intencionalmente vulnerable para fines educativos

DROP DATABASE IF EXISTS notas;
CREATE DATABASE notas;
USE notas;

-- A02: Cryptographic Failures - Contraseñas en texto plano
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255) -- SIN hash, almacenamiento inseguro
);

-- A01: Broken Access Control - Sin verificación de propietario
DROP TABLE IF EXISTS notes;
CREATE TABLE notes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR(50),
  note TEXT
);

-- Datos de prueba con contraseñas débiles (A07: Authentication Failures)
INSERT INTO users (username, password) VALUES 
('admin', 'admin123'),           -- A07: Contraseña débil
('user1', '123456'),             -- A07: Contraseña muy débil  
('test', 'password'),            -- A07: Contraseña común
('demo', 'demo');                -- A07: Contraseña trivial

-- Notas de ejemplo para demostrar A01: Broken Access Control
INSERT INTO notes (user, note) VALUES 
('admin', 'Información confidencial del sistema: La clave maestra es ABC123'),
('admin', '<script>alert("XSS en nota de admin!")</script>'),
('user1', 'Mi nota personal privada - no debería ser visible para otros'),
('user1', '<img src="x" onerror="alert(\'XSS via imagen\')" />'),
('test', 'Datos sensibles: Número de tarjeta 4532-1234-5678-9012'),
('demo', '<h1>HTML inyectado</h1><p style="color:red;">Contenido malicioso</p>');

-- A05: Security Misconfiguration - Usuario con privilegios excesivos
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost';
FLUSH PRIVILEGES; 