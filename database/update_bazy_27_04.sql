alter table group_achievements modify name varchar(30);

alter table group_achievements change `descryption` `description` varchar(100);

alter table users add nick varchar(40);

alter table reactions add id_post int(11);

ALTER TABLE pz_projekt.reactions ADD CONSTRAINT reactions_posts_fk FOREIGN KEY (id_post) REFERENCES pz_projekt.posts(id_post) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE pz_projekt.reactions MODIFY COLUMN id_event int(11) NULL;

ALTER TABLE pz_projekt.reaction_types DROP COLUMN image;
ALTER TABLE pz_projekt.reaction_types DROP FOREIGN KEY reaction_types_events_fk;
ALTER TABLE pz_projekt.reaction_types DROP COLUMN id_event;

/*
 * w xampie w konfiguracji bazy w pliku my.ini należy dodać:
 * w sekcji oznaczonej: [mysqld]
 * event_scheduler=ON
 * */
