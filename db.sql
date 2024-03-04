drop database if exists on_tap;

Create database on_tap;

use on_tap;

Create table categories
(
    id int primary key auto_increment,
    name varchar(100) NOT NULL UNIQUE,
    status tinyint(1) DEFAULT '0',
    created_at date DEFAULT current_timestamp(),
    updated_at date null
);

Create table products
(
    id int primary key auto_increment,
    name varchar(100) NOT NULL UNIQUE,
    image varchar(100) NOT NULL,
    price float(10,2) NOT NULL,
    sale_price float(10,2) NOT NULL,
    category_id int NOT NULL,
    description text NOT NULL,
    status tinyint(1) DEFAULT '0',
    created_at date DEFAULT current_timestamp(),
    updated_at date null,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

Create table product_images
(
    id int primary key auto_increment,
    image varchar(100) NOT NULL,
    product_id int NOT NULL,
    status tinyint(1) DEFAULT '0',
    created_at date DEFAULT current_timestamp(),
    updated_at date null,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

Create table users
(
    id int primary key auto_increment,
    name varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    password varchar(200) NOT NULL,
    created_at date DEFAULT current_timestamp(),
    updated_at date null
);

Create table personal_access_tokens
(
    id int primary key auto_increment,
    name varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    password varchar(200) NOT NULL,
    created_at date DEFAULT current_timestamp(),
    updated_at date null
);


Create table banners
(
    id int primary key auto_increment,
    name varchar(100) NOT NULL UNIQUE,
    link varchar(100) NOT NULL DEFAULT '#',
    image varchar(100) NOT NULL,
    description varchar(255) NOT NULL,
    position varchar(100) DEFAULT 'top-banner',
    prioty tinyint DEFAULT '0',
    status tinyint(1) DEFAULT '0',
    created_at date DEFAULT current_timestamp(),
    updated_at date null
);


Create table blogs
(
    id int primary key auto_increment,
    name varchar(100) NOT NULL UNIQUE,
    link varchar(100) NOT NULL DEFAULT '#',
    image varchar(100) NOT NULL,
    description varchar(255) NOT NULL,
    position varchar(100) DEFAULT 'top-banner',
    status tinyint(1) DEFAULT '0',
    created_at date DEFAULT current_timestamp(),
    updated_at date null
);


Create table customers
(
    id int primary key auto_increment,
    name varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    phone varchar(100) NOT NULL UNIQUE,
    address varchar(100) NULL,
    gender tinyint NOT NULL DEFAULT '0',
    password varchar(200) NOT NULL,
    email_verified_at date null,
    created_at date DEFAULT current_timestamp(),
    updated_at date null
);

Create table customer_reset_tokens
(
    email varchar(100) primary key,
    token varchar(100) NOT NULL UNIQUE,
    created_at date DEFAULT current_timestamp(),
    updated_at date null
);

Create table comments
(
    id int primary key auto_increment,
    customer_id int NOT NULL,
    product_id int NOT NULL,
    comment text,
    created_at date DEFAULT current_timestamp(),
    updated_at date null,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

Create table favorites
(
    id int primary key auto_increment,
    customer_id int NOT NULL,
    product_id int NOT NULL,
    created_at date DEFAULT current_timestamp(),
    updated_at date null,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

Create table carts
(
    customer_id int NOT NULL,
    product_id int NOT NULL,
    price float(10,2) NOT NULL,
    quantity int NOT NULL,
    primary key (customer_id, product_id),
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

Create table orders
(
    id int primary key auto_increment,
    name varchar(100) NULL,
    email varchar(100) NULL,
    phone varchar(100) NULL,
    address varchar(100) NULL,
    token varchar(50) NULL,
    status tinyint(1) DEFAULT '0',
    customer_id int NOT NULL,
    created_at date DEFAULT current_timestamp(),
    updated_at date null,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

Create table order_details
(
    order_id int NOT NULL,
    product_id int NOT NULL,
    quantity tinyint NOT NULL,
    price float(10,2) NOT NULL,
    primary key (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO banners(name, status, link, description, position, prioty, image) VALUES
('Fresh Meat', 1, '#', '', 'top-banner', 0, 'banner_bg.png');

INSERT INTO banners(name, status, link, description, position, prioty, image) VALUES
('gallery 1', 1, '#', '', 'gallery', 1, 'gallery_img01.png'),
('gallery 2', 1, '#', '', 'gallery', 2, 'gallery_img02.png'),
('gallery 3', 1, '#', '', 'gallery', 3, 'gallery_img03.png');

INSERT INTO banners(name, image, link, status) VALUES
('Banner 1', 'banner_bg.png', '#', 1) ;

INSERT INTO banners(name, image, position, status) VALUES
('gallery 1', 'gallery_img01.png', 'gallery', 1) ,
('gallery 2', 'gallery_img02.png', 'gallery', 1) ,
('gallery 3', 'gallery_img03.png', 'gallery', 1) ;

INSERT INTO `users` (`name`, `email`, `password`, `created_at`, `updated_at`) VALUES
('Admin Manager', 'admin@gmail.com', '$2y$12$ElFD8Eq8bOZ8bsym04rY1e6znHP874r/FSPw/ZfMy1CB85O/Yc60q', '2023-12-04', '2023-12-04');

INSERT INTO categories(name, status) VALUES
('Dưa hấu', 1) ,
('Cà chua', 1) ,
('Chuối tiến vua', 1) ,
('Nho mỹ', 1);

INSERT INTO `products` (`name`, `image`, `price`, `sale_price`, `category_id`, `description`, `status`, `created_at`, `updated_at`) VALUES
('Product 1', 'h2_product01.png', 500000.00, 250000.00, 2, 'sasas', 1, '2023-12-06', '2023-12-06');
('Product 2', 'h2_product02.png', 500000.00, 250000.00, 2, 'sasas', 2, '2023-12-06', '2023-12-06');
('Product 3', 'h2_product03.png', 500000.00, 250000.00, 2, 'sasas', 3, '2023-12-06', '2023-12-06');

INSERT INTO `product_images` (`id`, `image`, `product_id`, `status`, `created_at`, `updated_at`) VALUES
(17, 'mrppO4Xk0YexKFRgwtJJdKGJm9naIJ0DryeDth4z.png', 1, 0, '2023-12-06', '2023-12-06'),
(18, 'pXLHEmW0mvjohEMtaD7NK8CET50RskXehfOgG8em.png', 1, 0, '2023-12-06', '2023-12-06'),
(19, 'rb8sk4CthFqNmyrdEE2bvBU8OOeWelxpuGcq1Coa.png', 1, 0, '2023-12-06', '2023-12-06'),
(20, 'lP4RQq0nehFTxGrnI0mVMJJOBKqlh2ziyt21m4Hd.png', 1, 0, '2023-12-06', '2023-12-06');