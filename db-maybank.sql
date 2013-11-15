SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `maybank` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
SHOW WARNINGS;
USE `maybank` ;

-- -----------------------------------------------------
-- Table `role_collection`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `role_collection` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `role_collection` (
  `role_collection_id` INT NOT NULL ,
  `role_name` VARCHAR(255) NULL ,
  `created_by` INT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`role_collection_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `user` (
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
  CONSTRAINT `user_created_by`
    FOREIGN KEY (`created_by` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_role_collection1`
    FOREIGN KEY (`role_id` )
    REFERENCES `role_collection` (`role_collection_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_app_group1`
    FOREIGN KEY (`group_id` )
    REFERENCES `user_group` (`group_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `user_created_by` ON `user` (`created_by` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_user_role_collection1` ON `user` (`role_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_user_app_group1` ON `user` (`group_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `user_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_group` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `user_group` (
  `group_id` INT NOT NULL AUTO_INCREMENT ,
  `group_name` VARCHAR(45) NULL ,
  `created_at` DATETIME NULL ,
  `is_active` TINYINT(1) NOT NULL ,
  `created_by` INT NULL ,
  PRIMARY KEY (`group_id`) ,
  CONSTRAINT `fk_user_group_user1`
    FOREIGN KEY (`created_by` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_user_group_user1` ON `user_group` (`created_by` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `application_role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `application_role` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `application_role` (
  `app_role_id` INT NOT NULL AUTO_INCREMENT ,
  `role_friendly_name` VARCHAR(255) NOT NULL ,
  `role_name` VARCHAR(255) NOT NULL ,
  `role_group` VARCHAR(128) NULL ,
  `created_at` DATETIME NULL ,
  `active` TINYINT(1) NULL ,
  PRIMARY KEY (`app_role_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `role_collection_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `role_collection_detail` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `role_collection_detail` (
  `detail_id` INT NOT NULL ,
  `role_collection_id` INT NOT NULL ,
  `app_role_id` INT NOT NULL ,
  PRIMARY KEY (`detail_id`) ,
  CONSTRAINT `fk_role_collection_detail_role_collection`
    FOREIGN KEY (`role_collection_id` )
    REFERENCES `role_collection` (`role_collection_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_collection_detail_application_role1`
    FOREIGN KEY (`app_role_id` )
    REFERENCES `application_role` (`app_role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_role_collection_detail_role_collection` ON `role_collection_detail` (`role_collection_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_role_collection_detail_application_role1` ON `role_collection_detail` (`app_role_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `user_password_change_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_password_change_log` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `user_password_change_log` (
  `log_id` BIGINT NOT NULL AUTO_INCREMENT ,
  `old_password` VARCHAR(255) NOT NULL ,
  `new_password` VARCHAR(255) NOT NULL ,
  `new_salt` VARCHAR(255) NULL ,
  `old_salt` VARCHAR(255) NULL ,
  `created_at` DATETIME NULL ,
  `ip_address` VARCHAR(45) NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`log_id`) ,
  CONSTRAINT `fk_user_password_change_log_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_user_password_change_log_user1` ON `user_password_change_log` (`user_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `channel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `channel` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `channel` (
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

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `user_group_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_group_detail` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `user_group_detail` (
  `detail_id` INT NOT NULL AUTO_INCREMENT ,
  `user_group_id` INT NOT NULL ,
  `allowed_channel` INT NOT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`detail_id`) ,
  CONSTRAINT `fk_user_group_detail_user_group1`
    FOREIGN KEY (`user_group_id` )
    REFERENCES `user_group` (`group_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_detail_channel1`
    FOREIGN KEY (`allowed_channel` )
    REFERENCES `channel` (`channel_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_user_group_detail_user_group1` ON `user_group_detail` (`user_group_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_user_group_detail_channel1` ON `user_group_detail` (`allowed_channel` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `user_forgot_password`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_forgot_password` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `user_forgot_password` (
  `forgot_id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `link` VARCHAR(255) NULL ,
  `expired_at` DATETIME NULL ,
  PRIMARY KEY (`forgot_id`) ,
  CONSTRAINT `fk_user_forgot_password_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_user_forgot_password_user1` ON `user_forgot_password` (`user_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `app_navigation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `app_navigation` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `app_navigation` (
  `navigation_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `order` TINYINT NULL ,
  `url_destination` VARCHAR(45) NULL ,
  `lang` CHAR(2) NULL COMMENT 'id or en\n' ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`navigation_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `role_navigation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `role_navigation` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `role_navigation` (
  `role_navigation_id` INT NOT NULL AUTO_INCREMENT ,
  `created_at` DATETIME NULL ,
  `navigation_id` INT NOT NULL ,
  `created_by` INT NOT NULL ,
  `role_id` INT NOT NULL ,
  PRIMARY KEY (`role_navigation_id`) ,
  CONSTRAINT `fk_role_navigation_app_navigation1`
    FOREIGN KEY (`navigation_id` )
    REFERENCES `app_navigation` (`navigation_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_navigation_user1`
    FOREIGN KEY (`created_by` )
    REFERENCES `user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_navigation_role_collection1`
    FOREIGN KEY (`role_id` )
    REFERENCES `role_collection` (`role_collection_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_role_navigation_app_navigation1` ON `role_navigation` (`navigation_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_role_navigation_user1` ON `role_navigation` (`created_by` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_role_navigation_role_collection1` ON `role_navigation` (`role_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `social_stream`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_stream` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `social_stream` (
  `post_id` BIGINT NOT NULL ,
  `post_stream_id` VARCHAR(255) NOT NULL COMMENT 'id from facebook, twitter or youtube\n' ,
  `channel_id` INT NOT NULL ,
  `type` VARCHAR(255) NULL COMMENT 'conversation_fb\nstream_fb\nstream_twitter\ndm_twitter\n' ,
  `retrieved_at` DATETIME NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`post_id`) ,
  CONSTRAINT `fk_social_stream_channel1`
    FOREIGN KEY (`channel_id` )
    REFERENCES `channel` (`channel_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_channel1` ON `social_stream` (`channel_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `social_stream_id` ON `social_stream` (`post_stream_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `fb_user_engaged`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fb_user_engaged` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `fb_user_engaged` (
  `facebook_id` VARCHAR(32) NOT NULL ,
  `name` VARCHAR(255) NULL ,
  `username` VARCHAR(64) NULL ,
  `created_at` DATETIME NULL ,
  `retrieved_at` DATETIME NULL ,
  `sex` CHAR(1) NULL DEFAULT ' ' ,
  PRIMARY KEY (`facebook_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `social_stream_fb_post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_stream_fb_post` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `social_stream_fb_post` (
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
  CONSTRAINT `fk_social_stream_facebook_social_stream1`
    FOREIGN KEY (`post_id` )
    REFERENCES `social_stream` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_fb_post_fb_user_engaged1`
    FOREIGN KEY (`author_id` )
    REFERENCES `fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_fb_post_fb_user_engaged1` ON `social_stream_fb_post` (`author_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `social_stream_fb_likes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_stream_fb_likes` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `social_stream_fb_likes` (
  `id` BIGINT NOT NULL AUTO_INCREMENT ,
  `post_id` BIGINT NOT NULL ,
  `facebook_id` VARCHAR(32) NOT NULL ,
  `date_created` DATETIME NULL ,
  `retrieved_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_social_stream_facebook_likes_social_stream_facebook_post1`
    FOREIGN KEY (`post_id` )
    REFERENCES `social_stream_fb_post` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_facebook_likes_facebook_user_engagged1`
    FOREIGN KEY (`facebook_id` )
    REFERENCES `fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_facebook_likes_social_stream_facebook_post1` ON `social_stream_fb_likes` (`post_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_facebook_likes_facebook_user_engagged1` ON `social_stream_fb_likes` (`facebook_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `social_stream_fb_comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_stream_fb_comments` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `social_stream_fb_comments` (
  `id` VARCHAR(64) NOT NULL ,
  `from` VARCHAR(32) NOT NULL ,
  `comment_content` TEXT NULL ,
  `created_at` DATETIME NULL ,
  `retrieved_at` DATETIME NULL ,
  `like_count` INT NULL ,
  `hierarchy` TINYINT NULL ,
  `comment_id` VARCHAR(64) NULL ,
  `attachment` VARCHAR(255) NULL ,
  `read` TINYINT(1) NULL COMMENT '1 = read\n0 = unread' ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_social_stream_facebook_comments_facebook_user_engagged1`
    FOREIGN KEY (`from` )
    REFERENCES `fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_facebook_comments_facebook_user_engagged1` ON `social_stream_fb_comments` (`from` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `social_stream_facebook_conversation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_stream_facebook_conversation` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `social_stream_facebook_conversation` (
  `conversation_id` BIGINT NOT NULL ,
  `snippet` VARCHAR(255) NULL ,
  `updated_time` DATETIME NULL ,
  `message_count` INT NULL ,
  `unread_count` INT NULL ,
  `status` TINYINT NULL DEFAULT 1 COMMENT '1 = show\n0 = hide\n\n' ,
  PRIMARY KEY (`conversation_id`) ,
  CONSTRAINT `fk_social_stream_facebook_conversation_social_stream1`
    FOREIGN KEY (`conversation_id` )
    REFERENCES `social_stream` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `social_stream_fb_conversation_participant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_stream_fb_conversation_participant` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `social_stream_fb_conversation_participant` (
  `id` BIGINT NOT NULL ,
  `fb_user_id` VARCHAR(32) NOT NULL ,
  `conversation_id` BIGINT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_social_stream_fb_conversation_participant_fb_user_engagged1`
    FOREIGN KEY (`fb_user_id` )
    REFERENCES `fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_fb_conversation_participant_social_stream_fa1`
    FOREIGN KEY (`conversation_id` )
    REFERENCES `social_stream_facebook_conversation` (`conversation_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_fb_conversation_participant_fb_user_engagged1` ON `social_stream_fb_conversation_participant` (`fb_user_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_fb_conversation_participant_social_stream_fa1` ON `social_stream_fb_conversation_participant` (`conversation_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `social_stream_facebook_conversation_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_stream_facebook_conversation_detail` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `social_stream_facebook_conversation_detail` (
  `detail_id` BIGINT NOT NULL ,
  `detail_id_from_facebook` VARCHAR(255) NULL ,
  `messages` TEXT NULL ,
  `sender` VARCHAR(32) NOT NULL ,
  `to` VARCHAR(32) NOT NULL ,
  `created_at` DATETIME NULL ,
  `conversation_id` BIGINT NOT NULL ,
  PRIMARY KEY (`detail_id`) ,
  CONSTRAINT `fk_social_stream_facebook_conversation_detail_fb_user_engagged1`
    FOREIGN KEY (`sender` )
    REFERENCES `fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_facebook_conversation_detail_fb_user_engagged2`
    FOREIGN KEY (`to` )
    REFERENCES `fb_user_engaged` (`facebook_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_facebook_conversation_detail_social_stream_f1`
    FOREIGN KEY (`conversation_id` )
    REFERENCES `social_stream_facebook_conversation` (`conversation_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_facebook_conversation_detail_fb_user_engagged1` ON `social_stream_facebook_conversation_detail` (`sender` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_facebook_conversation_detail_fb_user_engagged2` ON `social_stream_facebook_conversation_detail` (`to` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `conversation_detail_id` ON `social_stream_facebook_conversation_detail` (`detail_id_from_facebook` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_facebook_conversation_detail_social_stream_f1` ON `social_stream_facebook_conversation_detail` (`conversation_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `social_stream_twitter`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_stream_twitter` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `social_stream_twitter` (
  `post_id` BIGINT NOT NULL ,
  `type` VARCHAR(32) NULL COMMENT 'DM = Direct Messages\nUT = User Timeline\nMT = Mentions Timeline' ,
  `favorited` TINYINT NULL ,
  `in_reply_to` BIGINT NOT NULL ,
  `text` VARCHAR(255) NULL ,
  `retweet_count` INT NULL ,
  `geolocation` VARCHAR(255) NULL ,
  `source` VARCHAR(255) NULL ,
  PRIMARY KEY (`post_id`) ,
  CONSTRAINT `fk_social_stream_twitter_social_stream1`
    FOREIGN KEY (`post_id` )
    REFERENCES `social_stream` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_twitter_social_stream_twitter1`
    FOREIGN KEY (`in_reply_to` )
    REFERENCES `social_stream_twitter` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_twitter_social_stream_twitter1` ON `social_stream_twitter` (`in_reply_to` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `twitter_user_engaged`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `twitter_user_engaged` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `twitter_user_engaged` (
  `twitter_user_id` BIGINT NOT NULL ,
  `screen_name` VARCHAR(255) NULL ,
  `name` VARCHAR(255) NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`twitter_user_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `social_stream_twitter_mentions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_stream_twitter_mentions` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `social_stream_twitter_mentions` (
  `mention_id` BIGINT NOT NULL AUTO_INCREMENT ,
  `post_id` BIGINT NOT NULL ,
  `index_1` INT NULL ,
  `index_2` INT NULL ,
  `user_id` BIGINT NOT NULL ,
  PRIMARY KEY (`mention_id`) ,
  CONSTRAINT `fk_social_stream_twitter_mentions_social_stream_twitter1`
    FOREIGN KEY (`post_id` )
    REFERENCES `social_stream_twitter` (`post_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_twitter_mentions_twitter_user_enggaged1`
    FOREIGN KEY (`user_id` )
    REFERENCES `twitter_user_engaged` (`twitter_user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_twitter_mentions_social_stream_twitter1` ON `social_stream_twitter_mentions` (`post_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fk_social_stream_twitter_mentions_twitter_user_enggaged1` ON `social_stream_twitter_mentions` (`user_id` ASC) ;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
