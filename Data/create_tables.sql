CREATE TABLE IF NOT EXISTS timers (
  timer_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  created  int(10) unsigned DEFAULT NULL,
  client_ip varchar(15) DEFAULT NULL,
  elapsed_seconds int(10) unsigned DEFAULT NULL,
  start int(10) unsigned DEFAULT NULL,
  stop int(10) unsigned DEFAULT NULL,
  last_updated int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (timer_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS users (
  user_id int(11) NOT NULL AUTO_INCREMENT,
  created int(11) DEFAULT NULL,
  modified int(11) DEFAULT NULL,
  token varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  last_login int(11) DEFAULT NULL,
  time_zone varchar(255) DEFAULT NULL,
  first_name varchar(255) DEFAULT NULL,
  last_name varchar(255) DEFAULT NULL,
  email varchar(255) DEFAULT NULL,
  profile_text varchar(255) DEFAULT NULL,
  location varchar(255) DEFAULT NULL,
  avatar varchar(255) DEFAULT NULL,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=5 ;