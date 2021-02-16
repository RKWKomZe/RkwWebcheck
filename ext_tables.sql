#
# Table structure for table 'tx_rkwwebcheck_domain_model_webcheck'
#
CREATE TABLE tx_rkwwebcheck_domain_model_webcheck (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	check_pid int(11) DEFAULT '0' NOT NULL,
	result_a text NOT NULL,
	result_b text NOT NULL,
	result_c text NOT NULL,
	topics int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_topic'
#
CREATE TABLE tx_rkwwebcheck_domain_model_topic (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	webcheck int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	weight double(11,2) DEFAULT '1.00' NOT NULL,
	result_a text NOT NULL,
	result_b text NOT NULL,
	result_c text NOT NULL,
	questions int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_question'
#
CREATE TABLE tx_rkwwebcheck_domain_model_question (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	topic int(11) unsigned DEFAULT '0' NOT NULL,

	question varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	answer_1 varchar(255) DEFAULT '' NOT NULL,
	result_1 text NOT NULL,
	value_1 int(11) DEFAULT '0' NOT NULL,
	answer_2 varchar(255) DEFAULT '' NOT NULL,
	result_2 text NOT NULL,
	value_2 int(11) DEFAULT '0' NOT NULL,
	answer_3 varchar(255) DEFAULT '' NOT NULL,
	result_3 text NOT NULL,
	value_3 int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_glossary'
#
CREATE TABLE tx_rkwwebcheck_domain_model_glossary (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	webcheck int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_checkresult'
#
CREATE TABLE tx_rkwwebcheck_domain_model_checkresult (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	fe_user varchar(255) DEFAULT '' NOT NULL,
	sum int(11) DEFAULT '0' NOT NULL,
    percentage double(11,1) DEFAULT '0.0' NOT NULL,

	completed int(11) DEFAULT '0' NOT NULL,
	send_notification tinyint(1) unsigned DEFAULT '0' NOT NULL,
	notification_timestamp int(11) DEFAULT '0' NOT NULL,
	results int(11) unsigned DEFAULT '0' NOT NULL,
	last_topic int(11) unsigned DEFAULT '0',
	last_question int(11) unsigned DEFAULT '0',
	webcheck int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_topicresult'
#
CREATE TABLE tx_rkwwebcheck_domain_model_topicresult (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	check_result int(11) unsigned DEFAULT '0' NOT NULL,

	sum int(11) DEFAULT '0' NOT NULL,
    percentage double(11,1) DEFAULT '0.0' NOT NULL,

	webcheck int(11) unsigned DEFAULT '0',
	topic int(11) unsigned DEFAULT '0',
	results int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_questionresult'
#
CREATE TABLE tx_rkwwebcheck_domain_model_questionresult (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	topic_result int(11) unsigned DEFAULT '0' NOT NULL,

	sum int(11) DEFAULT '0' NOT NULL,
	webcheck int(11) unsigned DEFAULT '0',
    topic int(11) unsigned DEFAULT '0',
	question int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_topic'
#
CREATE TABLE tx_rkwwebcheck_domain_model_topic (

	webcheck int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_question'
#
CREATE TABLE tx_rkwwebcheck_domain_model_question (

	topic int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_topicresult'
#
CREATE TABLE tx_rkwwebcheck_domain_model_topicresult (

	check_result int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwebcheck_domain_model_questionresult'
#
CREATE TABLE tx_rkwwebcheck_domain_model_questionresult (

	topic_result int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_webcheck_check_topic_mm'
#
CREATE TABLE tx_rkwwebcheck_check_topic_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_webcheck_topic_question_mm'
#
CREATE TABLE tx_rkwwebcheck_topic_question_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

