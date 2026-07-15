<script>
    function recipeForm(initial) {
        return {
            ingredients: initial.ingredients,
            steps: initial.steps,

            addIngredient() {
                this.ingredients.push({ name: '', amount: '', unit: '' });
            },

            addStep() {
                this.steps.push({ position: this.steps.length + 1, description: '' });
            },

            moveStep(idx, delta) {
                const target = idx + delta;
                if (target < 0 || target >= this.steps.length) return;
                [this.steps[idx], this.steps[target]] = [this.steps[target], this.steps[idx]];
            },
        };
    }
</script>
