let index = 1;
let stepIndex = 1;

function addIngredient(){
    const container = document.getElementById('ingredients');
    container.insertAdjacentHTML('beforeend', `
        <div class="ingredient-row">
        <input type="text"   name="ingredients[${index}][name]"   placeholder="Name" />
        <input type="number" name="ingredients[${index}][amount]" placeholder="Quantity" />
        <select name="ingredients[${index}][unit]">
            <option value="g">g</option>
            <option value="kg">kg</option>
            <option value="ml">ml</option>
            <option value="L">L</option>
            <option value="pieces">pieces</option>
        </select>
        </div>
    `);
    index++;
}

function addStep(){
    const container = document.getElementById('steps');
    container.insertAdjacentHTML('beforeend', `
        <div class="step-row">
            <textarea name="steps[${stepIndex}][description]" placeholder="Step ${stepIndex + 1}:"></textarea>
        </div>
    `);
    stepIndex++;
}

const params = new URLSearchParams(window.location.search);
const id = params.get("id");

if (!id) {
    document.body.innerHTML = "<p>Identifiant de recette manquant.</p>";
} 
else{
    fetch(`../api/recipe.php?id=${id}`)
        .then(res => {
            if (!res.ok) throw new Error("Recette introuvable");
            return res.json();
        })
        .then(data => {
            const {recipe, ingredients, steps} = data;

            document.querySelector("h1").textContent = recipe.title_recipes;
            document.querySelector("p").textContent  = recipe.description_recipe;

            const ul = document.querySelector("ul");
            ul.innerHTML = ingredients.map(i =>
                `<li>${i.quantity} ${i.unit} ${i.name}</li>`
            ).join("");

            const ol = document.querySelector("ol");
            ol.innerHTML = steps.map(s =>
                `<li>${s.description}</li>`
            ).join("");
        })
        .catch(err => {
            document.body.innerHTML = `<p>Erreur : ${err.message}</p>`;
        });
}