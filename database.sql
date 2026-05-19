drop table if exists Users CASCADE ;
create table Users
(
    id_users SERIAL,
    firstname varchar(50) not null,
    lastname varchar(50) not null,
    email varchar(100) not null unique,
    password varchar(80) not null,

PRIMARY KEY(id_users)

);


drop table if exists Recipes CASCADE;
create table Recipes
(
    id_recipes SERIAL,
    user_id int not null,
    title_recipes varchar(50) not null,
    description_recipe text not null,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp,
    PRIMARY KEY (id_recipes),
    FOREIGN KEY (user_id) REFERENCES Users(id_users)
);


drop table if exists Ingredients CASCADE;
create table Ingredients
(
    id_ingredients SERIAL,
    recipe_id int not null,
    name varchar(50) not null,
    quantity int not null,
    unit varchar(50) not null,
    PRIMARY KEY (id_ingredients),
    FOREIGN KEY (recipe_id)REFERENCES Recipes(id_recipes)

);

drop table if exists Steps CASCADE;
create table Steps
(
    id_steps SERIAL,
    recipe_id int not null,
    step_number int not null,
    description text not null,
    PRIMARY KEY (id_steps),
    FOREIGN KEY (recipe_id) REFERENCES Recipes (id_recipes)
);
