-- convert Laravel migrations to raw SQL scripts --

-- migration:2014_10_12_000000_create_users_table --
create table `users` (
  `id` bigint unsigned not null auto_increment primary key, 
  `name` varchar(255) not null, 
  `email` varchar(255) not null, 
  `email_verified_at` timestamp null, 
  `password` varchar(255) not null, 
  `isAdmin` tinyint(1) not null default '0', 
  `state` enum(
    'active', 'inactive', 'suspended'
  ) null, 
  `remember_token` varchar(100) null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `users` 
add 
  unique `users_email_unique`(`email`);

-- migration:2014_10_12_100000_create_password_resets_table --
create table `password_resets` (
  `email` varchar(255) not null, 
  `token` varchar(255) not null, 
  `created_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `password_resets` 
add 
  index `password_resets_email_index`(`email`);

-- migration:2019_10_18_163752_create_address_table --
create table `address` (
  `id` bigint unsigned not null auto_increment primary key, 
  `street` varchar(255) not null, 
  `city` varchar(255) not null, 
  `state` varchar(255) not null, 
  `zip` int not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2019_10_18_163925_create_card_table --
create table `card` (
  `id` bigint unsigned not null auto_increment primary key, 
  `cardNumber` int not null, `expDate` int not null, 
  `cvv` int not null, `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2019_10_18_164134_create_seat_table --
create table `seat` (
  `id` bigint unsigned not null auto_increment primary key, 
  `number` int not null, 
  `user` bigint unsigned null, 
  `taken` tinyint(1) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `seat` 
add 
  constraint `seat_user_foreign` foreign key (`user`) references `users` (`id`);

-- migration:2019_10_18_164450_create_movies_table --
create table `movies` (
  `id` bigint unsigned not null auto_increment primary key, 
  `title` varchar(255) not null, 
  `category` varchar(255) not null, 
  `director` varchar(255) not null, 
  `producer` varchar(255) not null, 
  `synopsis` varchar(255) not null, 
  `pictureLink` varchar(255) not null, 
  `videoLink` varchar(255) not null, 
  `rating` varchar(255) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2019_10_18_164629_create_actors_table --
create table `actors` (
  `id` bigint unsigned not null auto_increment primary key, 
  `name` varchar(255) not null, 
  `movie` bigint unsigned null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `actors` 
add 
  constraint `actors_movie_foreign` foreign key (`movie`) references `movies` (`id`);

-- migration:2019_10_18_164645_create_reviews_table --
create table `reviews` (
  `id` bigint unsigned not null auto_increment primary key, 
  `review` varchar(255) not null, 
  `movie` bigint unsigned not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `reviews` 
add 
  constraint `reviews_movie_foreign` foreign key (`movie`) references `movies` (`id`);

-- migration:2019_10_18_165257_create_show_table --
create table `show` (
  `id` bigint unsigned not null auto_increment primary key, 
  `date` varchar(255) not null, 
  `time` varchar(255) not null, 
  `duration` int not null, 
  `movie` bigint unsigned not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `show` 
add 
  constraint `show_movie_foreign` foreign key (`movie`) references `movies` (`id`);

-- migration:2019_10_18_165515_create_showroom_table --
create table `showroom` (
  `id` bigint unsigned not null auto_increment primary key, 
  `seatNumber` int not null, `seatCount` int not null, 
  `rowCount` int not null, `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2019_10_18_165957_create_ticket_table --
create table `ticket` (
  `seat` bigint unsigned not null, `showroom` bigint unsigned not null, 
  `user` bigint unsigned not null, `show` bigint unsigned not null, 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `ticket` 
add 
  constraint `ticket_seat_foreign` foreign key (`seat`) references `seat` (`id`);
alter table 
  `ticket` 
add 
  constraint `ticket_showroom_foreign` foreign key (`showroom`) references `showroom` (`id`);
alter table 
  `ticket` 
add 
  constraint `ticket_user_foreign` foreign key (`user`) references `users` (`id`);
alter table 
  `ticket` 
add 
  constraint `ticket_show_foreign` foreign key (`show`) references `show` (`id`);

-- migration:2019_10_18_170426_create_booking_table --
create table `booking` (
  `id` bigint unsigned not null auto_increment primary key, 
  `date` varchar(255) not null, 
  `time` varchar(255) not null, 
  `bookingNumber` int not null, 
  `user` bigint unsigned not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `booking` 
add 
  constraint `booking_user_foreign` foreign key (`user`) references `users` (`id`);

-- migration:2019_10_18_170654_create_promotion_table --
create table `promotion` (
  `id` bigint unsigned not null auto_increment primary key, 
  `isActive` tinyint(1) not null, 
  `discount` double not null, 
  `code` varchar(255) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2019_10_18_170858_add_foreign_key_constraints --
alter table 
  `users` 
add 
  `card` bigint unsigned null, 
add 
  `address` bigint unsigned null;
alter table 
  `users` 
add 
  constraint `users_card_foreign` foreign key (`card`) references `card` (`id`);
alter table 
  `users` 
add 
  constraint `users_address_foreign` foreign key (`address`) references `address` (`id`);
alter table 
  `seat` 
add 
  `show` bigint unsigned null;
alter table 
  `seat` 
add 
  constraint `seat_show_foreign` foreign key (`show`) references `show` (`id`);

-- migration:2019_10_27_201523_create_ticket_type_table --
create table `ticket_type` (
  `id` bigint unsigned not null auto_increment primary key, 
  `created_at` timestamp null, `updated_at` timestamp null, 
  `child` double not null, `adult` double not null, 
  `senior` double not null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2019_10_27_202559_second_foreign_key_constraint_update --
alter table 
  `booking` 
add 
  `card` bigint unsigned null;
alter table 
  `booking` 
add 
  constraint `booking_card_foreign` foreign key (`card`) references `card` (`id`);
alter table 
  `ticket` 
add 
  `ticket_type` bigint unsigned null;
alter table 
  `ticket` 
add 
  constraint `ticket_ticket_type_foreign` foreign key (`ticket_type`) references `ticket_type` (`id`);
alter table 
  `show` 
add 
  `showroom` bigint unsigned not null;
alter table 
  `show` 
add 
  constraint `show_showroom_foreign` foreign key (`showroom`) references `showroom` (`id`);

-- migration:2019_10_27_202709_create_pricing_table --
create table `pricing` (
  `id` bigint unsigned not null auto_increment primary key, 
  `fees` double not null, `taxes` double not null, 
  `promotion` bigint unsigned null, 
  `finalPrice` double not null, `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `pricing` 
add 
  constraint `pricing_promotion_foreign` foreign key (`promotion`) references `promotion` (`id`);
