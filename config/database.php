<?php
    /**
     * Main class of the project, do the link between the php code and the SQL request
     */
    class Database{
        private PDO $pdo; //link between php and bdd

        /**
         * Connect to the BDD
         */
        public function __construct(){
            $this->connexionBD();
        }

        /**
         * Connexion to BDD, will be accessible with $this->pdo
         * @return void
         */
        private function connexionBD() : void {
            $dsn = 'pgsql:dbname=narniton;'; 
            $user = 'narniton'; 
            $password = 'narniton'; 
            try {$this->pdo = new PDO($dsn, $user, $password);}
            catch (PDOException $e) {echo 'Connexion échouée : ' . $e->getMessage();}//si erreur de connection, on affiche l'erreur obtenue
        }

        /**
         * Summary of writeRecipesNames
         * @return void
         */
        function writeRecipesNames() : void {
            $statement = $this->pdo->query('SELECT title_recipes FROM recipes;'); 
            echo "<h1><b>Recipes</b></h1>";
            while ($row = $statement->fetch(PDO::FETCH_BOTH)) echo $row['title_recipes'];

            echo "<br>";
        }

        /**
         * Getting all the recipes
         * @return array
         */
        function getRecipes(): array { 
            $request = "SELECT * FROM recipes"; 

            $statement = $this->pdo->prepare($request); 
            $statement->execute(); 

            return $statement->fetchAll(PDO::FETCH_ASSOC); 
        }

        /**
         * Getting 1 recipe in particular
         * @return array
         */
        function getRecipeById(int $id): array { 
            $request = " SELECT * FROM recipes WHERE id_recipes = :id "; 

            $statement = $this->pdo->prepare($request); 
            $statement->execute([ ':id' => $id ]); 

            return $statement->fetch(PDO::FETCH_ASSOC); 
        }

        /**
         * Getting the ingredients
         * @return array
         */
        function getIngredients(int $recipeId): array { 
            $request = " SELECT * FROM ingredients WHERE recipe_id = :id "; 

            $statement = $this->pdo->prepare($request); 
            $statement->execute([ ':id' => $recipeId ]); 

            return $statement->fetchAll(PDO::FETCH_ASSOC); 
        }

        /**
         * Getting the steps
         * @return array
         */
        function getSteps(int $recipeId): array { 
            $request = " SELECT * FROM steps WHERE recipe_id = :id ORDER BY step_number "; 
            
            $statement = $this->pdo->prepare($request); 
            $statement->execute([ ':id' => $recipeId ]); 

            return $statement->fetchAll(PDO::FETCH_ASSOC); 
        }

        /**
         * Getting the recipe typed in the search bar
         * @return void
         */
        public function addRecipe(string $title, string $description, $ingredients = [], $steps = []){
            $stmt = $this->pdo->prepare("
                INSERT INTO recipes (user_id, title_recipes, description_recipe)
                VALUES (:user_id, :title, :description)
                RETURNING id_recipes
            ");
            $stmt->execute([
                ':user_id'     => 1, //to change if user session
                ':title'       => $title,
                ':description' => $description,
            ]);

            $recipe_id = $stmt->fetchColumn();

            $stmtIng = $this->pdo->prepare("
                INSERT INTO ingredients (recipe_id, name, quantity, unit)
                VALUES (:recipe_id, :name, :quantity, :unit)
            ");

            foreach ($ingredients as $ingredient){
                $name = $ingredient['name'] ?? '';
                $quantity = (int)($ingredient['amount'] ?? 0);
                $unit = $ingredient['unit'] ?? '';

                if ($name === '' || $quantity <= 0) continue; //if given ingredient is wrong

                $stmtIng->execute([
                    ':recipe_id' => $recipe_id,
                    ':name'      => $name,
                    ':quantity'  => $quantity,
                    ':unit'      => $unit,
                ]);
            }

            $this->addSteps($recipe_id, $steps);
        }

        /**
         * Summary of addSteps
         * @param mixed $steps
         * @return void
         */
        function addSteps(int $id, $steps = []) : void {
            $stmtStep = $this->pdo->prepare("
                INSERT INTO steps (recipe_id, step_number, description)
                VALUES (:recipe_id, :step_number, :description)
            ");

            foreach ($steps as $index => $step) {
                $description = $step['description'] ?? '';

                if ($description === '') continue; //if no description

                $stmtStep->execute([
                    ':recipe_id'   => $id,
                    ':step_number' => $index + 1,
                    ':description' => $description,
                ]);
            }
        }

        /**
         * Searching for a recipe
         * @return array
         */
        function search(string $input): array {

            $sql = "
                SELECT DISTINCT r.*
                FROM recipes r
        
                LEFT JOIN ingredients i
                ON i.recipe_id = r.id_recipes
        
                WHERE r.title_recipes ILIKE :search
                OR i.name ILIKE :search
            ";
        
            $stmt = $this->pdo->prepare($sql);
        
            $stmt->execute([
                ':search' => '%' . $input . '%'
            ]);
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }    
?>
