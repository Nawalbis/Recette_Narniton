<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Narniton</title>
</head>
<body>


    <section id="accueil">
            <div class="logo">
                <a href="./index.html"><img src="" alt="logo narniton"></a>
            </div>

            
            <h1>Narniton</h1>
        

            <input type="radio" id="create" name="Create">
            <label for="creation">Create New Recipe</label><br>

            <input type="radio" id="search" name="couleur" value="bleu">
            <label for="search">Search for existing recipes</label><br>


            <img src="img/accueil_narniton.png" alt="accueil">


            <h2>Zoom on our favorite recipe</h2>
            <img src="img/salade_soupejsp.png" alt="favorite_recipe">
            

        </section>

        <?php
            include_once "models/form.php";

            $f = new Formulaire(".", "POST");

            $f->addTextInput("Name of the recipe");

            $f->addButton();
        ?>
    </body>
    </html>