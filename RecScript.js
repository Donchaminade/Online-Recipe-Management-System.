
    document.getElementById('recipeForm').addEventListener('submit', function(event) {
        // Get the form fields
        const name = document.getElementById('name').value.trim();
        const ingredients = document.getElementById('ingredients').value.trim();
        const description = document.getElementById('description').value.trim();
        const prepHours = document.getElementById('prephours').value;
        const prepMinutes = document.getElementById('prepminutes').value;
        const process = document.getElementById('process').value.trim();

        // Regular expression to disallow numbers in name, ingredients, and description
        const textOnlyRegex = /^[A-Za-z\s]+$/;

        // Validate Name (no numbers allowed)
        if (name === "" || !textOnlyRegex.test(name)) {
            alert("Please enter a valid name without numbers.");
            event.preventDefault(); // Prevent form submission
            return;
        }

        // Validate Ingredients (no numbers allowed)
        if (ingredients === "" || !textOnlyRegex.test(ingredients)) {
            alert("Please enter valid ingredients without numbers.");
            event.preventDefault();
            return;
        }

        // Validate Description (no numbers allowed)
        if (description === "" || !textOnlyRegex.test(description)) {
            alert("Please enter a valid description without numbers.");
            event.preventDefault();
            return;
        }

        // Validate Preparation Time (must not be both 0 hours and 0 minutes)
        if (prepHours === "0" && prepMinutes === "0") {
            alert("Preparation time must be greater than 0.");
            event.preventDefault();
            return;
        }

        // Validate Process
        if (process === "") {
            alert("Please enter the process.");
            event.preventDefault();
            return;
        }
    });