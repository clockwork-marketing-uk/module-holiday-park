function validate(stages, currentState) {

    stages.forEach(stage => {

        if (stage.fields && stage?.stage == currentState) {
            stage.fields.forEach(field => {
                if (field.required && field.htmlElement) {
                    console.log(field, field.htmlElement.value)
                    if (!field.htmlElement.value) {
                        return false
                    }
                }
            });
        }
        
    });

    return true

}

export { validate }