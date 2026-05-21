<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"content="width=device-width, initial-scale=1.0">
    <title>Narniton</title>

    <link rel="stylesheet" href="./assets/css/style.css">

</head>
<body>


    <?php
        include_once "config/database.php";

        $db = new Database();

        if(isset($_POST['title']) && isset($_POST['description'])){
            $db->addRecipe(
                $_POST['title'],
                $_POST['description']
            );
            header('Location: index.php');
            exit();
        }

        if(isset($_GET['search']))
            $recipes = $db->search($_GET['search']);
        else
            $recipes = $db->getRecipes();
        
    ?>



    <section id="accueil">
        <div class="logo">
            <a href="./index.php">
                <img src="assets/img/logo.png" alt="logo narniton">
            </a>
        </div>

        <h1>Narniton</h1>



        <form method="GET">
            <input type="text" name="search" placeholder="Search recipes">
            <button type="submit">
                Search
            </button>
        </form>

        <br>

        <img src="assets/img/accueil.png" alt="accueil" width="300">

        <h2>Our Recipes</h2>

        <div class="recipes">
            <?php
                foreach($recipes as $recipe){

                    echo "<div class='recipe-card'>";

                    echo "<h3>";
                    echo $recipe['title_recipes'];
                    echo "</h3>";

                    echo "<a href='views/views.php?id=". $recipe['id_recipes']. "'>";
                    echo "<img src='assets/img/recipe_" . $recipe['id_recipes'] . ".png' width='200'>";
                    echo "</div>";
                }
            ?>
        </div>

        <hr>

        <h2>Add a Recipe</h2>

        <form method="POST">
            <input type="text" name="title" placeholder="Recipe title" required>

            <br><br>
            <textarea name="description" placeholder="Recipe description" required></textarea>

            <br><br>
            <button type="submit">Add Recipe</button>

        </form>

    </section>

</body>
</html>

