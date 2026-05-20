drop table if exists users CASCADE ;
create table users
(
    id_users SERIAL,
    firstname varchar(50) not null,
    lastname varchar(50) not null,
    email varchar(100) not null unique,
    password varchar(80) not null,

PRIMARY KEY(id_users)

);
INSERT INTO users (firstname, lastname, email, password) VALUES
('admin', 'admin', 'admin@mail.com', 'test');


drop table if exists recipes CASCADE;
create table recipes
(
    id_recipes SERIAL,
    user_id int not null,
    title_recipes varchar(50) not null,
    description_recipe text not null,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp,
    PRIMARY KEY (id_recipes),
    FOREIGN KEY (user_id) REFERENCES users(id_users)
);

INSERT INTO recipes (user_id, title_recipes, description_recipe) VALUES 
(1, 'Carbonara', 'Des pâtes italiennes crémeuses'), 
(1, 'Burger Maison', 'Burger avec cheddar'), 
(1, 'Soupe Tomate', 'Soupe chaude'), 
(1, 'Tiramisu', 'Dessert italien');


drop table if exists ingredients CASCADE;
create table ingredients
(
    id_ingredients SERIAL,
    recipe_id int not null,
    name varchar(50) not null,
    quantity int not null,
    unit varchar(50) not null,
    PRIMARY KEY (id_ingredients),
    FOREIGN KEY (recipe_id)REFERENCES recipes(id_recipes)

);

INSERT INTO ingredients (recipe_id, name, quantity, unit) VALUES 
(1, 'Pâtes', 500, 'g'), 
(1, 'Parmesan', 100, 'g'), 
(1, 'Lardons', 200, 'g'), 

(2, 'Pain Burger', 2, 'pieces'), 
(2, 'Steak', 2, 'pieces'), 
(2, 'Cheddar', 2, 'tranches'), 

(3, 'Tomates', 5, 'pieces'), 
(3, 'Eau', 1, 'L'), 

(4, 'Mascarpone', 250, 'g'), 
(4, 'Café', 1, 'tasse');

drop table if exists steps CASCADE;
create table steps
(
    id_steps SERIAL,
    recipe_id int not null,
    step_number int not null,
    description text not null,
    PRIMARY KEY (id_steps),
    FOREIGN KEY (recipe_id) REFERENCES recipes (id_recipes)
);
INSERT INTO steps (recipe_id, step_number, description) VALUES 
(1, 1, 'Faire cuire les pâtes'), 
(1, 2, 'Cuire les lardons'), 
(1, 3, 'Mélanger le tout'), 
(2, 1, 'Cuire les steaks'), 
(2, 2, 'Assembler le burger'), 
(3, 1, 'Faire cuire les tomates'), 
(3, 2, 'Mixer la soupe'), 
(4, 1, 'Préparer le café'), 
(4, 2, 'Monter le tiramisu');