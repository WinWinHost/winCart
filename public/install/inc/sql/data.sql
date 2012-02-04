INSERT INTO `menus` (`id`, `name`, `access_level`, `position`) VALUES 
(2, 'Main Menu', 'public', 0),
(3, ' admin_menu', 'admin', 3);

INSERT INTO `menu_items` (`id`, `menu_id`, `label`, `link_type`, `page_cat_id`, `page_id`, `link`, `position`) VALUES
(1, 2, 'Home', 'link', 0, 0, '/', 2),
(3, 3, 'Manage Content ', 'link', 0, 0, '/pageadmin/list', 2),
(4, 3, 'Manage Menus ', 'link', 0, 0, '/menu ', 1),
(5, 3, 'Rebuild search index', 'link', 0, 0, ' /search/build', 3),
(6, 3, 'Manage user', 'link', 0, 0, '/user/list', 4),
(7, 2, 'Products', 'link', 0, 0, '/products', 3),
(8, 2, 'Register', 'link', 0, 0, '/user/create', 5),
(9, 3, 'Manage products', 'link', 0, 0, '/productsedit/list', 5),
(23, 2, 'Articles', 'link', 0, 0, '/page/', 4),
(22, 3, 'Manage Orders', 'link', 0, 0, '/ordersadmin/', 7),
(24, 3, 'Product Category', 'link', 0, 0, '/productsedit/listcat', 6);

