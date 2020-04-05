/* 预备 */
SET NAMES 'utf8';

/* 表 */
DROP TABLE IF EXISTS `jz_danzi`;

  #链接
CREATE TABLE `jz_danzi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,                     /* id */
  `jz_date` varchar(64) NOT NULL DEFAULT '',                /* 日期 */
  `jz_name` varchar(64) NOT NULL DEFAULT '',                /* 名称 */
  `jz_bet` varchar(64) NOT NULL DEFAULT '',                 /* 名称 */
  `jz_win` varchar(64) NOT NULL DEFAULT '',                 /* 名称 */
  `pubtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', /* 发表时间 */
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `jz_danzi` (`id`, `jz_date`, `jz_name`, `jz_bet`, `jz_win`, `pubtime`) VALUES 
(1, '6.1', '001 3 002 3','100', '255', '2016-06-01 09:09:09');

INSERT INTO `jz_danzi` (`id`, `jz_date`, `jz_name`, `jz_bet`, `jz_win`, `pubtime`) VALUES 
(2, '6.2', '001 3 002 3','100', '255', '2016-06-02 09:09:09');