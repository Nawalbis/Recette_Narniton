<?php
    include_once "../config/database.php";


    $db = new Database();
    $id = $_GET['id'];

    $recipe = $db->getRecipeById($id);
    $ingredients = $db->getIngredients($id);
    $steps = $db->getSteps($id);
?>

    <h1><?= $recipe['title_recipes'] ?></h1>
    <p><?= $recipe['description_recipe'] ?></p>

    <h2>Ingrédients</h2><ul>
    <?php
        foreach($ingredients as $ingredient){
            echo "<li>";
            echo $ingredient['quantity'] . " ";
            echo $ingredient['unit'] . " ";
            echo $ingredient['name'];
            echo "</li>";
        }
    ?>
    </ul>

    <h2>Étapes</h2><ol>

    <?php
        foreach($steps as $step){
            echo "<li>";
            echo $step['description'];
            echo "</li>";
        }
    ?>
</ol>