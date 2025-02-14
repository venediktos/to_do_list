<h1>This is a simple tool to help with someone's chores.</h1>

<strong>Database creation script:</strong>

create table to_do_list.tasks<br>
(<br>
    id           int(8) auto_increment
        primary key,<br>
    task         varchar(256)                           null,<br>
    completion   tinyint(1) default 0                   null,<br>
    created_time timestamp  default current_timestamp() not null<br>
)<br>
    engine = InnoDB;

