function validate(stages, currentState) {

    let validation = {
        message: false,
        valid: true
    }

    console.log(stages, currentState)

    let emptyFields = []
    stages.forEach(stage => {
        if (stage.fields && stage?.stage == currentState) {
            stage.fields.forEach(field => {
                console.log(field)
                if (field.required === true && field.htmlElement) {
                    if (!field.htmlElement.value) {
                        emptyFields.push(field.htmlElement.parentElement.querySelector('label')?.textContent)
                    }
                }
            });
        }
    });

    if (emptyFields.length > 0) {
        console.log(emptyFields)

        validation.valid = false
        validation.message = "The following fields are required: "
        validation.fields = emptyFields
    }

    return validation

}

export { validate }