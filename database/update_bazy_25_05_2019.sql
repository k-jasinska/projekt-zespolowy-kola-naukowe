ALTER TABLE pz_projekt.group_achievements MODIFY COLUMN id_group int(11) NULL;
ALTER TABLE pz_projekt.group_achievements DROP FOREIGN KEY group_achievements_groups_fk;
ALTER TABLE pz_projekt.group_achievements ADD CONSTRAINT group_achievements_groups_fk FOREIGN KEY (id_group) REFERENCES pz_projekt.groups(id_group) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE pz_projekt.achievements DROP FOREIGN KEY achievements_member_fk;
ALTER TABLE pz_projekt.achievements ADD CONSTRAINT achievements_member_fk FOREIGN KEY (id_member) REFERENCES pz_projekt.`member`(id_member) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.events DROP FOREIGN KEY events_users_fk;
ALTER TABLE pz_projekt.events ADD CONSTRAINT events_users_fk FOREIGN KEY (id_owner) REFERENCES pz_projekt.users(id_user) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE pz_projekt.achievements ADD CONSTRAINT achievements_group_achievements_fk FOREIGN KEY (id_group_achievements) REFERENCES pz_projekt.group_achievements(id_group_achievement) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.group_events DROP FOREIGN KEY group_events_events_fk;
ALTER TABLE pz_projekt.group_events DROP FOREIGN KEY group_events_groups_fk;
ALTER TABLE pz_projekt.group_events ADD CONSTRAINT group_events_events_fk FOREIGN KEY (id_event) REFERENCES pz_projekt.events(id_event) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.group_events ADD CONSTRAINT group_events_groups_fk FOREIGN KEY (id_group) REFERENCES pz_projekt.groups(id_group) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.posts DROP FOREIGN KEY posts_groups_fk;
ALTER TABLE pz_projekt.posts DROP FOREIGN KEY posts_users_fk;
ALTER TABLE pz_projekt.posts MODIFY COLUMN id_user int(11) NULL;
ALTER TABLE pz_projekt.posts MODIFY COLUMN id_group int(11) NULL;
ALTER TABLE pz_projekt.posts ADD CONSTRAINT posts_users_fk FOREIGN KEY (id_user) REFERENCES pz_projekt.users(id_user) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE pz_projekt.posts ADD CONSTRAINT posts_groups_fk FOREIGN KEY (id_group) REFERENCES pz_projekt.groups(id_group) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.posts ADD CONSTRAINT posts_groups_fk FOREIGN KEY (id_group) REFERENCES pz_projekt.groups(id_group) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.posts ADD CONSTRAINT posts_users_fk FOREIGN KEY (id_user) REFERENCES pz_projekt.users(id_user) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE pz_projekt.reactions MODIFY COLUMN id_user int(11) NULL;
ALTER TABLE pz_projekt.reactions DROP FOREIGN KEY reactions_users_fk;
ALTER TABLE pz_projekt.reactions ADD CONSTRAINT reactions_users_fk FOREIGN KEY (id_user) REFERENCES pz_projekt.users(id_user) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.reactions DROP FOREIGN KEY reactions_events_fk;
ALTER TABLE pz_projekt.reactions ADD CONSTRAINT reactions_events_fk FOREIGN KEY (id_event) REFERENCES pz_projekt.events(id_event) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.news DROP FOREIGN KEY news_users_fk;
ALTER TABLE pz_projekt.news MODIFY COLUMN id_user int(11) NULL;
ALTER TABLE pz_projekt.news ADD CONSTRAINT news_users_fk FOREIGN KEY (id_user) REFERENCES pz_projekt.users(id_user) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE pz_projekt.`member` DROP FOREIGN KEY member_users_fk;
ALTER TABLE pz_projekt.`member` DROP FOREIGN KEY member_groups_fk;
ALTER TABLE pz_projekt.`member` ADD CONSTRAINT member_users_fk FOREIGN KEY (id_user) REFERENCES pz_projekt.users(id_user) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.`member` ADD CONSTRAINT member_groups_fk FOREIGN KEY (id_group) REFERENCES pz_projekt.groups(id_group) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pz_projekt.authorization_tokens DROP FOREIGN KEY authorization_tokens_users_fk;
ALTER TABLE pz_projekt.authorization_tokens ADD CONSTRAINT authorization_tokens_users_fk FOREIGN KEY (id_user) REFERENCES pz_projekt.users(id_user) ON DELETE CASCADE ON UPDATE CASCADE;
