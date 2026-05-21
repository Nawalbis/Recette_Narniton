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