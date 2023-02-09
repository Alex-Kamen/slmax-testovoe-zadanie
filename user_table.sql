CREATE TABLE `user` (
    `id` int(11) NOT NULL,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `dateOfBirth` date NOT NULL,
    `gender` int(1) NOT NULL,
    `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;