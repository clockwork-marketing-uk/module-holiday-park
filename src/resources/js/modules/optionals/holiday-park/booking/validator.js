function validate(stages, currentState) {

    let validation = {
        message: false,
        valid: true
    }

    let emptyFields = []
    stages.forEach(stage => {
        if (stage.fields && stage?.stage == currentState) {
            stage.fields.forEach(field => {
                if (field.required && field.htmlElement) {
                    if (!field.htmlElement.value) {
                        emptyFields.push(field.htmlElement.parentElement.parentElement.textContent)
                    }
                }
            });
        }
    });

    if (emptyFields.length > 0) {
        validation.valid = false
        validation.message = "The following fields are required: "
        validation.fields = emptyFields
    }

    return validation

}

export { validate }