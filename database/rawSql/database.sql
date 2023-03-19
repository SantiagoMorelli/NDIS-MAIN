-- convert Laravel migrations to raw SQL scripts --

-- migration:2014_10_12_000000_create_users_table --
create table `users` (
  `id` bigint unsigned not null auto_increment primary key, 
  `name` varchar(255) not null, 
  `email` varchar(255) not null, 
  `email_verified_at` timestamp null, 
  `password` varchar(255) not null, 
  `remember_token` varchar(100) null, 
  `current_team_id` bigint unsigned null, 
  `profile_photo_path` text null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `users` 
add 
  unique `users_email_unique`(`email`);

-- migration:2014_10_12_100000_create_password_resets_table --
create table `password_resets` (
  `email` varchar(255) not null, 
  `token` varchar(255) not null, 
  `created_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `password_resets` 
add 
  index `password_resets_email_index`(`email`);

-- migration:2014_10_12_200000_add_two_factor_columns_to_users_table --
alter table 
  `users` 
add 
  `two_factor_secret` text null 
after 
  `password`, 
add 
  `two_factor_recovery_codes` text null 
after 
  `two_factor_secret`;

-- migration:2019_08_19_000000_create_failed_jobs_table --
create table `failed_jobs` (
  `id` bigint unsigned not null auto_increment primary key, 
  `uuid` varchar(255) not null, 
  `connection` text not null, 
  `queue` text not null, 
  `payload` longtext not null, 
  `exception` longtext not null, 
  `failed_at` timestamp default CURRENT_TIMESTAMP not null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `failed_jobs` 
add 
  unique `failed_jobs_uuid_unique`(`uuid`);

-- migration:2019_12_14_000001_create_personal_access_tokens_table --
create table `personal_access_tokens` (
  `id` bigint unsigned not null auto_increment primary key, 
  `tokenable_type` varchar(255) not null, 
  `tokenable_id` bigint unsigned not null, 
  `name` varchar(255) not null, 
  `token` varchar(64) not null, 
  `abilities` text null, 
  `last_used_at` timestamp null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `personal_access_tokens` 
add 
  index `personal_access_tokens_tokenable_type_tokenable_id_index`(
    `tokenable_type`, `tokenable_id`
  );
alter table 
  `personal_access_tokens` 
add 
  unique `personal_access_tokens_token_unique`(`token`);

-- migration:2021_03_23_053738_create_sessions_table --
create table `sessions` (
  `id` varchar(255) not null, 
  `user_id` bigint unsigned null, 
  `ip_address` varchar(45) null, 
  `user_agent` text null, 
  `payload` text not null, 
  `last_activity` int not null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `sessions` 
add 
  primary key `sessions_id_primary`(`id`);
alter table 
  `sessions` 
add 
  index `sessions_user_id_index`(`user_id`);
alter table 
  `sessions` 
add 
  index `sessions_last_activity_index`(`last_activity`);

-- migration:2021_03_25_063204_add_is_admin_column_to_users_table --
alter table 
  `users` 
add 
  `is_admin` tinyint(1) not null default '0' 
after 
  `current_team_id`;

-- migration:2021_04_28_075740_create_jwk_data_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `jwk_data` (
  `id` bigint unsigned not null auto_increment primary key, 
  `jwk` text null, `jwk_private` text null, 
  `jwt_token` text null, `public_key` text null, 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';

-- migration:2021_05_03_121258_create_orders_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `orders` (
  `id` bigint unsigned not null auto_increment primary key, 
  `order_number` text not null, 
  `order_date` datetime not null, 
  `order_discount` decimal(8, 2) null, 
  `shipping_total` decimal(8, 2) null, 
  `order_total` decimal(8, 2) null, 
  `order_gst_status` tinyint(1) null, 
  `customer_first_name` text null, 
  `customer_last_name` text null, 
  `billing_address_street` text null, 
  `billing_address_city` text null, 
  `billing_address_state` text null, 
  `billing_address_post_code` text null, 
  `shipping_address_street` text null, 
  `shipping_address_city` text null, 
  `shipping_address_state` text null, 
  `shipping_address_post_code` text null, 
  `contact_phone_number` text null, 
  `ndis_participant_first_name` text not null, 
  `ndis_participant_last_name` text not null, 
  `ndis_participant_number` text not null, 
  `ndis_participant_date_of_birth` date not null, 
  `ndis_plan_management_option` text null, 
  `ndis_plan_start_date` date null, 
  `ndis_plan_end_date` date null, 
  `plan_manager_name` text null, 
  `invoice_email_address` text null, 
  `parent_carer_status` tinyint(1) null, 
  `parent_carer_name` text null, 
  `parent_carer_email` text null, 
  `parent_carer_phone` text null, 
  `parent_carer_relationship` text null, 
  `product_category` text null, 
  `order_status` text null comment '0 = Error, 1 = Submited', 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';

-- migration:2021_05_03_144545_create_order_items_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `order_items` (
  `id` bigint unsigned not null auto_increment primary key, 
  `orders_id` bigint not null, 
  `item_name` text not null, 
  `item_quantity` int not null, 
  `item_price` decimal(8, 2) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `order_items` 
add 
  index `order_items_orders_id_index`(`orders_id`);

-- migration:2021_05_03_144618_create_ndis_service_booking_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `ndis_service_booking` (
  `id` bigint unsigned not null auto_increment primary key, 
  `orders_id` bigint not null, `service_booking_id` text null, 
  `status` tinyint null comment '1 = Requested, 2 = Delete', 
  `api_response` text null, `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `ndis_service_booking` 
add 
  index `ndis_service_booking_orders_id_index`(`orders_id`);

-- migration:2021_05_03_144649_create_ndis_payment_request_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `ndis_payment_request` (
  `id` bigint unsigned not null auto_increment primary key, 
  `ndis_service_booking_id` bigint not null, 
  `orders_id` bigint not null, `order_item_id` bigint not null, 
  `claim_number` text null, `status` tinyint null comment '0 = Rejected, 1 = Incomplete, 4 = Pending Payment, 41 = Paid, 42 = Cancelled, 7 = Awaiting Approval', 
  `api_response` text null, `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `ndis_payment_request` 
add 
  index `ndis_payment_request_ndis_service_booking_id_index`(`ndis_service_booking_id`);
alter table 
  `ndis_payment_request` 
add 
  index `ndis_payment_request_orders_id_index`(`orders_id`);
alter table 
  `ndis_payment_request` 
add 
  index `ndis_payment_request_order_item_id_index`(`order_item_id`);

-- migration:2021_05_04_062628_create_device_authentication_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `device_authentication` (
  `id` bigint unsigned not null auto_increment primary key, 
  `access_token` text null, 
  `token_expiry` datetime null, 
  `expires_in` int null comment 'Expire in seconds', 
  `device_expiry` datetime null, 
  `key_expiry` datetime null, 
  `token_type` varchar(255) null, 
  `scope` varchar(255) null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';

-- migration:2021_05_11_055126_create_product_category_items_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `product_category_items` (
  `id` bigint unsigned not null auto_increment primary key, 
  `item_number` text not null, `item_name` text null, 
  `category_name` text null, `priority` int null, 
  `status` tinyint not null default '1' comment '0 = inactive, 1 = active', 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';

-- migration:2021_05_12_070229_create_logs_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `logs` (
  `id` bigint unsigned not null auto_increment primary key, 
  `name` varchar(255) null, 
  `url` text null, 
  `headers` text null, 
  `payload` text null, 
  `method` varchar(255) null, 
  `response` text null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';

-- migration:2021_05_19_132411_modify_column_to_personal_access_tokens_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';

-- migration:2021_05_20_054059_modify_column_to_orders_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';

-- migration:2021_05_21_150316_create_audit_change_log_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `audit_change_log` (
  `id` bigint unsigned not null auto_increment primary key, 
  `page_id` varchar(100) null, 
  `action` varchar(100) null, 
  `created_user_id` bigint not null, 
  `orders_id` bigint null, 
  `created_at` timestamp not null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `audit_change_log` 
add 
  index `audit_change_log_created_user_id_index`(`created_user_id`);
alter table 
  `audit_change_log` 
add 
  index `audit_change_log_orders_id_index`(`orders_id`);

-- migration:2021_05_24_112131_add_google2fa_secret_to_users --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';

-- migration:2021_06_29_130601_add_columns_to_order_items_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';

-- migration:2021_07_01_142204_add_column_to_orders_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';

-- migration:2022_05_16_014334_create_bcm_order_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `bcm_order` (
  `order_number` bigint not null, 
  `order_date` datetime not null, 
  `order_discount` decimal(8, 2) null, 
  `shipping_total` decimal(8, 2) null, 
  `order_total` decimal(8, 2) null, 
  `gst_total` decimal(8, 2) null, 
  `order_gst_status` int null, 
  `customer_first_name` text null, 
  `customer_last_name` text null, 
  `customer_email` varchar(255) not null, 
  `customer_phone_number` varchar(255) not null, 
  `order_comment` text null, 
  `billing_address_first_name` text null, 
  `billing_address_last_name` text null, 
  `billing_address_company` text null, 
  `billing_address_street` text null, 
  `billing_address_city` text null, 
  `billing_address_state` text null, 
  `billing_address_post_code` text null, 
  `shipping_address_first_name` text null, 
  `shipping_address_last_name` text null, 
  `shipping_address_company` text null, 
  `shipping_address_street` text null, 
  `shipping_address_city` text null, 
  `shipping_address_state` text null, 
  `shipping_address_post_code` text null, 
  `contact_phone_number` text null, 
  `invoice_email_address` text null, 
  `payment_option` text null, 
  `product_category` text null, 
  `order_status` text null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `bcm_order` 
add 
  unique `bcm_order_order_number_unique`(`order_number`);

-- migration:2022_05_16_051114_create_bcm_order_items_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `bcm_order_items` (
  `id` bigint unsigned not null auto_increment primary key, 
  `order_id` bigint not null, 
  `item_name` varchar(255) not null, 
  `item_quantity` int not null, 
  `item_price` decimal(8, 2) not null, 
  `product_category` varchar(255) null, 
  `product_category_item` varchar(255) null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';
alter table 
  `bcm_order_items` 
add 
  unique `bcm_order_items_order_id_unique`(`order_id`);

-- migration:2022_05_24_052702_create_shippings_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `shipping` (
  `id` bigint unsigned not null auto_increment primary key, 
  `tracking_number` varchar(255) null, 
  `courier_company` varchar(255) null, 
  `expected_time_of_arrival` varchar(255) null, 
  `dispatch_time` varchar(255) null, 
  `notes` text null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';

-- migration:2022_05_25_033806_add_order_id_to_shipping --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';

-- migration:2022_05_30_065716_create_ticketings_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `ticketing` (
  `id` bigint unsigned not null auto_increment primary key, 
  `subject` varchar(255) null, 
  `status` varchar(255) null, 
  `due_date` date null, 
  `notes` text null, 
  `order_number` varchar(255) null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null, 
  `type` varchar(255) null
) default character set utf8 collate 'utf8_unicode_ci';

-- migration:2022_06_03_061759_create_comments_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `comment` (
  `id` bigint unsigned not null auto_increment primary key, 
  `order_number` bigint not null, `created_at` timestamp null, 
  `updated_at` timestamp null, `comment` text not null
) default character set utf8 collate 'utf8_unicode_ci';

-- migration:2022_06_14_093152_create_suppliers_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `suppliers` (
  `supplier_id` text null, 
  `supplier_name` varchar(255) not null, 
  `order_id` bigint not null, 
  `product_sku` varchar(255) null, 
  `supplier_emailid` varchar(255) null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';

-- migration:2022_06_14_095523_add_more_columns_to_supplier --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';

-- migration:2022_06_21_124542_add_assignment_to_bcm_order_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';

-- migration:2022_06_28_115636_create_tracking_order_progress_table --
select 
  * 
from 
  information_schema.tables 
where 
  table_schema = ? 
  and table_name = ? 
  and table_type = 'BASE TABLE';
create table `trackingOrderProgress` (
  `id` bigint unsigned not null auto_increment primary key, 
  `trackingInterval` varchar(255) not null default '5' comment 'day', 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8 collate 'utf8_unicode_ci';
