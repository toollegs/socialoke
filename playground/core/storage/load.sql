-- drop database socialoke;

-- create database socialoke;

use socialoke;

-- create table song(id int not null auto_increment, name varchar(255), artist varchar(255), popular boolean default false, duet boolean default false, create_date timestamp not null default current_timestamp, primary key ( id ), index(id), index(name,artist));

-- LOAD DATA LOCAL INFILE 'all-new.csv' INTO TABLE song FIELDS ENCLOSED BY '"' TERMINATED BY ',' LINES TERMINATED BY '\n' (name, artist);

drop table if exists host_gig;
drop table if exists host;
drop table if exists host_company;
drop table if exists cust_req;
drop table if exists cust_fav;
drop table if exists vote;
drop table if exists registration;
drop table if exists sms_inbound;
drop table if exists cust;
drop table if exists gig;
drop table if exists venue;

create table host_company(code varchar(8), name varchar(255), create_date timestamp not null default current_timestamp, primary key (code));

insert into host_company(name,code) values ('Gorham Productions','gorpro');
insert into host_company(name,code) values ('J Christopher','jchr');
insert into host_company(name,code) values ('Socialoke','soc');
insert into host_company(name,code) values ('Billy, Inc.','billinc');

create table host(host_company_code varchar(8) not null default "NONE", id varchar(255) not null, phone_no varchar(11) not null, create_date timestamp not null default current_timestamp, primary key(name,host_company_code), index(host_company_code), index(name,host_company_code), foreign key(host_company_code) references host_company(code) on delete cascade on update cascade);

insert into host(host_company_code,id,phone_no) values ('gorpro','dan','15083205592');
insert into host(host_company_code,id,phone_no) values ('gorpro','mike','19788551400');
insert into host(host_company_code,id,phone_no) values ('gorpro','rob','16178661155');
insert into host(host_company_code,id,phone_no) values ('gorpro','adrian','16172767019');
insert into host(host_company_code,id,phone_no) values ('gorpro','brian','17813088441');
insert into host(host_company_code,id,phone_no) values ('gorpro','isabelle','17814924618');
insert into host(host_company_code,id,phone_no) values ('gorpro','tommy','17813072995');
insert into host(host_company_code,id,phone_no) values ('gorpro','skeeter','15088014953');
insert into host(host_company_code,id,phone_no) values ('gorpro','vin','18579285310');
insert into host(host_company_code,id,phone_no) values ('gorpro','cody','17815529093');
insert into host(host_company_code,id,phone_no) values ('jchr','jt','18609836880');
insert into host(host_company_code,id,phone_no) values ('jchr','josh','18607868510');
insert into host(host_company_code,id,phone_no) values ('billinc','billy','16177751549');
insert into host(host_company_code,id,phone_no) values ('soc','jeff','16179706735');
insert into host(host_company_code,id,phone_no) values ('soc','wizard','1339237781');

create table venue(code varchar(32) not null, name varchar(255) not null, create_date timestamp not null default current_timestamp, fb_link varchar(255), index(code), primary key(code));

insert into venue(code,name,fb_link) values ('rover','Wild Rover Boston','http://www.facebook.com/wildroverboston');
insert into venue(code,name,fb_link) values ('sissys',"Sissy K's Boston",'http://www.facebook.com/pages/Sissy-Ks/144091968934326');
insert into venue(code,name,fb_link) values ('hill','On The Hill Tavern Somerville','http://www.facebook.com/onthehilltavern');
insert into venue(code,name,fb_link) values ('yesterdays',"Yesterday's Quincy",'http://www.facebook.com/pages/Yesterdays-Bar/181030449074');
insert into venue(code,name,fb_link) values ('legends','Legends Bristol','http://www.facebook.com/pages/Legends-Sports-Bar/146706877110');
insert into venue(code,name,fb_link) values ('zen','Zen Bar Plainville','http://www.facebook.com/zen.bar.3?fref=ts');
insert into venue(code,name,fb_link) values ('downtown','Downtown Cafe Bristol','http://www.facebook.com/downtown06010?fref=ts');
insert into venue(code,name,fb_link) values ('cathay','Cathay Center Weymouth','http://www.GorhamProductions.com');
insert into venue(code,name,fb_link) values ('easton','Easton','http://www.facebook.com');
insert into venue(code,name,fb_link) values ('alumni','Alumni Franklin','http://www.facebook.com/pages/The-Alumi-Restaurant-And-Bar/204307558091');
insert into venue(code,name,fb_link) values ('rooster','Red Rooster Wrentham','http://www.facebook.com/pages/The-Red-Rooster/335788729842869');
insert into venue(code,name,fb_link) values ('flynns',"Chickie Flynn's",'http://www.facebook.com/pages/Chickie-Flynns-Family-Restaurant-Bar/128220980554357');
insert into venue(code,name,fb_link) values ('tavern2',"Tavern Wrentham",'tavernwrentham,http://www.facebook.com/tavernatwrentham');
insert into venue(code,name,fb_link) values ('smokeys',"Smokey O'Gradys East Hampton",'http://www.facebook.com/pages/Smokey-OGradys/185917181432825');
insert into venue(code,name,fb_link) values ('citysports',"City Sports Bristol",'http://www.facebook.com/sparetimebristol');
insert into venue(code,name,fb_link) values ('kinsale',"Kinsale Boston",'http://www.facebook.com/pages/Kinsale-Irish-Pub-Restaurant/182735945081207');
insert into venue(code,name,fb_link) values ('dolphin',"Dolphinxe Seafood Cambridge",'http://www.facebook.com/DolphinSeafoodCambridge');
insert into venue(code,name,fb_link) values ('lastshot',"Last Shot Stoughton",'http://www.facebook.com/thelastshotstoughton');
insert into venue(code,name,fb_link) values ('bell',"Bell In Hand Boston",'http://www.facebook.com/bellinhandtavern');
insert into venue(code,name,fb_link) values ('redzone',"RedZone Plainville",'http://www.facebook.com/Redzone.sports.lounge');

create table host_gig(host_id varchar(255) not null, venue_code varchar(255) not null, dow varchar(3) not null, start_time datetime not null, primary key(host_id), venue_code, dow), foreign key(host_id) references host(id) on delete cascade on update cascade, foreign key(venue_code) references venue(code) on delete cascade on update cascade);

create table cust(fb_id varchar(255), phone_no varchar(10), create_date timestamp not null default current_timestamp, primary key(phone_no));

create table gig(venue_code varchar(255) not null, host_id varchar(255) not null, code int not null, date_str varchar(6) not null, create_date timestamp not null default current_timestamp, primary key(code,date_str), index(venue_code), index(date_str), index(host_id), foreign key(venue_code) references venue(code) on delete cascade on update cascade, foreign key(host_id) references host(id) on delete cascade on update cascade);

create table cust_req(cust_phone_no varchar(10) not null, gig_code int not null, song_name varchar(255) not null, song_artist varchar(255) not null, note varchar(255), create_date timestamp not null default current_timestamp, primary key(cust_phone_no, gig_code, song_name, song_artist), index(cust_phone_no), index(cust_phone_no, gig_code), index(cust_phone_no, gig_code, song_name, song_artist), foreign key(cust_phone_no) references cust(phone_no) on delete cascade on update cascade, foreign key (gig_code) references gig(code) on delete cascade on update cascade, foreign key(song_name, song_artist) references song(name,artist) on delete cascade on update cascade);

create table cust_fav(cust_phone_no varchar(10) not null, venue_code varchar(255) not null, song_name varchar(255) not null, song_artist varchar(255) not null, primary key(cust_phone_no, song_name, song_artist), index(cust_phone_no, song_name, song_artist), foreign key(cust_phone_no) references cust(phone_no) on delete cascade on update cascade, foreign key(song_name, song_artist) references song(name, artist) on delete cascade on update cascade, foreign key(venue_code) references venue(code) on delete cascade on update cascade);

create table vote(gig_code int not null, cust_phone_no varchar(10) not null, song_name varchar(255) not null, song_artist varchar(255) not null, vote int not null, create_date timestamp not null default current_timestamp, primary key(gig_code,cust_phone_no,song_name,song_artist), index(gig_code,cust_phone_no,song_name,song_artist), foreign key(gig_code) references gig(code), foreign key(cust_phone_no) references cust(phone_no) on delete cascade on update cascade, foreign key(song_name, song_artist) references song(name,artist) on delete cascade on update cascade);

create table sms_inbound(id int not null auto_increment, phone_no varchar(10) not null, primary key(id), foreign key(phone_no) references cust(phone_no) on delete cascade on update cascade);

