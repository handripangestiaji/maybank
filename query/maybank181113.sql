SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `maybank` ;
CREATE SCHEMA IF NOT EXISTS `maybank` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `maybank` ;




-- -----------------------------------------------------
-- Table `maybank`.`role_collection`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`role_collection` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`role_collection` (
  `role_collection_id` INT NOT NULL ,
  `role_name` VARCHAR(255) NULL ,
  `created_by` INT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`role_collection_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`user` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT ,
  `full_name` VARCHAR(255) NOT NULL ,
  `display_name` VARCHAR(255) NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `created_at` DATETIME NULL ,
  `created_by` INT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `salt` VARCHAR(255) NOT NULL DEFAULT 'maybank_salt' ,
  `role_id` INT NULL ,
  `group_id` INT NULL ,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`user_id`) ,
  INDEX `user_created_by` (`created_by` ASC) ,
  INDEX `fk_user_role_collection1` (`role_id` ASC) ,
  INDEX `fk_user_app_group1` (`group_id` ASC) ,
  CONSTRAINT `user_created_by`
    FOREIGN KEY (`created_by` )
    REFERENCES `maybank`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_role_collection1`
    FOREIGN KEY (`role_id` )
    REFERENCES `maybank`.`role_collection` (`role_collection_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_app_group1`
    FOREIGN KEY (`group_id` )
    REFERENCES `maybank`.`user_group` (`group_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`user_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`user_group` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`user_group` (
  `group_id` INT NOT NULL AUTO_INCREMENT ,
  `group_name` VARCHAR(45) NULL ,
  `created_at` DATETIME NULL ,
  `is_active` TINYINT(1) NOT NULL ,
  `created_by` INT NULL ,
  PRIMARY KEY (`group_id`) ,
  INDEX `fk_user_group_user1` (`created_by` ASC) ,
  CONSTRAINT `fk_user_group_user1`
    FOREIGN KEY (`created_by` )
    REFERENCES `maybank`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`application_role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`application_role` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`application_role` (
  `app_role_id` INT NOT NULL AUTO_INCREMENT ,
  `role_friendly_name` VARCHAR(255) NOT NULL ,
  `role_name` VARCHAR(255) NOT NULL ,
  `role_group` VARCHAR(128) NULL ,
  `created_at` DATETIME NULL ,
  `active` TINYINT(1) NULL ,
  PRIMARY KEY (`app_role_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`role_collection_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`role_collection_detail` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`role_collection_detail` (
  `detail_id` INT NOT NULL ,
  `role_collection_id` INT NOT NULL ,
  `app_role_id` INT NOT NULL ,
  PRIMARY KEY (`detail_id`) ,
  INDEX `fk_role_collection_detail_role_collection` (`role_collection_id` ASC) ,
  INDEX `fk_role_collection_detail_application_role1` (`app_role_id` ASC) ,
  CONSTRAINT `fk_role_collection_detail_role_collection`
    FOREIGN KEY (`role_collection_id` )
    REFERENCES `maybank`.`role_collection` (`role_collection_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_collection_detail_application_role1`
    FOREIGN KEY (`app_role_id` )
    REFERENCES `maybank`.`application_role` (`app_role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`user_password_change_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`user_password_change_log` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`user_password_change_log` (
  `log_id` BIGINT NOT NULL AUTO_INCREMENT ,
  `old_password` VARCHAR(255) NOT NULL ,
  `new_password` VARCHAR(255) NOT NULL ,
  `new_salt` VARCHAR(255) NULL ,
  `old_salt` VARCHAR(255) NULL ,
  `created_at` DATETIME NULL ,
  `ip_address` VARCHAR(45) NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`log_id`) ,
  INDEX `fk_user_password_change_log_user1` (`user_id` ASC) ,
  CONSTRAINT `fk_user_password_change_log_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `maybank`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`channel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`channel` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`channel` (
  `channel_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `oauth_token` VARCHAR(255) NOT NULL ,
  `oauth_secret` VARCHAR(255) NOT NULL ,
  `token_created_at` DATETIME NULL ,
  `is_active` TINYINT(1) NULL ,
  `connection_type` VARCHAR(45) NOT NULL COMMENT 'facebook, twitter, youtube\n' ,
  `social_id` VARCHAR(255) NOT NULL COMMENT 'facebook page_id\ntwitter screen_name\n' ,
  PRIMARY KEY (`channel_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`user_group_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`user_group_detail` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`user_group_detail` (
  `detail_id` INT NOT NULL AUTO_INCREMENT ,
  `user_group_id` INT NOT NULL ,
  `allowed_channel` INT NOT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`detail_id`) ,
  INDEX `fk_user_group_detail_user_group1` (`user_group_id` ASC) ,
  INDEX `fk_user_group_detail_channel1` (`allowed_channel` ASC) ,
  CONSTRAINT `fk_user_group_detail_user_group1`
    FOREIGN KEY (`user_group_id` )
    REFERENCES `maybank`.`user_group` (`group_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_detail_channel1`
    FOREIGN KEY (`allowed_channel` )
    REFERENCES `maybank`.`channel` (`channel_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`user_forgot_password`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`user_forgot_password` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`user_forgot_password` (
  `forgot_id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `link` VARCHAR(255) NULL ,
  `expired_at` DATETIME NULL ,
  PRIMARY KEY (`forgot_id`) ,
  INDEX `fk_user_forgot_password_user1` (`user_id` ASC) ,
  CONSTRAINT `fk_user_forgot_password_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `maybank`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`app_navigation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`app_navigation` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`app_navigation` (
  `navigation_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `order` TINYINT NULL ,
  `url_destination` VARCHAR(45) NULL ,
  `lang` CHAR(2) NULL COMMENT 'id or en\n' ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`navigation_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`role_navigation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`role_navigation` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`role_navigation` (
  `role_navigation_id` INT NOT NULL AUTO_INCREMENT ,
  `created_at` DATETIME NULL ,
  `navigation_id` INT NOT NULL ,
  `created_by` INT NOT NULL ,
  `role_id` INT NOT NULL ,
  PRIMARY KEY (`role_navigation_id`) ,
  INDEX `fk_role_navigation_app_navigation1` (`navigation_id` ASC) ,
  INDEX `fk_role_navigation_user1` (`created_by` ASC) ,
  INDEX `fk_role_navigation_role_collection1` (`role_id` ASC) ,
  CONSTRAINT `fk_role_navigation_app_navigation1`
    FOREIGN KEY (`navigation_id` )
    REFERENCES `maybank`.`app_navigation` (`navigation_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_navigation_user1`
    FOREIGN KEY (`created_by` )
    REFERENCES `maybank`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_navigation_role_collection1`
    FOREIGN KEY (`role_id` )
    REFERENCES `maybank`.`role_collection` (`role_collection_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`social_stream`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`social_stream` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`social_stream` (
  `post_id` BIGINT NOT NULL AUTO_INCREMENT ,
  `post_stream_id` VARCHAR(255) NOT NULL COMMENT 'id from facebook, twitter or youtube\n' ,
  `channel_id` INT NOT NULL ,
  `type` VARCHAR(255) NULL COMMENT 'conversation_fb\nstream_fb\nstream_twitter\ndm_twitter\n' ,
  `retrieved_at` DATETIME NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`post_id`) ,
  INDEX `fk_social_stream_channel1` (`channel_id` ASC) ,
  INDEX `social_stream_id` (`post_stream_id` ASC) ,
  CONSTRAINT `fk_social_stream_channel1`
    FOREIGN KEY (`channel_id` )
    REFERENCES `maybank`.`channel` (`channel_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`fb_user_engaged`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`fb_user_engaged` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`fb_user_engaged` (
  `facebook_id` VARCHAR(32) NOT NULL ,
  `name` VARCHAR(255) NULL DEFAULT NULL ,
  `username` VARCHAR(64) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `retrieved_at` DATETIME NULL DEFAULT NULL ,
  `sex` CHAR(1) NULL DEFAULT '' ,
  PRIMARY KEY (`facebook_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `maybank`.`social_stream_fb_post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`social_stream_fb_post` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`social_stream_fb_post` (
  `post_id` BIGINT NOT NULL ,
  `post_content` TEXT NULL ,
  `author_id` VARCHAR(32) NOT NULL ,
  `attachment` TEXT NULL ,
  `enggagement_count` INT NULL ,
  `total_likes` INT NULL ,
  `total_comments` INT NULL ,
  `total_shares` INT NULL ,
  `updated_at` DATETIME NULL ,
  `is_customer_post` TINYINT NOT NULL DEFAULT 0 ,
  `post_status` TINYINT NOT NULL DEFAULT 1 COMMENT '1 = published\n2 = removed\n' ,
  PRIMARY KEY (`post_id`) ,
  INDEX `fk_social_stream_fb_post_fb_user_engaged1` (`author_id` ASC) ,
  CONSTRAINT `fk_social_stream_facebook_social_stream1`
    FOREIGN KEY (`post_id` )
    REFERENCES `maybank`.`social_stream` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_fb_post_fb_user_engaged1`
    FOREIGN KEY (`author_id` )
    REFERENCES `maybank`.`fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`social_stream_fb_likes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`social_stream_fb_likes` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`social_stream_fb_likes` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
  `post_id` BIGINT(20) NOT NULL ,
  `facebook_id` VARCHAR(32) NOT NULL ,
  `date_created` DATETIME NULL DEFAULT NULL ,
  `retrieved_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_social_stream_facebook_likes_social_stream_facebook_post1` (`post_id` ASC) ,
  INDEX `fk_social_stream_facebook_likes_facebook_user_engagged1` (`facebook_id` ASC) ,
  CONSTRAINT `fk_social_stream_facebook_likes_facebook_user_engagged1`
    FOREIGN KEY (`facebook_id` )
    REFERENCES `maybank`.`fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_facebook_likes_social_stream_facebook_post1`
    FOREIGN KEY (`post_id` )
    REFERENCES `maybank`.`social_stream_fb_post` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `maybank`.`social_stream_fb_comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`social_stream_fb_comments` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`social_stream_fb_comments` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
  `comment_stream_id` VARCHAR(64) NOT NULL ,
  `from` VARCHAR(32) NOT NULL ,
  `comment_content` TEXT NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `retrieved_at` DATETIME NULL DEFAULT NULL ,
  `like_count` INT(11) NULL DEFAULT NULL ,
  `hierarchy` TINYINT(4) NULL DEFAULT NULL ,
  `comment_id` VARCHAR(64) NULL DEFAULT NULL ,
  `attachment` VARCHAR(255) NULL DEFAULT NULL ,
  `read` TINYINT(1) NULL DEFAULT NULL COMMENT '1 = read\n0 = unread' ,
  `post_id` BIGINT(20) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `comment_stream_id_UNIQUE` (`comment_stream_id` ASC) ,
  INDEX `fk_social_stream_facebook_comments_facebook_user_engagged1` (`from` ASC) ,
  INDEX `fk_social_stream_fb_comments_social_stream_fb_post1` (`post_id` ASC) ,
  CONSTRAINT `fk_social_stream_facebook_comments_facebook_user_engagged1`
    FOREIGN KEY (`from` )
    REFERENCES `maybank`.`fb_user_engaged` (`facebook_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_social_stream_fb_comments_social_stream_fb_post1`
    FOREIGN KEY (`post_id` )
    REFERENCES `maybank`.`social_stream_fb_post` (`post_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 2927
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `maybank`.`social_stream_facebook_conversation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`social_stream_facebook_conversation` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`social_stream_facebook_conversation` (
  `conversation_id` BIGINT NOT NULL ,
  `snippet` VARCHAR(255) NULL ,
  `updated_time` DATETIME NULL ,
  `message_count` INT NULL ,
  `unread_count` INT NULL ,
  `status` TINYINT NULL DEFAULT 1 COMMENT '1 = show\n0 = hide\n\n' ,
  PRIMARY KEY (`conversation_id`) ,
  CONSTRAINT `fk_social_stream_facebook_conversation_social_stream1`
    FOREIGN KEY (`conversation_id` )
    REFERENCES `maybank`.`social_stream` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`social_stream_fb_conversation_participant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`social_stream_fb_conversation_participant` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`social_stream_fb_conversation_participant` (
  `id` BIGINT NOT NULL ,
  `fb_user_id` VARCHAR(32) NOT NULL ,
  `conversation_id` BIGINT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_social_stream_fb_conversation_participant_fb_user_engagged1` (`fb_user_id` ASC) ,
  INDEX `fk_social_stream_fb_conversation_participant_social_stream_fa1` (`conversation_id` ASC) ,
  CONSTRAINT `fk_social_stream_fb_conversation_participant_fb_user_engagged1`
    FOREIGN KEY (`fb_user_id` )
    REFERENCES `maybank`.`fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_fb_conversation_participant_social_stream_fa1`
    FOREIGN KEY (`conversation_id` )
    REFERENCES `maybank`.`social_stream_facebook_conversation` (`conversation_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`social_stream_facebook_conversation_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`social_stream_facebook_conversation_detail` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`social_stream_facebook_conversation_detail` (
  `detail_id` BIGINT NOT NULL ,
  `detail_id_from_facebook` VARCHAR(255) NULL ,
  `messages` TEXT NULL ,
  `sender` VARCHAR(32) NOT NULL ,
  `to` VARCHAR(32) NOT NULL ,
  `created_at` DATETIME NULL ,
  `conversation_id` BIGINT NOT NULL ,
  PRIMARY KEY (`detail_id`) ,
  INDEX `fk_social_stream_facebook_conversation_detail_fb_user_engagged1` (`sender` ASC) ,
  INDEX `fk_social_stream_facebook_conversation_detail_fb_user_engagged2` (`to` ASC) ,
  UNIQUE INDEX `conversation_detail_id` (`detail_id_from_facebook` ASC) ,
  INDEX `fk_social_stream_facebook_conversation_detail_social_stream_f1` (`conversation_id` ASC) ,
  CONSTRAINT `fk_social_stream_facebook_conversation_detail_fb_user_engagged1`
    FOREIGN KEY (`sender` )
    REFERENCES `maybank`.`fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_facebook_conversation_detail_fb_user_engagged2`
    FOREIGN KEY (`to` )
    REFERENCES `maybank`.`fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_facebook_conversation_detail_social_stream_f1`
    FOREIGN KEY (`conversation_id` )
    REFERENCES `maybank`.`social_stream_facebook_conversation` (`conversation_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`twitter_user_engaged`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`twitter_user_engaged` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`twitter_user_engaged` (
  `twitter_user_id` BIGINT NOT NULL ,
  `screen_name` VARCHAR(255) NULL ,
  `profile_image_url` TEXT NULL ,
  `name` VARCHAR(255) NULL ,
  `description` VARCHAR(255) NULL ,
  `url` VARCHAR(255) NULL ,
  `location` VARCHAR(255) NULL ,
  `statuses_count` INT NULL ,
  `friends_count` INT NULL ,
  `followers_count` INT NULL ,
  `verified_account` TINYINT NULL COMMENT '1 = verified , 0 = unverified' ,
  `time_zone` VARCHAR(255) NULL ,
  `following` TINYINT NULL DEFAULT 0 ,
  `created_at` DATETIME NULL ,
  `retrieved_at` DATETIME NULL ,
  PRIMARY KEY (`twitter_user_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maybank`.`social_stream_twitter`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maybank`.`social_stream_twitter` ;

CREATE  TABLE IF NOT EXISTS `maybank`.`social_stream_twitter` (
  `post_id` BIGINT NOT NULL ,
  `type` VARCHAR(32) NULL COMMENT 'Direct Messages, User Timeline, Mentions Timeline' ,
  `favorited` TINYINT NULL ,
  `in_reply_to` BIGINT NOT NULL ,
  `twitter_entities` TEXT NULL ,
  `text` VARCHAR(255) NULL ,
  `retweet_count` INT NULL ,
  `geolocation` VARCHAR(255) NULL ,
  `source` VARCHAR(255) NULL ,
  `twitter_user_id` BIGINT NOT NULL ,
  `created_at` DATETIME NULL COMMENT 'mentions, direct_message, hashtags, homefeed, own_post\n' ,
  PRIMARY KEY (`post_id`) ,
  INDEX `fk_social_stream_twitter_social_stream_twitter1` (`in_reply_to` ASC) ,
  INDEX `fk_social_stream_twitter_twitter_user_engaged1` (`twitter_user_id` ASC) ,
  CONSTRAINT `fk_social_stream_twitter_social_stream1`
    FOREIGN KEY (`post_id` )
    REFERENCES `maybank`.`social_stream` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_twitter_social_stream_twitter1`
    FOREIGN KEY (`in_reply_to` )
    REFERENCES `maybank`.`social_stream_twitter` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_twitter_twitter_user_engaged1`
    FOREIGN KEY (`twitter_user_id` )
    REFERENCES `maybank`.`twitter_user_engaged` (`twitter_user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
