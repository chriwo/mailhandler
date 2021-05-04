#
# Table structure for table 'tx_mailhandler_domain_model_mail'
#
CREATE TABLE tx_mailhandler_domain_model_mail (
	title varchar(100) DEFAULT '' NOT NULL,
	mail_subject varchar(100) DEFAULT '' NOT NULL,
	mail_body text,
	mail_sender varchar(255) DEFAULT '' NOT NULL,
	mail_receiver varchar(255) DEFAULT '' NOT NULL,
	mail_receiver_cc text,
	mail_receiver_bcc text,
	mail_return_path varchar(100) DEFAULT '' NOT NULL,
	mail_reply_to text,
	mail_attachment int(11) unsigned DEFAULT '0' NOT NULL,

	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);
