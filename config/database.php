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
         * Getting the recipe typed in the search bar
         * @return array
         */
        function search(string $input): void{
            $sql = "SELECT r.title_recipes, i.name
                    FROM Recipes r
                    LEFT JOIN Ingredients i 
                    ON i.recipe_id = r.id_recipes
                    WHERE r.title_recipes ILIKE :search
                    OR i.name ILIKE :search";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':search' => '%' . $input . '%']);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                echo "Recette : " . $row['title_recipes'] . " - Ingrédient : " . $row['name'] . "<br>";
            }
        }



        // /**
        //  * Write autors' full names and all quotes from BDD
        //  * @return void
        //  */
        // public function writeAll() : void {
        //     $this->writeNames(); //noms et prénoms des auteurs
        //     $this->writeCitations(); //texte des citations
        // }

        // /**
        //  * Write full name of every autor in the BDD
        //  * @return void
        //  */
        // public function writeNames() : void {
        //     $statement = $this->pdo->query('SELECT * FROM auteur;'); 
        //     echo "<h1><b>Auteur de la BDD</h1></b><table>
        //             <tr>
        //                 <th>Nom</th>
        //                 <th>Prénom</th>
        //             </tr>";
        //     while ($row = $statement->fetch(PDO::FETCH_BOTH)) echo "<tr><td>" . $row['nom'] . "</td><td>" . $row['prenom'] . "</td></tr>";

        //     echo "</table><br>";
        // }

        // /**
        //  * Print out every quotes in the database
        //  * @return void
        //  */
        // public function writeCitations() : void {
        //     $statement = $this->pdo->query('SELECT * FROM citation;'); 
        //     echo "<h1><b>Citations de la BDD</h1></b><br>";
        //     while ($row = $statement->fetch(PDO::FETCH_BOTH)) echo $row['phrase'] . "<i> " . $this->getAutorFromCitation($row['phrase']) . "</i>,<b> " . $this->getDateFromCitation($row['phrase']) . " ème siècle</b><br>";

        //     echo "</table><br>";
        // }

        // /**
        //  * return the full name of the autor of a given quote
        //  * @param string $citation the quote who's autor is searched
        //  * @return string full name of the autor found
        //  */
        // public function getAutorFromCitation(string $citation) : string {
        //     $request = "SELECT nom, prenom FROM auteur
        //                 JOIN citation ON citation.auteurid = auteur.id
        //                 WHERE citation.phrase = :citation;"; 
        //     $statement = $this->pdo->prepare($request); 
        //     $statement->bindParam(':citation', $citation); 
        //     $statement->execute(); 
        //     $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //     return $result[0]['prenom'] . " " . $result[0]['nom'];
        // }

        // /**
        //  * return the date of a given quote
        //  * @param string $citation the quote who's autor is searched
        //  * @return string date found
        //  */
        // public function getDateFromCitation(string $citation) : string {
        //     $request = "SELECT numero FROM siecle
        //                 JOIN citation ON citation.siecleid = siecle.id
        //                 WHERE citation.phrase = :citation;"; 
        //     $statement = $this->pdo->prepare($request); 
        //     $statement->bindParam(':citation', $citation); 
        //     $statement->execute(); 
        //     $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //     return $result[0]['numero'];
        // }

        // /**
        //  * Print out a random quote from the database
        //  * @return void
        //  */
        // public function getRandomCitation() : void {
        //     $statement = $this->pdo->query('SELECT phrase FROM citation;'); 
        //     echo "<h1><b>Citation aléatoire:</h1></b><br>";
        //     $rows = $statement->fetchall(PDO::FETCH_BOTH);

        //     $randInd = rand(0, sizeof($rows) - 1);

        //     echo $rows[$randInd]['phrase'] . "<i> " . $this->getAutorFromCitation($rows[$randInd]['phrase']) . "</i>,<b> " . $this->getDateFromCitation($rows[$randInd]['phrase']) . " ème siècle</b><br>";
        // }

        // /**
        //  * Return all the quote based on a year
        //  * @param string $date the year the user's searching for
        //  * @return array an array of quotes found
        //  */
        // public function getCitationsFromDate(string $date) : array {
        //     $request = "SELECT phrase FROM citation
        //                 JOIN siecle ON citation.siecleid = siecle.id
        //                 WHERE siecle.numero = :date;"; 
        //     $statement = $this->pdo->prepare($request); 
        //     $statement->bindParam(':date', $date); 
        //     $statement->execute(); 
        //     $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //     return $result;
        // }

        // /**
        //  * Return quotes with corresponding autor's surname
        //  * @param string $prenom the surname wanted
        //  * @return array an array with found quotes
        //  */
        // public function getCitationsFromSurName(string $prenom) : array {
        //     $request = "SELECT phrase FROM citation
        //                 JOIN auteur ON citation.auteurid = auteur.id
        //                 WHERE auteur.prenom = :prenom;"; 
        //     $statement = $this->pdo->prepare($request); 
        //     $statement->bindParam(':prenom', $prenom); 
        //     $statement->execute(); 
        //     $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //     return $result;
        // }

        // /**
        //  * Return quotes with corresponding autor's name
        //  * @param string $name the name wanted
        //  * @return array an array with found quotes
        //  */
        // public function getCitationsFromName(string $name) : array {
        //     $request = "SELECT phrase FROM citation
        //                 JOIN auteur ON citation.auteurid = auteur.id
        //                 WHERE auteur.nom = :name;"; 
        //     $statement = $this->pdo->prepare($request); 
        //     $statement->bindParam(':name', $name); 
        //     $statement->execute(); 
        //     return $statement->fetchAll(PDO::FETCH_ASSOC);

        // }

        // /**
        //  * Print out how many quotes are in the database
        //  * @return void
        //  */
        // public function printNbCitations() : void {
        //     $request = "SELECT COUNT(*) FROM citation;";
        //     $statement = $this->pdo->prepare($request); 
        //     $statement->execute(); 
        //     $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        //     echo "Il y a <b>" . $result[0]["count"] . " </b>citations répertoriées.";
        // }

        // /**
        //  * Return all the autors in the database
        //  * @return array an array containing all the autors found - use [i]["nom"] or [i]["prenom"], with i an int
        //  */
        // public function getAutors() : array {
        //     $request = "SELECT nom, prenom FROM auteur;";
        //     $statement = $this->pdo->prepare($request);
        //     $statement->execute();
        //     return $statement->fetchAll(PDO::FETCH_ASSOC);
        // }

        // /**
        //  * Return all the centeries in the database
        //  * @return array an array containing all the centeries found - use [i]["numero"], with i an int
        //  */
        // public function getSiecles() : array {
        //     $request = "SELECT numero FROM siecle;";
        //     $statement = $this->pdo->prepare($request);
        //     $statement->execute();
        //     return $statement->fetchAll(PDO::FETCH_ASSOC);
        // }

        // /**
        //  * Return all the quotes in the database
        //  * @return array an array containing all the quotes found - use [i]["phrase"], with i an int
        //  */
        // public function getCitations() : array {
        //     $request = "SELECT phrase FROM citation;";
        //     $statement = $this->pdo->prepare($request);
        //     $statement->execute();
        //     return $statement->fetchAll(PDO::FETCH_ASSOC);
        // }

        // /**
        //  * Add an autor to the database
        //  * @param string $nom the name of the new autor
        //  * @param string $prenom the surname of the new autor
        //  * @return void
        //  */
        // public function addAuteur(string $nom, string $prenom) : void {
        //     $request = "INSERT INTO auteur (nom, prenom) VALUES (:nom, :prenom)";
        //     $statement = $this->pdo->prepare($request);

        //     $statement->bindParam(':nom', $nom); 
        //     $statement->bindParam(':prenom', $prenom); 
        //     $statement->execute();
        // }

        // /**
        //  * Add a centery in the database
        //  * @param string $nb the new centery
        //  * @return void
        //  */
        // public function addSiecle(string $nb) : void {
        //     $request = "INSERT INTO siecle (numero) VALUES (:numero)";
        //     $statement = $this->pdo->prepare($request);

        //     $statement->bindParam(':numero', $nb); 
        //     $statement->execute();
        // }

        // /**
        //  * Return an id based on a autor name - return 0 if none found
        //  * @param string $nom the name searched for
        //  * @param string $prenom the surname searched for
        //  * @return int the indice of the searched autor - 0 if not found
        //  */
        // public function getAuteurId(string $nom, string $prenom) : int {
        //     $statement = $this->pdo->prepare("SELECT id FROM auteur WHERE nom = :nom AND prenom = :prenom");
        //     $statement->execute(['nom' => $nom, 'prenom' => $prenom]);
        //     return (int)$statement->fetchColumn(); //retourne le nb de ligne donc l'id
        // }

        // /**
        //  * Return an id based on a centery - return 0 if none found
        //  * @param string $nb the centery searched for
        //  * @return int the indice of the searched centery - 0 if not found
        //  */
        // public function getSiecleId(string $nb) : int {
        //     $statement = $this->pdo->prepare("SELECT id FROM siecle WHERE numero = :numero");
        //     $statement->bindParam(':numero', $nb);
        //     $statement->execute();  
        //     return (int)$statement->fetchColumn();
        // }

        // /**
        //  * Add a quote to the database
        //  * @param string $phrase the new quote
        //  * @param int $auteurId the autor who said/written the quote
        //  * @param int $siecleId the centery of the original quote
        //  * @return void
        //  */
        // public function addCitation(string $phrase, int $auteurId, int $siecleId) : void {
        //     $request = "INSERT INTO citation (phrase, auteurid, siecleid) VALUES (:phrase, :auteurid, :siecleid)";
        //     $statement = $this->pdo->prepare($request);

        //     $statement->bindParam(':phrase', $phrase);
        //     $statement->bindParam(':auteurid', $auteurId);
        //     $statement->bindParam(':siecleid', $siecleId);

        //     $statement->execute();
        //     echo"citation ajoutée";
        // }

        // /**
        //  * Delete a quote from the database
        //  * @param string $phrase the quote searcehd for
        //  * @return void
        //  */
        // public function deleteCitationFromPhrase(string $phrase) : void {
        //     $request = "DELETE FROM citation WHERE phrase = :phrase";
        //     $statement = $this->pdo->prepare($request);
        //     $statement->bindParam(':phrase', $phrase);
        //     $statement->execute();
        // }

    }
?>
