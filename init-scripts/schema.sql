\c todo;

CREATE TABLE IF NOT EXISTS todos
(
    id            serial PRIMARY KEY,
    title         character varying(255),
    txt           text,
    state         character varying(255),
    user_id       int,
    creation_date date
);

CREATE TABLE IF NOT EXISTS todousers
(
    id       serial PRIMARY KEY,
    username character varying(255),
    password text not null,
    role     character varying(255)
);

CREATE EXTENSION pgcrypto;

INSERT INTO todousers(username, password, role)
VALUES ('test', crypt('test', gen_salt('bf')), 'admin');

INSERT INTO todos (title, txt, state, user_id, creation_date)
VALUES ('Go shopping', 'milk, meat, eggs', 'CREATED', 1, '2024-07-20'),
       ('Call friends', 'paul, mark, leo', 'CREATED', 1, '2024-07-21');
