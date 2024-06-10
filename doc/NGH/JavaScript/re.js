document.addEventListener('DOMContentLoaded', function () {
    const addIngredientButton = document.getElementById('addIngredient');
    const ingredientsContainer = document.getElementById('ingredients');
    
    const addStepButton = document.getElementById('addStep');
    const stepsContainer = document.getElementById('steps');
    
    addIngredientButton.addEventListener('click', function () {
        const ingredientRow = document.createElement('div');
        ingredientRow.classList.add('ingredient-row');
        ingredientRow.innerHTML = `
            <input type="text" name="ingredient[]" placeholder="재료명">
            <input type="text" name="quantity[]" placeholder="양">
            <button type="button" class="remove-ingredient">제거</button>
        `;
        ingredientsContainer.appendChild(ingredientRow);
        
        const removeIngredientButton = ingredientRow.querySelector('.remove-ingredient');
        removeIngredientButton.addEventListener('click', function () {
            ingredientsContainer.removeChild(ingredientRow);
        });
    });
    
    addStepButton.addEventListener('click', function () {
        const stepCount = stepsContainer.querySelectorAll('.step').length + 1;
        const step = document.createElement('div');
        step.classList.add('step');
        step.innerHTML = `
            <h3>Step ${stepCount}</h3>
            <textarea name="stepDescription[]" placeholder="예) 소고기를 기름을 두른 팬에..."></textarea>
            <div class="step-images">
                <input type="file" name="stepImage[]">
            </div>
            <button type="button" class="remove-step">순서 제거</button>
        `;
        stepsContainer.appendChild(step);
        
        const removeStepButton = step.querySelector('.remove-step');
        removeStepButton.addEventListener('click', function () {
            stepsContainer.removeChild(step);
        });
    });
    
    document.getElementById('cancel').addEventListener('click', function () {
        document.getElementById('recipeForm').reset();
    });
});
