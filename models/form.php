<?php

/**
 * Secondary class, can make a base for any <form>
 */
class Formulaire{
    private string $text; //the fieldset that will be printed out later

    /**
     * Create a form object
     * @param string $file the file wich the form is linked to
     * @param string $method POST/GET
     */
    public function __construct(string $file, string $method){
        $this->text = "<form method=\"{$method}\" action=\"{$file}\">";
    }

    /**
     * Print out the form and delete the object.
     */
    public function __destruct(){
        $this->text .= '</form><br>';
        echo $this->text;
    }

    /**
     * Add an input to print out later
     * @param string $texte the text to print out
     * @param string $type text, int...
     * @param string $name name in order to use it later
     * @param bool $isRequired true/false
     * @return void
     */
    public function addTextInput(string $texte = "Nom", string $type = "text", string $name = "name", bool $isRequired = true) : void {
        $this->text .= "<label>{$texte} :</label> 
                        <input type=\"{$type}\" name=\"{$name}\" {$isRequired}>
                        <br>";
    }

    /**
     * Add a button to print out later
     * @param string $text text in the button
     * @return void
     */
    public function addButton(string $text = "Envoyer") : void {
        $this->text .= "<button type=\"submit\">{$text}</button><br>";
    }

    /**
     * Add a select fieldset
     * @param array $choices an array of all the different choices possibles
     * @param string $name to find out wich value is selectionned later
     * @return void
     */
    public function addSelect(array $choices, string $name) : void {
        $this->text .= "<select name=\"{$name}\">";

        foreach ($choices as $value) {
            $this->text .= "<option value=\"{$value}\">{$value}</option>";
        }

        $this->text .= "</select><br>";
    }

    /**
     * Add a simple text to print out later
     * @param string $text the text to print out
     * @return void
     */
    public function addText(string $text) : void {
        $this->text .= $text . "<br>";
    }

    /**
     * Add a h1 title to print out later
     * @param string $title the h1 title to print out
     * @return void
     */
    public function addTitle(string $title) : void {
        $this->text .= "<h1>{$title}</h1><br>";
    }
}
