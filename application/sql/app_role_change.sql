INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES (NULL, 'Social Stream_Notification', 'Case Notification', 'Social Stream', '2014-02-20', '1', '1');
INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES (NULL, 'Search', 'Search', 'Search', '2014-02-20', '1', NULL);
INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES
(NULL, 'Regional_User', 'Regional User', 'User Management', '2014-02-20', '1', '2');
INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES
(NULL, 'Publisher_All_Edit_Post', 'Edit Post', 'Publisher', '2014-02-20', '1', '42');
INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES
(NULL, 'Content Management_Product_Edit', 'Edit', 'Content Management', '2014-02-20', '1', '55');

INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES
(NULL, 'Content Management_Short_URL_Edit', 'Edit', 'Content Management', '2014-02-20', '1', '51');

INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES
(NULL, 'Content Management_Campaign_View', 'Edit', 'Content Management', '2014-02-20', '1', '46');

INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES
(NULL, 'Content Management_TAG_Edit', 'Edit', 'Content Management', '2014-02-20', '1', '59');



INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES
(NULL, 'Social Channel Management_Country', 'Country', 'Social Channel Management', '2014-02-20', '1', '7');

Set @last_id_country = LAST_INSERT_ID();
INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES
(NULL, 'Social Channel Management_Country_Add', 'Add', 'Social Channel Management', '2014-02-20', '1', @last_id_country);
INSERT INTO `maybank`.`application_role` (`app_role_id`, `role_friendly_name`, `role_name`, `role_group`, `created_at`, `active`, `parent_id`) VALUES
(NULL, 'Social Channel Management_Country_Delete', 'Delete', 'Social Channel Management', '2014-02-20', '1', @last_id_country);


UPDATE `maybank`.`application_role` SET `role_name` = 'All Countrys Channel' WHERE `application_role`.`app_role_id` in (69, 65);
UPDATE `maybank`.`application_role` SET `role_name` = 'All Available Channel' WHERE `application_role`.`app_role_id` in (70, 66);
