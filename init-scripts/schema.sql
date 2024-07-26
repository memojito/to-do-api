\c todo;

CREATE TABLE IF NOT EXISTS todo (
                                           id serial PRIMARY KEY,
                                           title text,
                                           txt text,
                                           user_id int,
                                           creation_date date
);

CREATE TABLE IF NOT EXISTS todouser (
                                      id serial PRIMARY KEY,
                                      first_name text,
                                      last_name text
);
