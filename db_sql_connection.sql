

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `text`, `url`, `is_active`) VALUES
(1, 'Book a online consultation', 'https://calendly.com/thegraftonvault?background_color=f7f0e3&text_color=0a1a33&primary_color=b29243', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `subtitle`, `content`, `cover_image`, `created_at`, `updated_at`) VALUES
(1, 'Why Choosing the Right Ring Is More Than Just Jewelry', 'A symbol of love, promise, and timeless craftsmanship', 'A ring is not just an accessory — it is a story wrapped in metal and stone. From engagements to anniversaries, rings carry emotions that last a lifetime. Choosing the right ring means selecting a piece that reflects personality and unforgettable moments.\r\n\r\nAt our ring service, every design is created with attention to detail and passion for craftsmanship. From classic solitaires to modern minimal designs, each ring is carefully crafted to balance elegance and durability. Our focus is not only on beauty but also on comfort, ensuring that every ring feels as good as it looks.\r\n\r\nQuality materials play a vital role in creating long-lasting rings. That’s why we use carefully selected metals and stones, maintaining high standards throughout the design and production process. Each ring goes through strict quality checks to ensure perfection before reaching you.\r\n\r\nWhat truly sets us apart is our customer-first approach. We guide you at every step — from selecting the right style to understanding ring care and maintenance. Whether you are buying your first ring or adding to a growing collection, we aim to make the experience smooth, transparent, and memorable.\r\n\r\nA ring marks a milestone, celebrates love, and holds memories forever. Choosing the right one should feel special — and we are here to make sure it truly is.', 'uploads/1767798131_blog_download (4).jpg', '2026-01-07 15:02:11', '2026-01-08 09:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `calendly_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `title`, `description`, `cover_image`, `created_at`, `calendly_link`) VALUES
(1, 'Engagement Collection', 'A spark that begins forever.\r\nAt THE GRAFTON VAULT, engagement rings capture the moment love says yes—crafted in brilliance, sealed with promise. 💍', 'uploads/1768036022_cover_Right_placement__202601092129.jpeg', '2026-01-07 11:30:26', 'https://calendly.com/thegraftonvault/engagement-wedding-ring'),
(2, 'Wedding Collection', 'Timeless circles of love, crafted to endure forever.\r\nAt THE GRAFTON VAULT, wedding rings whisper elegance, promise devotion, and seal your forever in precious brilliance.', 'uploads/1768036007_cover_Hyperrealistic_luxury_jewellery_202601092120.jpeg', '2026-01-07 14:40:51', 'https://calendly.com/thegraftonvault/engagement-wedding-ring');

-- --------------------------------------------------------

--
-- Table structure for table `collection_gallery`
--

CREATE TABLE `collection_gallery` (
  `id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `collection_gallery`
--

INSERT INTO `collection_gallery` (`id`, `collection_id`, `image_path`) VALUES
(1, 1, 'uploads/1767785426_0_download (4).jpg'),
(2, 1, 'uploads/1767785426_1_download (3).jpg'),
(3, 1, 'uploads/1767785426_2_download (2).jpg'),
(4, 2, 'uploads/1767796851_0_download (4).jpg'),
(5, 2, 'uploads/1767796851_1_download (3).jpg'),
(6, 2, 'uploads/1767796851_2_download (2).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `interest` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `submission_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `contact_submissions`
--

INSERT INTO `contact_submissions` (`id`, `fullname`, `phone`, `email`, `interest`, `message`, `submission_date`) VALUES
(1, 'Nani Balaga', '8555858978', 'sankar_balaga@srmap.edu.in', 'ENGAGEMENT', 'testing ', '2026-01-07 13:43:22'),
(6, 'Bhanu Deep', '7702251899', 'bhanudeepreddy@gmail.com', 'ENGAGEMENT', 'Hey this is Bhanu', '2026-01-07 14:03:16'),
(13, 'Bhanu Deep', '07702251899', 'bhanudeepreddy@gmail.com', 'Wedding', 'Hello Ian, I\'m interested in exploring about the wedding rings', '2026-01-09 06:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`) VALUES
(1, 'What types of rings do you offer?', 'We offer a wide range of rings including engagement rings, wedding bands, casual rings, and custom-designed rings to suit different styles and occasions.'),
(2, 'Can I customize my ring design?', 'Yes, customization is available. You can choose the ring style, metal type, stone design, and size based on your preference.'),
(3, 'What materials are used in your rings?', 'Our rings are crafted using high-quality materials such as gold, silver, and premium stones to ensure durability and elegance.');

-- --------------------------------------------------------

--
-- Table structure for table `instagram_posts`
--

CREATE TABLE `instagram_posts` (
  `id` int(11) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `post_url` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `instagram_posts`
--

INSERT INTO `instagram_posts` (`id`, `caption`, `post_url`, `image_url`, `created_at`) VALUES
(1, 'Wedding Rings', 'https://www.instagram.com/reel/DS9n8OxipKj/?utm_source=ig_web_copy_link&igsh=NTc4MTIwNjQ2YQ==', 'uploads/1768035413_insta_Tgv post 1-2.png', '2026-01-07 15:11:54'),
(2, 'Engagement Rings', 'https://www.instagram.com/p/DTTJ9Krkg3-/', 'uploads/1768035462_insta_Hyperrealistic_cinematic_luxury_202601092052.jpeg', '2026-01-10 08:57:42'),
(3, 'Craftsmanship', 'https://www.instagram.com/p/DS7mkPLlCl1/', 'uploads/1768035562_insta_TGV LOGO SET-1-MAIN - PRIMARY LOGO.png', '2026-01-10 08:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `reviewer_name` varchar(255) NOT NULL,
  `reviewer_initial` varchar(5) NOT NULL,
  `review_text` text NOT NULL,
  `rating` int(1) DEFAULT 5,
  `date_posted` varchar(100) DEFAULT 'Recently',
  `verified_buyer` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `reviewer_name`, `reviewer_initial`, `review_text`, `rating`, `date_posted`, `verified_buyer`) VALUES
(1, 'Nani Balaga', 'N', 'The Grafton Standard\r\nOur Heritage of Perfection\r\nWe do not simply make jewelry; we craft legacies intended to outlast the very stars themselves.\r\nGrafton Family', 5, '4 Months Ago', 1),
(2, 'Sruthi', 'S', 'The design was elegant and exactly as shown. The quality feels premium and the delivery was smooth. Highly recommended for anyone looking for something special.', 5, '1 Year Ago', 1),
(3, 'Karthik Potnuru', 'K', 'Great service and beautiful craftsmanship.\r\nThe ring finishing is excellent, and the customer support was very helpful in guiding me through the selection. Totally worth it.', 5, '2 Months Ago', 1),
(4, 'Charan Balaji', 'C', 'Bought this ring as a gift and the response was amazing. The packaging was neat and classy. Will definitely order again', 4, '1 Months Ago', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon_image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `booking_url` text DEFAULT NULL,
  `button_text` varchar(50) DEFAULT 'Book Now'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `icon_image`, `description`, `created_at`, `booking_url`, `button_text`) VALUES
(1, 'Design Consultation', 'uploads/1767799807_serv_download (2).jpg', 'Our master jewelers work directly with you to bring your vision to life. We respect your time and investment, ensuring every sketch translates perfectly to the final piece.', '2026-01-07 15:20:07', NULL, 'Book Now'),
(2, 'Diamond Education', 'uploads/1767799773_serv_download (3).jpg', 'Navigate the world of 4Cs with confidence. We provide transparent, expert guidance to ensure you get the absolute best value for your money.', '2026-01-07 15:20:07', 'https://www.remove.bg/upload', 'TESTING'),
(3, 'Resizing & Repair', 'uploads/1767799759_serv_download (4).jpg', 'Your precious heirlooms deserve the finest touch. We restore beauty and fit with laser precision, treating your history with the reverence it demands.', '2026-01-07 15:20:07', 'www.framenflowmedia.in', 'FnFm');

-- --------------------------------------------------------

--
-- Table structure for table `shop_gallery`
--

CREATE TABLE `shop_gallery` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `shop_gallery`
--

INSERT INTO `shop_gallery` (`id`, `image_url`, `created_at`) VALUES
(17, 'uploads/1768035129_shop_0_Tgv post 1-4.png', '2026-01-10 08:52:09'),
(18, 'uploads/1768035149_shop_0_Tgv post 1-11.png', '2026-01-10 08:52:29'),
(19, 'uploads/1768035162_shop_0_Tgv post 1-5.png', '2026-01-10 08:52:42'),
(20, 'uploads/1768035176_shop_0_Tgv post 1-12.png', '2026-01-10 08:52:56'),
(21, 'uploads/1768035193_shop_0_Tgv post 1-16.png', '2026-01-10 08:53:13'),
(23, 'uploads/1768035240_shop_0_Tgv post 1-17.png', '2026-01-10 08:54:00'),
(24, 'uploads/1768035285_shop_0_Tgv post 1-19.png', '2026-01-10 08:54:45'),
(26, 'uploads/1768035322_shop_0_Tgv post 1-10.png', '2026-01-10 08:55:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_gallery`
--
ALTER TABLE `collection_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_id` (`collection_id`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instagram_posts`
--
ALTER TABLE `instagram_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_gallery`
--
ALTER TABLE `shop_gallery`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `collection_gallery`
--
ALTER TABLE `collection_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `instagram_posts`
--
ALTER TABLE `instagram_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shop_gallery`
--
ALTER TABLE `shop_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collection_gallery`
--
ALTER TABLE `collection_gallery`
  ADD CONSTRAINT `collection_gallery_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
